<x-appLanding title="About">
    <!-- About Sections -->
      <section class="flex flex-col md:flex-row items-center justify-between px-8 md:px-16 py-12 bg-custom-green">
        <div class="flex flex-col md:flex-row items-center gap-10">
            <div class="md:w-1/2">
                <img src="{{ asset('images/about.png') }}" alt="Tentang MetaMeal">
            </div>
            <div class="md:w-1/2 border border-dashed border-light-blue p-6 rounded-lg bg-white shadow">
                <h2 class="text-xl md:text-2xl font-bold text-blue-600 mb-4">Tentang MetaMeal</h2>
                <p class="text-gray-700 text-sm mb-4">
                    MetaMeal adalah platform diet yang membantu Anda mencapai pola makan sehat dengan cara yang lebih mudah dan menyenangkan. Kami menyediakan panduan diet, rekomendasi menu sehat, dan fitur latihan fisik, memastikan progres Anda bisa mencapai target tubuh ideal tanpa stress.
                </p>
                <h3 class="font-semibold text-blue-600 mb-2">Kenapa Memilih MetaMeal?</h3>
                <ul class="list-disc list-inside text-gray-700 text-sm space-y-1">
                    <li><strong>Personalized diet</strong> – Sesuai dengan kebutuhan dan preferensi Anda</li>
                    <li><strong>Latihan Fisik & Rencana Makan</strong> – Latihan fisik, Makanan sehat, lezat, dan mudah dibuat</li>
                    <li><strong>Pelacakan Kemajuan</strong> – Pantau berat badan, kalori, dan progress diet Anda</li>
                    <li><strong>Tips & Edukasi Sehat</strong> – Dapatkan insight dari ahli gizi</li>
                </ul>
            </div>
        </div>
    </section>

</x-appLanding>