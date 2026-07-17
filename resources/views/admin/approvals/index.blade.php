@extends('layouts.nutrival')
@section('title', 'Approval Custom Food')
@section('content')

<h1 class="text-2xl font-bold mb-2">✅ Approval Makanan Custom</h1>
<p class="text-sm text-stone-500 mb-6">Review makanan yang diajukan pengguna. Approve = masuk katalog publik. Reject = tetap bisa dipakai pemiliknya secara pribadi.</p>

{{-- Filter status --}}
<div class="flex gap-2 mb-6">
    @foreach(['pending' => '⏳ Pending', 'approved' => '✔ Disetujui', 'rejected' => '✖ Ditolak', 'all' => 'Semua'] as $s => $label)
        <a href="{{ route('admin.approvals.index', ['status' => $s]) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium {{ $status === $s ? 'bg-emerald-600 text-white' : 'bg-white border border-stone-200 hover:bg-stone-50' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="space-y-4">
    @forelse($foods as $food)
        <div class="bg-white rounded-2xl border border-stone-200 p-5">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="font-bold">{{ $food->name }}
                        <span class="text-xs font-normal px-2 py-0.5 rounded-full ml-1
                            {{ $food->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($food->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-600') }}">
                            {{ $food->status }}
                        </span>
                    </p>
                    <p class="text-xs text-stone-500 mt-0.5">
                        oleh <b>{{ $food->creator->name ?? '—' }}</b> • {{ $food->created_at->translatedFormat('d M Y H:i') }}
                        • {{ $food->category->icon }} {{ $food->category->name }} • porsi: {{ $food->servingLabel() }}
                    </p>
                    @if($food->description)<p class="text-sm text-stone-600 mt-1">{{ $food->description }}</p>@endif
                </div>
            </div>

            @if($food->status === 'pending')
                {{-- Approve dengan opsi koreksi nutrisi --}}
                <form method="POST" action="{{ route('admin.approvals.approve', $food) }}" class="mt-4 border-t border-stone-100 pt-4">
                    @csrf @method('PATCH')
                    <p class="text-xs font-semibold text-stone-500 mb-2">Nilai gizi per porsi standar (bisa dikoreksi sebelum approve):</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                        @foreach([['calories','Kalori'],['protein','Protein (g)'],['carbs','Karbo (g)'],['fat','Lemak (g)']] as [$field, $label])
                            <div>
                                <label class="text-xs text-stone-500">{{ $label }}</label>
                                <input type="number" name="{{ $field }}" step="0.1" min="0" value="{{ $food->$field }}"
                                       class="mt-0.5 w-full rounded-lg border-stone-300 text-sm">
                            </div>
                        @endforeach
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">✔ Approve & Masukkan ke Katalog</button>
                    </div>
                </form>

                {{-- Reject dengan alasan --}}
                <form method="POST" action="{{ route('admin.approvals.reject', $food) }}" class="mt-3 flex flex-wrap gap-2 items-center">
                    @csrf @method('PATCH')
                    <input type="text" name="admin_note" required placeholder="Alasan penolakan (wajib)…"
                           class="flex-1 min-w-56 rounded-xl border-stone-300 text-sm">
                    <button class="px-4 py-2 rounded-xl bg-red-50 text-red-600 text-sm font-semibold hover:bg-red-100">✖ Tolak</button>
                </form>
            @elseif($food->admin_note)
                <p class="mt-3 text-xs text-stone-500 border-t border-stone-100 pt-3">Catatan admin: {{ $food->admin_note }}</p>
            @endif
        </div>
    @empty
        <div class="bg-white rounded-2xl border border-stone-200 px-5 py-12 text-center text-stone-400">
            Tidak ada makanan dengan status ini.
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $foods->links() }}</div>
@endsection
