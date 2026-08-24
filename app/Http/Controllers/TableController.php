<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = \App\Models\Table::with('ratings')->get();
        // Generate QR URL dynamically using the current request host,
        // so it works for any environment (local IP, production domain, etc.)
        // without needing to touch .env
        $baseUrl = request()->getSchemeAndHttpHost();

        // Calculate rankings
        $sorted = $tables->map(function ($t) {
            $avg = $t->ratings->avg('table_rating') ?? 5.0;
            $favs = $t->ratings->where('is_favorite_table', true)->count();
            $count = $t->ratings->count();
            $score = ($avg * 2) + ($favs * 3) + $count;
            return ['id' => $t->id, 'score' => $score];
        })->sortByDesc('score')->values();

        $tableRankMap = [];
        foreach ($sorted as $idx => $item) {
            $tableRankMap[$item['id']] = $idx + 1;
        }

        return view('admin.tables.index', compact('tables', 'baseUrl', 'tableRankMap'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|unique:tables,table_number',
        ]);

        $uuid = \Illuminate\Support\Str::uuid();

        // qr_code_path is no longer stored — QR is generated dynamically
        // in the admin view using the current request host, so it works
        // on any environment (local dev, staging, production) automatically.
        \App\Models\Table::create([
            'table_number' => $request->table_number,
            'uuid'         => $uuid,
            'qr_code_path' => null,
        ]);

        return redirect()->route('tables.index')
                        ->with('success','Table created successfully.');
    }

    public function destroy(\App\Models\Table $table)
    {
        if ($table->status === 'occupied') {
            return redirect()->route('tables.index')
                            ->with('error', 'Gagal menghapus: Meja sedang terisi (occupied). Silakan kosongkan meja terlebih dahulu.');
        }

        $table->delete();

        return redirect()->route('tables.index')
                        ->with('success', 'Table deleted successfully');
    }

    public function clearTable(\App\Models\Table $table)
    {
        // Mark all active orders for this table as completed
        \App\Models\Order::where('table_id', $table->id)
            ->whereIn('order_status', ['pending', 'cooking', 'served'])
            ->update(['order_status' => 'completed']);

        // Set table status to available
        $table->status = 'available';
        $table->save();

        return redirect()->route('tables.index')
                        ->with('success', 'Meja berhasil dikosongkan');
    }

}

