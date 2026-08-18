<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->only(['name', 'price', 'description', 'category', 'sub_category']);

        if ($image = $request->file('image')) {
            $destinationPath = public_path('images');
            $profileImage = \Illuminate\Support\Str::random(20) . '.' . $image->extension();
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
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'category'     => 'required|string|max:255',
            'is_available' => 'required|in:0,1',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->only(['name', 'price', 'description', 'category', 'sub_category', 'is_available']);

        if ($image = $request->file('image')) {
            if ($menu->image && file_exists(public_path('images/' . $menu->image))) {
                unlink(public_path('images/' . $menu->image));
            }
            $destinationPath = public_path('images');
            $profileImage = \Illuminate\Support\Str::random(20) . '.' . $image->extension();
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
}
