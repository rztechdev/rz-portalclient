<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ config('app.name', 'RZ Portal') }} | Solusi Operasional Terpadu</title>
    <!-- Favicon & Brand Icons -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo_rz_teks.jpeg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo_rz_teks.jpeg') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script>
        // Inline theme check to prevent flickering (FOUC)
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased overflow-x-hidden relative min-h-screen flex flex-col justify-between bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-50 transition-colors duration-300"
      x-data="welcomeLayout">

    <!-- Decorative background grid (Clean neutral on white) -->
    <div class="fixed inset-0 bg-grid-pattern z-[-1] pointer-events-none"></div>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col w-full relative overflow-x-hidden">
        
        <!-- Headerless Top Bar (Transparent & Borderless inline navigation inside Container) -->
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-4 sm:py-6 flex items-center justify-between z-50">
            <!-- Branding -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group font-sans shrink-0">
                <img src="{{ asset('images/logo_rz_teks.png') }}" alt="RZ Digital Creative Logo" class="h-8 sm:h-9 w-auto object-contain brightness-0 dark:brightness-100 hover:opacity-95 group-hover:scale-105 transition-all duration-300">
                <span class="text-lg sm:text-xl font-extrabold tracking-tight text-zinc-900 dark:text-white group-hover:opacity-90 transition-opacity">RZ Portal</span>
            </a>

            <!-- Navigation Links (Hidden on mobile) -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-zinc-500 dark:text-zinc-400">
                <a href="#fitur" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Fitur Utama</a>
                <a href="#rbac" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Akses Peran (RBAC)</a>
            </nav>

            <!-- Actions Row -->
            <div class="flex items-center gap-2 sm:gap-4">
                <!-- Theme Switcher -->
                <button @click="toggleTheme()" 
                        type="button"
                        class="p-2 rounded-xl text-zinc-500 dark:text-zinc-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-zinc-200/50 dark:hover:bg-zinc-900/50 transition-colors focus:outline-none cursor-pointer"
                        title="Ganti Tema">
                    <span class="material-symbols-outlined text-[20px] sm:text-[22px] block text-zinc-600 dark:text-zinc-400" x-show="!darkMode">dark_mode</span>
                    <span class="material-symbols-outlined text-[20px] sm:text-[22px] block text-amber-400" x-show="darkMode" style="display: none;">light_mode</span>
                </button>

                <!-- Auth Buttons -->
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm font-bold bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all shadow-sm shadow-indigo-600/10">
                            Dasbor
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-2.5 py-1.5 text-xs sm:text-sm font-semibold text-zinc-600 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-white transition-colors">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-3 py-1.5 text-xs sm:text-sm font-semibold border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-200 hover:border-indigo-600/30 dark:hover:border-indigo-500/40 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-900/50 transition-all">
                                Daftar
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 pt-6 sm:pt-10 pb-16 sm:pb-20 flex-1 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16 items-center relative overflow-hidden">
            
            <!-- Left Side (Typography and details) -->
            <div class="lg:col-span-6 space-y-5 sm:space-y-6 text-left">
                <!-- Tagline Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-zinc-100 dark:bg-zinc-900 border border-zinc-250 dark:border-zinc-800 rounded-full text-[10px] sm:text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400 max-w-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400 animate-pulse shrink-0"></span>
                    <span class="truncate">SISTEM MANAJEMEN OPERASIONAL TERPADU</span>
                </div>
                
                <!-- Main Header -->
                <h1 class="text-3xl sm:text-5xl lg:text-[54px] font-black text-zinc-900 dark:text-white leading-[1.15] sm:leading-[1.1] tracking-tight">
                    Orkestrasi Kerja <br class="hidden sm:inline"/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-indigo-500 dark:from-indigo-400 dark:to-indigo-300">
                        Tanpa Hambatan.
                    </span>
                </h1>
                
                <!-- Description -->
                <p class="text-sm sm:text-base lg:text-lg text-zinc-650 dark:text-zinc-400 leading-relaxed max-w-xl">
                    Tinggalkan koordinasi yang terfragmentasi. RZ Portal menyatukan pelacakan kepatuhan janji layanan (SLA), delegasi tugas tim teknis, dan repositori dokumen proyek dalam satu ekosistem operasional terintegrasi.
                </p>
                
                <!-- CTA Actions -->
                <div class="flex flex-col sm:flex-row gap-3 pt-2 w-full sm:w-auto">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="w-full sm:w-auto px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition-all duration-200 flex items-center justify-center gap-2 shadow-sm shadow-indigo-600/10">
                                Buka Dasbor Utama
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition-all duration-200 flex items-center justify-center gap-2 shadow-sm shadow-indigo-600/10">
                                Mulai Sekarang
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        @endauth
                    @endif
                    <a href="#fitur" class="w-full sm:w-auto px-6 py-3.5 border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-xl font-semibold text-sm hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-colors text-center">
                        Pelajari Fitur
                    </a>
                </div>

                <!-- Strategic Statistics -->
                <div class="pt-6 sm:pt-8 border-t border-zinc-200 dark:border-zinc-800/80 mt-6 sm:mt-8 flex gap-6 sm:gap-8">
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-zinc-900 dark:text-white">99.9%</div>
                        <div class="text-[10px] sm:text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mt-1">Uptime SLA</div>
                    </div>
                    <div class="w-px bg-zinc-200 dark:bg-zinc-800"></div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-zinc-900 dark:text-white">100%</div>
                        <div class="text-[10px] sm:text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wider font-semibold mt-1">Transparansi Progres</div>
                    </div>
                </div>
            </div>

            <!-- Right Side (Stunning Mockup UI with overflow prevention) -->
            <div class="lg:col-span-6 relative mt-4 lg:mt-0 max-w-full overflow-hidden sm:overflow-visible">
                <!-- Wrapper Mockup Panel -->
                <div class="bg-white dark:bg-zinc-900 p-4 sm:p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-xl relative z-10 w-full">
                    
                    <!-- Mock Browser Top Controls -->
                    <div class="flex justify-between items-center mb-4 sm:mb-6 pb-3 sm:pb-4 border-b border-zinc-150 dark:border-zinc-800/60">
                        <div class="flex gap-1.5 shrink-0">
                            <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-rose-500/85"></span>
                            <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-amber-500/85"></span>
                            <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-emerald-500/85"></span>
                        </div>
                        <span class="text-[10px] sm:text-xs font-mono text-zinc-400 dark:text-zinc-500 truncate px-2">rzportal.local/dashboard</span>
                        <div class="w-4 sm:w-6"></div>
                    </div>

                    <!-- Mini dashboard content simulation -->
                    <div class="space-y-4">
                        <!-- SLA Alert Widget -->
                        <div class="bg-zinc-50 dark:bg-zinc-950 p-3 sm:p-4 rounded-xl border border-zinc-200/60 dark:border-zinc-800/60 shadow-sm">
                            <div class="flex justify-between items-start gap-2 mb-2">
                                <div class="min-w-0">
                                    <div class="text-[9px] text-indigo-600 dark:text-indigo-400 font-mono font-bold uppercase tracking-wider truncate">TKT-102 &bull; SLA Aktif</div>
                                    <div class="text-xs sm:text-sm font-bold text-zinc-850 dark:text-zinc-100 mt-0.5 truncate">Integrasi Gateway Payment</div>
                                </div>
                                <span class="px-2 py-0.5 bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 text-[9px] font-extrabold rounded-md border border-rose-100 dark:border-rose-900/30 shrink-0">KRITIS</span>
                            </div>
                            <div class="flex justify-between items-center mt-3 pt-2.5 border-t border-zinc-200/40 dark:border-zinc-800/40">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center text-[9px] font-bold shrink-0">IT</span>
                                    <span class="text-[10px] sm:text-xs text-zinc-500 dark:text-zinc-400 truncate">Tim Infrastruktur</span>
                                </div>
                                <div class="text-[10px] sm:text-xs text-rose-650 dark:text-rose-400 flex items-center gap-1 font-semibold shrink-0">
                                    <span class="material-symbols-outlined text-[13px] sm:text-[15px] animate-pulse">timer</span>
                                    <span>01:24:59 Tersisa</span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Tasks list -->
                        <div class="bg-zinc-50 dark:bg-zinc-950 p-3 sm:p-4 rounded-xl border border-zinc-200/60 dark:border-zinc-800/60 shadow-sm">
                            <div class="flex justify-between items-center gap-2 mb-3">
                                <span class="text-xs font-bold text-zinc-800 dark:text-zinc-250 truncate">Tugas Internal Proyek</span>
                                <span class="text-[9px] font-mono font-semibold bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-100 dark:border-emerald-900/30 text-emerald-600 dark:text-emerald-400 px-1.5 py-0.5 rounded shrink-0">80% SELESAI</span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-500 dark:text-zinc-400">
                                    <span class="material-symbols-outlined text-emerald-500 text-[14px] sm:text-[16px] shrink-0">check_circle</span>
                                    <span class="line-through truncate">Migrasi Database & Sinkronisasi Skema</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-500 dark:text-zinc-400">
                                    <span class="material-symbols-outlined text-emerald-500 text-[14px] sm:text-[16px] shrink-0">check_circle</span>
                                    <span class="line-through truncate">Uji Beban & Keamanan Endpoint API</span>
                                </div>
                                <div class="flex items-center gap-2 text-zinc-800 dark:text-zinc-200">
                                    <span class="material-symbols-outlined text-zinc-350 dark:text-zinc-700 text-[14px] sm:text-[16px] shrink-0">radio_button_unchecked</span>
                                    <span class="text-[11px] sm:text-xs font-medium truncate">UAT (User Acceptance Testing) & Sign-Off</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Backing decorative visual ornaments (Hidden on extra small screens to prevent overflow) -->
                <div class="hidden sm:block absolute -top-8 -right-8 w-36 h-36 border border-zinc-200 dark:border-zinc-800/60 rounded-full -z-10"></div>
                <div class="hidden sm:block absolute -bottom-10 -left-10 w-44 h-44 border border-indigo-600/10 rounded-full -z-10"></div>
            </div>
        </section>

        <!-- Features Grid Section -->
        <section id="fitur" class="py-12 sm:py-20 border-t border-zinc-200 dark:border-zinc-800/80 bg-zinc-100/20 dark:bg-zinc-950/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center mb-10 sm:mb-16 space-y-2">
                    <h2 class="text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400 tracking-widest uppercase">Kapasitas Sistem</h2>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 dark:text-white tracking-tight">Keunggulan RZ Portal</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Feature Card 1 -->
                    <div class="bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 hover:border-indigo-600/30 dark:hover:border-indigo-500/40 hover:-translate-y-1 transition-all duration-300 shadow-sm hover:shadow-md">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-5 sm:mb-6">
                            <span class="material-symbols-outlined text-[22px] sm:text-[24px]">dashboard_customize</span>
                        </div>
                        <h4 class="text-base sm:text-lg font-bold text-zinc-900 dark:text-white mb-2 sm:mb-3">Manajemen Terpusat</h4>
                        <p class="text-xs sm:text-sm text-zinc-650 dark:text-zinc-400 leading-relaxed">
                            Satu pintu untuk memantau pengerjaan proyek dan delegasi tugas. Visibilitas papan kerja terintegrasi langsung untuk seluruh tim teknis.
                        </p>
                    </div>

                    <!-- Feature Card 2 (Highlight variant) -->
                    <div class="bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 hover:border-indigo-600/30 dark:hover:border-indigo-500/40 hover:-translate-y-1 transition-all duration-300 shadow-sm hover:shadow-md relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 sm:w-28 sm:h-28 bg-indigo-600/5 rounded-full blur-xl"></div>
                        <div class="w-11 h-11 sm:w-12 sm:h-12 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-5 sm:mb-6 relative z-10">
                            <span class="material-symbols-outlined text-[22px] sm:text-[24px]">monitoring</span>
                        </div>
                        <h4 class="text-base sm:text-lg font-bold text-zinc-900 dark:text-white mb-2 sm:mb-3 relative z-10">Pemantauan Otomatis</h4>
                        <p class="text-xs sm:text-sm text-zinc-650 dark:text-zinc-400 leading-relaxed relative z-10">
                            Lacak metrik KPI dan kepatuhan janji layanan (SLA Compliance) secara real-time. Sistem otomatis menghitung durasi tiket tanpa pelaporan manual.
                        </p>
                    </div>

                    <!-- Feature Card 3 -->
                    <div class="bg-white dark:bg-zinc-900 p-6 sm:p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 hover:border-indigo-600/30 dark:hover:border-indigo-500/40 hover:-translate-y-1 transition-all duration-300 shadow-sm hover:shadow-md">
                        <div class="w-11 h-11 sm:w-12 sm:h-12 bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 mb-5 sm:mb-6">
                            <span class="material-symbols-outlined text-[22px] sm:text-[24px]">rule_folder</span>
                        </div>
                        <h4 class="text-base sm:text-lg font-bold text-zinc-900 dark:text-white mb-2 sm:mb-3">Standarisasi Layanan</h4>
                        <p class="text-xs sm:text-sm text-zinc-650 dark:text-zinc-400 leading-relaxed">
                            Formulir pelaporan kendala IT terstandar untuk klien. Terhubung langsung dengan repositori file dan dokumen hasil pengerjaan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Interactive RBAC Explorer Section -->
        <section id="rbac" class="py-12 sm:py-20 border-t border-zinc-200 dark:border-zinc-800/80">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center mb-10 sm:mb-12">
                    <h2 class="text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400 tracking-widest uppercase mb-2">Keamanan & Kejelasan Tanggung Jawab</h2>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-zinc-900 dark:text-white tracking-tight">Hak Akses Berbasis Peran (RBAC)</h3>
                    <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-2 max-w-lg mx-auto">Sistem keamanan operasional multi-level untuk membagi tanggung jawab kerja dan menjaga integritas data.</p>
                </div>

                <!-- Interactive Tab Layout (Alpine.js) -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8 items-start">
                    
                    <!-- Left Tab Buttons (4 Roles - Horizontally scrollable on mobile) -->
                    <div class="md:col-span-4 flex flex-row md:flex-col gap-2 overflow-x-auto no-scrollbar pb-3 md:pb-0 scroll-smooth -mx-4 px-4 md:mx-0 md:px-0">
                        <!-- PM Tab -->
                        <button @click="activeRole = 'pm'"
                                :class="activeRole === 'pm' ? 'bg-indigo-50/80 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border-indigo-500 font-bold' : 'bg-transparent text-zinc-500 hover:bg-zinc-150 dark:hover:bg-zinc-900/50 border-transparent'"
                                class="flex items-center gap-2.5 px-4 py-3 rounded-xl border-l-2 text-xs sm:text-sm text-left transition-all shrink-0">
                            <span class="material-symbols-outlined text-[18px] sm:text-[20px] shrink-0">manage_accounts</span>
                            <span>Project Manager</span>
                        </button>
                        
                        <!-- Technician Tab -->
                        <button @click="activeRole = 'tech'"
                                :class="activeRole === 'tech' ? 'bg-indigo-50/80 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border-indigo-500 font-bold' : 'bg-transparent text-zinc-500 hover:bg-zinc-150 dark:hover:bg-zinc-900/50 border-transparent'"
                                class="flex items-center gap-2.5 px-4 py-3 rounded-xl border-l-2 text-xs sm:text-sm text-left transition-all shrink-0">
                            <span class="material-symbols-outlined text-[18px] sm:text-[20px] shrink-0">terminal</span>
                            <span>Tim Teknis</span>
                        </button>

                        <!-- Client Tab -->
                        <button @click="activeRole = 'client'"
                                :class="activeRole === 'client' ? 'bg-indigo-50/80 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border-indigo-500 font-bold' : 'bg-transparent text-zinc-500 hover:bg-zinc-150 dark:hover:bg-zinc-900/50 border-transparent'"
                                class="flex items-center gap-2.5 px-4 py-3 rounded-xl border-l-2 text-xs sm:text-sm text-left transition-all shrink-0">
                            <span class="material-symbols-outlined text-[18px] sm:text-[20px] shrink-0">support_agent</span>
                            <span>Klien / Pelapor</span>
                        </button>

                        <!-- CEO Tab -->
                        <button @click="activeRole = 'ceo'"
                                :class="activeRole === 'ceo' ? 'bg-indigo-50/80 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border-indigo-500 font-bold' : 'bg-transparent text-zinc-500 hover:bg-zinc-150 dark:hover:bg-zinc-900/50 border-transparent'"
                                class="flex items-center gap-2.5 px-4 py-3 rounded-xl border-l-2 text-xs sm:text-sm text-left transition-all shrink-0">
                            <span class="material-symbols-outlined text-[18px] sm:text-[20px] shrink-0">corporate_fare</span>
                            <span>CEO / Direktur</span>
                        </button>
                    </div>

                    <!-- Right Display Screen -->
                    <div class="md:col-span-8 bg-white dark:bg-zinc-900 p-5 sm:p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm min-h-[260px] transition-all">
                        
                        <!-- Content: PM -->
                        <div x-show="activeRole === 'pm'" class="space-y-3 sm:space-y-4" x-transition:enter="transition ease-out duration-200">
                            <div class="flex items-center gap-2.5">
                                <span class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 shrink-0">
                                    <span class="material-symbols-outlined text-[20px] sm:text-[22px] block">manage_accounts</span>
                                </span>
                                <h4 class="text-base sm:text-lg font-bold text-zinc-900 dark:text-white">Project Manager (Pusat Kontrol)</h4>
                            </div>
                            <p class="text-xs sm:text-sm text-zinc-655 dark:text-zinc-400 leading-relaxed">
                                Bertindak sebagai penanggung jawab utama operasional dan koordinasi proyek. Memiliki kapabilitas penuh untuk mendelegasikan tugas serta mengontrol tenggat waktu SLA.
                            </p>
                            <div class="pt-3.5 border-t border-zinc-100 dark:border-zinc-800/60 grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Mendelegasikan tiket ke tim teknis</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Mengontrol & membuat proyek baru</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Melacak KPI kepatuhan SLA tim</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Mengelola hak akses repositori file</span>
                                </div>
                            </div>
                        </div>

                        <!-- Content: Technician -->
                        <div x-show="activeRole === 'tech'" class="space-y-3 sm:space-y-4" x-transition:enter="transition ease-out duration-200" style="display: none;">
                            <div class="flex items-center gap-2.5">
                                <span class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-450 shrink-0">
                                    <span class="material-symbols-outlined text-[20px] sm:text-[22px] block">terminal</span>
                                </span>
                                <h4 class="text-base sm:text-lg font-bold text-zinc-900 dark:text-white">Tim Teknis (Eksekutor Sistem)</h4>
                            </div>
                            <p class="text-xs sm:text-sm text-zinc-655 dark:text-zinc-400 leading-relaxed">
                                Anggota tim lapangan atau pengembang yang menerima penugasan langsung dari PM. Fokus pada penyelesaian masalah kendala sistem sesuai tenggat waktu yang ditentukan.
                            </p>
                            <div class="pt-3.5 border-t border-zinc-100 dark:border-zinc-800/60 grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-emerald-500 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Menerima notifikasi tugas otomatis</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-emerald-500 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Mengubah progres status penugasan</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-emerald-500 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Mengunggah dokumen laporan kerja</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-emerald-500 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Menutup tiket yang telah diselesaikan</span>
                                </div>
                            </div>
                        </div>

                        <!-- Content: Client -->
                        <div x-show="activeRole === 'client'" class="space-y-3 sm:space-y-4" x-transition:enter="transition ease-out duration-200" style="display: none;">
                            <div class="flex items-center gap-2.5">
                                <span class="p-2 rounded-lg bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 shrink-0">
                                    <span class="material-symbols-outlined text-[20px] sm:text-[22px] block">support_agent</span>
                                </span>
                                <h4 class="text-base sm:text-lg font-bold text-zinc-900 dark:text-white">Klien / Pelapor Kendala</h4>
                            </div>
                            <p class="text-xs sm:text-sm text-zinc-655 dark:text-zinc-400 leading-relaxed">
                                Pengguna eksternal atau perwakilan mitra yang melaporkan kendala operasional. Laporan kendala memicu inisiasi penghitung SLA secara otomatis.
                            </p>
                            <div class="pt-3.5 border-t border-zinc-100 dark:border-zinc-800/60 grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-amber-550 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Membuat tiket pelaporan kendala baru</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-amber-550 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Melacak progres pengerjaan tiket</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-amber-550 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Mengunduh berkas lampiran pengerjaan</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-amber-550 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Memberikan penilaian CSAT layanan</span>
                                </div>
                            </div>
                        </div>

                        <!-- Content: CEO -->
                        <div x-show="activeRole === 'ceo'" class="space-y-3 sm:space-y-4" x-transition:enter="transition ease-out duration-200" style="display: none;">
                            <div class="flex items-center gap-2.5">
                                <span class="p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-300 shrink-0">
                                    <span class="material-symbols-outlined text-[20px] sm:text-[22px] block">corporate_fare</span>
                                </span>
                                <h4 class="text-base sm:text-lg font-bold text-zinc-900 dark:text-white">CEO / Direktur (Pemantau Strategis)</h4>
                            </div>
                            <p class="text-xs sm:text-sm text-zinc-655 dark:text-zinc-400 leading-relaxed">
                                Memiliki visibilitas strategis (Read-Only) untuk memantau performa bisnis agregat, statistik kepatuhan SLA bulanan, serta kepuasan pelanggan secara menyeluruh.
                            </p>
                            <div class="pt-3.5 border-t border-zinc-100 dark:border-zinc-800/60 grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-zinc-500 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Akses dasbor eksekutif agregat</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-zinc-500 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Memantau grafik kepatuhan SLA global</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-zinc-500 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Melihat evaluasi penilaian kepuasan klien</span>
                                </div>
                                <div class="flex items-center gap-2 text-[11px] sm:text-xs text-zinc-600 dark:text-zinc-350">
                                    <span class="material-symbols-outlined text-zinc-500 text-[16px] sm:text-[18px] shrink-0">check_box</span>
                                    <span class="truncate">Sistem read-only (keamanan data terjamin)</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="relative border-t border-zinc-200 dark:border-zinc-800/80 bg-zinc-50/80 dark:bg-zinc-950/80 py-10 sm:py-16 px-4 sm:px-6 lg:px-8 transition-colors duration-300 overflow-hidden">
        <!-- Decorative background grid pattern -->
        <div class="absolute inset-0 bg-grid-pattern pointer-events-none opacity-70 dark:opacity-40"></div>

        <div class="max-w-7xl mx-auto w-full relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-8 sm:pb-12 border-b border-zinc-200 dark:border-zinc-800">
            
            <!-- Col 1: Brand Info (lg:col-span-4) -->
            <div class="lg:col-span-4 space-y-4">
                <a href="{{ url('/') }}" class="inline-block focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8B9B70] rounded-xl">
                    <x-rz-logo variant="light" size="lg" />
                </a>
                <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed max-w-sm">
                    Platform orkestrasi operasional terpadu & agensi digital RZ Digital Creative. Pelacakan SLA proyek, manajemen tim, dan layanan website berkualitas tinggi.
                </p>
                
                <!-- Social Channels -->
                <div class="pt-1 flex items-center gap-3">
                    <!-- WhatsApp -->
                    <a 
                        href="https://wa.me/6285151699883" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="w-9 h-9 rounded-xl bg-zinc-100 dark:bg-zinc-800/80 hover:bg-[#8B9B70] hover:text-white dark:hover:bg-[#8B9B70] text-zinc-600 dark:text-zinc-300 flex items-center justify-center transition-colors duration-200 border border-zinc-200 dark:border-zinc-700/60"
                        aria-label="WhatsApp"
                        title="WhatsApp (+62 851-5169-9883)"
                    >
                        <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.969.54 1.777.781 2.796.781 3.182 0 5.768-2.587 5.768-5.766 0-3.18-2.586-5.767-5.768-5.767zm9.969 5.766c0 5.503-4.478 9.98-9.969 9.98-1.745 0-3.376-.453-4.793-1.242L2 22l1.328-4.851C2.474 15.698 2 13.911 2 11.938 2 6.435 6.478 1.958 11.969 1.958c5.491 0 10.031 4.477 10.031 9.98z"/>
                        </svg>
                    </a>

                    <!-- Email -->
                    <a 
                        href="mailto:rzcompanyidn@gmail.com" 
                        class="w-9 h-9 rounded-xl bg-zinc-100 dark:bg-zinc-800/80 hover:bg-[#8B9B70] hover:text-white dark:hover:bg-[#8B9B70] text-zinc-600 dark:text-zinc-300 flex items-center justify-center transition-colors duration-200 border border-zinc-200 dark:border-zinc-700/60"
                        aria-label="Email"
                        title="Email (rzcompanyidn@gmail.com)"
                    >
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </a>

                    <!-- Instagram -->
                    <a 
                        href="https://instagram.com/rzdigitalcreative.id" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="w-9 h-9 rounded-xl bg-zinc-100 dark:bg-zinc-800/80 hover:bg-[#8B9B70] hover:text-white dark:hover:bg-[#8B9B70] text-zinc-600 dark:text-zinc-300 flex items-center justify-center transition-colors duration-200 border border-zinc-200 dark:border-zinc-700/60"
                        aria-label="Instagram"
                        title="Instagram (@rzdigitalcreative.id)"
                    >
                        <svg class="w-4.5 h-4.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>

                <!-- Operating Status Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 font-mono text-[10px] text-zinc-600 dark:text-zinc-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>ONLINE • Fast Response</span>
                </div>
            </div>

            <!-- Col 2: Layanan Website (lg:col-span-3) -->
            <div class="lg:col-span-3 space-y-3">
                <h5 class="text-xs font-bold font-mono tracking-wider text-zinc-400 dark:text-zinc-500 uppercase">
                    Layanan Website
                </h5>
                <ul class="space-y-2.5 text-xs sm:text-sm text-zinc-600 dark:text-zinc-400">
                    <li><a href="https://rzdigitalcreative.my.id/#paket-harga" target="_blank" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">Landing Page Starter (1 Hal)</a></li>
                    <li><a href="https://rzdigitalcreative.my.id/#paket-harga" target="_blank" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">Company Profile Bisnis (5 Hal)</a></li>
                    <li><a href="https://rzdigitalcreative.my.id/#paket-harga" target="_blank" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">Toko Online & Kasir POS Web</a></li>
                    <li><a href="https://rzdigitalcreative.my.id/#paket-harga" target="_blank" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">Redesain & Optimasi SEO</a></li>
                    <li><a href="https://rzdigitalcreative.my.id" target="_blank" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] font-semibold transition-colors flex items-center gap-1">Website Utama ↗</a></li>
                </ul>
            </div>

            <!-- Col 3: Portal Client (lg:col-span-2) -->
            <div class="lg:col-span-2 space-y-3">
                <h5 class="text-xs font-bold font-mono tracking-wider text-zinc-400 dark:text-zinc-500 uppercase">
                    Portal Client
                </h5>
                <ul class="space-y-2.5 text-xs sm:text-sm text-zinc-600 dark:text-zinc-400">
                    <li><a href="#fitur" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">Fitur Utama</a></li>
                    <li><a href="#rbac" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">Akses Peran (RBAC)</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">Masuk Portal</a></li>
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">Daftar Akun Baru</a></li>
                    @endif
                    <li><a href="{{ url('/dashboard') }}" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">Dasbor Monitoring</a></li>
                </ul>
            </div>

            <!-- Col 4: Hubungi Kami (lg:col-span-3) -->
            <div class="lg:col-span-3 space-y-3">
                <h5 class="text-xs font-bold font-mono tracking-wider text-zinc-400 dark:text-zinc-500 uppercase">
                    Hubungi Kami
                </h5>
                <ul class="space-y-3 text-xs sm:text-sm text-zinc-600 dark:text-zinc-400">
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800/80 border border-zinc-200 dark:border-zinc-700/60 text-[#8B9B70] dark:text-[#A2B187] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.699c.969.54 1.777.781 2.796.781 3.182 0 5.768-2.587 5.768-5.766 0-3.18-2.586-5.767-5.768-5.767zm9.969 5.766c0 5.503-4.478 9.98-9.969 9.98-1.745 0-3.376-.453-4.793-1.242L2 22l1.328-4.851C2.474 15.698 2 13.911 2 11.938 2 6.435 6.478 1.958 11.969 1.958c5.491 0 10.031 4.477 10.031 9.98z"/>
                            </svg>
                        </div>
                        <a href="https://wa.me/6285151699883" target="_blank" class="hover:text-zinc-900 dark:hover:text-white font-mono whitespace-nowrap transition-colors">
                            +62 851-5169-9883 (WA)
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800/80 border border-zinc-200 dark:border-zinc-700/60 text-[#8B9B70] dark:text-[#A2B187] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <a href="mailto:rzcompanyidn@gmail.com" class="hover:text-zinc-900 dark:hover:text-white whitespace-nowrap transition-colors">
                            rzcompanyidn@gmail.com
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800/80 border border-zinc-200 dark:border-zinc-700/60 text-[#8B9B70] dark:text-[#A2B187] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </div>
                        <a href="https://instagram.com/rzdigitalcreative.id" target="_blank" class="hover:text-zinc-900 dark:hover:text-white whitespace-nowrap transition-colors">
                            @rzdigitalcreative.id
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Bottom Row with Domains -->
        <div class="max-w-7xl mx-auto w-full pt-6 sm:pt-8 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-zinc-400 dark:text-zinc-600 font-semibold text-center sm:text-left">
            <div>
                &copy; {{ date('Y') }} RZ Digital Creative. All rights reserved.
            </div>
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-4 font-mono text-[11px]">
                <a href="https://portalclient.rzdigitalcreative.my.id" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">portalclient.rzdigitalcreative.my.id</a>
                <span>•</span>
                <a href="https://rzdigitalcreative.my.id" target="_blank" class="hover:text-[#8B9B70] dark:hover:text-[#A2B187] transition-colors">rzdigitalcreative.my.id</a>
            </div>
        </div>
    </footer>

</body>
</html>