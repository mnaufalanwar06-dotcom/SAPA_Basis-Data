<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Akun Anda - SAPA (Sahabat Perlindungan)</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        sapaPink: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
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
        .curved-header {
            border-bottom-left-radius: 50% 30px;
            border-bottom-right-radius: 50% 30px;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-0 sm:p-4 select-none">

    <!-- Mobile Device Frame Wrapper -->
    <div class="w-full max-w-sm sm:max-w-md bg-white min-h-screen sm:min-h-[812px] sm:rounded-[40px] sm:shadow-2xl sm:border-[8px] sm:border-gray-900 relative overflow-hidden flex flex-col justify-between">
        
        <!-- Status Bar Mobile (Indikator Jam & Baterai) -->
        <div class="pt-3 px-6 flex justify-between items-center bg-gradient-to-r from-sapaPink-500 to-sapaPink-600 text-white text-xs font-semibold z-20">
            <span>9:41</span>
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9 4.03-9 9 0 2.12.74 4.07 1.97 5.61L4.35 19.4c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0l1.9-1.9C9.2 19.54 10.55 20 12 20c4.97 0 9-4.03 9-9s-4.03-9-9-9zm0 15c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z"/></svg>
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 4h-3V2h-4v2H7c-.55 0-1 .45-1 1v16c0 .55.45 1 1 1h10c.55 0 1-.45 1-1V5c0-.55-.45-1-1-1z"/></svg>
            </div>
        </div>

        <div>
            <!-- Header Kurva Merah Muda (Gradient Wave Header) -->
            <div class="relative bg-gradient-to-b from-sapaPink-500 via-sapaPink-500 to-sapaPink-600 pt-4 pb-16 px-6 curved-header shadow-md">
                
                <!-- Tombol Kembali (Back Button) -->
                <button type="button" onclick="window.history.length > 1 ? history.back() : window.location.href='/'" class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 backdrop-blur-sm flex items-center justify-center text-white transition active:scale-95 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <!-- Badge Logo Lingkaran Melayang -->
                <div class="absolute -bottom-10 left-1/2 -translate-x-1/2">
                    <div class="w-24 h-24 rounded-full bg-white shadow-xl shadow-sapaPink-500/20 border-4 border-white flex items-center justify-center p-3 transition transform hover:scale-105">
                        <!-- Icon Heart & Hands (Logo SAPA) -->
                        <svg class="w-14 h-14 text-sapaPink-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                            <path d="M12 5 9.04 7.96a2.17 2.17 0 0 0 0 3.08v0c.82.82 2.13.85 3 .07l2.07-1.9" fill="currentColor" fill-opacity="0.15"/>
                            <path d="m14 10 1.5 1.5"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Area Form Utama -->
            <div class="pt-14 px-7 pb-6 text-center">
                
                <!-- Judul Halaman -->
                <h1 class="text-2xl font-black text-sapaPink-700 tracking-tight">Masuk ke Akun Anda</h1>
                <p class="text-xs text-gray-400 font-medium mt-1">Silakan login untuk melanjutkan</p>

                <!-- Alert Warning Client / Server -->
                <div id="formAlert" class="alert-auto-dismiss mt-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl text-xs text-left hidden flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span id="formAlertText">Silakan isi email/nomor HP dan password Anda.</span>
                </div>

                <form action="#" method="POST" id="userLoginForm" class="mt-6 space-y-4 text-left">
                    @csrf
                    
                    <!-- Input Email atau Nomor HP -->
                    <div>
                        <label class="block text-xs font-bold text-sapaPink-600 mb-1.5">Email atau Nomor HP</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sapaPink-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <input type="text" 
                                   id="login_input"
                                   name="login"
                                   placeholder="contoh@email.com" 
                                   required
                                   class="w-full pl-11 pr-4 py-3 bg-white border-2 border-sapaPink-300 focus:border-sapaPink-600 focus:ring-0 rounded-2xl text-xs text-gray-800 placeholder-gray-300 font-medium transition duration-200">
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div>
                        <label class="block text-xs font-bold text-sapaPink-600 mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-sapaPink-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input type="password" 
                                   id="user_password"
                                   name="password"
                                   placeholder="Masukkan password" 
                                   required
                                   class="w-full pl-11 pr-10 py-3 bg-white border-2 border-sapaPink-300 focus:border-sapaPink-600 focus:ring-0 rounded-2xl text-xs text-gray-800 placeholder-gray-300 font-medium transition duration-200">
                            
                            <!-- Toggle Password Eye Icon -->
                            <button type="button" 
                                    onclick="toggleUserPassword()" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-sapaPink-400 hover:text-sapaPink-600 cursor-pointer">
                                <svg id="eyeOpen" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeClosed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol Masuk Utama -->
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 bg-sapaPink-700 hover:bg-sapaPink-800 active:scale-98 text-white font-bold text-sm tracking-wide rounded-2xl shadow-lg shadow-sapaPink-700/30 transition duration-200 cursor-pointer">
                            masuk
                        </button>
                    </div>

                    <!-- Link Lupa Password -->
                    <div class="text-center pt-1">
                        <a href="#" class="text-xs font-bold text-sapaPink-600 hover:text-sapaPink-800 transition">
                            Lupa Password?
                        </a>
                    </div>
                </form>

                <!-- Pembatas (Divider) -->
                <div class="relative my-6 flex items-center justify-center">
                    <div class="w-full border-t border-sapaPink-200"></div>
                    <span class="absolute bg-white px-3 text-[11px] font-medium text-gray-400">atau</span>
                </div>

                <!-- Tombol Sekunder (Daftar Akun) -->
                <div>
                    <a href="#" class="block w-full py-3 bg-white border-2 border-sapaPink-300 hover:border-sapaPink-500 text-sapaPink-700 font-bold text-xs tracking-wide rounded-2xl text-center transition duration-200">
                        Daftar Akun
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Halus -->
        <div class="pb-4 text-center text-[10px] text-gray-300 font-medium">
            SAPA &copy; {{ date('Y') }} - Sistem Pelaporan Aman
        </div>
    </div>

    <!-- Script Interaktif JS -->
    <script>
        function toggleUserPassword() {
            const passInput = document.getElementById('user_password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                passInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        }

        // Auto-dismiss alert jika ada
        const activeAlertTimers = new Map();
        function autoDismissAlert(el, delay = 3000) {
            if (!el) return;
            if (activeAlertTimers.has(el)) clearTimeout(activeAlertTimers.get(el));
            el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            el.style.opacity = '1';
            const timer = setTimeout(() => {
                el.style.opacity = '0';
                setTimeout(() => el.classList.add('hidden'), 500);
            }, delay);
            activeAlertTimers.set(el, timer);
        }

        document.getElementById('userLoginForm').addEventListener('submit', function(e) {
            const loginInput = document.getElementById('login_input');
            const passInput = document.getElementById('user_password');
            const formAlert = document.getElementById('formAlert');

            if (!loginInput.value.trim() || !passInput.value) {
                e.preventDefault();
                formAlert.classList.remove('hidden');
                autoDismissAlert(formAlert, 3000);
            }
        });
    </script>
</body>
</html>
