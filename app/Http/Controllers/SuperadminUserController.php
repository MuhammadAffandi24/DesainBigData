<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gudang;
use Illuminate\Http\Request;

class SuperadminUserController extends Controller
{
    /**
     * Dashboard superadmin
     */
    public function index()
    {
        $users = User::all();

        $total = Gudang::count();
        $aktif = Gudang::where('status', 'active')->count();
        $nonaktif = Gudang::where('status', 'inactive')->count();

        return view('admin.homepageadmin', [
            'users' => $users,
            'total_gudang' => $total,
            'aktif' => $aktif,
            'nonaktif' => $nonaktif
        ]);
    }

    /**
     * Update status user (Aktif / Tidak Aktif)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        $user = User::findOrFail($id);

        // Safety: superadmin utama ga boleh dinonaktifkan (opsional)
        if ($user->role === 'Superadmin') {
            return back()->with('error', 'Status Superadmin tidak boleh diubah');
        }

        $user->status = $request->status;
        $user->save();

        return back()->with('success', 'Status user berhasil diperbarui');
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Safety rule
        if ($user->role === 'Superadmin') {
            return back()->with('error', 'Superadmin tidak boleh dihapus');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
