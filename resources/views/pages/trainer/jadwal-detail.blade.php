<x-app>
    <div class="max-w-4xl mx-auto mt-6 space-y-6">

        <!-- Header Trainee -->
        <div class="flex items-center gap-4 bg-white p-4 rounded shadow border">
            <img src="{{ asset('img/' . ($trainee->gender === 'female' ? 'female-icon.png' : ($trainee->gender === 'male' ? 'male-icon.png' : 'default-icon.png'))) }}"
                 alt="Profil"
                 class="w-16 h-16 rounded-full border border-green-500 object-cover">

            <div>
                <h2 class="text-xl font-bold">{{ $trainee->name }}</h2>
                <p class="text-gray-600 text-sm">
                    Umur: {{ $trainee->umur ?? '-' }} |
                    Berat: {{ $trainee->berat ?? '-' }} kg |
                    Tinggi: {{ $trainee->tinggi ?? '-' }} cm
                </p>
            </div>
        </div>

        <!-- Jadwal Latihan -->
        <div class="bg-white p-4 rounded shadow border">
            <h3 class="text-lg font-semibold mb-4">Jadwal Program Latihan</h3>

            @if($jadwal->isEmpty())
                <p class="text-gray-500 italic">Belum ada program latihan untuk trainee ini.</p>
            @else
                <ul class="space-y-3">
                    @foreach($jadwal as $item)
                        <li class="border p-3 rounded bg-gray-50">
                            <p class="font-semibold">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</p>
                            <p class="text-sm">Program: {{ $item->nama_program }}</p>
                            <p class="text-sm text-gray-600 italic">Feedback: {{ $item->feedback ?? 'Belum diberikan' }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div>
            <a href="{{ route('resep.trainer') }}" class="text-green-600 hover:underline text-sm">← Kembali ke daftar resep</a>
        </div>
    </div>
</x-app>
