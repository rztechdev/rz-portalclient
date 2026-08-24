<div x-show="sidebarOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-zinc-900/40 dark:bg-zinc-950/80 backdrop-blur-md z-40 lg:hidden" 
     @click="sidebarOpen = false"
     style="display: none;">
</div>

<aside :class="sidebarOpen ? 'lg:w-64 translate-x-0' : 'lg:w-20 -translate-x-full lg:translate-x-0'" 
       class="fixed top-0 left-0 z-50 h-screen bg-white/90 dark:bg-zinc-950/90 backdrop-blur-xl border-r border-zinc-200/80 dark:border-zinc-900/80 transition-all duration-300 ease-in-out flex flex-col shadow-[1px_0_10px_rgba(0,0,0,0.015)] dark:shadow-[1px_0_15px_rgba(0,0,0,0.2)] w-64">
    
    <!-- Branding Header -->
    <div class="h-16 shrink-0 flex items-center justify-between px-6 border-b border-zinc-200/60 dark:border-zinc-800/60 bg-white/50 dark:bg-zinc-950/50 backdrop-blur-md">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group font-sans">
            <img src="{{ asset('images/logo_rz_teks.jpeg') }}" alt="RZ Digital Creative Logo" class="h-8 w-auto object-contain rounded-lg shadow-2xs group-hover:scale-105 transition-transform duration-300">
            <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="flex flex-col">
                <span class="text-sm font-black text-zinc-900 dark:text-white tracking-tight leading-none">RZ Portal</span>
                <span class="text-[9px] font-mono text-emerald-500 dark:text-emerald-400 font-bold uppercase tracking-wider mt-0.5">Control Center</span>
            </div>
        </a>
        
        <button @click="sidebarOpen = false" class="lg:hidden p-2 text-zinc-400 dark:text-zinc-500 hover:text-zinc-600 dark:hover:text-white rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800/50 transition-colors">
            <span class="material-symbols-outlined text-[20px] block">close</span>
        </button>
    </div>

    <!-- Navigation Menu items -->
    <nav class="flex-1 overflow-y-auto custom-scrollbar py-6 space-y-1 transition-all duration-300 px-4" :class="sidebarOpen ? 'px-4' : 'lg:px-2 px-4'">
        <!-- Dasbor Link -->
        @php
            $isDashboard = request()->routeIs('dashboard');
        @endphp
        <a href="{{ route('dashboard') }}" 
           :title="!sidebarOpen ? 'Dasbor' : ''"
           :class="sidebarOpen ? 'px-4 py-2.5 justify-start gap-3' : 'lg:justify-center lg:px-0 py-2.5 px-4 justify-start gap-3'"
           class="relative flex items-center rounded-xl text-xs transition-all duration-300 group px-4 py-2.5 justify-start gap-3 {{ $isDashboard ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/5 text-emerald-600 dark:text-emerald-400 font-bold border border-emerald-500/10 dark:border-emerald-500/20 shadow-sm' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100/60 dark:hover:bg-zinc-900/40 hover:text-zinc-900 dark:hover:text-zinc-100 font-semibold border border-transparent hover:translate-x-1' }}">
            @if($isDashboard)
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-gradient-to-b from-emerald-500 to-teal-400 rounded-r-md"></span>
            @endif
            <span class="material-symbols-outlined text-[19px] {{ $isDashboard ? 'text-emerald-500 dark:text-emerald-400 scale-105' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-zinc-100 group-hover:scale-110' }} transition-all duration-300">dashboard</span>
            <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="truncate">Dashboard</span>
        </a>

        <!-- Tiket Saya Link (Klien) -->
        @if(auth()->user()->hasRole('client'))
            @php
                $isTickets = request()->routeIs('tickets.*');
            @endphp
            <a href="{{ route('tickets.index') }}" 
               :title="!sidebarOpen ? 'Tiket Saya' : ''"
               :class="sidebarOpen ? 'px-4 py-2.5 justify-start gap-3' : 'lg:justify-center lg:px-0 py-2.5 px-4 justify-start gap-3'"
               class="relative flex items-center rounded-xl text-xs transition-all duration-300 group px-4 py-2.5 justify-start gap-3 {{ $isTickets ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/5 text-emerald-600 dark:text-emerald-400 font-bold border border-emerald-500/10 dark:border-emerald-500/20 shadow-sm' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100/60 dark:hover:bg-zinc-900/40 hover:text-zinc-900 dark:hover:text-zinc-100 font-semibold border border-transparent hover:translate-x-1' }}">
                @if($isTickets)
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-gradient-to-b from-emerald-500 to-teal-400 rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined text-[19px] {{ $isTickets ? 'text-emerald-500 dark:text-emerald-400 scale-105' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-zinc-100 group-hover:scale-110' }} transition-all duration-300">confirmation_number</span>
                <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="truncate">Tiket Saya</span>
            </a>
        @endif

        <!-- Mode Eksekutif Header -->
        @if(auth()->user()->hasRole('ceo'))
            <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" class="flex items-center gap-2 px-4 py-2 mt-3 mb-2">
                <span class="text-[9px] font-bold font-mono text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">Mode Eksekutif</span>
                <div class="h-px bg-zinc-200/60 dark:bg-zinc-800/60 flex-1"></div>
            </div>
        @endif

        <!-- Tiket Masuk Link (Admin / Teknisi) -->
        @if(auth()->user()->hasRole('admin'))
            @php
                $isAdminTickets = request()->routeIs('admin.tickets*');
            @endphp
            <a href="{{ route('admin.tickets') }}" 
               :title="!sidebarOpen ? 'Tiket Masuk' : ''"
               :class="sidebarOpen ? 'px-4 py-2.5 justify-start gap-3' : 'lg:justify-center lg:px-0 py-2.5 px-4 justify-start gap-3'"
               class="relative flex items-center rounded-xl text-xs transition-all duration-300 group px-4 py-2.5 justify-start gap-3 {{ $isAdminTickets ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/5 text-emerald-600 dark:text-emerald-400 font-bold border border-emerald-500/10 dark:border-emerald-500/20 shadow-sm' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100/60 dark:hover:bg-zinc-900/40 hover:text-zinc-900 dark:hover:text-zinc-100 font-semibold border border-transparent hover:translate-x-1' }}">
                @if($isAdminTickets)
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-gradient-to-b from-emerald-500 to-teal-400 rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined text-[19px] {{ $isAdminTickets ? 'text-emerald-500 dark:text-emerald-400 scale-105' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-zinc-100 group-hover:scale-110' }} transition-all duration-300">support_agent</span>
                <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="truncate">Tiket Masuk</span>
            </a>
        @elseif(auth()->user()->hasRole('technician'))
            @php
                $isTechTickets = request()->routeIs('technician.tickets*');
            @endphp
            <a href="{{ route('technician.tickets') }}" 
               :title="!sidebarOpen ? 'Tiket Masuk' : ''"
               :class="sidebarOpen ? 'px-4 py-2.5 justify-start gap-3' : 'lg:justify-center lg:px-0 py-2.5 px-4 justify-start gap-3'"
               class="relative flex items-center rounded-xl text-xs transition-all duration-300 group px-4 py-2.5 justify-start gap-3 {{ $isTechTickets ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/5 text-emerald-600 dark:text-emerald-400 font-bold border border-emerald-500/10 dark:border-emerald-500/20 shadow-sm' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100/60 dark:hover:bg-zinc-900/40 hover:text-zinc-900 dark:hover:text-zinc-100 font-semibold border border-transparent hover:translate-x-1' }}">
                @if($isTechTickets)
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-gradient-to-b from-emerald-500 to-teal-400 rounded-r-md"></span>
                @endif
                <span class="material-symbols-outlined text-[19px] {{ $isTechTickets ? 'text-emerald-500 dark:text-emerald-400 scale-105' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-zinc-100 group-hover:scale-110' }} transition-all duration-300">support_agent</span>
                <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="truncate">Tiket Masuk</span>
            </a>
        @endif

        <!-- Proyek Link -->
        @php
            $isProjects = request()->routeIs('projects.*');
        @endphp
        <a href="{{ route('projects.index') }}" 
           :title="!sidebarOpen ? 'Proyek' : ''"
           :class="sidebarOpen ? 'px-4 py-2.5 justify-start gap-3' : 'lg:justify-center lg:px-0 py-2.5 px-4 justify-start gap-3'"
           class="relative flex items-center rounded-xl text-xs transition-all duration-300 group px-4 py-2.5 justify-start gap-3 {{ $isProjects ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/5 text-emerald-600 dark:text-emerald-400 font-bold border border-emerald-500/10 dark:border-emerald-500/20 shadow-sm' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100/60 dark:hover:bg-zinc-900/40 hover:text-zinc-900 dark:hover:text-zinc-100 font-semibold border border-transparent hover:translate-x-1' }}">
            @if($isProjects)
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-gradient-to-b from-emerald-500 to-teal-400 rounded-r-md"></span>
            @endif
            <span class="material-symbols-outlined text-[19px] {{ $isProjects ? 'text-emerald-500 dark:text-emerald-400 scale-105' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-zinc-100 group-hover:scale-110' }} transition-all duration-300">view_kanban</span>
            <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="truncate">Proyek</span>
        </a>
    </nav>
</aside>

<header :class="sidebarOpen ? 'lg:left-64' : 'lg:left-20 left-0'" 
        class="fixed top-0 right-0 h-16 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800/80 flex items-center justify-between px-4 sm:px-8 z-30 transition-all duration-300">
    
    <div class="flex items-center">
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white focus:outline-none transition-colors">
            <span class="material-symbols-outlined text-[24px]" x-text="sidebarOpen ? 'menu_open' : 'menu'">menu_open</span>
        </button>
    </div>

    <div class="flex items-center gap-2 sm:gap-4">
        
        <!-- Theme Toggle Button -->
        <button @click="toggleTheme()" 
                class="p-2 rounded-xl text-zinc-500 dark:text-zinc-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 transition-colors focus:outline-none"
                title="Ganti Tema">
            <span class="material-symbols-outlined text-[24px] block" x-show="!darkMode">light_mode</span>
            <span class="material-symbols-outlined text-[24px] block" x-show="darkMode" style="display: none;">dark_mode</span>
        </button>

        <x-dropdown align="right" width="80" contentClasses="py-0 overflow-hidden bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl">
            <x-slot name="trigger">
                <button class="relative p-2 rounded-xl text-zinc-500 dark:text-zinc-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 transition-colors focus:outline-none">
                    <span class="material-symbols-outlined text-[24px]">notifications</span>
                    @php
                        $unreadCount = method_exists(Auth::user(), 'unreadNotifications') ? Auth::user()->unreadNotifications->count() : 0;
                    @endphp
                    @if($unreadCount > 0)
                        <span id="notification-badge" class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[9px] font-black leading-none text-white bg-rose-500 rounded-full border border-white dark:border-zinc-900 shadow-sm">
                            {{ $unreadCount }}
                        </span>
                    @else
                        <span id="notification-badge" class="hidden absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-[9px] font-black leading-none text-white bg-rose-500 rounded-full border border-white dark:border-zinc-900 shadow-sm">0</span>
                    @endif
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="px-4 py-3 bg-zinc-50/50 dark:bg-zinc-950/50 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                    <span class="text-xs font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-wider">Pusat Notifikasi</span>
                    <span id="notification-count-label" class="text-[10px] font-mono bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 px-2 py-0.5 rounded-md font-bold">{{ $unreadCount }} Baru</span>
                </div>

                <div id="notification-list" class="max-h-80 overflow-y-auto custom-scrollbar divide-y divide-zinc-100 dark:divide-zinc-800/40 bg-white dark:bg-zinc-900">
                    @if(method_exists(Auth::user(), 'unreadNotifications') && $unreadCount > 0)
                        @foreach(Auth::user()->unreadNotifications->take(5) as $notification)
                            <div data-notification-item class="px-4 py-3.5 hover:bg-zinc-50 dark:hover:bg-zinc-950/30 transition-colors duration-150 text-sm group">
                                @if(!empty($notification->data['url']))
                                    <a href="{{ $notification->data['url'] }}" class="block">
                                @endif
                                <div class="font-semibold text-zinc-800 dark:text-zinc-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $notification->data['title'] ?? 'Pemberitahuan Sistem' }}
                                </div>
                                <div class="text-zinc-500 dark:text-zinc-400 text-xs mt-1 leading-relaxed">
                                    {{ $notification->data['message'] ?? '' }}
                                </div>
                                @if(!empty($notification->data['url']))
                                    </a>
                                @endif
                                <div class="text-[10px] font-mono text-zinc-400 dark:text-zinc-500 mt-2.5 flex justify-between items-center">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[12px]">schedule</span>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    <button type="button" @click.stop onclick="markAsRead('{{ $notification->id }}', this)" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold">Tandai Dibaca</button>
                                 </div>
                            </div>
                        @endforeach
                    @else
                        <div data-notification-empty class="px-4 py-8 text-center bg-white dark:bg-zinc-900">
                            <span class="material-symbols-outlined text-zinc-300 dark:text-zinc-600 text-[36px] block mb-2">notifications_off</span>
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 italic">Kotak masuk bersih. Tidak ada notifikasi baru.</p>
                        </div>
                    @endif
                </div>
            </x-slot>
        </x-dropdown>

        <x-dropdown align="right" width="56" contentClasses="py-0 overflow-hidden bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl">
            <x-slot name="trigger">
                <button class="flex items-center gap-2.5 pl-3 sm:pl-4 border-l border-zinc-200 dark:border-zinc-800/80 focus:outline-none group">
                    <div class="text-right hidden sm:block">
                        <div class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-150">{{ Auth::user()->name }}</div>
                        <div class="text-[9px] font-mono text-zinc-400 dark:text-zinc-500 mt-0.5">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=8B9B70&background=F6F8F3&bold=true" alt="Profile" 
                             class="w-8 h-8 rounded-full border border-zinc-200 dark:border-zinc-800 transition-all duration-200">
                        <span class="absolute bottom-0 right-0 w-2 h-2 bg-emerald-500 rounded-full border border-white dark:border-zinc-900"></span>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="px-4 py-3 bg-zinc-50 dark:bg-zinc-950/40 sm:hidden border-b border-zinc-200 dark:border-zinc-800">
                    <p class="text-xs font-mono text-zinc-400 dark:text-zinc-500 uppercase tracking-wider">Pengguna</p>
                    <p class="text-sm font-bold text-zinc-800 dark:text-zinc-200 truncate mt-0.5">{{ Auth::user()->name }}</p>
                </div>

                <div class="p-1.5 bg-white dark:bg-zinc-900">
                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2.5 px-3 py-2 text-sm text-zinc-600 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-zinc-400 dark:text-zinc-500">manage_accounts</span>
                        <span>{{ __('Pengaturan Profil') }}</span>
                    </x-dropdown-link>
                </div>

                <div class="p-1.5 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800/50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();" 
                                        class="flex items-center gap-2.5 px-3 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/20 rounded-lg transition-colors font-bold">
                            <span class="material-symbols-outlined text-[18px]">logout</span>
                            <span>{{ __('Keluar Aplikasi') }}</span>
                        </x-dropdown-link>
                    </form>
                </div>
            </x-slot>
        </x-dropdown>
    </div>
</header>