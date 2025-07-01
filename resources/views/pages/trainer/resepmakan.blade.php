<x-app>
    <!-- Tombol Tambah -->
    <div class="flex justify-end mb-4">
        <button id="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition transform hover:scale-105 duration-200">
            + Tambah Resep Makan
        </button>
    </div>

  <!-- Daftar Resep -->
<section class="space-y-4">
    @if(count($data) === 0)
        <p class="text-center text-gray-500">Belum ada resep makan.</p>
    @endif

    @foreach($data as $item)
    <div class="bg-gray-200 p-4 rounded-lg shadow-md flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold">{{ $item['trainee']['name'] ?? '-' }}</h2>
            <p class="text-sm">{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('l, d F Y') }}</p>
            <p class="text-sm text-gray-700 italic">({{ $item['nama_makanan'] ?? '-' }})</p>
            <p>{{ $item['kategori'] }}</p>
            <p class="text-sm text-gray-700">Kalori: {{ $item['kalori'] }} kcal</p>
            <p class="text-sm text-gray-700">Feedback: {{ $item['feedback'] ?? '-' }}</p>
        </div>
        <div class="space-x-2">
            <button class="bg-green-500 text-white px-4 py-2 rounded open-modal-btn"
                data-id="{{ $item['id'] }}"
                data-nama="{{ $item['nama_makanan'] }}"
                data-tanggal="{{ $item['tanggal'] }}"
                data-kategori="{{ $item['kategori'] }}"
                data-detail="{{ $item['details'] }}"
                data-feedback="{{ $item['feedback'] }}"
                data-kalori="{{ $item['kalori'] }}">
                Ubah
            </button>
            <button class="bg-red-500 text-white px-4 py-2 rounded delete-btn" data-id="{{ $item['id'] }}">
                Hapus
            </button>
        </div>
    </div>
    @endforeach
</section>


    <!-- Modal Tambah/Edit -->
    <div id="editModal" class="fixed inset-0 bg-white/30 backdrop-blur-md flex items-center justify-center hidden z-50">
        <div class="bg-white text-black rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-bold mb-4" id="modalTitle">Tambah Resep Makan</h2>
            <form id="editForm">
                <input type="hidden" id="recordId" name="id" />
                <input type="hidden" id="modalMode" value="add" />

                <div class="mb-4" id="traineeDropdownWrapper">
                    <label class="block text-sm font-semibold mb-1">Pilih Trainee</label>
                    <select id="traineeSelect" name="trainee_id" class="w-full border rounded p-2 bg-white text-black">
                        <option value="">-- Pilih Trainee --</option>
                        @foreach($trainees as $trainee)
                            <option value="{{ $trainee->id }}">{{ $trainee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Nama Makanan</label>
                    <input type="text" id="modalNama" name="nama_makanan" class="w-full border rounded p-2" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Tanggal</label>
                    <input type="date" id="modalTanggal" name="tanggal" class="w-full border rounded p-2" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Kategori</label>
                    <input type="text" id="modalKategori" name="kategori" class="w-full border rounded p-2" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Detail</label>
                    <textarea id="modalDetail" name="details" class="w-full border rounded p-2" rows="3" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Kalori</label>
                    <input type="number" id="modalKalori" name="kalori" class="w-full border rounded p-2" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Feedback</label>
                    <textarea id="modalFeedback" name="feedback" class="w-full border rounded p-2" rows="2"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script -->
    <script>
        const modal = document.getElementById("editModal");
        const modalMode = document.getElementById("modalMode");
        const modalTitle = document.getElementById("modalTitle");
        const recordId = document.getElementById("recordId");
        const traineeSelect = document.getElementById("traineeSelect");
        const traineeWrapper = document.getElementById("traineeDropdownWrapper");

        const modalNama = document.getElementById("modalNama");
        const modalTanggal = document.getElementById("modalTanggal");
        const modalKategori = document.getElementById("modalKategori");
        const modalDetail = document.getElementById("modalDetail");
        const modalKalori = document.getElementById("modalKalori");
        const modalFeedback = document.getElementById("modalFeedback");

        document.getElementById("openAddModal").addEventListener("click", () => {
            modalMode.value = "add";
            modalTitle.textContent = "Tambah Resep Makan";
            recordId.value = "";
            modalNama.value = "";
            modalTanggal.value = "";
            modalKategori.value = "";
            modalDetail.value = "";
            modalKalori.value = "";
            modalFeedback.value = "";
            traineeSelect.value = "";
            traineeWrapper.classList.remove("hidden");
            modal.classList.remove("hidden");
        });

        document.querySelectorAll(".open-modal-btn").forEach(button => {
            button.addEventListener("click", () => {
                modalMode.value = "edit";
                modalTitle.textContent = "Ubah Resep Makan";
                recordId.value = button.dataset.id;
                modalNama.value = button.dataset.nama;
                modalTanggal.value = button.dataset.tanggal;
                modalKategori.value = button.dataset.kategori;
                modalDetail.value = button.dataset.detail;
                modalKalori.value = button.dataset.kalori;
                modalFeedback.value = button.dataset.feedback;
                traineeWrapper.classList.add("hidden");
                modal.classList.remove("hidden");
            });
        });

        document.getElementById("closeModal").addEventListener("click", () => {
            modal.classList.add("hidden");
        });

        document.getElementById("editForm").addEventListener("submit", function (e) {
            e.preventDefault();

            const mode = modalMode.value;
            const id = recordId.value;
            const url = mode === "add"
                ? "{{ route('resep.store') }}"
                : `/resepmakan/update/${id}`;

            const token = '{{ csrf_token() }}';
            const data = {
    nama_makanan: modalNama.value,
    tanggal: modalTanggal.value,
    kategori: modalKategori.value,
    details: modalDetail.value, // ✅ ini WAJIB ADA
    kalori: modalKalori.value,
    feedback: modalFeedback.value,
    _token: token
};


            if (mode === "add") {
                data.trainee_id = traineeSelect.value;
            }

            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(result => {
                alert(result.message || "Berhasil!");
                location.reload();
            })
            .catch(err => {
                console.error(err);
                alert("Terjadi kesalahan");
            });
        });

        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", () => {
                const id = button.getAttribute("data-id");
                if (confirm("Yakin ingin menghapus resep ini?")) {
                    fetch(`/resepmakan/delete/${id}`, { method: "GET" })
                        .then(res => res.json())
                        .then(result => {
                            alert(result.message || "Berhasil dihapus");
                            location.reload();
                        });
                }
            });
        });
    </script>
</x-app>
