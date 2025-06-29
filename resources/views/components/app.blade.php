<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{$title ?? "MyPages"}}</title>
  @vite('resources/css/app.css')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" defer></script>
</head>
<body class="bg-gray-100">
  <div class="flex flex-col md:flex-row h-screen transition-all duration-300 ease-in-out">
    
    <!-- Sidebar -->
    <x-sideBar></x-sideBar>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <!-- Header -->
      <x-headerBar></x-headerBar>

      {{-- CONTENT UTAMA --}}
      {{$slot}}
    </main>
  </div>

  <!-- Modal Edits Profil -->
  <x-modal.editProfil></x-modal.editProfil>

  <!-- Script -->
   <script>
    window.addEventListener('DOMContentLoaded', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Profile
    window.scrollTo({ top: 0, behavior: 'smooth' });

    const popup = document.getElementById('profilePopup');
    const editProfileModal = document.getElementById('editProfileModal');

    window.toggleProfile = function () {
        popup.classList.toggle('hidden');
    }

    window.openModal = function () {
        editProfileModal.classList.remove('hidden');
        editProfileModal.classList.add('flex');
        popup.classList.add('hidden');
    }

    window.closeModal = function () {
        editProfileModal.classList.remove('flex');
        editProfileModal.classList.add('hidden');
    }

    window.addEventListener('click', function(e) {
        const isInsidePopup = popup?.contains(e.target);
        const isButton = e.target.closest('button');
        const isInsideModal = editProfileModal?.contains(e.target);
        if (!isInsidePopup && !isButton && popup && !editProfileModal?.classList.contains('flex')) {
            popup.classList.add('hidden');
        }
    });

    // ==== MODAL LATIHAN ====
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

    const addBtn = document.getElementById("openAddModal");
    if (addBtn) {
        addBtn.addEventListener("click", () => {
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
    }

    closeModal?.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    const form = document.getElementById("editForm");
    form?.addEventListener("submit", function (e) {
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
            data.trainee_id = traineeSelect?.value;
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

});
</script>

  
</body>
</html>
