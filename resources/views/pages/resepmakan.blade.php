<x-app title="Resep Makanan Trainer">
    <div class="space-y-4">
        @forelse ($data as $item)
        <div class="bg-gray-100 p-4 rounded-lg shadow-md flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">{{ $item->nama }}</h2>
                <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</p>
                <p class="text-sm">{{ $item->jenismakanan }}</p>
                <p class="text-xs text-gray-600">{{ $item->kalori }} Kalori</p>
            </div>
            <button onclick="showModal({{ $item->id }})" class="focus:outline-none text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
        @empty
        <p class="text-center text-gray-500">Belum ada resep dari trainer Anda.</p>
        @endforelse
    </div>

    <!-- Modal -->
    <div id="resepModal" class="fixed inset-0 bg-white/50 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl relative">
            <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
            <div id="modalContent"></div>
        </div>
    </div>

    <!-- JS -->
    <script>
        const resepData = @json($data);

        function toggleModal() {
            document.getElementById("resepModal").classList.toggle("hidden");
        }

        function showModal(id) {
            const resep = resepData.find(item => item.id === id);
            if (!resep) return;

            const content = `
                <h3 class="text-2xl font-bold mb-2">${resep.nama}</h3>
                <p class="text-sm text-gray-500 mb-2">${new Date(resep.tanggal).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</p>
                <p class="font-semibold mb-1">Jenis Makanan: ${resep.jenismakanan}</p>
                <p class="font-semibold mb-1">Kalori: ${resep.kalori} Kalori</p>
                <p class="font-semibold mt-4">Detail:</p>
                <p class="text-sm text-gray-700 whitespace-pre-line">${resep.details}</p>
            `;

            document.getElementById("modalContent").innerHTML = content;
            toggleModal();
        }
    </script>
</x-app>
