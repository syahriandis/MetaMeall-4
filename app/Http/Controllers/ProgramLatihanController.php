<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramLatihan;

class ProgramLatihanController extends Controller
{
    public function programlatihan_trainer()
    {
        $data = ProgramLatihan::orderBy('tanggal', 'asc')->get();
        return view('pages.trainer.programlatihan', compact('data'));
    }

    public function programlatihan()
    {
        $data = ProgramLatihan::orderBy('tanggal', 'asc')->get();
        return view('pages.programlatihan', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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

    public function destroy($id)
    {
        $program = ProgramLatihan::findOrFail($id);
        $program->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    // ✅ Tambahkan method feedback DI DALAM class
    public function submitFeedback(Request $request, $id)
    {
        $request->validate([
            'feedback' => 'required|string'
        ]);

        $program = ProgramLatihan::findOrFail($id);
        // dd($program);
        $program->feedback = $request->input('feedback');
        // $program->status = 'sudah'; // Ubah status menjadi 'sudah' jika feedback sudah diberikan
        $program->save();

        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }
}
