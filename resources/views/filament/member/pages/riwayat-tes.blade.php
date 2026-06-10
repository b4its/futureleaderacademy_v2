<x-filament-panels::page>
    <div class="space-y-6">
        @if(empty($this->riwayatList))
            <div class="text-center py-16 px-4">
                <svg class="w-32 h-32 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Riwayat Tes</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Anda belum mengerjakan tes apapun. Mulai mengerjakan tes untuk melihat riwayat di sini.</p>
                <a href="{{ route('filament.member.pages.pembelajaran-interaktif') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-pink-500 text-white rounded-xl font-semibold shadow-md hover:from-orange-600 hover:to-pink-600 transition">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                    </svg>
                    Mulai Tes Sekarang
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4">
                @foreach($this->riwayatList as $riwayat)
                    @php
                        $nilai = floatval($riwayat['total_nilai']);
                        $persentase = $riwayat['persentase'];

                        // Konfigurasi warna berbasis persentase terhadap total bobot
                        if($persentase >= 80) {
                            $borderColor = 'border-emerald-500';
                            $gradientCircle = 'from-emerald-400 to-emerald-600';
                            $categoryText = 'Sangat Baik';
                        } elseif($persentase >= 70) {
                            $borderColor = 'border-blue-500';
                            $gradientCircle = 'from-blue-400 to-blue-600';
                            $categoryText = 'Baik';
                        } elseif($persentase >= 60) {
                            $borderColor = 'border-amber-500';
                            $gradientCircle = 'from-amber-400 to-amber-600';
                            $categoryText = 'Cukup';
                        } else {
                            $borderColor = 'border-red-500';
                            $gradientCircle = 'from-red-400 to-red-600';
                            $categoryText = 'Perlu Belajar Lagi';
                        }
                    @endphp
                    
                    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 border-l-4 {{ $borderColor }} transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                        <div class="flex flex-col md:flex-row gap-6 items-center md:items-start">
                            
                            <div class="flex-shrink-0 flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full flex flex-col items-center justify-center text-white bg-gradient-to-br {{ $gradientCircle }} shadow-inner">
                                    <span class="text-2xl font-bold leading-none">{{ number_format($nilai, 0) }}</span>
                                    <span class="text-[10px] font-semibold opacity-90 mt-0.5">/ {{ $riwayat['nilai_maksimal'] }}</span>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 mt-3 font-semibold">{{ $categoryText }}</p>
                            </div>

                            <div class="flex-1 w-full">
                                <div class="mb-5 text-center md:text-left">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $riwayat['pelajaran'] }}</h3>
                                    <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 ring-1 ring-inset ring-blue-700/10 dark:ring-blue-400/20">
                                            {{ $riwayat['kategori'] }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300 ring-1 ring-inset ring-purple-700/10 dark:ring-purple-400/20">
                                            {{ $riwayat['tipe'] }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 ring-1 ring-inset ring-gray-500/10">
                                            <svg class="w-3.5 h-3.5 mr-1.5 opacity-70" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $riwayat['waktu_dikerjakan'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-3 md:gap-4">
                                    <div class="bg-gray-50 dark:bg-white/5 rounded-xl p-3 md:p-4 text-center ring-1 ring-inset ring-gray-900/5 dark:ring-white/10">
                                        <div class="flex items-center justify-center mb-1.5">
                                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white leading-none">{{ $riwayat['jumlah_benar'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Benar</div>
                                    </div>

                                    <div class="bg-gray-50 dark:bg-white/5 rounded-xl p-3 md:p-4 text-center ring-1 ring-inset ring-gray-900/5 dark:ring-white/10">
                                        <div class="flex items-center justify-center mb-1.5">
                                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white leading-none">{{ $riwayat['jumlah_salah'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Salah</div>
                                    </div>

                                    <div class="bg-gray-50 dark:bg-white/5 rounded-xl p-3 md:p-4 text-center ring-1 ring-inset ring-gray-900/5 dark:ring-white/10">
                                        <div class="flex items-center justify-center mb-1.5">
                                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white leading-none">{{ $riwayat['durasi'] }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Menit</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-filament-panels::page>