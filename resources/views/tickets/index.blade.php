<x-app-layout>

            <div>
                <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium text-sm rounded-xl shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Tiket Baru
                </a>
            <div>


    <div class="py-12 bg-gray-50/50 dark:bg-gray-900/50 min-h-[calc(100vh-65px)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Alert Success -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-900/50 text-emerald-800 dark:text-emerald-300 rounded-2xl flex items-start gap-3 shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 mt-0.5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <span class="font-semibold text-sm">Berhasil!</span>
                        <p class="text-xs mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Total Tickets -->
                <div class="relative overflow-hidden bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Total Tiket Anda</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">{{ $tickets->count() }}</h3>
                        </div>
                        <div class="p-3 bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                </div>

                <!-- Active Tickets -->
                <div class="relative overflow-hidden bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Tiket Aktif</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">
                                {{ $tickets->whereIn('status', ['open', 'pending'])->count() }}
                            </h3>
                        </div>
                        <div class="p-3 bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 rounded-2xl">
                            <div class="relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @if($tickets->whereIn('status', ['open', 'pending'])->count() > 0)
                                    <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-amber-500 ring-2 ring-white dark:ring-gray-800 animate-pulse"></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500"></div>
                </div>

                <!-- Resolved Tickets -->
                <div class="relative overflow-hidden bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Tiket Selesai</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">
                                {{ $tickets->whereIn('status', ['resolved', 'closed'])->count() }}
                            </h3>
                        </div>
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                </div>
            </div>

            <!-- Tickets Table Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700/50 flex justify-between items-center">
                    <h4 class="font-bold text-gray-800 dark:text-gray-100 text-lg">Daftar Riwayat Tiket</h4>
                    <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Ter-update otomatis</span>
                </div>

                @if($tickets->isEmpty())
                    <!-- Empty State -->
                    <div class="py-16 px-6 text-center">
                        <div class="inline-flex p-4 bg-gray-50 dark:bg-gray-900 text-gray-400 dark:text-gray-500 rounded-full mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v3a2 2 0 01-2 2H4a2 2 0 01-2-2v-3a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <h5 class="text-base font-semibold text-gray-700 dark:text-gray-300">Belum ada tiket terdaftar</h5>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1 max-w-sm mx-auto">Jika Anda mengalami kendala teknis atau membutuhkan bantuan, silakan kirimkan tiket baru menggunakan tombol di atas.</p>
                    </div>
                @else
                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 dark:bg-gray-900/30 text-gray-400 dark:text-gray-500 font-semibold text-xs uppercase tracking-wider border-b border-gray-100 dark:border-gray-700/50">
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Keluhan / Permintaan</th>
                                    <th class="px-6 py-4 text-center">Prioritas</th>
                                    <th class="px-6 py-4 text-center">Deadline SLA</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4">Penanganan</th>
                                    <th class="px-6 py-4">Proyek</th>
                                    <th class="px-6 py-4 text-right">Tanggal Buat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50 text-sm text-gray-600 dark:text-gray-300">
                                @foreach($tickets as $ticket)
                                    <tr class="hover:bg-gray-50/40 dark:hover:bg-gray-900/20 transition-colors">
                                        <td class="px-6 py-4 font-mono font-semibold text-gray-400 dark:text-gray-500">
                                            #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $ticket->title }}</div>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 line-clamp-1 max-w-md">{{ $ticket->description }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($ticket->priority == 'high')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/50">
                                                    High
                                                </span>
                                            @elseif($ticket->priority == 'medium')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/50">
                                                    Medium
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/50">
                                                    Low
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- SLA Deadline -->
                                        <td class="px-6 py-4 text-center">
                                            @if($ticket->status == 'resolved' || $ticket->status == 'closed')
                                                <span class="text-xs text-gray-400 dark:text-gray-500">Selesai: {{ $ticket->resolved_at ? $ticket->resolved_at->format('d/m/y H:i') : '-' }}</span>
                                            @else
                                                @php
                                                    $slaStatus = $ticket->slaStatus();
                                                    $color = $slaStatus == 'breached' ? 'text-rose-500 dark:text-rose-400' : ($slaStatus == 'warning' ? 'text-amber-500 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400');
                                                @endphp
                                                <span class="text-xs font-bold {{ $color }}">
                                                    {{ $ticket->sla_resolution_due_at ? $ticket->sla_resolution_due_at->diffForHumans() : '-' }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $statusColors = [
                                                    'open' => 'bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 border-blue-100 dark:border-blue-900/30',
                                                    'pending' => 'bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 border-amber-100 dark:border-amber-900/30',
                                                    'resolved' => 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/30',
                                                    'closed' => 'bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 border-gray-200 dark:border-gray-700',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold border {{ $statusColors[$ticket->status] ?? $statusColors['closed'] }}">
                                                @if(in_array($ticket->status, ['open', 'pending']))
                                                    <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                                @endif
                                                {{ $ticket->statusLabel() }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php $pic = $ticket->displayTechnician(); @endphp
                                            @if($pic)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-950/50 flex items-center justify-center text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase">
                                                        {{ substr($pic->name, 0, 2) }}
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-gray-800 dark:text-gray-200 block">{{ $pic->name }}</span>
                                                        <span class="text-xxs text-gray-400">PIC / Teknisi</span>
                                                    </div>
                                                </div>
                                            @elseif($ticket->project)
                                                <span class="text-xs text-amber-600 dark:text-amber-400">Proyek dibuat, PIC belum ditetapkan</span>
                                            @else
                                                <span class="text-xs text-gray-400 dark:text-gray-500 italic">Menunggu admin meninjau tiket</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($ticket->project)
                                                <a href="{{ route('projects.show', $ticket->project) }}" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                                    {{ $ticket->project->name }}
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400 italic">—</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-gray-400 dark:text-gray-500 text-xs">
                                            {{ $ticket->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
