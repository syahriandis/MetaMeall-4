<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResepMakan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ResepMakanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Trainer: lihat semua + form tambah (dropdown trainee)
    public function indexTrainer()
    {
        $data = ResepMakan::orderBy('tanggal', 'asc')->get();
        $trainees = User::where('role', 'trainee')->get();

        return view('pages.trainer.resepmakan', compact('data', 'trainees'));
    }

    // Trainee: hanya lihat miliknya
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = ResepMakan::where('trainee_id', $user->id)->orderBy('tanggal', 'asc')->get();

        return view('pages.resepmakan', compact('data'));
    }

    // Simpan resep baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trainee_id' => 'required|exists:users,id',
            'nama_makanan' => 'required',
            'tanggal' => 'required|date',
            'kategori' => 'required',
            'details' => 'required',
            'kalori' => 'required|numeric',
            'feedback' => 'nullable'
        ]);

        $validated['feedback'] = $validated['feedback'] ?? 'belum';

        // Sesuaikan field untuk model
        $validated['nama'] = $validated['nama_makanan'];
        $validated['jenis_makanan'] = $validated['kategori'];
        $validated['komposisi'] = $validated['details'];

        unset($validated['nama_makanan'], $validated['kategori'], $validated['details']);

        ResepMakan::create($validated);

        return response()->json(['message' => 'Resep berhasil ditambahkan']);
    }

    // Update resep
    public function update(Request $request, $id)
    {
        $resep = ResepMakan::findOrFail($id);

        $validated = $request->validate([
    'trainee_id' => 'required|exists:users,id',
    'nama' => 'required',
    'tanggal' => 'required|date',
    'jenis_makanan' => 'required',
    'details' => 'required', // ✅ INI WAJIB ADA
    'kalori' => 'required|numeric',
    'feedback' => 'nullable'
]);


        $validated['feedback'] = $validated['feedback'] ?? 'belum';

        $validated['nama'] = $validated['nama_makanan'];
        $validated['jenis_makanan'] = $validated['kategori'];
        $validated['komposisi'] = $validated['details'];

        unset($validated['nama_makanan'], $validated['kategori'], $validated['details']);

        $resep->update($validated);

        return response()->json(['message' => 'Resep berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $resep = ResepMakan::findOrFail($id);
        $resep->delete();

        return response()->json(['message' => 'Resep berhasil dihapus']);
    }

    public function submitFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string'
        ]);

        $resep = ResepMakan::findOrFail($id);
        $resep->feedback = $request->input('feedback');
        $resep->save();

        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }
}
