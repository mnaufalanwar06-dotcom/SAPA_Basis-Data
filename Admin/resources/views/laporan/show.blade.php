<x-app-layout>
    <div class="flex justify-between items-center gap-4 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('laporan.index') }}" class="w-9 h-9 border border-gray-200 bg-white rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-50 transition">←</a>
            <h2 class="text-xl font-bold text-rose-600">Detail Laporan {{ $laporan->nomor_laporan }}</h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('laporan.edit', $laporan->id_laporan) }}" class="rounded-lg border border-rose-200 bg-white px-3 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50">Edit Laporan</a>
            <span class="whitespace-nowrap bg-amber-50 text-amber-600 border border-amber-200 px-4 py-1.5 rounded-full text-xs font-bold">
                {{ $laporan->status_penanganan }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Data Utama -->
        <div class="lg:col-span-2 min-w-0 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm">
                <h3 class="font-bold text-rose-600 mb-4 border-b pb-2">Data Utama Laporan</h3>
                <div class="grid grid-cols-2 gap-y-4 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs">Nomor Laporan</p>
                        <p class="font-bold text-rose-600">{{ $laporan->nomor_laporan }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Kategori Kejadian</p>
                        <p class="font-semibold text-gray-800">{{ $laporan->kategori }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Nama Pelapor</p>
                        <p class="font-semibold text-gray-800">{{ $laporan->nama_pelapor ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Melapor Sebagai</p>
                        <p class="font-semibold text-gray-800">{{ $laporan->sebagai }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Lokasi Kejadian</p>
                        <p class="font-semibold text-gray-800">{{ $laporan->lokasi_kejadian }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Tanggal Kejadian</p>
                        <p class="font-semibold text-gray-800">
                            {{ optional($laporan->tanggal_kejadian)->format('d M Y') ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <p class="font-bold text-gray-800 text-sm mb-2">Penjelasan Kronologi Kejadian</p>
                    <p class="text-gray-600 text-sm leading-relaxed bg-gray-50 p-4 rounded-xl whitespace-pre-wrap break-words" style="overflow-wrap: anywhere;">
                        {{ $laporan->kronologi }}
                    </p>
                </div>
            </div>

            <!-- Bukti Lampiran -->
            <div class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm">
                <h3 class="font-bold text-rose-600 mb-4">Bukti Lampiran</h3>
                @if($laporan->bukti_lampiran)
                    <div class="space-y-3">
                        @foreach(array_filter(array_map('trim', explode(',', $laporan->bukti_lampiran))) as $lampiran)
                            <div class="flex items-center justify-between border border-gray-200 p-3 rounded-xl bg-gray-50">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 shrink-0 bg-rose-100 rounded-lg flex items-center justify-center text-rose-600 font-bold text-xs">FILE</div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-sm text-gray-800 truncate">{{ basename($lampiran) }}</p>
                                        <p class="text-xs text-gray-400">Berkas Lampiran Laporan</p>
                                    </div>
                                </div>
                                @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($lampiran))
                                    <a href="{{ asset('storage/' . ltrim($lampiran, '/')) }}" download="{{ basename($lampiran) }}" class="shrink-0 p-2 text-rose-500 hover:bg-rose-50 rounded-lg flex items-center justify-center" title="Unduh berkas">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                @else
                                    <span class="shrink-0 text-xs text-gray-400" title="Berkas tidak ditemukan di server">Tidak tersedia</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 text-xs italic">Tidak ada bukti lampiran yang disertakan.</p>
                @endif
            </div>
        </div>

        <!-- Kolom Update Status -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm">
                <h3 class="font-bold text-rose-600 mb-4">Tindak Lanjut Laporan</h3>
                <form action="{{ route('laporan.update-status', $laporan->id_laporan) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Ubah Status</label>
                        <select name="status_penanganan" class="w-full border-gray-200 rounded-xl text-xs p-3 focus:ring-rose-500 focus:border-rose-500">
                            <option value="Menunggu Verifikasi" {{ $laporan->status_penanganan == 'Menunggu Verifikasi' ? 'selected' : '' }}>Perlu Verifikasi</option>
                            <option value="Sedang Diproses" {{ $laporan->status_penanganan == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="Selesai" {{ $laporan->status_penanganan == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Admin / Petugas</label>
                        <textarea name="catatan_admin" rows="3" class="w-full border-gray-200 rounded-xl text-xs p-3 focus:ring-rose-500 focus:border-rose-500" placeholder="Tuliskan catatan internal...">{{ $laporan->catatan_admin }}</textarea>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="reset" class="w-1/2 py-2.5 border border-rose-500 text-rose-500 rounded-xl text-xs font-bold hover:bg-rose-50">Batal</button>
                        <button type="submit" class="w-1/2 py-2.5 bg-rose-500 text-white rounded-xl text-xs font-bold hover:bg-rose-600 shadow-md shadow-rose-200">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>