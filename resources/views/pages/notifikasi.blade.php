<x-app title="Notifikasi Trainee">
    <div>
        <h2 class="text-2xl font-bold mb-4">Notifikasi</h2>

        <!-- Daftar Notifikasi -->
        <div class="bg-gray-200 rounded-xl p-4 space-y-4">
            @foreach($data as $notif)
                <div class="bg-white rounded-xl p-4 shadow-md flex justify-between items-center">
                    <div>
                        <p class="font-bold text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($notif->created_at)->translatedFormat('l, d F Y H:i') }}
                        </p>
                        <h3 class="text-lg font-semibold">{{ $notif->title }}</h3>
                        <p class="text-gray-700">{{ $notif->message }}</p>
                        <p class="text-xs font-semibold {{ $notif->is_read ? 'text-green-600' : 'text-red-600' }}">
                            {{ $notif->is_read ? 'Sudah Dibaca' : 'Belum Dibaca' }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        @if(!$notif->is_read)
                        <button 
                            class="bg-blue-500 text-white px-3 py-1 rounded mark-read-btn"
                            data-id="{{ $notif->id }}">
                            Sudah Membaca
                        </button>
                        @endif
                        <button 
                            class="bg-red-500 text-white px-3 py-1 rounded delete-btn" 
                            data-id="{{ $notif->id }}">
                            Hapus
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="markReadModal" class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <h2 class="text-lg font-bold mb-4">Tandai sebagai sudah dibaca?</h2>
            <p class="text-sm mb-4">Apakah kamu yakin ingin menandai notifikasi ini sebagai <strong>Sudah Dibaca</strong>?</p>
            <div class="flex justify-end gap-2">
                <button onclick="toggleModal(false)" class="bg-gray-400 text-white px-4 py-2 rounded">Batal</button>
                <button id="confirmMarkRead" class="bg-blue-500 text-white px-4 py-2 rounded">Ya, Tandai</button>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        let currentNotifId = null;

        function toggleModal(show = true) {
            const modal = document.getElementById("markReadModal");
            modal.classList.toggle("hidden", !show);
        }

        document.addEventListener("DOMContentLoaded", () => {
            // Hapus notifikasi
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

            // Tampilkan modal konfirmasi tandai sudah baca
            document.querySelectorAll(".mark-read-btn").forEach(button => {
                button.addEventListener("click", () => {
                    currentNotifId = button.dataset.id;
                    toggleModal(true);
                });
            });

            // Submit update status dibaca
            document.getElementById("confirmMarkRead").addEventListener("click", async () => {
                if (!currentNotifId) return;

                try {
                    const response = await fetch(`/notifikasi/${currentNotifId}/read`, {
                        method: "PATCH",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ is_read: 1 })
                    });

                    const result = await response.json();
                    if (response.ok) {
                        alert(result.message);
                        location.reload();
                    } else {
                        alert("Gagal tandai: " + result.message);
                    }
                } catch (error) {
                    alert("Error tandai: " + error.message);
                }

                toggleModal(false);
                currentNotifId = null;
            });
        });
    </script>
</x-app>
