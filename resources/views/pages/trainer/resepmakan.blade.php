<x-app>
    <!-- Tombol Tambah -->
    <div class="flex justify-end mb-4">
        <button onclick="toggle_create()" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition transform hover:scale-105 duration-200">
            + Tambah Resep Makan
        </button>
    </div>

    <!-- Daftar Resep -->
    <div id="listData">
        @foreach($data as $item)
        <div class="bg-gray-200 p-4 rounded-lg shadow-md flex justify-between items-center transition hover:shadow-lg duration-300 mb-4" data-id="{{ $item['id'] }}">
            <div>
                <h2 class="text-xl font-bold">{{ $item['nama'] ?? '-' }}</h2>
                <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('l, d F Y') }}</p>
                <p>{{ $item['jenismakanan'] ?? '-' }}</p>
                <p class="text-sm text-gray-600">{{ $item['kalori'] ?? '-' }} Kalori</p>
            </div>
            <div class="space-x-2">
                <button class="bg-green-500 text-white px-4 py-2 rounded open-modal-btn"
                    data-id="{{ $item['id'] }}"
                    data-nama="{{ $item['nama'] }}"
                    data-tanggal="{{ $item['tanggal'] }}"
                    data-jenismakanan="{{ $item['jenismakanan'] }}"
                    data-details="{{ $item['details'] }}"
                    data-kalori="{{ $item['kalori'] }}"
                    data-status="{{ $item['status'] }}">
                    Ubah
                </button>
                <button class="bg-red-500 text-white px-4 py-2 rounded delete-btn" data-id="{{ $item['id'] }}">
                    Hapus
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal Tambah/Ubah -->
    <div id="editModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 id="modalTitle" class="text-xl font-bold mb-4">Tambah Resep Makan</h2>
            <form id="editForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="modalId" name="id" />
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Nama User</label>
                    <input type="text" id="modalNama" name="nama" class="w-full border rounded p-2" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Tanggal</label>
                    <input type="date" id="modalTanggal" name="tanggal" class="w-full border rounded p-2" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Jenis Makanan</label>
                    <input type="text" id="modalResep" name="jenismakanan" class="w-full border rounded p-2" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Details</label>
                    <textarea class="w-full border rounded p-2 resize-none" id="modalDetails" name="details" rows="3" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Kalori</label>
                    <input type="number" id="modalKalori" name="kalori" class="w-full border rounded p-2" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Status</label>
                    <select class="w-full border rounded p-2" id="modalStatus" name="status" required>
                        <option value="not yet">Not Yet</option>
                        <option value="finish">Finish</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="create-modal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 id="create-title" class="text-xl font-bold mb-4">Tambah Resep Makanasdasd</h2>
            <form action="/resepmakan/trainer" method="POST">
                @csrf
                <input type="hidden" name="id" />
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Nama User</label>
                    <input type="text" name="nama" class="w-full border rounded p-2" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Tanggal</label>
                    <input type="date" name="tanggal" class="w-full border rounded p-2" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Jenis Makanan</label>
                    <input type="text" name="jenismakanan" class="w-full border rounded p-2" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Details</label>
                    <textarea class="w-full border rounded p-2 resize-none" name="details" rows="3" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Kalori</label>
                    <input type="number" name="kalori" class="w-full border rounded p-2" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Status</label>
                    <select class="w-full border rounded p-2" name="status" required>
                        <option value="not yet">Not Yet</option>
                        <option value="finish">Finish</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="toggle_create()" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script -->
    <script>
       window.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("editModal");
    const modalTitle = document.getElementById("modalTitle");
    const modalId = document.getElementById("modalId");
    const modalNama = document.getElementById("modalNama");
    const modalTanggal = document.getElementById("modalTanggal");
    const modalResep = document.getElementById("modalResep");
    const modalDetails = document.getElementById("modalDetails");
    const modalKalori = document.getElementById("modalKalori");
    const modalStatus = document.getElementById("modalStatus");

    const closeModalBtn = document.getElementById("closeModal");
    const editForm = document.getElementById("editForm");

    document.querySelectorAll(".open-modal-btn").forEach(button => {
        button.addEventListener("click", () => {
            modalTitle.textContent = "Ubah Resep Makan";
            modalId.value = button.dataset.id;
            modalNama.value = button.dataset.nama;
            modalTanggal.value = button.dataset.tanggal;
            modalResep.value = button.dataset.jenismakanan;
            modalDetails.value = button.dataset.details;
            modalKalori.value = button.dataset.kalori;
            modalStatus.value = button.dataset.status;
            modal.classList.remove("hidden");
        });
    });

    closeModalBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    editForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const id = modalId.value;
        const url = id ? `/resepmakan/${id}` : `/resepmakan/trainer`;
        const method = id ? "PUT" : "POST";

        const formData = {
            nama: modalNama.value,
            tanggal: modalTanggal.value,
            jenismakanan: modalResep.value,
            details: modalDetails.value,
            kalori: modalKalori.value,
            status: modalStatus.value,
            _token: "{{ csrf_token() }}"
        };

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": formData._token
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                alert(result.message);
                location.reload();
            } else {
                alert("Gagal: " + (result.message || "Terjadi kesalahan"));
            }
        } catch (error) {
            alert("Error: " + error.message);
        }
    });

    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", async () => {
            if (!confirm("Yakin ingin menghapus data ini?")) return;
            const id = button.dataset.id;

            try {
                const response = await fetch(`/resepmakan/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert("Gagal hapus: " + result.message);
                }
            } catch (error) {
                alert("Error hapus: " + error.message);
            }
        });
    });

    window.toggle_create = function () {
        const createModal = document.getElementById("create-modal");
        createModal.classList.toggle("hidden");
    };
});

    </script>
</x-app>