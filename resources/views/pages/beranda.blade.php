<x-app title="Beranda">
  @if (session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded text-center">
        {{ session('success') }}
    </div>
  @endif
    
  <div class="bg-white rounded-xl shadow-md p-8 text-center transition duration-300 ease-in-out">
    <div class="flex justify-center mb-6">
      <img src="https://th.bing.com/th/id/OIP.cnqbSAuzQvDJ-NNethRsNgHaE8?rs=1&pid=ImgDetMain" alt="Tips Diet" class="w-96 max-w-full rounded-lg border border-gray-300">
    </div>
    <h1 class="text-3xl font-bold mb-2">Selamat Datang Di MetaMeal</h1>
    <p class="text-gray-600">Temukan Tips Dietmu di sini</p>
  </div>
</x-app>