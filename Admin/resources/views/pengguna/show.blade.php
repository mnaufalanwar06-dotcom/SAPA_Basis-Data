<x-app-layout>
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pengguna.index') }}" class="w-9 h-9 border border-gray-200 bg-white rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-50 transition shadow-sm">←</a>
        <h2 class="text-xl font-bold text-rose-600">Profil & Riwayat Pengguna</h2>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kartu Info Pengguna -->
        <div class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm h-fit">
            <div class="flex items-center gap-4 border-b pb-4 mb-4">
                <div class="w-14 h-14 rounded-full bg-rose-500 text-white flex items-center justify-center font-bold text-lg uppercase shadow-sm">
                    {{ substr($user->name ?? 'U', 0, 2) }}
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-base">{{ $user->name }}</h3>
                    <span class="text-xs bg-rose-50 text-rose-600 font-semibold px-2 py-0.5 rounded-md">Pelapor Terdaftar</span>
                </div>
            </div>

            <div class="mb-4 flex items-center justify-between gap-3 rounded-xl border {{ $user->is_active ? 'border-emerald-200 bg-emerald-50' : 'border-amber-200 bg-amber-50' }} p-3">
                <div>
                    <p class="text-xs font-bold {{ $user->is_active ? 'text-emerald-700' : 'text-amber-700' }}">
                        {{ $user->is_active ? 'Akun Aktif' : 'Akun Nonaktif' }}
                    </p>
                    <p class="mt-1 text-[11px] text-gray-500">
                        {{ $user->is_active ? 'Pengguna dapat masuk dan mengirim laporan.' : 'Pengguna tidak dapat masuk atau mengirim laporan.' }}
                    </p>
                </div>
                <form action="{{ route('pengguna.toggle-status', $user->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="whitespace-nowrap rounded-lg px-3 py-2 text-xs font-bold {{ $user->is_active ? 'bg-amber-100 text-amber-700 hover:bg-amber-200' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}">
                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan Akun' }}
                    </button>
                </form>
            </div>

            <div class="space-y-4 text-xs">
                <div>
                    <p class="text-gray-400">Email</p>
                    <p class="font-semibold text-gray-700">{{ $user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Nomor HP / WhatsApp</p>
                    <p class="font-semibold text-gray-700">{{ $user->no_hp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Tanggal Terdaftar</p>
                    <p class="font-semibold text-gray-700">{{ optional($user->created_at)->format('d F Y, H:i') ?? '-' }}</p>
                </div>
                <div class="pt-2 border-t border-gray-100">
                    <p class="text-gray-400">Total Kasus yang Dilaporkan</p>
                    <p class="font-bold text-rose-600 text-sm mt-0.5">{{ $laporans->count() }} Laporan</p>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Laporan dari Pengguna Ini -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-rose-100 shadow-sm overflow-hidden">
            <h3 class="font-bold text-rose-600 mb-4 border-b pb-2">Riwayat Laporan dari {{ $user->name }}</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-rose-50/50 text-gray-500 text-xs font-bold uppercase border-b border-rose-100">
                            <th class="py-3 px-4 whitespace-nowrap">No Laporan</th>
                            <th class="py-3 px-4 whitespace-nowrap">Kategori</th>
                            <th class="py-3 px-4 whitespace-nowrap">Tanggal</th>
                            <th class="py-3 px-4 text-center whitespace-nowrap">Status</th>
                            <th class="py-3 px-4 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse($laporans as $item)
                        <tr>
                            <td class="py-4 px-4 font-bold text-rose-600 whitespace-nowrap">{{ $item->nomor_laporan }}</td>
                            <td class="py-4 px-4 font-semibold text-gray-800 whitespace-nowrap">{{ $item->kategori }}</td>
                            <td class="py-4 px-4 text-gray-500 whitespace-nowrap">{{ optional($item->tanggal_kejadian)->format('d M Y') ?? '-' }}</td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                @if($item->status_penanganan == 'Menunggu Verifikasi')
                                    <span title="Menunggu verifikasi oleh admin" class="inline-flex items-center gap-1.5 whitespace-nowrap bg-amber-50 text-amber-700 px-2.5 py-1 rounded-full font-bold border border-amber-200/60">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Perlu Verifikasi
                                    </span>
                                @elseif($item->status_penanganan == 'Sedang Diproses' || $item->status_penanganan == 'Diproses')
                                    <span class="inline-block bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-bold">Sedang Diproses</span>
                                @else
                                    <span class="inline-block bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full font-bold">Selesai</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex flex-wrap justify-center gap-2">
                                    <a href="{{ route('laporan.show', $item->id_laporan) }}" class="inline-block bg-rose-500 text-white font-bold px-3 py-1.5 rounded-lg hover:bg-rose-600 transition shadow-sm">
                                        Lihat
                                    </a>
                                    <a href="{{ route('laporan.edit', $item->id_laporan) }}" class="inline-block border border-rose-200 bg-white text-rose-600 font-bold px-3 py-1.5 rounded-lg hover:bg-rose-50 transition">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400">Pengguna ini belum memiliki riwayat laporan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>