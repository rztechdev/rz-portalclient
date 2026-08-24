<x-app-layout>
    <div class="py-8 bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-50 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 hover:border-indigo-600/30 dark:hover:border-indigo-500/40 transition-all duration-350 shadow-sm hover:shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-zinc-500 dark:text-zinc-400 text-xs font-semibold uppercase tracking-wider">Proyek Aktif</p>
                            <h4 class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $stats['active_projects'] }}</h4>
                        </div>
                        <div class="p-2 bg-zinc-100 dark:bg-zinc-950 rounded-lg text-indigo-600 dark:text-indigo-400">
                            <span class="material-symbols-outlined">work</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs {{ $stats['projects_trend']['positive'] ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                        <span class="material-symbols-outlined text-sm mr-1">{{ $stats['projects_trend']['positive'] ? 'trending_up' : 'trending_down' }}</span>
                        {{ $stats['projects_trend']['label'] }}
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 hover:border-indigo-600/30 dark:hover:border-indigo-500/40 transition-all duration-350 shadow-sm hover:shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-zinc-500 dark:text-zinc-400 text-xs font-semibold uppercase tracking-wider">Tiket Terbuka</p>
                            <h4 class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $stats['open_tickets'] }}</h4>
                        </div>
                        <div class="p-2 bg-zinc-100 dark:bg-zinc-950 rounded-lg text-amber-500">
                            <span class="material-symbols-outlined">confirmation_number</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-rose-600 dark:text-rose-400">
                        @if($stats['sla_warning_count'] > 0)
                            <span class="material-symbols-outlined text-sm mr-1">warning</span>
                            {{ $stats['sla_warning_count'] }} tiket mendekati SLA
                        @else
                            <span class="material-symbols-outlined text-sm mr-1 text-emerald-500">check_circle</span>
                            <span class="text-emerald-600 dark:text-emerald-400">Tidak ada peringatan SLA</span>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 hover:border-indigo-600/30 dark:hover:border-indigo-500/40 transition-all duration-350 shadow-sm hover:shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-zinc-500 dark:text-zinc-400 text-xs font-semibold uppercase tracking-wider">SLA Compliance</p>
                            <h4 class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $stats['sla_compliance_percent'] }}%</h4>
                        </div>
                        <div class="p-2 bg-zinc-100 dark:bg-zinc-950 rounded-lg text-emerald-500">
                            <span class="material-symbols-outlined">verified</span>
                        </div>
                    </div>
                    <div class="mt-4 w-full bg-zinc-100 dark:bg-zinc-950 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500" style="width: {{ $stats['sla_compliance_percent'] }}%"></div>
                    </div>
                    @if($stats['sla_tracked_count'] > 0)
                        <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">{{ $stats['sla_tracked_count'] }} tiket dengan SLA aktif</p>
                    @endif
                </div>

                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 hover:border-indigo-600/30 dark:hover:border-indigo-500/40 transition-all duration-350 shadow-sm hover:shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-zinc-500 dark:text-zinc-400 text-xs font-semibold uppercase tracking-wider">Total Tiket</p>
                            <h4 class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $stats['total_tickets'] }}</h4>
                        </div>
                        <div class="p-2 bg-zinc-100 dark:bg-zinc-950 rounded-lg text-emerald-500">
                            <span class="material-symbols-outlined">inventory_2</span>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-zinc-500 dark:text-zinc-400">Semua tiket dalam ruang lingkup Anda</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <h4 class="text-zinc-800 dark:text-zinc-200 font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400">pie_chart</span> Tiket Per Status
                    </h4>
                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mb-4">Distribusi dari database</p>
                    <div class="relative h-64 flex items-center justify-center">
                        <canvas id="ticketsChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <h4 class="text-zinc-800 dark:text-zinc-200 font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400">donut_large</span> Tugas Tim
                    </h4>
                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mb-4">Status tugas proyek</p>
                    <div class="relative h-64 flex items-center justify-center">
                        <canvas id="tasksChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-1 bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <h4 class="text-zinc-800 dark:text-zinc-200 font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400">bar_chart</span> Status Proyek
                    </h4>
                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mb-4">Agregasi status proyek</p>
                    <div class="relative h-64">
                        <canvas id="projectsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <h4 class="text-zinc-800 dark:text-zinc-200 font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-amber-500">priority_high</span> Tiket Per Prioritas
                    </h4>
                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mb-4">Pie chart prioritas tiket</p>
                    <div class="relative h-72">
                        <canvas id="priorityChart"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <h4 class="text-zinc-800 dark:text-zinc-200 font-bold mb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-500">show_chart</span> Tiket Baru (6 Bulan)
                    </h4>
                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mb-4">Tren pembuatan tiket dari database</p>
                    <div class="relative h-72">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                    <h4 class="text-zinc-900 dark:text-white font-bold">Aktivitas Terkini</h4>
                    <a href="{{ route('projects.index') }}" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-semibold">Lihat Proyek</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-zinc-700 dark:text-zinc-300">
                        <thead>
                            <tr class="text-zinc-400 dark:text-zinc-500 uppercase text-[10px] tracking-widest">
                                <th class="px-6 py-4">Proyek/Tiket</th>
                                <th class="px-6 py-4">Assignee</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_activity as $row)
                                @php
                                    $statusColors = [
                                        'open' => 'bg-sky-50 dark:bg-sky-950/30 text-sky-600 dark:text-sky-400 border border-sky-100 dark:border-sky-900/30',
                                        'pending' => 'bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30',
                                        'resolved' => 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30',
                                        'closed' => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700/50',
                                        'active' => 'bg-indigo-50 dark:bg-indigo-950/30 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-900/30',
                                        'completed' => 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30',
                                        'todo' => 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700/50',
                                        'in_progress' => 'bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30',
                                        'done' => 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30',
                                    ];
                                    $badgeClass = $statusColors[$row['status']] ?? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30';
                                @endphp
                                <tr class="border-t border-zinc-200 dark:border-zinc-800/60 hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                                    <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                                        @if($row['url'])
                                            <a href="{{ $row['url'] }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ $row['title'] }}</a>
                                        @else
                                            {{ $row['title'] }}
                                        @endif
                                        <span class="ml-2 text-[10px] text-zinc-400 dark:text-zinc-500 uppercase font-mono">{{ $row['type'] }}</span>
                                    </td>
                                    <td class="px-6 py-4">{{ $row['assignee'] }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-md {{ $badgeClass }} text-[10px] font-bold uppercase tracking-wider">{{ $row['status_label'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400">{{ $row['time_ago'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-zinc-400 dark:text-zinc-500">
                                        Belum ada aktivitas. Data akan muncul setelah tiket atau proyek dibuat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script id="dashboard-data" type="application/json">
        @json($charts)
    </script>
    @endpush
</x-app-layout>
