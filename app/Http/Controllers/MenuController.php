<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = \App\Models\Menu::all();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = public_path('images');
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = $profileImage;
        }

        \App\Models\Menu::create($input);

        return redirect()->route('menus.index')
                        ->with('success','Menu created successfully.');
    }

    public function show(\App\Models\Menu $menu)
    {
        return view('admin.menus.show',compact('menu'));
    }

    public function edit(\App\Models\Menu $menu)
    {
        return view('admin.menus.edit',compact('menu'));
    }

    public function update(Request $request, \App\Models\Menu $menu)
    {
        $request->validate([
            'name'         => 'required',
            'price'        => 'required|numeric',
            'category'     => 'required',
            'is_available' => 'required|in:0,1',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Gunakan only() agar hanya field yang diizinkan yang diteruskan ke DB
        $input = $request->only(['name', 'price', 'description', 'category', 'sub_category', 'is_available']);

        if ($image = $request->file('image')) {
            // Hapus gambar lama jika ada
            if ($menu->image && file_exists(public_path('images/' . $menu->image))) {
                unlink(public_path('images/' . $menu->image));
            }
            $destinationPath = public_path('images');
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = $profileImage;
        }

        $menu->update($input);

        return redirect()->route('menus.index')
                        ->with('success', 'Menu berhasil diupdate.');
    }

    public function destroy(\App\Models\Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menus.index')
                        ->with('success','Menu deleted successfully');
    }

    // -------------------------------------------------------------------------
    // PDF Import Methods
    // -------------------------------------------------------------------------

    /**
     * Process uploaded PDF: call Python OCR script, store result in session.
     */
    public function importPdfProcess(Request $request)
    {
        // No execution time limit — Python extraction can take a while on CPU
        set_time_limit(0);

        $request->validate([
            'file' => 'required|file|mimes:pdf|max:102400',
        ]);

        $pdf = $request->file('file');

        // Use PHP's own temp path — file is already here, no need to copy
        $fullPath = $pdf->getRealPath();

        Log::info("PDF Import: file={$fullPath}, size=" . $pdf->getSize());

        if (!file_exists($fullPath)) {
            Log::error("PDF Import: PHP temp file not found at {$fullPath}");
            session(['pdf_import_items' => []]);
            return redirect()->route('menus.importPdfReview');
        }

        // Resolve Python executable from .env
        $pythonBin  = env('PYTHON_PATH', 'python');
        $scriptPath = base_path('python_ocr/extract_menu.py');

        Log::info("PDF Import: running Python [{$pythonBin}]");

        $process = new Process([$pythonBin, $scriptPath, $fullPath]);
        $process->setTimeout(600);
        $process->run();

        $stdout   = trim($process->getOutput());
        $stderr   = trim($process->getErrorOutput());
        $exitCode = $process->getExitCode();

        Log::info("PDF Import: exit={$exitCode}, stdout_len=" . strlen($stdout));
        if ($stderr) {
            Log::info("PDF Import stderr:\n{$stderr}");
        }

        $items = [];
        if (!empty($stdout)) {
            $decoded = json_decode($stdout, true);
            if (is_array($decoded)) {
                $items = $decoded;
            } else {
                Log::warning("PDF Import: JSON decode failed. stdout preview: " . substr($stdout, 0, 500));
            }
        }

        session(['pdf_import_items' => $items]);

        return redirect()->route('menus.importPdfReview');
    }

    /**
     * Show review/edit page with OCR results.
     */
    public function importPdfReview()
    {
        $items = session('pdf_import_items', []);
        return view('admin.menus.import_review', compact('items'));
    }

    /**
     * Save confirmed items to the database.
     */
    public function importPdfSave(Request $request)
    {
        $names         = $request->input('names', []);
        $prices        = $request->input('prices', []);
        $categories    = $request->input('categories', []);
        $sub_categories = $request->input('sub_categories', []);
        $descriptions  = $request->input('descriptions', []);

        $count = 0;
        foreach ($names as $i => $name) {
            $name = trim($name);
            if ($name === '') {
                continue;
            }

            Menu::create([
                'name'         => $name,
                'price'        => is_numeric($prices[$i] ?? '') ? (float)($prices[$i]) : 0,
                'category'     => $categories[$i] ?? 'Makanan',
                'sub_category' => $sub_categories[$i] ?? '',
                'description'  => $descriptions[$i] ?? '',
                'is_available' => 1,
            ]);
            $count++;
        }

        session()->forget('pdf_import_items');

        return redirect()->route('menus.index')
                         ->with('success', "{$count} menu berhasil diimport dari PDF!");
    }

    // -------------------------------------------------------------------------
    // Bulk Image Upload
    // -------------------------------------------------------------------------

    /**
     * Bulk upload images. Filename (without extension) must match a Menu ID.
     * Example: 25.jpg will be assigned to menu with id=25.
     */
    public function bulkImageUpload(Request $request)
    {
        $request->validate([
            'images'   => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $uploaded = 0;
        $skipped  = [];

        foreach ($request->file('images') as $image) {
            // Extract menu ID from filename (e.g. "25.jpg" → 25)
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            if (!is_numeric($originalName)) {
                $skipped[] = $image->getClientOriginalName() . ' (nama bukan angka ID)';
                continue;
            }

            $menu = Menu::find((int) $originalName);

            if (!$menu) {
                $skipped[] = $image->getClientOriginalName() . ' (menu ID ' . $originalName . ' tidak ditemukan)';
                continue;
            }

            // Delete old image file if exists
            $oldImagePath = public_path('images/' . $menu->image);
            if ($menu->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Save new image to public/images/
            $newFilename = $originalName . '_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $newFilename);

            $menu->image = $newFilename;
            $menu->save();

            $uploaded++;
        }

        $message = "{$uploaded} gambar berhasil diupload.";
        if (!empty($skipped)) {
            $message .= ' Dilewati: ' . implode(', ', $skipped);
            return redirect()->route('menus.index')->with('warning', $message);
        }

        return redirect()->route('menus.index')->with('success', $message);
    }
}
