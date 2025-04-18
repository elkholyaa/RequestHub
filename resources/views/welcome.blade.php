<x-guest-layout>
    <!-- ——— Auth links top‑right ——— -->
    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
        @if (Route::has('login'))
            <a href="{{ route('login') }}"
               class="font-semibold text-gray-700 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">
                Log&nbsp;in
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="ml-4 font-semibold text-gray-700 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">
                    Register
                </a>
            @endif
        @endif
    </div>

    <!-- ——— Simple hero ——— -->
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100">
        <h1 class="text-4xl font-bold mb-4">Welcome to RequestHub</h1>
        <p class="text-lg text-gray-700">Streamline your Service &amp; Maintenance requests</p>
    </div>
</x-guest-layout>
