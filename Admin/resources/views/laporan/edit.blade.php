<x-app-layout>
    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('laporan.show', $laporan->id_laporan) }}" class="flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 transition hover:bg-gray-50" aria-label="Kembali ke detail">←</a>
        <div>
            <h2 class="text-xl font-bold text-rose-600">Edit Data Laporan</h2>
            <p class="mt-1 text-xs text-gray-500">{{ $laporan->nomor_laporan }}</p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="mb-2 font-bold">Periksa kembali data berikut:</p>
            <ul class="list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('laporan.update', $laporan->id_laporan) }}" method="POST" class="max-w-3xl space-y-5 rounded-2xl border border-rose-100 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="nama_pelapor" class="mb-1.5 block text-xs font-bold text-gray-700">Nama Pelapor</label>
                <input id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor', $laporan->nama_pelapor) }}" required maxlength="100" class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500">
            </div>
            <div>
                <label for="kategori" class="mb-1.5 block text-xs font-bold text-gray-700">Kategori Kejadian</label>
                <input id="kategori" name="kategori" value="{{ old('kategori', $laporan->kategori) }}" required maxlength="100" class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500">
            </div>
            <div>
                <label for="sebagai" class="mb-1.5 block text-xs font-bold text-gray-700">Pelapor Sebagai</label>
                <select id="sebagai" name="sebagai" class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500">
                    @foreach(['Korban', 'Saksi', 'Keluarga Korban'] as $pilihan)
                        <option value="{{ $pilihan }}" {{ old('sebagai', $laporan->sebagai) === $pilihan ? 'selected' : '' }}>{{ $pilihan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tanggal_kejadian" class="mb-1.5 block text-xs font-bold text-gray-700">Tanggal Kejadian</label>
                <input id="tanggal_kejadian" type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', optional($laporan->tanggal_kejadian)->format('Y-m-d')) }}" required class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500">
            </div>
        </div>

        <div>
            <label for="lokasi_kejadian" class="mb-1.5 block text-xs font-bold text-gray-700">Lokasi Kejadian</label>
            <input id="lokasi_kejadian" name="lokasi_kejadian" value="{{ old('lokasi_kejadian', $laporan->lokasi_kejadian) }}" maxlength="255" class="w-full rounded-xl border-gray-200 text-sm focus:border-rose-500 focus:ring-rose-500">
        </div>

        <div>
            <label for="kronologi" class="mb-1.5 block text-xs font-bold text-gray-700">Penjelasan Kronologi</label>
            <textarea id="kronologi" name="kronologi" rows="7" required class="w-full rounded-xl border-gray-200 text-sm leading-relaxed focus:border-rose-500 focus:ring-rose-500">{{ old('kronologi', $laporan->kronologi) }}</textarea>
        </div>

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
            <a href="{{ route('laporan.show', $laporan->id_laporan) }}" class="rounded-xl border border-gray-200 px-5 py-2.5 text-xs font-bold text-gray-600 hover:bg-gray-50">Batal</a>
            <button type="submit" class="rounded-xl bg-rose-500 px-5 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-rose-600">Simpan Perubahan</button>
        </div>
    </form>
</x-app-layout>