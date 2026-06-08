<x-filament-panels::page>
    <div x-data="{ 
            isModalOpen: false, 
            currentTes: null, 
            kodeInput: '', 
            isError: false,
            openModal(tes) {
                this.currentTes = tes;
                this.kodeInput = '';
                this.isError = false;
                this.isModalOpen = true;
                setTimeout(() => $refs.kodeInput.focus(), 100);
            },
            submitKode() {
                if (!this.currentTes) return;
                
                if (this.kodeInput.trim().toUpperCase() === this.currentTes.kode_tes.toUpperCase()) {
                    window.location.href = '/pembelajaran/cat/' + this.currentTes.id;
                } else {
                    this.isError = true;
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: { type: 'danger', message: 'Kode tes salah. Silakan coba lagi.' }
                    }));
                    setTimeout(() => this.isError = false, 500);
                }
            }
        }" 
        class="space-y-6"
    >
        <div class="relative overflow-hidden bg-gradient-to-r from-orange-500 to-pink-500 rounded-2xl p-6 text-white shadow-sm">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">🎓 Selamat Datang di Pembelajaran Sederhana</h2>
                    <p class="text-white/90">Pilih tes yang ingin Anda kerjakan atau masukkan kode tes untuk memulai</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-24 h-24 opacity-50 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
            </div>
        </div>

        @php
            $gradients = [
                'from-indigo-500 to-purple-600',
                'from-pink-500 to-rose-500',
                'from-cyan-500 to-blue-500',
                'from-emerald-400 to-cyan-500',
                'from-amber-400 to-orange-500',
                'from-fuchsia-600 to-purple-800'
            ];
        @endphp

        @if(empty($this->tesList))
            <div class="text-center py-16 px-4">
                <svg class="w-32 h-32 mx-auto mb-4 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tidak Ada Tes Tersedia</h3>
                <p class="text-gray-500 dark:text-gray-400">Belum ada tes yang tersedia saat ini. Silakan cek kembali nanti atau hubungi pengajar Anda.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($this->tesList as $index => $tes)
                    <div @click="openModal({{ json_encode($tes) }})" 
                         class="group relative overflow-hidden rounded-2xl p-6 text-white bg-gradient-to-br {{ $gradients[$index % count($gradients)] }} cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-500/20 dark:hover:shadow-black/40">
                        
                        <div class="absolute inset-0 bg-white/0 transition-colors duration-300 group-hover:bg-white/10"></div>
                        
                        <div class="relative z-10 flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold mb-3 line-clamp-2 leading-tight">{{ $tes['pelajaran'] }}</h3>
                                <div class="flex gap-2 flex-wrap">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-sm">{{ $tes['kategori'] }}</span>
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-sm">{{ $tes['tipe'] }}</span>
                                </div>
                            </div>
                            
                            @if($tes['is_paid'])
                                <div class="inline-block px-2 py-2 rounded-full bg-white/20 backdrop-blur-sm ml-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="relative z-10 grid grid-cols-3 gap-3 mb-5">
                            <div class="flex flex-col items-start gap-1">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xl font-bold leading-none mt-1">{{ $tes['total_soal'] }}</div>
                                    <div class="text-xs text-white/80">Soal</div>
                                </div>
                            </div>

                            <div class="flex flex-col items-start gap-1">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xl font-bold leading-none mt-1">{{ $tes['batas_waktu'] }}</div>
                                    <div class="text-xs text-white/80">Menit</div>
                                </div>
                            </div>

                            <div class="flex flex-col items-start gap-1">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xl font-bold leading-none mt-1">{{ $tes['peserta_count'] }}</div>
                                    <div class="text-xs text-white/80">Peserta</div>
                                </div>
                            </div>
                        </div>

                        <div class="relative z-10 pt-4 border-t border-white/20">
                            @if($tes['user_attempted'])
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-semibold text-white/90">Sudah Dikerjakan</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2 text-sm group-hover:translate-x-1 transition-transform">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-semibold text-white">Klik untuk Mulai</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div x-cloak x-show="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center">
            <div x-show="isModalOpen" 
                 x-transition.opacity 
                 @click="isModalOpen = false"
                 class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

            <div x-show="isModalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative w-full max-w-lg bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-6 md:p-8 mx-4 ring-1 ring-gray-200 dark:ring-gray-800">
                
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white" x-text="currentTes?.pelajaran"></h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1" x-text="`${currentTes?.total_soal} Soal • ${currentTes?.batas_waktu} Menit`"></p>
                    </div>
                    <button @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submitKode">
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Masukkan Kode Tes
                        </label>
                        <input 
                            x-ref="kodeInput"
                            x-model="kodeInput"
                            type="text" 
                            :class="isError ? 'border-red-500 focus:ring-red-500 animate-[shake_0.5s_ease-in-out]' : 'border-gray-300 dark:border-gray-700 focus:ring-orange-500 focus:border-orange-500'"
                            class="w-full px-4 py-3 border-2 bg-transparent rounded-xl outline-none text-lg font-mono uppercase text-gray-900 dark:text-white transition-all shadow-sm"
                            placeholder="Contoh: ABC123"
                            required
                            autocomplete="off">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Pastikan Anda memasukkan kode tes yang benar
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" @click="isModalOpen = false" class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white rounded-xl font-semibold shadow-md transition">
                            Mulai Tes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-filament-panels::page>