<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UBCFitnessid - Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full h-screen flex">
        <!-- Left Section (70%) -->
        <div class="w-2/3 flex flex-col justify-between bg-gray-900 px-12 py-10 relative">
            <!-- Navbar -->
            <div class="flex items-center gap-8">
                <div class="bg-orange-500 text-white font-bold rounded-full w-10 h-10 flex items-center justify-center text-xl">U</div>
                <nav class="flex gap-6 text-gray-300 text-sm">
                    <a href="{{ route('login') }}" class="hover:text-white">Login</a>
                    <a href="{{ route('register') }}" class="hover:text-white">Register</a>
                </nav>
            </div>
            <!-- Main Text -->
            <div class="flex-1 flex flex-col justify-center mt-24">
                <span class="block w-8 h-1 bg-orange-500 mb-6"></span>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-8 leading-tight">
                    Mulai perjalanan <br>
                    kebugaranmu bersama kami!<br>
                </h1>
                <p class="text-white text-lg mb-6">
                    Nikmati fasilitas gym terbaik di kota Anda.<br>
                </p>
                <div class="flex items-center gap-4 mt-4">
                    <a href="#" class="border border-white text-white px-6 py-2 rounded hover:bg-white hover:text-gray-900 transition text-xs tracking-widest">MORE ABOUT US</a>
                    <button class="border border-white rounded-full w-10 h-10 flex items-center justify-center text-white hover:bg-white hover:text-gray-900 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                            <polygon points="10,9 16,12 10,15" fill="currentColor"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Right Section (30%) -->
        <div class="w-1/3 relative flex items-center justify-center bg-gradient-to-br from-orange-900 to-yellow-700 overflow-hidden">
            <!-- Background overlay pattern (optional) -->
            <div class="absolute inset-0 opacity-60" style="background-image: url('/images/bg-pattern.jpg'); background-size: cover; background-position: center;"></div>
            <!-- Main Image -->
            <!-- <img src="/images/background3.jpg" alt="Gym" class="relative z-10 rounded-lg shadow-2xl w-[90%] object-cover mt-20"> -->
            <!-- Social Icons (top right) -->
            <div class="absolute top-6 right-8 flex gap-3 z-20">
                <a href="#"><img src="/images/facebook.png" class="w-5 h-5" alt="fb"></a>
                <a href="#"><img src="/images/tiktok.png" class="w-5 h-5" alt="tw"></a>
                <a href="#"><img src="/images/instagram.png" class="w-5 h-5" alt="ig"></a>
            </div>
            <!-- Scroll Down (right, vertical) -->  
        </div>
        <div class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/6 z-20">
            <img src="/images/background3.jpg" alt="Gym" class="w-[600px] rounded-xl shadow-2xl object-cover">
        </div>
    </div>
</body>
</html>
