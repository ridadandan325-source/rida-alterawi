<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\User;
use Illuminate\Http\Request;

class AdminLandController extends Controller
{
    public function index()
    {
        $lands = Land::with('user')->latest()->get();
        return view('admin.lands.index', compact('lands'));
    }

    public function edit(Land $land)
    {
        $users = User::orderBy('name')->get(['id','name','email']);
        return view('admin.lands.edit', compact('land','users'));
    }

    public function update(Request $request, Land $land)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'lat' => ['required','numeric'],
            'lng' => ['required','numeric'],
            'is_for_sale' => ['nullable'],
            'user_id' => ['required','exists:users,id'],
        ]);

        $data['is_for_sale'] = $request->has('is_for_sale');

        $land->update($data);

        return redirect()->route('admin.lands.index')->with('success', 'Land updated (Admin) ✅');
    }

    public function destroy(Land $land)
    {
        $land->delete();
        return redirect()->route('admin.lands.index')->with('success', 'Land deleted (Admin) ✅');
    }
}
