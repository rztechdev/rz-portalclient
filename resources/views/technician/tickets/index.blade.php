<x-app-layout>
    <div class="py-12 bg-gray-50/50 dark:bg-gray-900/50 min-h-[calc(100vh-65px)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Alerts -->
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

            @if(session('error'))
                <div class="p-4 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-900/50 text-rose-800 dark:text-rose-300 rounded-2xl flex items-start gap-3 shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 mt-0.5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <span class="font-semibold text-sm">Perhatian!</span>
                        <p class="text-xs mt-0.5">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Total System Tickets -->
                <div class="relative overflow-hidden bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Semua Tiket Masuk</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">
                                {{ \App\Models\Ticket::count() }}
                            </h3>
                        </div>
                        <div class="p-3 bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                </div>

                <!-- Unassigned Tickets -->
                <div class="relative overflow-hidden bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Belum Ditugaskan</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">
                                {{ \App\Models\Ticket::whereNull('technician_id')->whereDoesntHave('project')->count() }}
                            </h3>
                        </div>
                        <div class="p-3 bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 rounded-2xl">
                            <div class="relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                @if(\App\Models\Ticket::whereNull('technician_id')->whereDoesntHave('project')->count() > 0)
                                    <span class="absolute top-0 right-0 block h-2.5 w-2.5 rounded-full bg-rose-500 ring-2 ring-white dark:ring-gray-800 animate-ping"></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-red-500"></div>
                </div>

                <!-- Assigned to Me -->
                <div class="relative overflow-hidden bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Ditugaskan ke Saya</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">
                                {{ \App\Models\Ticket::whereIn('status', ['open', 'pending'])->where(function ($q) {
                                    $uid = Auth::id();
                                    $q->where('technician_id', $uid)
                                        ->orWhereHas('project', fn ($p) => $p->where('manager_id', $uid))
                                        ->orWhereHas('project.tasks', fn ($t) => $t->where('assignee_id', $uid));
                                })->count() }}
                            </h3>
                        </div>
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                </div>
            </div>

            <!-- Navigation Tabs & List Table Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm overflow-hidden">
                
                <!-- Custom Tabs Navigation -->
                <div class="px-6 pt-5 border-b border-gray-100 dark:border-gray-700/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex border-b border-gray-100 dark:border-gray-700/30 w-full sm:w-auto">
                        <a href="{{ route('technician.tickets', ['tab' => 'semua']) }}" 
                            class="px-4 py-3 text-sm font-semibold border-b-2 transition-all {{ $tab == 'semua' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' }}">
                            Semua Tiket
                        </a>
                        <a href="{{ route('technician.tickets', ['tab' => 'belum_ditugaskan']) }}" 
                            class="px-4 py-3 text-sm font-semibold border-b-2 transition-all flex items-center gap-1.5 {{ $tab == 'belum_ditugaskan' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' }}">
                            Belum Ditugaskan
                            <span class="px-1.5 py-0.5 rounded-full text-xxs font-bold bg-rose-100 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400">
                                {{ \App\Models\Ticket::whereNull('technician_id')->whereDoesntHave('project')->count() }}
                            </span>
                        </a>
                        <a href="{{ route('technician.tickets', ['tab' => 'ditugaskan_ke_saya']) }}" 
                            class="px-4 py-3 text-sm font-semibold border-b-2 transition-all {{ $tab == 'ditugaskan_ke_saya' ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' }}">
                            Ditugaskan ke Saya
                        </a>
                    </div>
                    <div class="pb-3 sm:pb-0 text-xs text-gray-400 dark:text-gray-500 font-medium">
                        Menampilkan {{ $tickets->count() }} tiket
                    </div>
                </div>

                @if($tickets->isEmpty())
                    <!-- Empty State -->
                    <div class="py-16 px-6 text-center">
                        <div class="inline-flex p-4 bg-gray-50 dark:bg-gray-900 text-gray-400 dark:text-gray-500 rounded-full mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <h5 class="text-base font-semibold text-gray-700 dark:text-gray-300">Tidak ada tiket ditemukan</h5>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1 max-w-sm mx-auto">
                            @if($tab == 'belum_ditugaskan')
                                Selamat! Semua tiket kendala klien sudah berhasil diklaim atau ditugaskan.
                            @elseif($tab == 'ditugaskan_ke_saya')
                                Bagus! Tidak ada pekerjaan tersisa yang ditugaskan kepada Anda saat ini.
                            @else
                                Belum ada tiket terdaftar di dalam sistem saat ini.
                            @endif
                        </p>
                    </div>
                @else
                    <!-- Table List -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 dark:bg-gray-900/30 text-gray-400 dark:text-gray-500 font-semibold text-xs uppercase tracking-wider border-b border-gray-100 dark:border-gray-700/50">
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Klien</th>
                                    <th class="px-6 py-4">Keluhan / Masalah</th>
                                    <th class="px-6 py-4 text-center">Prioritas</th>
                                    <th class="px-6 py-4 text-center">SLA Respons</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4">Aksi / Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50 text-sm text-gray-600 dark:text-gray-300">
                                @foreach($tickets as $ticket)
                                    <tr class="hover:bg-gray-50/40 dark:hover:bg-gray-900/20 transition-colors">
                                        <!-- ID -->
                                        <td class="px-6 py-4 font-mono font-semibold text-gray-400 dark:text-gray-500">
                                            #{{ str_pad($ticket->id, 5, '0', STR_PAD_LEFT) }}
                                        </td>
                                        
                                        <!-- Client -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2.5">
                                                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-950/50 flex items-center justify-center text-xs font-bold text-blue-600 dark:text-blue-400 uppercase">
                                                    {{ substr($ticket->client->name, 0, 2) }}
                                                </div>
                                                <div>
                                                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $ticket->client->name }}</span>
                                                    <p class="text-xxs text-gray-400 dark:text-gray-500">{{ $ticket->client->email }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Issue Description -->
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $ticket->title }}</div>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 line-clamp-1 max-w-sm">{{ $ticket->description }}</p>
                                        </td>

                                        <!-- Priority Badge -->
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

                                        <!-- SLA Response -->
                                        <td class="px-6 py-4 text-center">
                                            @if($ticket->first_response_at)
                                                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                                    OK ({{ $ticket->first_response_at->format('H:i') }})
                                                </span>
                                            @else
                                                @php
                                                    $respBreached = $ticket->isResponseSlaBreached();
                                                    $respColor = $respBreached ? 'text-rose-500 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400';
                                                @endphp
                                                <span class="text-xs font-bold {{ $respColor }}">
                                                    {{ $ticket->sla_response_due_at ? $ticket->sla_response_due_at->diffForHumans() : '-' }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status Badge -->
                                        <td class="px-6 py-4 text-center">
                                            @if($ticket->status == 'open')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/30">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                    Open
                                                </span>
                                            @elseif($ticket->status == 'pending')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                    Pending
                                                </span>
                                            @elseif($ticket->status == 'resolved')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Resolved
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                                    Closed
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4">
                                            @if($ticket->project)
                                                <a href="{{ route('projects.show', $ticket->project) }}" 
                                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-950/30 dark:hover:bg-indigo-900/50 dark:text-indigo-400 font-semibold text-xs rounded-xl shadow-sm transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                    Lihat Proyek
                                                </a>
                                            @else
                                                <span class="text-xs text-gray-400 dark:text-gray-500">Belum ada proyek</span>
                                            @endif
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
