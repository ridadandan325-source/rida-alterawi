<?php

namespace App\Http\Controllers;

use App\Models\Land;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandController extends Controller
{
    // عرض أراضي المستخدم اللي عامل Login
    public function index()
    {
        $lands = Land::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('lands.index', compact('lands'));
    }

    // صفحة فورم إضافة أرض
    public function create()
    {
        return view('lands.create');
    }

    // حفظ أرض جديدة
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
        ]);

        $data['is_for_sale'] = $request->has('is_for_sale');
        $data['user_id'] = Auth::id();

        Land::create($data);

        return redirect()->route('lands.index')
            ->with('success', 'Land added successfully!');
    }

    // صفحة تعديل أرض
    public function edit(Land $land)
    {
        if ($land->user_id !== Auth::id()) {
            return redirect()->route('lands.index')
                ->with('error', 'You are not allowed to edit this land.');
        }

        if (!$land->is_for_sale) {
            return redirect()->route('lands.index')
                ->with('error', 'This land is sold and cannot be edited.');
        }

        return view('lands.edit', compact('land'));
    }

    // تحديث بيانات الأرض
    public function update(Request $request, Land $land)
    {
        if ($land->user_id !== Auth::id()) {
            return redirect()->route('lands.index')
                ->with('error', 'You are not allowed to update this land.');
        }

        if (!$land->is_for_sale) {
            return redirect()->route('lands.index')
                ->with('error', 'This land is sold and cannot be updated.');
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
        ]);

        $data['is_for_sale'] = $request->has('is_for_sale');

        $land->update($data);

        return redirect()->route('lands.index')
            ->with('success', 'Land updated successfully!');
    }

    // حذف أرض
    public function destroy(Land $land)
    {
        if ($land->user_id !== Auth::id()) {
            return redirect()->route('lands.index')
                ->with('error', 'You are not allowed to delete this land.');
        }

        if (!$land->is_for_sale) {
            return redirect()->route('lands.index')
                ->with('error', 'This land is sold and cannot be deleted.');
        }

        $land->delete();

        return redirect()->route('lands.index')
            ->with('success', 'Land deleted successfully!');
    }
}
