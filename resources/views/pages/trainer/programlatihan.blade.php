<x-app>
    <!-- Tombol Tambah -->
    <div class="flex justify-end mb-4">
        <button id="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition transform hover:scale-105 duration-200">
            + Tambah Program Latihan
        </button>
    </div>

    <!-- Daftar Program -->
    <section class="space-y-4">
        @if(count($data) === 0)
            <p class="text-center text-gray-500">Belum ada program latihan.</p>
        @endif

        @foreach($data as $item)
        <div class="bg-gray-200 p-4 rounded-lg shadow-md flex justify-between items-center shadow transition hover:shadow-lg duration-300">
            <div>
                <h2 class="text-xl font-bold">{{ $item['nama'] ?? '-' }}</h2>
                <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('l, d F Y') }}</p>
                <p>{{ $item['jenis_latihan'] ?? '-' }}</p>
                <p class="text-sm text-gray-700">Kalori: {{ $item['kalori'] ?? 0 }} kcal</p>
                <p class="text-sm text-gray-700">Feedback: {{ $item['feedback'] ?? '-' }}</p>
            </div>
            <div class="space-x-2">
                <button class="bg-green-500 text-white px-4 py-2 rounded open-modal-btn"
                    data-id="{{ $item['id'] ?? '' }}"
                    data-nama="{{ $item['nama'] ?? '' }}"
                    data-tanggal="{{ $item['tanggal'] ?? '' }}"
                    data-latihan="{{ $item['jenis_latihan'] ?? '' }}"
                    data-detail="{{ $item['details'] ?? '' }}"
                    data-feedback="{{ $item['feedback'] ?? '' }}"
                    data-kalori="{{ $item['kalori'] ?? 0 }}">
                    Ubah
                </button>
                <button class="bg-red-500 text-white px-4 py-2 rounded delete-btn"
                    data-id="{{ $item['id'] ?? '' }}">
                    Hapus
                </button>
            </div>
        </div>
        @endforeach
    </section>

    <!-- Modal Tambah/Edit -->
    <div id="editModal" class="fixed inset-0 bg-white/30 backdrop-blur-md flex items-center justify-center hidden z-50">
        <div class="bg-white text-black rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-bold mb-4" id="modalTitle">Tambah Program Latihan</h2>
            <form id="editForm">
                <input type="hidden" id="recordId" name="id" />
                <input type="hidden" id="modalMode" value="add" />

                <!-- TRAINEE DROPDOWN -->
                @if(isset($trainees))
                <div class="mb-4" id="traineeDropdownWrapper">
                    <label class="block text-sm font-semibold mb-1">Pilih Trainee</label>
                    <select id="traineeSelect" name="trainee_id" class="w-full border rounded p-2 bg-white text-black">
                        <option value="">-- Pilih Trainee --</option>
                        @foreach($trainees as $trainee)
                            <option value="{{ $trainee->id }}">{{ $trainee->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Nama</label>
                    <input type="text" id="modalNama" name="nama" class="w-full border rounded p-2 bg-white text-black" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Tanggal</label>
                    <input type="date" id="modalTanggal" name="tanggal" class="w-full border rounded p-2 bg-white text-black" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Jenis Latihan</label>
                    <input type="text" id="modalLatihan" name="jenis_latihan" class="w-full border rounded p-2 bg-white text-black" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Details</label>
                    <textarea id="details" name="details" rows="3" class="w-full border rounded p-2 bg-white text-black resize-none" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Kalori</label>
                    <input type="number" id="modalKalori" name="kalori" class="w-full border rounded p-2 bg-white text-black" required />
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Feedback dari Trainee</label>
                    <textarea id="edit-feedback" name="feedback" rows="2" class="w-full border rounded p-2 bg-white text-black resize-none"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <!-- Script interaksi -->
    <script>
        const modal = document.getElementById("editModal");
        const closeModal = document.getElementById("closeModal");
        const modalMode = document.getElementById("modalMode");
        const modalTitle = document.getElementById("modalTitle");
        const recordId = document.getElementById("recordId");
        const modalNama = document.getElementById("modalNama");
        const modalTanggal = document.getElementById("modalTanggal");
        const modalLatihan = document.getElementById("modalLatihan");
        const modalDetails = document.getElementById("details");
        const modalKalori = document.getElementById("modalKalori");
        const modalFeedback = document.getElementById("edit-feedback");
        const traineeSelect = document.getElementById("traineeSelect");
        const traineeWrapper = document.getElementById("traineeDropdownWrapper");

        document.querySelectorAll(".open-modal-btn").forEach(button => {
            button.addEventListener("click", () => {
                modalMode.value = "edit";
                modalTitle.textContent = "Ubah Program Latihan";
                recordId.value = button.getAttribute("data-id");
                modalNama.value = button.getAttribute("data-nama");
                modalTanggal.value = button.getAttribute("data-tanggal");
                modalLatihan.value = button.getAttribute("data-latihan");
                modalDetails.value = button.getAttribute("data-detail");
                modalKalori.value = button.getAttribute("data-kalori");
                modalFeedback.value = button.getAttribute("data-feedback");
                if (traineeWrapper) traineeWrapper.classList.add("hidden");
                modal.classList.remove("hidden");
            });
        });

        document.getElementById("openAddModal").addEventListener("click", () => {
            modalMode.value = "add";
            modalTitle.textContent = "Tambah Program Latihan";
            recordId.value = "";
            modalNama.value = "";
            modalTanggal.value = "";
            modalLatihan.value = "";
            modalDetails.value = "";
            modalKalori.value = "";
            modalFeedback.value = "";
            if (traineeSelect) traineeSelect.value = "";
            if (traineeWrapper) traineeWrapper.classList.remove("hidden");
            modal.classList.remove("hidden");
        });

        closeModal.addEventListener("click", () => {
            modal.classList.add("hidden");
        });

        document.getElementById("editForm").addEventListener("submit", function (e) {
            e.preventDefault();

            const mode = modalMode.value;
            const id = recordId.value;
            const url = mode === "add"
                ? "{{ route('program.store') }}"
                : `/programlatihan/update/${id}`;

            const token = '{{ csrf_token() }}';

            const data = {
                nama: modalNama.value,
                tanggal: modalTanggal.value,
                jenis_latihan: modalLatihan.value,
                details: modalDetails.value,
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
                alert("Terjadi kesalahan saat mengirim data");
            });
        });

        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", () => {
                const id = button.getAttribute("data-id");
                if (confirm("Yakin ingin menghapus data ini?")) {
                    fetch(`/programlatihan/delete/${id}`, {
                        method: "GET"
                    })
                    .then(res => res.json())
                    .then(result => {
                        alert(result.message || "Berhasil dihapus");
                        location.reload();
                    });
                }
            });
        });
    </script>
    @endpush
</x-app>
