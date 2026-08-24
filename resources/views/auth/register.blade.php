<x-guest-layout>
    <!-- Floating Card Wrapper (coordinates shadow & hover lift) -->
    <div class="w-full max-w-4xl relative group py-10 flex flex-col justify-center items-center">
        <!-- Realistic dynamic floor shadow -->
        <div class="absolute bottom-4 left-[10%] w-[80%] h-8 bg-zinc-950/20 dark:bg-black/60 rounded-full pointer-events-none transition-all duration-700 ease-out group-hover:opacity-10 group-hover:scale-x-75 group-hover:blur-[64px] animate-floor-shadow z-0"></div>

        <!-- Bobbing float animation container -->
        <div class="w-full relative z-10 animate-float">
            <!-- Interactive Lift & Glow Container -->
            <div id="auth-card" class="w-full super-glass border border-zinc-200/60 dark:border-zinc-800/60 rounded-[2rem] overflow-hidden transition-all duration-700 ease-out group-hover:-translate-y-4 group-hover:shadow-[0_45px_85px_-20px_rgba(0,0,0,0.22),_0_20px_40px_-25px_rgba(0,0,0,0.15),_0_0_60px_0px_rgba(139,155,112,0.12)] dark:group-hover:shadow-[0_55px_100px_-25px_rgba(0,0,0,0.8),_0_35px_60px_-30px_rgba(0,0,0,0.7),_0_0_65px_0px_rgba(139,155,112,0.08)] shadow-2xl">
        
                <div class="grid grid-cols-1 md:grid-cols-12 min-h-[520px]">
                
                <!-- Left Column (Form Inputs): Desktop: Left, Mobile: Bottom -->
                <div id="form-panel" class="md:col-span-7 flex flex-col justify-center p-8 sm:p-10 lg:p-12 order-2 md:order-1">
                    
                    <div class="w-full max-w-md mx-auto space-y-6 flex flex-col">
                        <!-- Back Button -->
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-zinc-400 dark:text-zinc-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors select-none self-start group">
                            <span class="material-symbols-outlined text-[16px] group-hover:-translate-x-0.5 transition-transform">arrow_back</span>
                            <span>Kembali ke Beranda</span>
                        </a>

                        <!-- Heading -->
                        <div class="text-left space-y-1">
                            <h3 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight">Daftar Akun Klien</h3>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 font-medium">Buat akun klien RZ untuk melaporkan kendala IT sistem dan memantau SLA perbaikan.</p>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('register') }}" class="space-y-4">
                            @csrf

                            <!-- Full Name -->
                            <div class="space-y-1">
                                <label for="name" class="block text-xs font-bold font-mono tracking-wider text-zinc-500 uppercase">Nama Lengkap</label>
                                <div class="relative">
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe"
                                           class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl text-zinc-900 dark:text-zinc-50 placeholder-zinc-400 dark:placeholder-zinc-600 focus:border-emerald-600 dark:focus:border-emerald-500 focus:ring focus:ring-emerald-600/20 dark:focus:ring-emerald-500/20 transition-all pl-4 pr-10 py-2.5 text-sm">
                                    <span class="material-symbols-outlined text-[20px] text-zinc-400 dark:text-zinc-600 absolute right-3.5 top-1/2 -translate-y-1/2 select-none pointer-events-none">person</span>
                                </div>
                                @error('name')
                                    <p class="text-rose-600 dark:text-rose-400 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="space-y-1">
                                <label for="email" class="block text-xs font-bold font-mono tracking-wider text-zinc-500 uppercase">Alamat Email</label>
                                <div class="relative">
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com"
                                           class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl text-zinc-900 dark:text-zinc-50 placeholder-zinc-400 dark:placeholder-zinc-600 focus:border-emerald-600 dark:focus:border-emerald-500 focus:ring focus:ring-emerald-600/20 dark:focus:ring-emerald-500/20 transition-all pl-4 pr-10 py-2.5 text-sm">
                                    <span class="material-symbols-outlined text-[20px] text-zinc-400 dark:text-zinc-600 absolute right-3.5 top-1/2 -translate-y-1/2 select-none pointer-events-none">mail</span>
                                </div>
                                @error('email')
                                    <p class="text-rose-600 dark:text-rose-400 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="space-y-1">
                                <label for="password" class="block text-xs font-bold font-mono tracking-wider text-zinc-500 uppercase">Kata Sandi</label>
                                <div class="relative">
                                    <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                                           class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl text-zinc-900 dark:text-zinc-50 placeholder-zinc-400 dark:placeholder-zinc-600 focus:border-emerald-600 dark:focus:border-emerald-500 focus:ring focus:ring-emerald-600/20 dark:focus:ring-emerald-500/20 transition-all pl-4 pr-10 py-2.5 text-sm">
                                    <span class="material-symbols-outlined text-[20px] text-zinc-400 dark:text-zinc-600 absolute right-3.5 top-1/2 -translate-y-1/2 select-none pointer-events-none">lock</span>
                                </div>
                                @error('password')
                                    <p class="text-rose-600 dark:text-rose-400 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="space-y-1">
                                <label for="password_confirmation" class="block text-xs font-bold font-mono tracking-wider text-zinc-500 uppercase">Konfirmasi Kata Sandi</label>
                                <div class="relative">
                                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                                           class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl text-zinc-900 dark:text-zinc-50 placeholder-zinc-400 dark:placeholder-zinc-600 focus:border-emerald-600 dark:focus:border-emerald-500 focus:ring focus:ring-emerald-600/20 dark:focus:ring-emerald-500/20 transition-all pl-4 pr-10 py-2.5 text-sm">
                                    <span class="material-symbols-outlined text-[20px] text-zinc-400 dark:text-zinc-600 absolute right-3.5 top-1/2 -translate-y-1/2 select-none pointer-events-none">vpn_key</span>
                                </div>
                                @error('password_confirmation')
                                    <p class="text-rose-600 dark:text-rose-400 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-md shadow-emerald-600/10 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600 dark:focus:ring-emerald-500 focus:ring-offset-white dark:focus:ring-offset-zinc-900 transition-all">
                                    Daftar Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column (Colored Welcoming Panel): Desktop: Right, Mobile: Top -->
                <div id="green-panel" class="md:col-span-5 bg-emerald-600 dark:bg-emerald-700 text-white flex flex-col justify-center items-center text-center p-8 sm:p-10 relative overflow-hidden rounded-b-[2.5rem] md:rounded-b-none md:rounded-l-[6rem] lg:rounded-l-[8rem] shrink-0 min-h-[220px] md:min-h-none order-1 md:order-2">
                    <!-- Background shapes inside colored panel -->
                    <div class="absolute top-[-25%] right-[-25%] w-60 h-60 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-[-15%] left-[-15%] w-52 h-52 bg-white/10 rounded-full blur-xl"></div>
                    
                    <div class="relative z-10 space-y-4 max-w-[280px]">
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight">Selamat Datang Kembali!</h2>
                        <p class="text-sm text-emerald-100 font-medium font-sans">Sudah terdaftar di portal operasional kami?</p>
                        <div class="pt-2">
                            <a href="{{ route('login') }}" id="btn-to-login" class="inline-block px-8 py-2.5 border-2 border-white hover:bg-white hover:text-emerald-700 text-white text-sm font-bold rounded-xl transition-all duration-350 shadow-sm focus:outline-none">
                                Masuk Portal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>