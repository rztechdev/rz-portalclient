<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Buat Tiket Baru') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kirimkan tiket gangguan atau permintaan bantuan teknis baru.</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 dark:bg-gray-900/50 min-h-[calc(100vh-65px)]">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Back Action -->
            <div class="mb-6">
                <a href="{{ route('tickets.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors group">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar Tiket
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700/50">
                    <h4 class="font-bold text-gray-800 dark:text-gray-100 text-lg">Informasi Gangguan / Layanan</h4>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Isi formulir di bawah ini sedetail mungkin agar teknisi kami dapat meresolusi kendala Anda dengan cepat.</p>
                </div>

                <form action="{{ route('tickets.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <!-- Title -->
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                            Judul / Keluhan Utama <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" 
                            placeholder="Contoh: Koneksi internet lambat / E-mail tidak bisa sinkron"
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:ring-4 focus:ring-blue-500/10 transition-all text-sm @error('title') border-rose-300 dark:border-rose-900/50 focus:border-rose-500 focus:ring-rose-500/10 @enderror"
                            required>
                        @error('title')
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div class="space-y-2">
                        <label for="priority" class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                            Tingkat Prioritas <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="priority" id="priority" 
                                class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:ring-4 focus:ring-blue-500/10 transition-all text-sm appearance-none @error('priority') border-rose-300 dark:border-rose-900/50 focus:border-rose-500 focus:ring-rose-500/10 @enderror"
                                required>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low (Biasa / Tidak mendesak)</option>
                                <option value="medium" {{ old('priority') == 'medium' || !old('priority') ? 'selected' : '' }}>Medium (Sedang / Perlu tindak lanjut standar)</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High (Mendesak / Menghentikan operasional bisnis)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                        @error('priority')
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300">
                            Deskripsi Lengkap Kendala <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="description" id="description" rows="6" 
                            placeholder="Jelaskan secara kronologis kendala Anda. Sertakan pesan error atau detail perangkat jika ada."
                            class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 focus:border-blue-500 focus:bg-white dark:focus:bg-gray-800 focus:ring-4 focus:ring-blue-500/10 transition-all text-sm @error('description') border-rose-300 dark:border-rose-900/50 focus:border-rose-500 focus:ring-rose-500/10 @enderror"
                            required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700/50 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('tickets.index') }}" class="inline-flex justify-center items-center px-5 py-3 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 font-semibold text-sm rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold text-sm rounded-2xl shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition-all duration-200 transform hover:-translate-y-0.5">
                            Kirim Tiket
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
