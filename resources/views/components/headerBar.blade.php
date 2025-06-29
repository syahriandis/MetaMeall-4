<!-- HEADER -->
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
      <!-- Tombol Profil -->
      <button onclick="toggleProfile()" class="text-white text-xl focus:outline-none">
        <i class="fas fa-user-circle"></i>
      </button>

<!-- Popup Profil -->
<div id="profilePopup" class="absolute right-0 top-12 bg-white text-black rounded-xl shadow-xl w-72 p-4 z-50 hidden transition-all">
  <div class="flex items-center gap-3 mb-4">
    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="avatar" class="w-12 h-12 rounded-full border">
    <div>
      <h4 class="font-semibold text-lg leading-tight">{{ Auth::user()->name }}</h4>
      <p class="text-sm text-gray-500 break-all">{{ Auth::user()->email }}</p>
    </div>
  </div>
  <div class="text-sm text-gray-700 space-y-1 mb-4">
    <div class="flex justify-between">
      <span class="font-medium">Umur:</span>
      <span>{{ Auth::user()->age !== null ? Auth::user()->age . ' tahun' : '-' }}</span>
    </div>
    <div class="flex justify-between">
      <span class="font-medium">Berat:</span>
      <span>{{ Auth::user()->weight !== null ? Auth::user()->weight . ' kg' : '-' }}</span>
    </div>
    <div class="flex justify-between">
      <span class="font-medium">Tinggi:</span>
      <span>{{ Auth::user()->height !== null ? Auth::user()->height . ' cm' : '-' }}</span>
    </div>
  </div>
  <div class="flex justify-end">
    <button onclick="openModal()" class="px-4 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Edit</button>
  </div>
</div>

      <!-- Tombol Logout -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-white text-xl hover:text-gray-200" title="Logout">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </form>
    @endif

    <!-- Mobile Menu -->
    <button class="md:hidden text-white text-xl focus:outline-none" onclick="toggleMobileMenu()">
      <i class="fas fa-bars"></i>
    </button>
  </div>
</div>

@if(Auth::check())
<!-- MODAL EDIT PROFIL -->
<div id="editProfileModal" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center">

  <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
    <h2 class="text-xl font-bold mb-4">Ubah Profil</h2>
    <form method="POST" action="{{ route('profile.update') }}">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full mt-1 border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full mt-1 border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-500">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Umur</label>
        <input type="number" name="age" value="{{ Auth::user()->age ?? '' }}" class="w-full mt-1 border rounded-lg p-2">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Berat (kg)</label>
        <input type="number" name="weight" value="{{ Auth::user()->weight ?? '' }}" class="w-full mt-1 border rounded-lg p-2">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
        <input type="number" name="height" value="{{ Auth::user()->height ?? '' }}" class="w-full mt-1 border rounded-lg p-2">
      </div>

      <div class="flex justify-end gap-2 mt-4">
        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- SCRIPT -->
<script>
  function toggleProfile() {
    const popup = document.getElementById('profilePopup');
    popup.classList.toggle('hidden');
  }

  function openModal() {
    document.getElementById('editProfileModal').classList.remove('hidden');
    document.getElementById('profilePopup')?.classList.add('hidden');
  }

  function closeModal() {
    document.getElementById('editProfileModal').classList.add('hidden');
  }

  window.addEventListener('click', function (e) {
    const popup = document.getElementById('profilePopup');
    const modal = document.getElementById('editProfileModal');
    const isInsidePopup = popup?.contains(e.target);
    const isInsideModal = modal?.contains(e.target);
    const isButton = e.target.closest('button');

    if (!isInsidePopup && !isInsideModal && !isButton) {
      popup?.classList.add('hidden');
    }
  });
</script>
@endif
