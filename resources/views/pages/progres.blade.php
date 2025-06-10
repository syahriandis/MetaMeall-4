<x-app title="Progres Latihan">
  <!-- Main Content -->
  <main class="flex-1 p-6 overflow-y-auto">

    <!-- Profil Section -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 flex items-center space-x-4">
      <div class="w-20 h-20 bg-gray-200 rounded-full"></div>
      <div class="border border-gray-300 rounded-lg px-6 py-2">
        <h2 class="font-bold text-lg">Rivaldo Franscisco</h2>
        <p class="text-sm text-gray-500">Pria, 19 Tahun</p>
      </div>
    </div>

    <!-- Grafik Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Grafik Latihan Fisik -->
      <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold mb-2">Kalori Latihan Fisik</h2>
        <p class="text-sm text-gray-500 mb-4">Diagram Kalori dari Latihan</p>
        <canvas id="latihanChart" class="w-full h-64"></canvas>
      </div>

      <!-- Grafik Program Makan -->
      <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold mb-2">Kalori Program Makan</h2>
        <p class="text-sm text-gray-500 mb-4">Diagram Kalori dari Program Makan</p>
        <canvas id="makanChart" class="w-full h-64"></canvas>
      </div>
    </div>

   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Ambil data dari Controller langsung
  const dataLatihan = @json($latihan);
  const dataMakan = @json($makan);

  // Siapkan data chart
  const tanggalLatihan = dataLatihan.map(item => item.tanggal);
  const kaloriLatihan = dataLatihan.map(item => item.kalori);

  const tanggalMakan = dataMakan.map(item => item.tanggal);
  const kaloriMakan = dataMakan.map(item => item.kalori);

  // Opsi umum chart
  const options = {
    responsive: true,
    animation: {
      duration: 1500,
      easing: 'easeOutBounce'
    },
    plugins: {
      legend: { display: false }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { stepSize: 100 },
        grid: { borderDash: [5, 5] }
      },
      x: {
        grid: { display: false }
      }
    }
  };

  // Render Chart Latihan
  const latihanCtx = document.getElementById('latihanChart').getContext('2d');
  new Chart(latihanCtx, {
    type: 'bar',
    data: {
      labels: tanggalLatihan,
      datasets: [{
        label: 'Kalori Latihan',
        data: kaloriLatihan,
        backgroundColor: 'rgba(75, 85, 99, 0.7)',
        borderRadius: 8,
        barThickness: 40
      }]
    },
    options: options
  });

  // Render Chart Makan
  const makanCtx = document.getElementById('makanChart').getContext('2d');
  new Chart(makanCtx, {
    type: 'bar',
    data: {
      labels: tanggalMakan,
      datasets: [{
        label: 'Kalori Makan',
        data: kaloriMakan,
        backgroundColor: 'rgba(160, 212, 104, 0.7)',
        borderRadius: 8,
        barThickness: 40
      }]
    },
    options: options
  });

  function toggleProfile() {
    const popup = document.getElementById('profilePopup');
    popup.classList.toggle('hidden');
  }

  // Klik di luar pop-up untuk menutup
  window.addEventListener('click', function (e) {
    const popup = document.getElementById('profilePopup');
    const button = e.target.closest('button');
    if (!popup.contains(e.target) && !button) {
      popup.classList.add('hidden');
    }
  });
</script>


</x-app>