<x-app>
    <section class="space-y-4">
        @foreach($data as $resep)

        <div class="bg-white p-4 rounded shadow-md">
            <div>
                <h2 class="text-xl font-bold text-blue-700">{{ $resep['nama'] ?? '-' }}</h2>
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($resep['tanggal'])->translatedFormat('l, d F Y') }}</p>
                <p><strong>Jenis Makanan:</strong> {{ $resep['jenis_makanan'] ?? '-' }}</p>
                <p><strong>Kalori:</strong> {{ $resep['kalori'] ?? '-' }} kkal</p>
            </div>
            <div class="mt-2">
                <button 
                    class="bg-green-600 text-white px-3 py-1 rounded detail-btn"
                    data-detail="{{ $resep['detail'] ?? '-' }}"
                    data-status="{{ $resep['status'] ?? '-' }}"
                >Lihat Detail
                </button>
            </div>
        </div>
        @endforeach
    </section>

    <!-- Modal Detail Resep -->
    <div id="detailModal" class="fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm bg-black/40 hidden">
        <div class="bg-white p-6 rounded-lg w-96 shadow">
            <h2 class="text-lg font-bold mb-2">Detail Resep Makan</h2>
            <p id="modalDetail" class="mb-2 text-gray-700"></p>
            <p id="modalStatus" class="text-sm italic text-gray-500"></p>
            <form id="feedbackForm" class="mt-4 space-y-2">
            <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback:</label>
            <textarea id="feedback" name="feedback" rows="3" class="w-full border rounded p-2" placeholder="Tulis feedback Anda..."></textarea>
            <button type="submit" class="px-4 py-1 bg-blue-600 text-white rounded">Kirim Feedback</button>
            <div id="feedbackMsg" class="text-green-600 text-sm mt-1 hidden">Feedback terkirim!</div>
        </form>
        <div class="mt-4 text-right">
            <button id="closeDetailModal" class="px-4 py-1 bg-gray-500 text-white rounded">Tutup</button>
        </div>
        <script>
            document.getElementById('feedbackForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Simulasi kirim feedback, bisa diganti AJAX ke backend
            document.getElementById('feedbackMsg').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('feedbackMsg').classList.add('hidden');
                document.getElementById('feedback').value = '';
            }, 2000);
            });
        </script>
    </div>
</div>

    <script>
        const modal = document.getElementById('detailModal');
        const detailText = document.getElementById('modalDetail');
        const statusText = document.getElementById('modalStatus');
        const closeBtn = document.getElementById('closeDetailModal');

        document.querySelectorAll('.detail-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                detailText.textContent = 'Detail: ' + btn.getAttribute('data-detail');
                statusText.textContent = 'Status: ' + btn.getAttribute('data-status');
                modal.classList.remove('hidden');
            });
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    </script>
</x-app>
