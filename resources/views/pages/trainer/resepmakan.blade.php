<x-app>
    
   <div class="flex justify-end mb-4">
  <button id="openAddModal" class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 transition transform hover:scale-105 duration-200 w-full sm:w-auto">
    + Tambah Resep Makan
  </button>
</div>



    <!-- Daftar Resep -->
    <section class="space-y-4">
        @if(count($data) === 0)
            <p class="text-center text-gray-500">Belum ada resep makan.</p>
        @endif

        @foreach($data as $trainee)

            <div class="mb-4 border rounded overflow-hidden">
                <!-- HEADER: klik untuk toggle -->
                <button onclick="toggleCollapse('{{ \Illuminate\Support\Str::slug($trainee['nama']) }}')" class="w-full text-left px-4 py-3 bg-green-100 hover:bg-green-200 transition flex items-center gap-4">
    {{-- Gender icon --}}
<div class="flex items-center gap-3">
    @php
  $genderRaw = strtolower(trim($trainee['gender']));
@endphp

<div class="p-4">
  @if($genderRaw === 'laki-laki' || $genderRaw === 'male')
    <i class="fa-solid fa-mars text-blue-500 text-2xl"></i>
  @elseif($genderRaw === 'perempuan' || $genderRaw === 'female')
    <i class="fa-solid fa-venus text-pink-500 text-2xl"></i>
  @else
    <i class="fa-solid fa-question text-gray-500 text-2xl"></i> <!-- fallback icon -->
  @endif
</div>


    <div>
        <p class="text-green-900 font-semibold">{{ $trainee['nama'] }}</p>
        <p class="text-green-800 text-sm">
            {{ $trainee['umur'] ?? '-' }} tahun • 
            {{ $trainee['berat'] ?? '-' }} kg • 
            {{ $trainee['tinggi'] ?? '-' }} cm
        </p>
    </div>
</div>





</button>


                <!-- ISI: daftar resep -->
                <div id="collapse-{{ \Illuminate\Support\Str::slug($trainee['nama']) }}" class="hidden p-4 space-y-3 bg-gray-100">
                    @foreach($trainee['resep'] as $item)

                       <div class="bg-white p-4 rounded shadow flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="w-full">
                        <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</p>
                        <p class="text-sm italic text-gray-600">({{ $item->nama }})</p>
                        <p class="text-sm">Kalori: {{ $item->kalori }} kcal</p>
                        <p class="text-sm">Feedback: {{ $item->feedback }}</p>
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto">
                       <button class="bg-green-500 text-white px-3 py-1 rounded w-full sm:w-auto open-modal-btn"
    data-id="{{ $item->id }}"
    data-nama="{{ $item->nama }}"
    data-tanggal="{{ $item->tanggal }}"
       data-kategori="{{ e($item->jenis_makanan ?? '') }}"
    data-detail="{{ e($item->komposisi ?? '') }}"
    data-feedback="{{ $item->feedback ?? '' }}"
    data-kalori="{{ $item->kalori ?? '' }}">
    Ubah
</button>

                        <button class="bg-red-500 text-white px-3 py-1 rounded w-full sm:w-auto delete-btn"
                            data-id="{{ $item->id }}">
                            Hapus
                        </button>
                    </div>
                    </div>

                    @endforeach
                </div>
            </div>
        @endforeach
    </section>

    <!-- Modal edit/tambah -->
<div id="editModal" class="hidden fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50">

  <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
    <h2 id="modalTitle" class="text-xl font-bold mb-4"></h2>
    <input type="hidden" id="modalMode">
    <input type="hidden" id="recordId">

    <div id="traineeDropdownWrapper" class="mb-3">
      <label class="block text-sm">Trainee</label>
     <select id="traineeSelect" class="w-full border rounded px-2 py-1">
    @foreach($trainees as $trainee)
        <option value="{{ $trainee->id }}">{{ $trainee->name }}</option>
    @endforeach
