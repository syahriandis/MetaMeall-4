<x-app>
    <!-- Tombol Tambah -->
    <div class="flex justify-end mb-4">
        <button onclick="toggle_create()" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition transform hover:scale-105 duration-200">
            + Tambah Notifikasi
        </button>
    </div>

    <!-- Daftar Notifikasi -->
    <div id="listData">
        @foreach($data as $item)
        <div class="bg-gray-200 p-4 rounded-lg shadow-md flex justify-between items-center transition hover:shadow-lg duration-300 mb-4" data-id="{{ $item['id'] }}">
            <div>
                <h2 class="text-xl font-bold">{{ $item['title'] ?? '-' }}</h2>
                <p class="text-sm">{{ $item['message'] ?? '-' }}</p>
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($item['created_at'])->translatedFormat('l, d F Y H:i') }}</p>
                <p class="text-xs font-semibold {{ $item['is_read'] ? 'text-green-600' : 'text-red-600' }}">
                    {{ $item['is_read'] ? 'Sudah Dibaca' : 'Belum Dibaca' }}
                </p>
            </div>
            <div class="space-x-2">
                <button class="bg-green-500 text-white px-4 py-2 rounded open-modal-btn"
                    data-id="{{ $item['id'] }}"
                    data-title="{{ $item['title'] }}"
                    data-message="{{ $item['message'] }}">
                    Ubah
                </button>
                <button class="bg-red-500 text-white px-4 py-2 rounded delete-btn" data-id="{{ $item['id'] }}">
                    Hapus
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal Ubah Notifikasi -->
    <div id="editModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 id="modalTitle" class="text-xl font-bold mb-4">Ubah Notifikasi</h2>
            <form id="editForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="modalId" name="id" />
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Judul</label>
                    <input type="text" id="modalTitleInput" name="title" class="w-full border rounded p-2" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Pesan</label>
                    <textarea class="w-full border rounded p-2 resize-none" id="modalMessage" name="message" rows="3" required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Notifikasi -->
    <div id="create-modal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-bold mb-4">Tambah Notifikasi</h2>
            <form action="/notifikasi" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Judul</label>
                    <input type="text" name="title" class="w-full border rounded p-2" required />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Pesan</label>
                    <textarea name="message" class="w-full border rounded p-2 resize-none" rows="3" required></textarea>
                </div>
                <input type="hidden" name="is_read" value="0" />
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
        const modalId = document.getElementById("modalId");
        const modalTitleInput = document.getElementById("modalTitleInput");
        const modalMessage = document.getElementById("modalMessage");
        const closeModalBtn = document.getElementById("closeModal");
        const editForm = document.getElementById("editForm");

        document.querySelectorAll(".open-modal-btn").forEach(button => {
            button.addEventListener("click", () => {
                modalId.value = button.dataset.id;
                modalTitleInput.value = button.dataset.title;
                modalMessage.value = button.dataset.message;
                modal.classList.remove("hidden");
            });
        });

        closeModalBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
        });

        editForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const id = modalId.value;
            const formData = {
                title: modalTitleInput.value,
                message: modalMessage.value,
                is_read: 0,
                _token: "{{ csrf_token() }}"
            };

            try {
                const response = await fetch(`/notifikasi/${id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": formData._token,
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();
                if (response.ok) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert("Gagal: " + result.message);
                }
            } catch (error) {
                alert("Error: " + error.message);
            }
        });

        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", async () => {
                if (!confirm("Yakin ingin menghapus notifikasi ini?")) return;
                const id = button.dataset.id;

                try {
                    const response = await fetch(`/notifikasi/${id}`, {
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
