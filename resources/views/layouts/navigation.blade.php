<!-- ========================================================================= -->
<!-- 1. DESKTOP SIDEBAR (Visible only on Desktop lg:flex) -->
<!-- ========================================================================= -->
<aside class="hidden lg:flex fixed top-0 left-0 z-50 h-screen bg-white dark:bg-zinc-950 border-r border-zinc-200/80 dark:border-zinc-800/80 flex-col w-64 shadow-xs select-none">
    
    <!-- Branding Header -->
    <div class="h-16 shrink-0 flex items-center justify-between px-6 border-b border-zinc-200/60 dark:border-zinc-800/60 bg-white/50 dark:bg-zinc-950/50 backdrop-blur-md">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group font-sans">
            <img src="{{ asset('images/logo_rz_teks.png') }}" alt="RZ Digital Creative Logo" class="h-8 w-auto object-contain brightness-0 dark:brightness-100 group-hover:scale-105 transition-transform duration-300">
            <div class="flex flex-col">
                <span class="text-sm font-black text-zinc-900 dark:text-white tracking-tight leading-none">RZ Portal</span>
                <span class="text-[9px] font-mono text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider mt-0.5">Client Center</span>
            </div>
        </a>
    </div>

    <!-- Navigation Menu items -->
    <nav class="flex-1 overflow-y-auto custom-scrollbar py-6 space-y-1 transition-all duration-300 px-4">
        <!-- Dasbor Link -->
        @php $isDashboard = request()->routeIs('dashboard'); @endphp
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-3.5 py-2.5 justify-start gap-3 rounded-lg text-xs transition-colors duration-150 group {{ $isDashboard ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-900/70 hover:text-zinc-900 dark:hover:text-zinc-100 font-medium' }}">
            <span class="material-symbols-outlined text-[20px] {{ $isDashboard ? 'text-white' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300' }} shrink-0">dashboard</span>
            <span class="truncate">Dashboard</span>
        </a>

        <!-- Tiket Saya Link (Klien) -->
        @can('tickets.create')
            @php $isTickets = request()->routeIs('tickets.*'); @endphp
            <a href="{{ route('tickets.index') }}" 
               class="flex items-center px-3.5 py-2.5 justify-start gap-3 rounded-lg text-xs transition-colors duration-150 group {{ $isTickets ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-900/70 hover:text-zinc-900 dark:hover:text-zinc-100 font-medium' }}">
                <span class="material-symbols-outlined text-[20px] {{ $isTickets ? 'text-white' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300' }} shrink-0">confirmation_number</span>
                <span class="truncate">Tiket Saya</span>
            </a>
        @endcan

        <!-- Tiket Masuk Link (Admin / Teknisi) -->
        @can('tickets.manage')
            @php $isAdminTickets = request()->routeIs('admin.tickets*'); @endphp
            <a href="{{ route('admin.tickets') }}" 
               class="flex items-center px-3.5 py-2.5 justify-start gap-3 rounded-lg text-xs transition-colors duration-150 group {{ $isAdminTickets ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-900/70 hover:text-zinc-900 dark:hover:text-zinc-100 font-medium' }}">
                <span class="material-symbols-outlined text-[20px] {{ $isAdminTickets ? 'text-white' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300' }} shrink-0">support_agent</span>
                <span class="truncate">Tiket Masuk</span>
            </a>
        @elsecan('tickets.handle')
            @php $isTechTickets = request()->routeIs('technician.tickets*'); @endphp
            <a href="{{ route('technician.tickets') }}" 
               class="flex items-center px-3.5 py-2.5 justify-start gap-3 rounded-lg text-xs transition-colors duration-150 group {{ $isTechTickets ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-900/70 hover:text-zinc-900 dark:hover:text-zinc-100 font-medium' }}">
                <span class="material-symbols-outlined text-[20px] {{ $isTechTickets ? 'text-white' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300' }} shrink-0">support_agent</span>
                <span class="truncate">Tiket Masuk</span>
            </a>
        @endcan

        <!-- Proyek Link -->
        @php $isProjects = request()->routeIs('projects.*'); @endphp
        <a href="{{ route('projects.index') }}" 
           class="flex items-center px-3.5 py-2.5 justify-start gap-3 rounded-lg text-xs transition-colors duration-150 group {{ $isProjects ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-900/70 hover:text-zinc-900 dark:hover:text-zinc-100 font-medium' }}">
            <span class="material-symbols-outlined text-[20px] {{ $isProjects ? 'text-white' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300' }} shrink-0">view_kanban</span>
            <span class="truncate">Proyek</span>
        </a>

        <!-- Seksi Administrasi -->
        @canany(['users.manage', 'roles.manage'])
            <div class="flex items-center gap-2 px-3.5 py-2 mt-4 mb-2">
                <span class="text-[9px] font-bold font-mono text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">Administrasi</span>
                <div class="h-px bg-zinc-200/60 dark:bg-zinc-800/60 flex-1"></div>
            </div>

            @can('users.manage')
                @php $isUsers = request()->routeIs('admin.users.*'); @endphp
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center px-3.5 py-2.5 justify-start gap-3 rounded-lg text-xs transition-colors duration-150 group {{ $isUsers ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-900/70 hover:text-zinc-900 dark:hover:text-zinc-100 font-medium' }}">
                    <span class="material-symbols-outlined text-[20px] {{ $isUsers ? 'text-white' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300' }} shrink-0">group</span>
                    <span class="truncate">Pengguna</span>
                </a>
            @endcan

            @can('roles.manage')
                @php $isRoles = request()->routeIs('admin.roles.*'); @endphp
                <a href="{{ route('admin.roles.index') }}"
                   class="flex items-center px-3.5 py-2.5 justify-start gap-3 rounded-lg text-xs transition-colors duration-150 group {{ $isRoles ? 'bg-emerald-600 text-white font-bold shadow-xs' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-900/70 hover:text-zinc-900 dark:hover:text-zinc-100 font-medium' }}">
                    <span class="material-symbols-outlined text-[20px] {{ $isRoles ? 'text-white' : 'text-zinc-400 dark:text-zinc-500 group-hover:text-zinc-700 dark:group-hover:text-zinc-300' }} shrink-0">admin_panel_settings</span>
                    <span class="truncate">Role &amp; Akses</span>
                </a>
            @endcan
        @endcanany

        <!-- Quick Action / Support in Sidebar -->
        <div class="pt-4 mt-4 border-t border-zinc-200/60 dark:border-zinc-800/60">
            @can('tickets.create')
                <a href="{{ route('tickets.create') }}" 
                   class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 hover:bg-emerald-100 dark:hover:bg-emerald-950/70 rounded-lg transition-colors border border-emerald-200/60 dark:border-emerald-800/40">
                    <span class="material-symbols-outlined text-[18px] text-emerald-600">add_circle</span>
                    <span>Buat Tiket Baru</span>
                </a>
            @else
                <a href="{{ route('projects.index') }}" 
                   class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 hover:bg-emerald-100 dark:hover:bg-emerald-950/70 rounded-lg transition-colors border border-emerald-200/60 dark:border-emerald-800/40">
                    <span class="material-symbols-outlined text-[18px] text-emerald-600">view_kanban</span>
                    <span>Lihat Semua Proyek</span>
                </a>
            @endcan
        </div>
    </nav>
</aside>

<!-- ========================================================================= -->
<!-- 2. TOP HEADER (Desktop & Mobile) -->
<!-- ========================================================================= -->
<header class="fixed top-0 right-0 left-0 lg:left-64 h-16 bg-white/90 dark:bg-zinc-950/90 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800/80 flex items-center justify-between px-4 sm:px-8 z-30 transition-all duration-300">
    
    <!-- Mobile Brand / Desktop Title -->
    <div class="flex items-center gap-3">
        <a href="{{ route('dashboard') }}" class="lg:hidden flex items-center gap-2 group">
            <img src="{{ asset('images/logo_rz_teks.png') }}" alt="RZ Digital Creative Logo" class="h-7 w-auto object-contain brightness-0 dark:brightness-100">
            <span class="text-xs font-black text-zinc-900 dark:text-white tracking-tight">RZ PORTAL</span>
        </a>
        <div class="hidden lg:flex items-center gap-3">
            <span class="text-xs font-bold text-zinc-800 dark:text-zinc-200">
                RZ Digital Creative Portal
            </span>
            <span class="h-4 w-px bg-zinc-200 dark:bg-zinc-800"></span>
            <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/60 dark:border-emerald-800/40 text-[10px] font-mono font-semibold text-emerald-700 dark:text-emerald-400">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Client Support Active</span>
            </div>
        </div>
    </div>

    <!-- Right Action Items -->
    <div class="flex items-center gap-2 sm:gap-3">
        @can('tickets.create')
            <a href="{{ route('tickets.create') }}" 
               class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-xs active:scale-95">
                <span class="material-symbols-outlined text-[16px]">add_circle</span>
                <span>Buat Tiket</span>
            </a>
        @endcan
        
        <!-- Theme Toggle Button -->
        <button @click="toggleTheme()" 
                type="button"
                class="p-2 rounded-xl text-zinc-500 dark:text-zinc-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 transition-colors focus:outline-none"
                title="Ganti Tema">
            <span class="material-symbols-outlined text-[22px] block" x-show="!darkMode">light_mode</span>
            <span class="material-symbols-outlined text-[22px] block" x-show="darkMode" style="display: none;">dark_mode</span>
        </button>

        <!-- Notifications Dropdown -->
        <x-dropdown align="right" width="80" contentClasses="py-0 overflow-hidden bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl">
            <x-slot name="trigger">
                <button type="button" class="relative p-2 rounded-xl text-zinc-500 dark:text-zinc-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-zinc-100 dark:hover:bg-zinc-800/50 transition-colors focus:outline-none">
                    <span class="material-symbols-outlined text-[22px]">notifications</span>
                    @php
                        $unreadCount = method_exists(Auth::user(), 'unreadNotifications') ? Auth::user()->unreadNotifications->count() : 0;
                    @endphp
                    @if($unreadCount > 0)
                        <span id="notification-badge" class="absolute top-1.5 right-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-[9px] font-black leading-none text-white bg-rose-500 rounded-full border border-white dark:border-zinc-900 shadow-sm">
                            {{ $unreadCount }}
                        </span>
                    @else
                        <span id="notification-badge" class="hidden absolute top-1.5 right-1.5 inline-flex items-center justify-center px-1.5 py-0.5 text-[9px] font-black leading-none text-white bg-rose-500 rounded-full border border-white dark:border-zinc-900 shadow-sm">0</span>
                    @endif
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="px-4 py-3 bg-zinc-50/50 dark:bg-zinc-950/50 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                    <span class="text-xs font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-wider">Pusat Notifikasi</span>
                    <span id="notification-count-label" class="text-[10px] font-mono bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 px-2 py-0.5 rounded-md font-bold">{{ $unreadCount }} Baru</span>
                </div>

                <div id="notification-list" class="max-h-80 overflow-y-auto custom-scrollbar divide-y divide-zinc-100 dark:divide-zinc-800/40 bg-white dark:bg-zinc-900">
                    @if(method_exists(Auth::user(), 'unreadNotifications') && $unreadCount > 0)
                        @foreach(Auth::user()->unreadNotifications->take(5) as $notification)
                            <div data-notification-item class="px-4 py-3.5 hover:bg-zinc-50 dark:hover:bg-zinc-950/30 transition-colors duration-150 text-sm group">
                                @if(!empty($notification->data['url']))
                                    <a href="{{ $notification->data['url'] }}" class="block">
                                @endif
                                <div class="font-semibold text-zinc-800 dark:text-zinc-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
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
                                    <button type="button" @click.stop onclick="markAsRead('{{ $notification->id }}', this)" class="text-emerald-600 dark:text-emerald-400 hover:underline font-bold">Tandai Dibaca</button>
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

        <!-- User Profile Dropdown -->
        <x-dropdown align="right" width="56" contentClasses="py-0 overflow-hidden bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl">
            <x-slot name="trigger">
                <button type="button" class="flex items-center gap-2.5 pl-3 sm:pl-4 border-l border-zinc-200 dark:border-zinc-800/80 focus:outline-none group">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-semibold text-zinc-800 dark:text-zinc-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ Auth::user()->name }}</div>
                        <div class="text-[9px] font-mono text-zinc-400 dark:text-zinc-500 mt-0.5">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="relative">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
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
                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2.5 px-3 py-2 text-xs text-zinc-600 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white rounded-lg transition-colors">
                        <span class="material-symbols-outlined text-[18px] text-zinc-400 dark:text-zinc-500">manage_accounts</span>
                        <span>{{ __('Pengaturan Profil') }}</span>
                    </x-dropdown-link>
                </div>

                <div class="p-1.5 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800/50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();" 
                                        class="flex items-center gap-2.5 px-3 py-2 text-xs text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/20 rounded-lg transition-colors font-bold">
                            <span class="material-symbols-outlined text-[18px]">logout</span>
                            <span>{{ __('Keluar Aplikasi') }}</span>
                        </x-dropdown-link>
                    </form>
                </div>
            </x-slot>
        </x-dropdown>
    </div>
</header>

<!-- ========================================================================= -->
<!-- 3. MOBILE BOTTOM NAVIGATION & DRAWER -->
<!-- ========================================================================= -->
<div x-data="{ mobileMenuOpen: false }">
    
    <!-- Fixed Bottom Navigation Bar -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 dark:bg-zinc-950/95 backdrop-blur-lg border-t border-zinc-200 dark:border-zinc-800 h-16 flex items-center justify-around px-2 shadow-lg select-none">
        
        <!-- 1. Dashboard -->
        @php $isDashboardMobile = request()->routeIs('dashboard'); @endphp
        <a href="{{ route('dashboard') }}" 
           class="flex flex-col items-center justify-center flex-1 h-full py-1 transition-colors {{ $isDashboardMobile ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 font-medium' }}">
            <span class="material-symbols-outlined text-[22px] {{ $isDashboardMobile ? 'scale-110 font-bold' : '' }} transition-transform">dashboard</span>
            <span class="text-[10px] mt-0.5 tracking-tight">Dashboard</span>
        </a>

        <!-- 2. Tiket (Klien/Admin/Teknisi) -->
        @can('tickets.create')
            @php $isTicketsMobile = request()->routeIs('tickets.*'); @endphp
            <a href="{{ route('tickets.index') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full py-1 transition-colors {{ $isTicketsMobile ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 font-medium' }}">
                <span class="material-symbols-outlined text-[22px] {{ $isTicketsMobile ? 'scale-110 font-bold' : '' }} transition-transform">confirmation_number</span>
                <span class="text-[10px] mt-0.5 tracking-tight">Tiket Saya</span>
            </a>
        @elsecan('tickets.manage')
            @php $isAdminTicketsMobile = request()->routeIs('admin.tickets*'); @endphp
            <a href="{{ route('admin.tickets') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full py-1 transition-colors {{ $isAdminTicketsMobile ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 font-medium' }}">
                <span class="material-symbols-outlined text-[22px] {{ $isAdminTicketsMobile ? 'scale-110 font-bold' : '' }} transition-transform">support_agent</span>
                <span class="text-[10px] mt-0.5 tracking-tight">Tiket Masuk</span>
            </a>
        @elsecan('tickets.handle')
            @php $isTechTicketsMobile = request()->routeIs('technician.tickets*'); @endphp
            <a href="{{ route('technician.tickets') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full py-1 transition-colors {{ $isTechTicketsMobile ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 font-medium' }}">
                <span class="material-symbols-outlined text-[22px] {{ $isTechTicketsMobile ? 'scale-110 font-bold' : '' }} transition-transform">support_agent</span>
                <span class="text-[10px] mt-0.5 tracking-tight">Tiket Masuk</span>
            </a>
        @else
            @php $isTicketsMobile = request()->routeIs('tickets.*'); @endphp
            <a href="{{ route('tickets.index') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full py-1 transition-colors {{ $isTicketsMobile ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 font-medium' }}">
                <span class="material-symbols-outlined text-[22px] {{ $isTicketsMobile ? 'scale-110 font-bold' : '' }} transition-transform">confirmation_number</span>
                <span class="text-[10px] mt-0.5 tracking-tight">Tiket</span>
            </a>
        @endcan

        <!-- 3. Projects -->
        @php $isProjectsMobile = request()->routeIs('projects.*'); @endphp
        <a href="{{ route('projects.index') }}" 
           class="flex flex-col items-center justify-center flex-1 h-full py-1 transition-colors {{ $isProjectsMobile ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 font-medium' }}">
            <span class="material-symbols-outlined text-[22px] {{ $isProjectsMobile ? 'scale-110 font-bold' : '' }} transition-transform">view_kanban</span>
            <span class="text-[10px] mt-0.5 tracking-tight">Proyek</span>
        </a>

        <!-- 4. Menu / Lainnya (Paling Kanan) -->
        @php 
            $isOtherActive = request()->routeIs('admin.users.*', 'admin.roles.*', 'profile.*'); 
        @endphp
        <button type="button" @click="mobileMenuOpen = true" 
                class="flex flex-col items-center justify-center flex-1 h-full py-1 transition-colors {{ $isOtherActive ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-zinc-200 font-medium' }}">
            <span class="material-symbols-outlined text-[22px]">grid_view</span>
            <span class="text-[10px] mt-0.5 tracking-tight">Menu</span>
        </button>
    </nav>

    <!-- Slide-Up Sheet Modal -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex flex-col justify-end"
         style="display: none;">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-zinc-950/60 backdrop-blur-sm transition-opacity"
             x-show="mobileMenuOpen"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"></div>

        <!-- Slide-Up Sheet Container -->
        <div class="relative bg-white dark:bg-zinc-900 rounded-t-2xl p-5 border-t border-zinc-200 dark:border-zinc-800 shadow-2xl space-y-4 max-h-[85vh] overflow-y-auto z-10"
             x-show="mobileMenuOpen"
             x-transition:enter="ease-out duration-250 transform"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="ease-in duration-200 transform"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full">
            
            <!-- Drawer Header Handle -->
            <div class="flex items-center justify-between pb-3 border-b border-zinc-100 dark:border-zinc-800">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-[22px]">apps</span>
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-white">Menu Lainnya</h3>
                </div>
                <button type="button" @click="mobileMenuOpen = false" class="p-1 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 rounded-lg">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <!-- Grid Menu Items -->
            <div class="grid grid-cols-2 gap-2.5">
                @can('tickets.create')
                    <!-- Buat Tiket Baru -->
                    <a href="{{ route('tickets.create') }}" 
                       class="flex items-center gap-2.5 p-3 rounded-xl border border-zinc-200/80 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950/50 hover:border-emerald-500 transition-colors {{ request()->routeIs('tickets.create') ? 'ring-1 ring-emerald-500 font-bold' : '' }}">
                        <span class="material-symbols-outlined text-emerald-600 text-[20px]">add_circle</span>
                        <span class="text-xs text-zinc-800 dark:text-zinc-200">Buat Tiket</span>
                    </a>
                @endcan

                @can('users.manage')
                    <!-- Kelola Pengguna -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center gap-2.5 p-3 rounded-xl border border-zinc-200/80 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950/50 hover:border-emerald-500 transition-colors {{ request()->routeIs('admin.users.*') ? 'ring-1 ring-emerald-500 font-bold' : '' }}">
                        <span class="material-symbols-outlined text-emerald-500 text-[20px]">group</span>
                        <span class="text-xs text-zinc-800 dark:text-zinc-200">Pengguna</span>
                    </a>
                @endcan

                @can('roles.manage')
                    <!-- Role & Akses -->
                    <a href="{{ route('admin.roles.index') }}" 
                       class="flex items-center gap-2.5 p-3 rounded-xl border border-zinc-200/80 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-950/50 hover:border-emerald-500 transition-colors {{ request()->routeIs('admin.roles.*') ? 'ring-1 ring-emerald-500 font-bold' : '' }}">
                        <span class="material-symbols-outlined text-purple-500 text-[20px]">admin_panel_settings</span>
                        <span class="text-xs text-zinc-800 dark:text-zinc-200">Role &amp; Akses</span>
                    </a>
                @endcan
            </div>

            <!-- Profile & Logout Section -->
            <div class="pt-3 border-t border-zinc-100 dark:border-zinc-800 space-y-2">
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-950/60 text-xs text-zinc-700 dark:text-zinc-300">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">account_circle</span>
                        <span>Profil Saya ({{ Auth::user()->name }})</span>
                    </div>
                    <span class="material-symbols-outlined text-[16px] text-zinc-400">arrow_forward</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 p-2.5 rounded-xl bg-rose-50 dark:bg-rose-950/30 text-xs font-bold text-rose-600 dark:text-rose-400">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
