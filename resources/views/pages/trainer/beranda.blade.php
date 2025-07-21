<x-app title="Beranda">
  @if (session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded text-center text-sm md:text-base">
        {{ session('success') }}
    </div>
  @endif

  <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 md:p-8 text-center transition duration-300 ease-in-out">
    <div class="flex justify-center mb-4 sm:mb-6">
      <img src="https://th.bing.com/th/id/OIP.cnqbSAuzQvDJ-NNethRsNgHaE8?rs=1&pid=ImgDetMain" 
           alt="Tips Diet" 
           class="w-full max-w-xs sm:max-w-md md:max-w-lg rounded-lg border border-gray-300">
    </div>
    <h1 class="text-2xl sm:text-3xl font-bold mb-2">Selamat Datang {{ Auth::user()->name }}</h1>
    <p class="text-gray-600 text-sm sm:text-base">Temukan Tips Dietmu disini</p>
  </div>

  {{-- Tabel Daftar Trainee --}}
  <div class="mt-8 sm:mt-10">
    <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4 text-left">Daftar Trainee</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-200 rounded-xl overflow-hidden text-left text-sm sm:text-base">
        <thead class="bg-green-200 text-gray-700">
          <tr>
            <th class="py-2 px-3 sm:px-4 border-b">Nama</th>
            <th class="py-2 px-3 sm:px-4 border-b">Email</th>
            <th class="py-2 px-3 sm:px-4 border-b text-center">Total Latihan</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($trainees as $trainee)
            <tr class="hover:bg-gray-100">
              <td class="py-2 px-3 sm:px-4 border-b">{{ $trainee->name }}</td>
              <td class="py-2 px-3 sm:px-4 border-b">{{ $trainee->email }}</td>
              <td class="py-2 px-3 sm:px-4 border-b text-center">{{ $trainee->total_latihan }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="text-center py-4 text-gray-500">Belum ada data trainee.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</x-app>
