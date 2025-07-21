<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramLatihan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProgramLatihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Trainer melihat semua program berdasarkan trainee
    public function programlatihan_trainer()
    {
        $trainees = User::where('role', 'trainee')->get();
        $data = [];

        foreach ($trainees as $trainee) {
            $programs = ProgramLatihan::where('trainee_id', $trainee->id)
                ->orderBy('tanggal', 'asc')
                ->get();

            $data[] = [
                'nama' => $trainee->name,
                'gender' => $trainee->gender,
                'umur' => $trainee->age,
                'berat' => $trainee->weight,
                'tinggi' => $trainee->height,
                'foto' => $trainee->foto,
                'programs' => $programs,
            ];
        }

        return view('pages.trainer.programlatihan', [
            'data' => $data,
            'trainees' => $trainees,
        ]);
    }

    // Trainee melihat program miliknya
    public function programlatihan()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = ProgramLatihan::where('trainee_id', $user->id)
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('pages.programlatihan', compact('data'));
    }

    // Tambah program latihan (oleh trainer)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trainee_id' => 'required|exists:users,id',
            'nama' => 'required',
            'tanggal' => 'required|date',
            'jenis_latihan' => 'required',
            'details' => 'required',
            'feedback' => 'nullable',
            'kalori' => 'required|numeric',
        ]);

        $validated['feedback'] = $validated['feedback'] ?? 'belum';

        ProgramLatihan::create($validated);

        return response()->json(['message' => 'Program latihan berhasil ditambahkan']);
    }

    // Update program
    public function update(Request $request, $id)
    {
        $program = ProgramLatihan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'jenis_latihan' => 'required',
            'details' => 'required',
            'feedback' => 'nullable',
            'kalori' => 'required|numeric',
        ]);

        $validated['feedback'] = $validated['feedback'] ?? 'belum';

        $program->update($validated);

        return response()->json(['message' => 'Program latihan berhasil diperbarui']);
    }

    // Hapus program
    public function destroy($id)
    {
        $program = ProgramLatihan::findOrFail($id);
        $program->delete();

        return response()->json(['message' => 'Program latihan berhasil dihapus']);
    }

    // Trainee mengirim feedback
    public function submitFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string',
        ]);

        $program = ProgramLatihan::findOrFail($id);
        $program->feedback = $request->input('feedback');
        $program->save();

        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }
}
