<footer class="bg-gray-800 text-white py-5">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Section 1: Informasi Desa -->
            <div>
                <h3 class="text-xl font-bold mt-4 mb-4">{{ $footer->nama ?? 'DESA JENANGAN' }}</h3>
                <p class="text-gray-400 mb-4 text-justify">
                    {{ $footer->deskripsi ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.' }}
                </p>
                <div class="flex space-x-4">
                    <!-- Instagram -->
                    @if($footer && $footer->link_ig)
                    <a href="{{ $footer->link_ig }}" class="text-gray-400 hover:text-white" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    @else
                    <a href="#" class="text-gray-400 hover:text-white opacity-50 cursor-not-allowed" aria-label="Instagram">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    @endif

                    <!-- Facebook -->
                    @if($footer && $footer->link_fb)
                    <a href="{{ $footer->link_fb }}" class="text-gray-400 hover:text-white" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-facebook fa-2x"></i>
                    </a>
                    @else
                    <a href="#" class="text-gray-400 hover:text-white opacity-50 cursor-not-allowed" aria-label="Facebook">
                        <i class="fab fa-facebook fa-2x"></i>
                    </a>
                    @endif

                    <!-- WhatsApp -->
                    @if($footer && $footer->link_wa)
                    <a href="{{ $footer->link_wa }}" class="text-gray-400 hover:text-white" aria-label="WhatsApp" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-whatsapp fa-2x"></i>
                    </a>
                    @else
                    <a href="#" class="text-gray-400 hover:text-white opacity-50 cursor-not-allowed" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp fa-2x"></i>
                    </a>
                    @endif

                    <!-- Youtube -->
                    @if($footer && $footer->link_youtube)
                    <a href="{{ $footer->link_youtube }}" class="text-gray-400 hover:text-white" aria-label="Youtube" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-youtube fa-2x"></i>
                    </a>
                    @else
                    <a href="#" class="text-gray-400 hover:text-white opacity-50 cursor-not-allowed" aria-label="Youtube">
                        <i class="fab fa-youtube fa-2x"></i>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Section 2: Hubungi Kami -->
            <div>
                <h3 class="text-xl font-bold mt-4 mb-4">HUBUNGI KAMI</h3>
                <p class="text-gray-400 text-justify">{{ $footer->alamat ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Jl. Contoh No. 123, Kecamatan Contoh, Kabupaten Contoh, 12345' }}</p>
                <p class="text-gray-400">Telepon: {{ $footer->telepon ?? '(021) 555-1234' }}</p>
                <p class="text-gray-400">
                    Email:
                    <a href="mailto:{{ $footer->email ?? 'info@desajenangan.id' }}" class="text-blue-400 hover:underline">{{ $footer->email ?? 'info@desajenangan.id' }}</a>
                </p>
            </div>

            <!-- Section 3: Lokasi Desa -->
            <div>
                <h3 class="text-xl font-bold mt-4 mb-4">LOKASI DESA</h3>
                <div class="w-full h-40 rounded-lg overflow-hidden">
                    @if($footer && $footer->lokasi)
                    <iframe
                    src="{{ $footer->lokasi }}"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"></iframe>
                    @else
                    <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                        <p class="text-gray-400 text-sm text-center px-4">Peta lokasi akan ditampilkan di sini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

        <!-- Footer Bottom -->
        <div class="border-t border-gray-700 mt-8 pt-4 text-center">
        <p class="text-gray-400">
            &copy; {{ date('Y') }} Pemerintah Desa Jenangan. All rights reserved. Powered by KKN-T UNIPMA 2025.
        </p>
        </div>
    </footer>
