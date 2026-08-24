<x-app-layout>
    <div class="py-12 bg-gray-50/50 dark:bg-gray-900/50 min-h-[calc(100vh-65px)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Title Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200">Manajemen Tiket & Proyek</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kelola tiket keluhan dari klien dan konversi menjadi proyek pengerjaan.</p>
                </div>
            </div>

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
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Belum Ada Proyek</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">
                                {{ \App\Models\Ticket::doesntHave('project')->count() }}
                            </h3>
                        </div>
                        <div class="p-3 bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-red-500"></div>
                </div>

                <!-- Active Projects -->
                <div class="relative overflow-hidden bg-white dark:bg-gray-800 p-6 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Proyek Berjalan</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 mt-2">
                                {{ \App\Models\Project::where('status', 'active')->count() }}
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

            <!-- List Table Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/50 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700/50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-gray-200">Daftar Semua Tiket Klien</h3>
                    <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Total: {{ $tickets->total() }} tiket</span>
                </div>

                @if($tickets->isEmpty())
                    <div class="py-16 px-6 text-center">
                        <div class="inline-flex p-4 bg-gray-50 dark:bg-gray-900 text-gray-400 dark:text-gray-500 rounded-full mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <h5 class="text-base font-semibold text-gray-700 dark:text-gray-300">Belum ada tiket masuk</h5>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 dark:bg-gray-900/30 text-gray-400 dark:text-gray-500 font-semibold text-xs uppercase tracking-wider border-b border-gray-100 dark:border-gray-700/50">
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Klien</th>
                                    <th class="px-6 py-4">Keluhan</th>
                                    <th class="px-6 py-4 text-center">Prioritas</th>
                                    <th class="px-6 py-4 text-center">SLA Respons</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-center">Hubungan Proyek</th>
                                    <th class="px-6 py-4">Aksi</th>
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

                                        <!-- Keluhan -->
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $ticket->title }}</div>
                                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1 line-clamp-1 max-w-sm">{{ $ticket->description }}</p>
                                        </td>

                                        <!-- Prioritas -->
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

                                        <!-- SLA Respons -->
                                        <td class="px-6 py-4 text-center">
                                            @if($ticket->first_response_at)
                                                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                                    Direspons
                                                </span>
                                            @else
                                                @php
                                                    $respBreached = $ticket->isResponseSlaBreached();
                                                    $respColor = $respBreached ? 'text-rose-500 dark:text-rose-400 font-bold' : 'text-gray-500 dark:text-gray-400';
                                                @endphp
                                                <span class="text-xs {{ $respColor }}">
                                                    {{ $ticket->sla_response_due_at ? $ticket->sla_response_due_at->diffForHumans() : '-' }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4 text-center">
                                            @if($ticket->status == 'open')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-900/30">
                                                    Open
                                                </span>
                                            @elseif($ticket->status == 'pending')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30">
                                                    Pending
                                                </span>
                                            @elseif($ticket->status == 'resolved')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30">
                                                    Resolved
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                                    Closed
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Hubungan Proyek -->
                                        <td class="px-6 py-4 text-center">
                                            @if($ticket->project)
                                                <span class="inline-flex items-center gap-1 text-xs text-emerald-600 dark:text-emerald-400 font-medium">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    Terhubung
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400 dark:text-gray-500">Belum ada proyek</span>
                                            @endif
                                        </td>

                                        <!-- Aksi -->
                                        <td class="px-6 py-4">
                                            @if(!$ticket->project)
                                                <a href="{{ route('projects.create', ['ticket_id' => $ticket->id]) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-sm hover:shadow transition-all">
                                                    Buat Proyek
                                                </a>
                                            @else
                                                <a href="{{ route('projects.show', $ticket->project) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold text-xs rounded-xl transition-all">
                                                    Detail Proyek
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700/50">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
