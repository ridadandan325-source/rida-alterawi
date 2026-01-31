<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\User;
use Illuminate\Http\Request;

use App\Services\LandService;
use App\Models\LandOwnership;
use Illuminate\Support\Facades\DB;

class AdminLandController extends Controller
{
    protected $landService;

    public function __construct(LandService $landService)
    {
        $this->landService = $landService;
    }

    public function index()
    {
        $lands = Land::with('user')->latest()->get();
        return view('admin.lands.index', compact('lands'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get(['id', 'name', 'email']);
        return view('admin.lands.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'is_for_sale' => ['nullable'],
            'user_id' => ['required', 'exists:users,id'],
            'coordinates' => ['nullable', 'string'],
            'area' => ['nullable', 'numeric'],
        ]);

        $data['is_for_sale'] = $request->has('is_for_sale');
        $data['land_unique_id'] = $this->landService->generateUniqueId();
        $data['land_id'] = $data['land_unique_id']; // Sync legacy field

        // Initial status logic
        $data['status'] = $data['is_for_sale'] ? 'listed_admin' : 'created';

        DB::transaction(function () use ($data) {
            $land = Land::create($data);

            // Create initial ownership record
            LandOwnership::create([
                'land_id' => $land->id,
                'user_id' => $land->user_id,
                'owned_at' => now(),
                'is_current' => true,
            ]);
        });

        return redirect()->route('admin.lands.index')->with('success', 'Land minted successfully with ID: ' . $data['land_id'] . ' ✅');
    }

    public function edit(Land $land)
    {
        $users = User::orderBy('name')->get(['id', 'name', 'email']);
        return view('admin.lands.edit', compact('land', 'users'));
    }

    public function update(Request $request, Land $land)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'is_for_sale' => ['nullable'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $data['is_for_sale'] = $request->has('is_for_sale');

        // Update status if listing status changed
        if ($land->user->is_admin) {
            $data['status'] = $data['is_for_sale'] ? 'listed_admin' : 'created';
        } else {
            $data['status'] = $data['is_for_sale'] ? 'listed_owner' : 'owned';
        }

        DB::transaction(function () use ($land, $data) {
            $oldUserId = $land->user_id;
            $land->update($data);

            // If owner was manually changed by admin, update ownership record
            if ($oldUserId != $data['user_id']) {
                $this->landService->transferOwnership($land, $data['user_id']);
            }
        });

        return redirect()->route('admin.lands.index')->with('success', 'Land updated (Admin) ✅');
    }

    public function destroy(Land $land)
    {
        $land->delete();
        return redirect()->route('admin.lands.index')->with('success', 'Land deleted (Admin) ✅');
    }
}
