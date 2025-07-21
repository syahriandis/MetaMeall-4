<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{$title ?? "MyPages"}}</title>
  @vite('resources/css/app.css')
  <!-- CDN Font Awesome versi lengkap -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-...isi...otomatis..." crossorigin="anonymous" referrerpolicy="no-referrer" />



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
    // Auto scroll ke atas saat halaman dimuat
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // ==== POPUP PROFILE ====
    const popup = document.getElementById('profilePopup');
    const editProfileModal = document.getElementById('editProfileModal');

    window.toggleProfile = function () {
        popup?.classList.toggle('hidden');
    }

    window.openModal = function () {
        editProfileModal?.classList.remove('hidden');
        editProfileModal?.classList.add('flex');
        popup?.classList.add('hidden');
    }

    window.closeModal = function () {
        editProfileModal?.classList.remove('flex');
        editProfileModal?.classList.add('hidden');
    }

    // Tutup popup saat klik di luar
    window.addEventListener('click', function(e) {
        const isInsidePopup = popup?.contains(e.target);
        const isButton = e.target.closest('button');
        const isInsideModal = editProfileModal?.contains(e.target);

        if (!isInsidePopup && !isButton && popup && !editProfileModal?.classList.contains('flex')) {
            popup.classList.add('hidden');
        }
    });
});
</script>

@stack('scripts')


</body>
</html>
