<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    // Untuk trainee (hanya bisa lihat & hapus)
    public function index()
    {
        $data = Notifikasi::latest()->get();
        return view('pages.notifikasi', compact('data'));
    }

    // Untuk trainer (bisa tambah, edit, hapus)
    public function indextrainer()
    {
        $data = Notifikasi::latest()->get();
        return view('pages.trainer.notifikasi', compact('data'));
    }

    // Tambah notifikasi (khusus trainer)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'is_read' => 'required|boolean',
        ]);

        Notifikasi::create($request->only('title', 'message', 'is_read'));

        return redirect()->back()->with('success', 'Notifikasi berhasil ditambahkan.');
    }

    // Edit notifikasi (khusus trainer)
    public function update(Request $request, $id)
    {
        $notifikasi = Notifikasi::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'is_read' => 'required|boolean',
        ]);

        $notifikasi->update($request->only('title', 'message', 'is_read'));

        return response()->json(['message' => 'Notifikasi berhasil diperbarui.']);
    }

    // Hapus notifikasi (bisa diakses trainee dan trainer)
    public function destroy($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->delete();

        return response()->json(['message' => 'Notifikasi berhasil dihapus.']);
    }

    // Tandai sebagai "Sudah Dibaca" (khusus trainee)
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->is_read = true;
        $notifikasi->save();

        return response()->json(['message' => 'Notifikasi ditandai sebagai sudah dibaca.']);
    }
}