</select>

    </div>

    <label class="block text-sm">Nama Makanan</label>
    <input id="modalNama" class="w-full mb-2 border px-2 py-1 rounded" type="text" />

    <label class="block text-sm">Tanggal</label>
    <input id="modalTanggal" class="w-full mb-2 border px-2 py-1 rounded" type="date" />

    <label class="block text-sm">Kategori</label>
    <input id="modalKategori" class="w-full mb-2 border px-2 py-1 rounded" type="text" />

    <label class="block text-sm">Komposisi</label>
    <textarea id="modalDetail" class="w-full mb-2 border px-2 py-1 rounded"></textarea>

    <label class="block text-sm">Kalori</label>
    <input id="modalKalori" class="w-full mb-2 border px-2 py-1 rounded" type="number" />

    <label class="block text-sm">Feedback</label>
    <input id="modalFeedback" class="w-full mb-4 border px-2 py-1 rounded" type="text" />

    <div class="flex justify-end space-x-2">
      <button id="closeModal" class="bg-gray-500 text-white px-4 py-1 rounded">Tutup</button>
      <button id="submitModal" class="bg-green-600 text-white px-4 py-1 rounded">Simpan</button>
    </div>
  </div>
</div>

    <!-- Modal dan lainnya tetap... -->
    @push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("editModal");
    const modalMode = document.getElementById("modalMode");
    const modalTitle = document.getElementById("modalTitle");
    const recordId = document.getElementById("recordId");
    const traineeSelect = document.getElementById("traineeSelect");
    const traineeWrapper = document.getElementById("traineeDropdownWrapper");

    const modalNama = document.getElementById("modalNama");
    const modalTanggal = document.getElementById("modalTanggal");
    const modalKategori = document.getElementById("modalKategori");
    const modalDetail = document.getElementById("modalDetail");
    const modalKalori = document.getElementById("modalKalori");
    const modalFeedback = document.getElementById("modalFeedback");

    document.getElementById("openAddModal").addEventListener("click", () => {
        modalMode.value = "add";
        modalTitle.textContent = "Tambah Resep Makan";
        recordId.value = "";
        modalNama.value = "";
        modalTanggal.value = "";
        modalKategori.value = "";
        modalDetail.value = "";
        modalKalori.value = "";
        modalFeedback.value = "";
        traineeSelect.value = "";
        traineeWrapper.classList.remove("hidden");
        modal.classList.remove("hidden");
    });

    document.querySelectorAll(".open-modal-btn").forEach(button => {
        button.addEventListener("click", () => {
            modalMode.value = "edit";
            modalTitle.textContent = "Ubah Resep Makan";
            recordId.value = button.dataset.id;
            modalNama.value = button.dataset.nama;
            modalTanggal.value = button.dataset.tanggal;
            modalKategori.value = button.dataset.kategori;
            modalDetail.value = button.dataset.detail;
            modalKalori.value = button.dataset.kalori;
            modalFeedback.value = button.dataset.feedback;
            traineeWrapper.classList.add("hidden");
            modal.classList.remove("hidden");
        });
    });

    document.getElementById("closeModal").addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // ✅ Submit Handler
    document.getElementById("submitModal").addEventListener("click", () => {
        const mode = modalMode.value;
        const id = recordId.value;
        const token = '{{ csrf_token() }}';

       const data = {
    trainee_id: traineeSelect.value,
    nama: modalNama.value,
    tanggal: modalTanggal.value,
    jenis_makanan: modalKategori.value,
    komposisi: modalDetail.value,
    kalori: modalKalori.value,
    feedback: modalFeedback.value,
    _token: token
};




        if (!data.nama || !data.tanggal || !data.kalori) {
    alert("Pastikan semua field wajib terisi.");
    return;
}


        const url = mode === "add"
            ? "{{ route('resep.store') }}"
            : `/resepmakan/update/${id}`;

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
            alert(result.message || "Berhasil disimpan!");
            modal.classList.add("hidden");
            location.reload();
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi kesalahan saat mengirim data.");
        });
    });

    // ✅ Delete Handler
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("data-id");
            if (confirm("Yakin ingin menghapus resep ini?")) {
                fetch(`/resepmakan/delete/${id}`, {
                    method: "GET"
                })
                .then(res => res.json())
                .then(result => {
                    alert(result.message || "Berhasil dihapus!");
                    location.reload();
                });
            }
        });
    });
});

// ✅ Toggle Collapse
function toggleCollapse(id) {
    const section = document.getElementById('collapse-' + id);
    section.classList.toggle('hidden');
}
</script>
@endpush

</x-app>
