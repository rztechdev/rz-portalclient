<x-app-layout>

            @can('create', App\Models\Project::class)
            <a href="{{ route('projects.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Proyek
            </a>
            @endcan


    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                @php
                    $statuses = ['pending' => ['label'=>'Pending','color'=>'yellow'], 'active' => ['label'=>'Aktif','color'=>'blue'], 'completed' => ['label'=>'Selesai','color'=>'green'], 'archived' => ['label'=>'Arsip','color'=>'gray']];
                @endphp
                @foreach($statuses as $key => $s)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-{{ $s['color'] }}-100 dark:bg-{{ $s['color'] }}-900 flex items-center justify-center">
                        <span class="text-{{ $s['color'] }}-600 dark:text-{{ $s['color'] }}-300 font-bold text-sm">
                            {{ $projects->where('status', $key)->count() }}
                        </span>
                    </div>
                    <span class="text-gray-600 dark:text-gray-400 text-sm font-medium">{{ $s['label'] }}</span>
                </div>
                @endforeach
            </div>

            {{-- Project Grid --}}
            @if($projects->isEmpty())
                <div class="text-center py-20 text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto w-16 h-16 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/></svg>
                    <p class="text-lg font-medium">Belum ada proyek</p>
                    <p class="text-sm mt-1">Mulai dengan membuat proyek baru</p>
                </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                @php
                    $total = $project->tasks->count();
                    $done  = $project->tasks->where('status','done')->count();
                    $pct   = $total > 0 ? round($done / $total * 100) : 0;
                    $statusColors = ['pending'=>'yellow','active'=>'blue','completed'=>'green','archived'=>'gray'];
                    $color = $statusColors[$project->status] ?? 'gray';
                @endphp
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col overflow-hidden group">
                    <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500 group-hover:from-purple-500 group-hover:to-indigo-500 transition-all duration-500"></div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-bold text-gray-900 dark:text-white text-lg leading-tight">{{ $project->name }}</h3>
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-200 shrink-0">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ $project->description ?? 'Tidak ada deskripsi.' }}</p>

                        {{-- Progress --}}
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                <span>Progress</span>
                                <span>{{ $done }}/{{ $total }} tugas ({{ $pct }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>

                        <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1 mb-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Client: {{ $project->client->name }}
                            </div>
                            @if($project->ticket)
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                Tiket: #{{ str_pad($project->ticket->id, 5, '0', STR_PAD_LEFT) }}
                            </div>
                            @endif
                            @if($project->end_date)
                            <div class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Deadline: {{ \Carbon\Carbon::parse($project->end_date)->format('d M Y') }}
                            </div>
                            @endif
                        </div>

                        <div class="mt-auto flex gap-2">
                            <a href="{{ route('projects.show', $project) }}"
                               class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold py-2 px-4 rounded-lg transition">
                                Lihat Detail
                            </a>
                            @can('update', $project)
                            <a href="{{ route('projects.edit', $project) }}"
                               class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 text-sm font-medium py-2 px-3 rounded-lg transition">
                                Edit
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">{{ $projects->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
