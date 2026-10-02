<x-app-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-rose-600">Pengaturan Admin</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kartu 1: Informasi Profil Admin -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-rose-100 shadow-sm">
            <h3 class="font-bold text-rose-600 text-sm mb-4">Informasi Profil Admin</h3>

            @if(session('success_profil'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success_profil') }}</span>
                </div>
            @endif

            <form action="{{ route('pengaturan.update-profil') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" 
                        value="{{ $admin->name ?? 'Revita' }}" required
                        class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-800 focus:ring-rose-500 focus:border-rose-500 transition">
                </div>

                <!-- Alamat Email -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" 
                        value="{{ $admin->email ?? 'revita@gmail.com' }}" required
                        class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-800 focus:ring-rose-500 focus:border-rose-500 transition">
                </div>

                <!-- Peran & ID Admin -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Peran Hak Akses</label>
                        <div class="px-4 py-2.5 bg-rose-50 border border-rose-100 rounded-xl text-xs font-bold text-rose-600">
                            Super Admin
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">ID Admin</label>
                        <div class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold text-gray-700">
                            SAPA-ADM-{{ str_pad($admin->id ?? 1, 3, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="bg-rose-500 text-white text-xs font-bold px-6 py-2.5 rounded-xl hover:bg-rose-600 active:scale-95 transition shadow-sm cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Kartu 2: Ganti Password -->
        <div class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm h-fit">
            <h3 class="font-bold text-rose-600 text-sm mb-4">Ganti Password</h3>

            @if(session('success_password'))
                <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success_password') }}</span>
                </div>
            @endif

            <form action="{{ route('pengaturan.update-password') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Password Lama</label>
                    <div class="relative">
                        <input id="password_lama" type="password" name="password_lama" placeholder="Masukkan password lama" required class="w-full px-4 pr-11 py-2.5 bg-white border @error('password_lama') border-rose-500 @else border-gray-200 @enderror rounded-xl text-xs text-gray-700 focus:ring-rose-500 focus:border-rose-500 transition">
                        <button type="button" onclick="toggleAdminPassword('password_lama', 'eye-password-lama', 'eye-off-password-lama')" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-rose-600" title="Tampilkan/sembunyikan password lama" aria-label="Tampilkan atau sembunyikan password lama">
                            <svg id="eye-password-lama" class="hidden h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eye-off-password-lama" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                    @error('password_lama')
                        <p class="mt-1 text-[11px] text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Password Baru (min. 6 karakter)</label>
                    <div class="relative">
                        <input id="password_baru" type="password" name="password_baru" placeholder="Masukkan password baru" required class="w-full px-4 pr-11 py-2.5 bg-white border @error('password_baru') border-rose-500 @else border-gray-200 @enderror rounded-xl text-xs text-gray-700 focus:ring-rose-500 focus:border-rose-500 transition">
                        <button type="button" onclick="toggleAdminPassword('password_baru', 'eye-password-baru', 'eye-off-password-baru')" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-rose-600" title="Tampilkan/sembunyikan password baru" aria-label="Tampilkan atau sembunyikan password baru">
                            <svg id="eye-password-baru" class="hidden h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eye-off-password-baru" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                    @error('password_baru')
                        <p class="mt-1 text-[11px] text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input id="konfirmasi_password" type="password" name="konfirmasi_password" placeholder="Konfirmasi password baru" required class="w-full px-4 pr-11 py-2.5 bg-white border @error('konfirmasi_password') border-rose-500 @else border-gray-200 @enderror rounded-xl text-xs text-gray-700 focus:ring-rose-500 focus:border-rose-500 transition">
                        <button type="button" onclick="toggleAdminPassword('konfirmasi_password', 'eye-konfirmasi-password', 'eye-off-konfirmasi-password')" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-rose-600" title="Tampilkan/sembunyikan konfirmasi password" aria-label="Tampilkan atau sembunyikan konfirmasi password">
                            <svg id="eye-konfirmasi-password" class="hidden h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eye-off-konfirmasi-password" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                    @error('konfirmasi_password')
                        <p class="mt-1 text-[11px] text-rose-500 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-rose-500 text-white text-xs font-bold py-2.5 rounded-xl hover:bg-rose-600 active:scale-95 transition shadow-sm cursor-pointer">
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function toggleAdminPassword(inputId, eyeId, eyeOffId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            const eyeOff = document.getElementById(eyeOffId);
            const tampil = input.type === 'password';

            input.type = tampil ? 'text' : 'password';
            eye.classList.toggle('hidden', !tampil);
            eyeOff.classList.toggle('hidden', tampil);
        }
    </script>
</x-app-layout>