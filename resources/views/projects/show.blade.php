<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('projects.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $project->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $project->client->name }}</p>
                </div>
            </div>
            @can('update', $project)
            <a href="{{ route('projects.edit', $project) }}"
               class="inline-flex items-center gap-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-semibold py-2 px-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Proyek
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-4">
        <div class="w-full space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
            @endif

            {{-- Project Info Cards --}}
            @php
                $total = $project->tasks->count();
                $done  = $project->tasks->where('status','done')->count();
                $pct   = $total > 0 ? round($done / $total * 100) : 0;
                $statusColors = ['pending'=>'yellow','active'=>'blue','completed'=>'green','archived'=>'gray'];
                $color = $statusColors[$project->status] ?? 'gray';
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 md:col-span-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium uppercase tracking-wide">Progress Keseluruhan</p>
                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2">
                                <div class="bg-emerald-600 h-2 rounded-full transition-all duration-700" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                        <span class="text-xl font-bold text-gray-800 dark:text-white">{{ $pct }}%</span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $done }} dari {{ $total }} tugas selesai</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium uppercase tracking-wide">Status</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-semibold bg-{{ $color }}-100 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-200">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium uppercase tracking-wide">Deadline</p>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white">
                        {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d M Y') : 'Tidak ditentukan' }}
                    </p>
                    @if($project->end_date && \Carbon\Carbon::parse($project->end_date)->isPast() && $project->status !== 'completed')
                        <p class="text-xs text-red-500 mt-0.5">Melewati deadline!</p>
                    @endif
                </div>
            </div>

            {{-- Description --}}
            @if($project->description)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                <h3 class="font-semibold text-gray-700 dark:text-gray-300 text-sm mb-2">Deskripsi Proyek</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $project->description }}</p>
            </div>
            @endif

            {{-- Tasks Kanban Board --}}
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800 dark:text-white text-lg">Tugas Proyek</h3>
                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"
                       class="inline-flex items-center gap-1 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold py-2 px-4 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Tugas
                    </a>
                    @endif
                </div>

                @php
                    $columns = [
                        'todo'        => ['label' => 'To Do',       'color' => 'gray',   'icon' => 'â³'],
                        'in_progress' => ['label' => 'In Progress',  'color' => 'blue',   'icon' => 'ðŸ”„'],
                        'review'      => ['label' => 'Review',       'color' => 'yellow', 'icon' => 'ðŸ”'],
                        'done'        => ['label' => 'Done',         'color' => 'green',  'icon' => 'âœ…'],
                    ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($columns as $status => $col)
                    @php $columnTasks = $project->tasks->where('status', $status); @endphp
                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-3 min-h-[200px]">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-base">{{ $col['icon'] }}</span>
                            <span class="font-semibold text-sm text-gray-700 dark:text-gray-300">{{ $col['label'] }}</span>
                            <span class="ml-auto bg-{{ $col['color'] }}-100 dark:bg-{{ $col['color'] }}-900 text-{{ $col['color'] }}-700 dark:text-{{ $col['color'] }}-300 text-xs font-bold rounded-full px-2 py-0.5">
                                {{ $columnTasks->count() }}
                            </span>
                        </div>
                        <div class="space-y-2">
                            @forelse($columnTasks as $task)
                            @php
                                $priorityColors = ['high'=>'red','medium'=>'yellow','low'=>'green'];
                                $pc = $priorityColors[$task->priority] ?? 'gray';
                            @endphp
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-3 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition group">
                                <div class="flex items-start justify-between mb-1.5">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-white leading-tight">{{ $task->name }}</p>
                                    <span class="ml-1 shrink-0 w-2 h-2 rounded-full mt-1.5 bg-{{ $pc }}-400"></span>
                                </div>
                                @if($task->assignee)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ $task->assignee->name }}
                                </p>
                                @endif
                                @if($task->due_date)
                                <p class="text-xs {{ \Carbon\Carbon::parse($task->due_date)->isPast() && $task->status !== 'done' ? 'text-red-500' : 'text-gray-400 dark:text-gray-500' }} flex items-center gap-1 mb-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                </p>
                                @endif
                                
                                @if(auth()->user()->hasRole('technician') && $task->assignee_id === auth()->id())
                                <div class="mt-2 pt-2 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between gap-1.5">
                                    <form action="{{ route('tasks.progress', $task) }}" method="POST" class="flex items-center gap-1">
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-[11px] bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded px-1.5 py-0.5 text-gray-700 dark:text-gray-200">
                                            @foreach(['todo' => 'To Do', 'in_progress' => 'In Progress', 'review' => 'Review', 'done' => 'Done'] as $st => $lbl)
                                                <option value="{{ $st }}" {{ $task->status === $st ? 'selected' : '' }}>{{ $lbl }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                    <a href="{{ route('tasks.show', $task) }}" class="text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium">Detail</a>
                                </div>
                                @elseif(auth()->user()->hasRole('admin'))
                                <div class="flex gap-1 mt-2 opacity-0 group-hover:opacity-100 transition">
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-xs text-emerald-600 hover:text-emerald-800 font-medium">Edit</a>
                                    <span class="text-gray-300 dark:text-gray-600">Â·</span>
                                    <a href="{{ route('tasks.show', $task) }}" class="text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium">Detail</a>
                                    <span class="text-gray-300 dark:text-gray-600">Â·</span>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tugas ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                    </form>
                                </div>
                                @else
                                <div class="flex gap-1 mt-2 opacity-0 group-hover:opacity-100 transition">
                                    <a href="{{ route('tasks.show', $task) }}" class="text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium">Detail</a>
                                </div>
                                @endif
                            </div>
                            @empty
                            <p class="text-xs text-gray-400 dark:text-gray-600 text-center py-4">Tidak ada tugas</p>
                            @endforelse
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Documents Section --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
                <h3 class="font-bold text-gray-800 dark:text-white text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Dokumen Proyek
                </h3>

                {{-- Upload Form --}}
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="mb-6 p-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl hover:border-emerald-400 transition-colors">
                    @csrf
                    <input type="hidden" name="documentable_type" value="project">
                    <input type="hidden" name="documentable_id" value="{{ $project->id }}">
                    <div class="flex items-center gap-4">
                        <label class="flex-1 flex items-center gap-3 cursor-pointer">
                            <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">Upload Dokumen</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOC, XLS, PNG, JPG â€” Maks. 20MB</p>
                            </div>
                            <input type="file" name="file" id="file" class="hidden" required onchange="document.getElementById('file-name').textContent = this.files[0].name">
                        </label>
                        <p id="file-name" class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs"></p>
                        <button type="submit" class="shrink-0 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold py-2 px-5 rounded-lg transition">Upload</button>
                    </div>
                </form>

                {{-- Document List --}}
                @if($project->documents->isEmpty())
                    <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-4">Belum ada dokumen diupload.</p>
                @else
                <div class="space-y-2">
                    @foreach($project->documents as $doc)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/40 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/40 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $doc->file_name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Diupload oleh {{ $doc->uploader->name }} Â· {{ $doc->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('documents.download', $doc) }}"
                               class="text-sm text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Download
                            </a>
                            @if(auth()->user()->hasRole('admin') || $doc->uploaded_by === auth()->id())
                            <form action="{{ route('documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

