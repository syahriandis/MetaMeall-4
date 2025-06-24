<div class="flex justify-between items-center mb-6 bg-[#5F8C2D] p-4 rounded-lg text-white shadow">
  <!-- Search Bar -->
  <div class="flex items-center bg-white rounded-full shadow-md p-2 w-full md:w-1/2">
    <i class="fas fa-search text-gray-400 ml-2"></i>
    <input type="text" placeholder="Search..." class="ml-2 w-full border-none focus:outline-none bg-transparent text-black">
  </div>

  <!-- User Icons -->
  <div class="hidden md:flex items-center space-x-4 relative">
    <a href="{{ route('notifikasi') }}" class="text-white text-xl hover:text-gray-200">
      <i class="fas fa-bell"></i>
    </a>

    @if(Auth::check())
      <button onclick="toggleProfile()" class="text-white text-xl focus:outline-none">
        <i class="fas fa-user-circle"></i>
      </button>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-white text-xl hover:text-gray-200" title="Logout">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </form>

      <!-- Pop-up Profile -->
      <div id="profilePopup" class="hidden absolute right-0 top-16 w-80 bg-white border border-gray-300 rounded-lg shadow-xl z-50 p-6">
        <div class="text-center">
          <img src="{{ asset(Auth::user()->profile_photo_path ?? 'images/profil.jpeg') }}" class="w-24 h-24 rounded-full mx-auto mb-3 border" alt="Foto Profil">

          <h2 class="text-lg font-bold text-gray-800">{{ Auth::user()->name }}</h2>
          <p class="text-gray-600 mb-2">{{ Auth::user()->email }}</p>

          <div class="text-left text-sm text-gray-700 space-y-1 mb-4">
            <p><strong>Umur:</strong> {{ Auth::user()->age }} tahun</p>
            <p><strong>Berat:</strong> {{ Auth::user()->weight }} kg</p>
            <p><strong>Tinggi:</strong> {{ Auth::user()->height }} cm</p>
          </div>

          <!-- Tombol Ubah Profil -->
          <button onclick="openModal()" class="bg-[#5F8C2D] hover:bg-[#4a7224] text-white px-4 py-2 rounded-full">
            Ubah Profil
          </button>
        </div>
      </div>
    @endif
  </div>

  <!-- Mobile Menu -->
  <button class="md:hidden text-white text-xl focus:outline-none" onclick="toggleMobileMenu()">
    <i class="fas fa-bars"></i>
  </button>
</div>
