<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h2 class="font-bold text-2xl text-zinc-800 dark:text-zinc-100 flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-emerald-500">group</span>
                        Manajemen Pengguna
                    </h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Kelola akun pengguna dan tetapkan role untuk mengatur hak aksesnya.</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 px-4 rounded-xl shadow-sm transition">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    Tambah Pengguna
                </a>
            </div>

            <x-flash />

            {{-- Search --}}
            <form method="GET" class="mb-6">
                <div class="relative max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 text-[20px]">search</span>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama atau email…"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white text-sm shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                </div>
            </form>

            {{-- Table --}}
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-950/40 text-left text-[11px] uppercase tracking-wider text-zinc-400 dark:text-zinc-500 font-semibold">
                                <th class="px-6 py-3.5">Pengguna</th>
                                <th class="px-6 py-3.5">Role</th>
                                <th class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @forelse($users as $user)
                                <tr class="hover:bg-zinc-50/70 dark:hover:bg-zinc-800/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=8B9B70&background=F6F8F3&bold=true"
                                                 alt="" class="w-9 h-9 rounded-full border border-zinc-200 dark:border-zinc-700">
                                            <div>
                                                <div class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $user->name }}</div>
                                                <div class="text-xs text-zinc-400 dark:text-zinc-500 font-mono">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @forelse($user->roles as $role)
                                            <span class="inline-block px-2.5 py-0.5 mr-1 mb-1 rounded-lg text-[11px] font-semibold
                                                {{ $role->name === 'admin' ? 'bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300' }}">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-zinc-400 italic">Tanpa role</span>
                                        @endforelse
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                               class="p-2 rounded-lg text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 transition" title="Ubah">
                                                <span class="material-symbols-outlined text-[19px] block">edit</span>
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                      onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="p-2 rounded-lg text-zinc-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition" title="Hapus">
                                                        <span class="material-symbols-outlined text-[19px] block">delete</span>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-16 text-center text-zinc-400 dark:text-zinc-500">
                                        <span class="material-symbols-outlined text-[40px] block mb-2">person_off</span>
                                        <p class="text-sm">Tidak ada pengguna yang cocok.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
