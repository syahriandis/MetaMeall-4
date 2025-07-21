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
        $trainees = User::where('role', 'trainee')->get();
        $data = [];

        foreach ($trainees as $trainee) {
            $resep = ResepMakan::where('trainee_id', $trainee->id)
                ->orderBy('tanggal', 'asc')
                ->get();

            $data[] = [
                'nama' => $trainee->name,
                'gender' => $trainee->gender,
                'umur' => $trainee->age,
                'berat' => $trainee->weight,
                'tinggi' => $trainee->height,
                'foto' => $trainee->foto,
                'resep' => $resep,
            ];
        }

        return view('pages.trainer.resepmakan', [
            'data' => $data,
            'trainees' => $trainees
        ]);
    }

    public function trainee()
    {
        return $this->belongsTo(User::class, 'trainee_id');
    }

    // Trainee: hanya lihat miliknya
    public function indexTrainee()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = ResepMakan::where('trainee_id', $user->id)->orderBy('tanggal', 'asc')->get();
        if ($data->isEmpty()) {
            return redirect()->back()->with('info', 'Belum ada resep yang ditambahkan.');
        }
        return view('pages.resepmakan', compact('data'));
    }

    // Simpan resep baru
    public function store(Request $request)
    {
        $validated = $request->validate([
    'trainee_id' => 'required|exists:users,id',
    'nama' => 'required',
    'tanggal' => 'required|date',
    'jenis_makanan' => 'required',
    'komposisi' => 'required',
    'kalori' => 'required|numeric',
    'feedback' => 'nullable|string'
]);

$data = [
    'trainee_id' => $validated['trainee_id'],
    'nama' => $validated['nama'],
    'tanggal' => $validated['tanggal'],
    'jenis_makanan' => $validated['jenis_makanan'],
    'komposisi' => $validated['komposisi'],
    'kalori' => $validated['kalori'],
    'feedback' => $validated['feedback'] ?? 'belum'
];

        ResepMakan::create($data);

        return response()->json(['message' => 'Resep berhasil ditambahkan']);
    }

    // Update resep
    public function update(Request $request, $id)
    {
        $resep = ResepMakan::findOrFail($id);

     $validated = $request->validate([
    'nama' => 'required',
    'tanggal' => 'required|date',
    'jenis_makanan' => 'required',
    'komposisi' => 'required',
    'kalori' => 'required|numeric',
    'feedback' => 'nullable|string'
]);

$data = [
    'nama' => $validated['nama'],
    'tanggal' => $validated['tanggal'],
    'jenis_makanan' => $validated['jenis_makanan'],
    'komposisi' => $validated['komposisi'],
    'kalori' => $validated['kalori'],
    'feedback' => $validated['feedback'] ?? 'belum'
];


        $resep->update($data);

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
