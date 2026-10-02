<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - SAPA (Sahabat Perlindungan Perempuan & Anak)</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        pinkTheme: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f472b6',
                            400: '#e879f9',
                            500: '#ec4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom curve on desktop matching reference image */
        @media (min-width: 768px) {
            .curved-panel {
                border-top-left-radius: 160px;
                border-bottom-left-radius: 110px;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#e8ecf4] via-[#f4e8f0] to-[#fce7f3] min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 select-none">

    <!-- Card Container -->
    <div class="w-full max-w-4xl bg-white rounded-[32px] shadow-[0_20px_60px_rgba(219,39,119,0.12)] border border-pink-100/70 overflow-hidden grid grid-cols-1 md:grid-cols-2 min-h-[500px] transition-all duration-300">
        
        <!-- Sisi Kiri: Form Masuk Admin -->
        <div class="p-8 sm:p-12 flex flex-col justify-center items-center text-center">
            
            <!-- Judul Halaman -->
            <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight mb-2">
                Masuk ke Portal Admin
            </h1>
            
            <p class="text-xs text-gray-400 mb-6 font-medium">
                Silakan masuk menggunakan akun admin Anda
            </p>

            <!-- Notifikasi Flash Info / Error -->
            @if(session('info'))
                <div class="alert-auto-dismiss w-full max-w-xs mb-4 p-3 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl text-xs text-left flex items-center gap-2">
                    <span>ℹ️</span>
                    <span>{{ session('info') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert-auto-dismiss w-full max-w-xs mb-4 p-3 bg-pink-50 border border-pink-200 text-pink-700 rounded-xl text-xs text-left flex items-center gap-2">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Notifikasi Peringatan Client-Side Validation -->
            <div id="formAlert" class="alert-auto-dismiss w-full max-w-xs mb-3.5 p-3 bg-rose-50 border border-rose-300 text-rose-700 rounded-xl text-xs text-left hidden flex items-start gap-2 shadow-sm animate-bounce-short">
                <span class="text-base leading-none">⚠️</span>
                <div class="flex-1">
                    <p class="font-bold text-rose-800 mb-0.5">Peringatan!</p>
                    <p id="formAlertText" class="text-[11px] text-rose-700">Silakan lengkapi email dan kata sandi Anda terlebih dahulu.</p>
                </div>
            </div>

            <!-- Formulir Login -->
            <form action="{{ route('login.post') }}" method="POST" id="loginForm" novalidate class="w-full max-w-xs space-y-3.5">
                @csrf

                <!-- Input Email -->
                <div class="text-left">
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           autocomplete="email" 
                           placeholder="Email"
                           class="w-full px-4 py-3 bg-[#f0f2f5] border border-transparent @error('email') border-pink-500 bg-pink-50/40 @enderror rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200">
                    
                    <p id="emailWarning" class="alert-auto-dismiss mt-1.5 text-[11px] font-semibold text-rose-600 flex items-center gap-1.5 hidden bg-rose-50 border border-rose-200 px-2.5 py-1.5 rounded-lg">
                        <svg class="w-3.5 h-3.5 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span id="emailWarningText">Silakan masukkan email Anda</span>
                    </p>

                    @error('email')
                        <p class="alert-auto-dismiss mt-1 text-[11px] font-semibold text-pink-600 flex items-center gap-1">
                            <span>⚠</span> <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Input Password dengan Toggle Lihat/Sembunyikan -->
                <div class="text-left">
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               autocomplete="current-password" 
                               placeholder="Password"
                               class="w-full pl-4 pr-10 py-3 bg-[#f0f2f5] border border-transparent @error('password') border-pink-500 bg-pink-50/40 @enderror rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition duration-200">
                        
                        <button type="button" 
                                onclick="togglePasswordVisibility()" 
                                title="Lihat/Sembunyikan Kata Sandi"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-pink-600 transition cursor-pointer">
                            <svg id="eyeOpenIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeClosedIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    <p id="passwordWarning" class="alert-auto-dismiss mt-1.5 text-[11px] font-semibold text-rose-600 flex items-center gap-1.5 hidden bg-rose-50 border border-rose-200 px-2.5 py-1.5 rounded-lg">
                        <svg class="w-3.5 h-3.5 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span id="passwordWarningText">Silakan masukkan kata sandi Anda</span>
                    </p>

                    @error('password')
                        <p class="alert-auto-dismiss mt-1 text-[11px] font-semibold text-pink-600 flex items-center gap-1">
                            <span>⚠</span> <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Lupa Password Link (Tengah) -->
                <div class="pt-1">
                    <a href="javascript:void(0)" onclick="openHelpModal()" class="text-xs text-gray-500 hover:text-pink-600 transition font-medium">
                        Lupa Kata Sandi Anda?
                    </a>
                </div>

                <!-- Remember Me (Tersembunyi tapi aktif) -->
                <input type="hidden" name="remember" value="1">

                <!-- Tombol Submit MASUK -->
                <div class="pt-2">
                    <button type="submit" 
                            id="btnSubmit"
                            class="px-12 py-3 bg-gradient-to-r from-pink-600 via-pink-600 to-rose-600 hover:from-pink-700 hover:via-pink-700 hover:to-rose-700 active:scale-95 text-white font-black text-xs tracking-wider uppercase rounded-xl shadow-lg shadow-pink-600/30 transition duration-200 cursor-pointer disabled:opacity-75">
                        <span id="btnText">MASUK</span>
                        <span id="btnSpinner" class="hidden">MEMVERIFIKASI...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Sisi Kanan: Panel Lengkung Warna Pink (Curved Pink Panel) -->
        <div class="curved-panel bg-gradient-to-br from-pink-500 via-pink-600 to-rose-600 text-white p-8 sm:p-12 flex flex-col justify-center items-center text-center shadow-inner relative overflow-hidden">
            
            <!-- Elemen Dekoratif Halus di Background Panel -->
            <div class="absolute -top-16 -right-16 w-56 h-56 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-56 h-56 bg-rose-900/15 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 max-w-xs flex flex-col items-center">
                <!-- Judul -->
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-5">
                    Selamat Datang, Admin
                </h2>

                <!-- Paragraf 1 -->
                <p class="text-xs sm:text-sm text-pink-50/90 leading-relaxed mb-4 font-normal">
                    Kelola dan tindak lanjuti laporan terkait perempuan dan anak dengan aman, cepat, dan bertanggung jawab.
                </p>

                <!-- Paragraf 2 -->
                <p class="text-xs sm:text-sm text-pink-50/90 leading-relaxed mb-5 font-normal">
                    Silakan masuk untuk mengakses sistem pelaporan dan memastikan setiap laporan mendapatkan penanganan yang tepat.
                </p>

                <!-- Kutipan -->
                <p class="text-xs sm:text-sm text-white font-bold italic leading-relaxed">
                    &ldquo;Bersama menciptakan ruang yang aman bagi perempuan dan anak.&rdquo;
                </p>
            </div>
        </div>

    </div>

    <!-- Modal Kredensial Cepat / Akun Demo -->
    <div id="demoModal" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-pink-100 transform transition-all">
            <div class="w-12 h-12 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center text-xl mb-4">
                🔑
            </div>
            <h3 class="text-base font-bold text-gray-900 mb-1">Pilih Akun Administrator</h3>
            <p class="text-xs text-gray-500 leading-relaxed mb-4">
                Klik salah satu akun di bawah untuk mengisi formulir login secara otomatis:
            </p>
            
            <div class="space-y-2.5 mb-5">
                <button type="button" 
                        onclick="fillCredentials('revita@gmail.com', 'admin123'); closeDemoModal();"
                        class="w-full p-3 bg-pink-50/60 hover:bg-pink-100/70 border border-pink-200/80 rounded-2xl text-left transition duration-150 group cursor-pointer">
                    <div class="font-bold text-gray-800 text-xs group-hover:text-pink-600">Revita  (Super Admin)</div>
                    <div class="text-[11px] text-gray-500">revita@gmail.com</div>
                    <div class="text-[10px] font-semibold text-pink-600 mt-0.5">Sandi: admin123</div>
                </button>

                <button type="button" 
                        onclick="fillCredentials('admin@sapa.id', 'admin123'); closeDemoModal();"
                        class="w-full p-3 bg-pink-50/60 hover:bg-pink-100/70 border border-pink-200/80 rounded-2xl text-left transition duration-150 group cursor-pointer">
                    <div class="font-bold text-gray-800 text-xs group-hover:text-pink-600">Admin SAPA (Administrator)</div>
                    <div class="text-[11px] text-gray-500">admin@sapa.id</div>
                    <div class="text-[10px] font-semibold text-pink-600 mt-0.5">Sandi: admin123</div>
                </button>
            </div>

            <button type="button" 
                    onclick="closeDemoModal()" 
                    class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>

    <!-- Modal Informasi Lupa Password -->
    <div id="helpModal" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-pink-100 transform transition-all">
            <div class="w-12 h-12 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center text-xl mb-4">
                🔒
            </div>
            <h3 class="text-base font-bold text-gray-900 mb-1.5">Lupa Kata Sandi?</h3>
            <p class="text-xs text-gray-500 leading-relaxed mb-5">
                Demi keamanan data kasus sensitif, perubahan kata sandi admin hanya dapat dilakukan melalui menu <strong class="text-pink-600">Pengaturan Akun</strong> setelah masuk, atau melalui Super Administrator IT SAPA.
            </p>
            <div class="space-y-2">
                <button type="button" 
                        onclick="fillCredentials('revita@gmail.com', 'admin123'); closeHelpModal();"
                        class="w-full py-2.5 bg-pink-600 hover:bg-pink-700 text-white rounded-xl text-xs font-bold transition cursor-pointer">
                    Gunakan Akun Default (admin123)
                </button>
                <button type="button" 
                        onclick="closeHelpModal()" 
                        class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-xs font-semibold transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Script Interaktif -->
    <script>
        // Toggle Lihat / Sembunyikan Password
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpenIcon');
            const eyeClosed = document.getElementById('eyeClosedIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }

        // Isi Otomatis Kredensial
        function fillCredentials(email, password) {
            const emailInput = document.getElementById('email');
            const passInput = document.getElementById('password');
            
            emailInput.value = email;
            passInput.value = password;

            emailInput.classList.add('ring-2', 'ring-pink-400');
            passInput.classList.add('ring-2', 'ring-pink-400');
            setTimeout(() => {
                emailInput.classList.remove('ring-2', 'ring-pink-400');
                passInput.classList.remove('ring-2', 'ring-pink-400');
            }, 500);
        }

        // Modal Akun Demo
        function openDemoModal() {
            const modal = document.getElementById('demoModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDemoModal() {
            const modal = document.getElementById('demoModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Modal Bantuan
        function openHelpModal() {
            const modal = document.getElementById('helpModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeHelpModal() {
            const modal = document.getElementById('helpModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Otomatis hilangkan peringatan setelah 3 detik (3000 ms)
        const activeAlertTimers = new Map();

        function autoDismissAlert(el, delay = 3000) {
            if (!el) return;
            if (activeAlertTimers.has(el)) {
                clearTimeout(activeAlertTimers.get(el));
            }
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';

            const timer = setTimeout(() => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(-4px)';
                setTimeout(() => {
                    el.classList.add('hidden');
                }, 500);
            }, delay);

            activeAlertTimers.set(el, timer);
        }

        // Terapkan auto-dismiss 3 detik pada semua peringatan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.alert-auto-dismiss').forEach(function(el) {
                if (!el.classList.contains('hidden')) {
                    autoDismissAlert(el, 3000);
                }
            });
        });

        // Form Validation & Submit Loading
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const emailInput = document.getElementById('email');
            const passInput = document.getElementById('password');
            const emailWarning = document.getElementById('emailWarning');
            const passwordWarning = document.getElementById('passwordWarning');
            const emailWarningText = document.getElementById('emailWarningText');
            const passwordWarningText = document.getElementById('passwordWarningText');
            const formAlert = document.getElementById('formAlert');
            const formAlertText = document.getElementById('formAlertText');

            let isValid = true;
            let missingFields = [];

            // Reset warnings
            emailWarning.classList.add('hidden');
            passwordWarning.classList.add('hidden');
            if (formAlert) formAlert.classList.add('hidden');
            
            emailInput.classList.remove('border-rose-500', 'bg-rose-50/40', 'ring-2', 'ring-rose-400/30');
            passInput.classList.remove('border-rose-500', 'bg-rose-50/40', 'ring-2', 'ring-rose-400/30');

            // Validasi Email
            if (!emailInput.value.trim()) {
                isValid = false;
                missingFields.push('Email');
                emailWarningText.textContent = 'Email tidak boleh kosong!';
                emailWarning.classList.remove('hidden');
                autoDismissAlert(emailWarning, 3000);
                emailInput.classList.add('border-rose-500', 'bg-rose-50/40', 'ring-2', 'ring-rose-400/30');
            }

            // Validasi Password
            if (!passInput.value) {
                isValid = false;
                missingFields.push('Kata Sandi');
                passwordWarningText.textContent = 'Kata sandi tidak boleh kosong!';
                passwordWarning.classList.remove('hidden');
                autoDismissAlert(passwordWarning, 3000);
                passInput.classList.add('border-rose-500', 'bg-rose-50/40', 'ring-2', 'ring-rose-400/30');
            }

            // Jika ada field yang kosong, batalkan submit dan tampilkan peringatan
            if (!isValid) {
                e.preventDefault();

                if (formAlert && formAlertText) {
                    if (missingFields.length === 2) {
                        formAlertText.textContent = 'Silakan masukkan email dan kata sandi Anda terlebih dahulu.';
                    } else if (missingFields.includes('Email')) {
                        formAlertText.textContent = 'Silakan masukkan email Anda terlebih dahulu.';
                    } else {
                        formAlertText.textContent = 'Silakan masukkan kata sandi Anda terlebih dahulu.';
                    }
                    formAlert.classList.remove('hidden');
                    autoDismissAlert(formAlert, 3000);
                }

                // Focus ke field yang kosong pertama kali
                if (!emailInput.value.trim()) {
                    emailInput.focus();
                } else if (!passInput.value) {
                    passInput.focus();
                }
                
                return false;
            }

            // Jika valid, tampilkan status loading tombol
            const btn = document.getElementById('btnSubmit');
            const text = document.getElementById('btnText');
            const spinner = document.getElementById('btnSpinner');

            btn.disabled = true;
            text.classList.add('hidden');
            spinner.classList.remove('hidden');
        });

        // Sembunyikan peringatan saat pengguna mengetik
        document.getElementById('email').addEventListener('input', function() {
            document.getElementById('emailWarning').classList.add('hidden');
            this.classList.remove('border-rose-500', 'bg-rose-50/40', 'ring-2', 'ring-rose-400/30');
            const formAlert = document.getElementById('formAlert');
            if (formAlert && document.getElementById('password').value) {
                formAlert.classList.add('hidden');
            }
        });

        document.getElementById('password').addEventListener('input', function() {
            document.getElementById('passwordWarning').classList.add('hidden');
            this.classList.remove('border-rose-500', 'bg-rose-50/40', 'ring-2', 'ring-rose-400/30');
            const formAlert = document.getElementById('formAlert');
            if (formAlert && document.getElementById('email').value.trim()) {
                formAlert.classList.add('hidden');
            }
        });
    </script>
</body>
</html>