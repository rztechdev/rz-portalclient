<x-app-layout>
    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h2 class="font-bold text-2xl text-zinc-800 dark:text-zinc-100 flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-emerald-500">admin_panel_settings</span>
                        Role &amp; Hak Akses
                    </h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Tentukan sekelompok izin, lalu tetapkan ke pengguna. Ubah izin di sini untuk mengatur akses seluruh sistem.</p>
                </div>
                <a href="{{ route('admin.roles.create') }}"
                   class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm py-2.5 px-4 rounded-xl shadow-sm transition">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Tambah Role
                </a>
            </div>

            <x-flash />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($roles as $role)
                    @php $isCore = in_array($role->name, $protectedRoles, true); @endphp
                    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-100 dark:border-zinc-800 shadow-sm p-5 flex flex-col">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $role->name === 'admin' ? 'bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400' }}">
                                    <span class="material-symbols-outlined text-[22px]">{{ $role->name === 'admin' ? 'shield_person' : 'badge' }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-bold text-zinc-800 dark:text-zinc-100 capitalize">{{ str_replace('_', ' ', $role->name) }}</h3>
                                        @if($isCore)
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400">Inti</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-0.5">
                                        {{ $role->name === 'admin' ? 'Seluruh izin' : $role->permissions_count . ' izin' }} · {{ $role->users_count }} pengguna
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.roles.edit', $role) }}"
                                   class="p-2 rounded-lg text-zinc-400 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 transition" title="Ubah">
                                    <span class="material-symbols-outlined text-[19px] block">edit</span>
                                </a>
                                @unless($isCore)
                                    <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                                          onsubmit="return confirm('Hapus role {{ $role->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-zinc-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition" title="Hapus">
                                            <span class="material-symbols-outlined text-[19px] block">delete</span>
                                        </button>
                                    </form>
                                @endunless
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
