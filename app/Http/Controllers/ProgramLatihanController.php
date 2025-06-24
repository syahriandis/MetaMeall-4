<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramLatihan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProgramLatihanController extends Controller
{
    // Middleware auth agar semua method hanya bisa diakses jika sudah login
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Halaman untuk trainer melihat semua program + dropdown trainee
    public function programlatihan_trainer()
    {
        $data = ProgramLatihan::orderBy('tanggal', 'asc')->get();
        $trainees = User::where('role', 'trainee')->get();

        return view('pages.trainer.programlatihan', compact('data', 'trainees'));
    }

    // Halaman untuk trainee melihat program latihan miliknya
    public function programlatihan()
    {
        $user = Auth::user();

        // Tambahan perlindungan jika user null
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = ProgramLatihan::where('trainee_id', $user->id)->orderBy('tanggal', 'asc')->get();

        return view('pages.programlatihan', compact('data'));
    }

    // Menyimpan data baru (trainer yang tambah program latihan untuk trainee)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trainee_id' => 'required|exists:users,id',
            'nama' => 'required',
            'tanggal' => 'required|date',
            'jenis_latihan' => 'required',
            'details' => 'required',
            'feedback' => 'nullable',
            'kalori' => 'required|numeric'
        ]);

        $validated['feedback'] = $validated['feedback'] ?? 'belum';

        ProgramLatihan::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan']);
    }

    // Update program latihan yang sudah ada
    public function update(Request $request, $id)
    {
        $program = ProgramLatihan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'jenis_latihan' => 'required',
            'details' => 'required',
            'feedback' => 'nullable',
            'kalori' => 'required|numeric'
        ]);

        $validated['feedback'] = $validated['feedback'] ?? 'belum';

        $program->update($validated);

        return response()->json(['message' => 'Data diperbarui']);
    }

    // Hapus program latihan
    public function destroy($id)
    {
        $program = ProgramLatihan::findOrFail($id);
        $program->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    // Trainee mengirim feedback
    public function submitFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string'
        ]);

        $program = ProgramLatihan::findOrFail($id);
        $program->feedback = $request->input('feedback');
        $program->save();

        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }
}
