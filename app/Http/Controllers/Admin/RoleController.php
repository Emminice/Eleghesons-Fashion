<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Show the role management page listing all users.
     */
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.roles', compact('users'));
    }

    /**
     * Promote a customer to admin.
     */
    public function makeAdmin(User $user)
    {
        // Prevent self-demotion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $user->update(['role' => 'admin']);

        return back()->with('success', "{$user->name} has been promoted to Admin.");
    }

    /**
     * Demote an admin back to customer.
     */
    public function makeCustomer(User $user)
    {
        // Prevent self-demotion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        // Prevent removing the last admin
        $adminCount = User::where('role', 'admin')->count();
        if ($adminCount <= 1) {
            return back()->with('error', 'Cannot remove the last admin. Promote another user first.');
        }

        $user->update(['role' => 'customer']);

        return back()->with('success', "{$user->name} has been changed to Customer.");
    }

    /**
     * Toggle role directly (admin <-> customer).
     */
    public function toggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot remove the last admin.');
            }
            $user->update(['role' => 'customer']);
            $msg = "{$user->name} changed to Customer.";
        } else {
            $user->update(['role' => 'admin']);
            $msg = "{$user->name} promoted to Admin.";
        }

        return back()->with('success', $msg);
    }
}
