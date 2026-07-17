@extends('layouts.nutrival')
@section('title', 'Kelola Pengguna')
@section('content')

<h1 class="text-2xl font-bold mb-6">👥 Kelola Pengguna</h1>

<form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2 mb-5 max-w-md">
    <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama / email…"
           class="flex-1 rounded-xl border-stone-300 focus:ring-emerald-500 focus:border-emerald-500">
    <button class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-semibold">Cari</button>
</form>

<div class="bg-white rounded-2xl border border-stone-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-stone-50 text-left text-stone-500">
            <tr>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3 text-right">Jumlah Log</th>
                <th class="px-4 py-3">Terdaftar</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-stone-50">
            @forelse($users as $u)
                <tr class="{{ $u->is_active ? '' : 'opacity-50' }}">
                    <td class="px-4 py-3 font-medium">{{ $u->name }}</td>
                    <td class="px-4 py-3 text-stone-500">{{ $u->email }}</td>
                    <td class="px-4 py-3 text-right">{{ number_format($u->food_logs_count) }}</td>
                    <td class="px-4 py-3 text-stone-500">{{ $u->created_at->translatedFormat('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $u->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-stone-200 text-stone-500' }}">
                            {{ $u->is_active ? 'aktif' : 'nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-1.5 justify-end">
                            <form method="POST" action="{{ route('admin.users.toggle', $u) }}">
                                @csrf @method('PATCH')
                                <button class="px-2.5 py-1 rounded-lg bg-stone-100 hover:bg-stone-200 text-xs">
                                    {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Hapus user {{ $u->name }}? Semua datanya ikut terhapus.')">
                                @csrf @method('DELETE')
                                <button class="px-2.5 py-1 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-10 text-center text-stone-400">Tidak ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
