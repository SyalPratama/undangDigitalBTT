<?php

namespace App\Http\Controllers\Reseller;


use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;

class ResKelolaUserController extends Controller
{
    // Menampilkan halaman kelola user
    public function index(Request $request)
    {
        $roles = Role::all(); 
        $users = User::with('roles')
            ->where('reseller_id', Auth::id())
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('reseller.kelola-user', compact('users', 'roles'));
    }

    // Menyimpan data user baru.

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'roles'    => 'nullable|array',
        ], [
            'email.unique' => 'Email ini sudah terdaftar di sistem! Gunakan email lain.',
        ]);

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->password, 
                'reseller_id' => Auth::id(),
            ]);

            if ($request->has('roles')) {
                $user->roles()->sync($request->roles);
            }

            return redirect()->back()->with('success', 'User berhasil ditambahkan.');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan user: ' . $e->getMessage()])->withInput();
        }
    }

    // Memperbarui data user.
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'roles'    => 'nullable|array',
        ], [
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain!',
        ]);

        try {
            $userData = [
                'name'  => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = $request->password;
            }

            $user->update($userData);
            $user->roles()->sync($request->roles ?? []);

            return redirect()->back()->with('success', 'Data user berhasil diperbarui.');

        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }

    // Menghapus data user.
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()->with('success', 'User berhasil dihapus.');
            
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus user: ' . $e->getMessage()]);
        }
    }
}