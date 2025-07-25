<x-app title="Progres Latihan">
  <!-- Main Content -->
  <main class="flex-1 p-6 overflow-y-auto">

    <!-- Dropdown Pilih Trainee -->
<form method="GET" class="mb-6">
    <label class="block font-semibold text-gray-600 mb-1">Pilih Trainee</label>
    <select name="trainee_id" onchange="this.form.submit()" class="border rounded p-2">
        <option value="">-- Pilih Trainee --</option>
        @foreach($trainees as $trainee)
            <option value="{{ $trainee->id }}" {{ $traineeId == $trainee->id ? 'selected' : '' }}>
                {{ $trainee->name }}
            </option>
        @endforeach
    </select>
</form>


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