<x-app-layout>
    <x-slot name="header">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 dark:text-white leading-tight">
                    Checkout
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                    Demo payment page (Fake) — no real money will be charged.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ url('/map?land_id='.$land->id) }}"
                   class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold hover:bg-gray-50
                          dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10">
                    Back to Map
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
        {{-- Summary --}}
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:bg-white/5 dark:border-white/10">
            <div class="text-sm text-gray-500 dark:text-gray-300">Order Summary</div>

            <div class="mt-3">
                <div class="text-xl font-extrabold text-gray-900 dark:text-white">
                    {{ $land->title }}
                </div>

                @if($land->description)
                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        {{ $land->description }}
                    </div>
                @else
                    <div class="mt-2 text-sm text-gray-400 dark:text-gray-400">
                        No description
                    </div>
                @endif
            </div>

            <div class="mt-5 rounded-2xl border border-gray-200 bg-gray-50 p-4 dark:bg-white/5 dark:border-white/10">
                <div class="text-xs text-gray-500 dark:text-gray-300">Total</div>
                <div class="text-3xl font-extrabold text-gray-900 dark:text-white">
                    {{ number_format((float)$land->price, 2) }}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    JOD (Demo)
                </div>
            </div>

            <div class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                * This checkout is for demonstration only.
            </div>
        </div>

        {{-- Payment --}}
        <div class="xl:col-span-2 rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:bg-white/5 dark:border-white/10">
            <div class="flex items-center justify-between">
                <div class="font-bold text-gray-900 dark:text-white">Choose Payment Method</div>
                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold
                             bg-emerald-50 text-emerald-800 border border-emerald-200
                             dark:bg-emerald-500/10 dark:text-emerald-200 dark:border-emerald-500/20">
                    Demo
                </span>
            </div>

            <form id="payForm" method="POST" action="{{ route('checkout.pay', $land) }}" class="mt-5 space-y-4">
                @csrf

                {{-- Methods --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <label class="rounded-2xl border border-gray-200 p-4 cursor-pointer hover:bg-gray-50
                                  dark:border-white/10 dark:hover:bg-white/10">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="method" value="visa" checked>
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-white">Visa / MasterCard</div>
                                <div class="text-sm text-gray-500 dark:text-gray-300">Card payment (fake)</div>
                            </div>
                        </div>
                    </label>

                    <label class="rounded-2xl border border-gray-200 p-4 cursor-pointer hover:bg-gray-50
                                  dark:border-white/10 dark:hover:bg-white/10">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="method" value="paypal">
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-white">PayPal</div>
                                <div class="text-sm text-gray-500 dark:text-gray-300">PayPal (fake)</div>
                            </div>
                        </div>
                    </label>
                </div>

                {{-- Fake Inputs (UI فقط) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input placeholder="Card Number (demo)"
                           class="rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-black/10
                                  dark:bg-white/5 dark:border-white/10 dark:text-white dark:placeholder:text-gray-400">

                    <input placeholder="Card Holder (demo)"
                           class="rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-black/10
                                  dark:bg-white/5 dark:border-white/10 dark:text-white dark:placeholder:text-gray-400">

                    <input placeholder="MM/YY"
                           class="rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-black/10
                                  dark:bg-white/5 dark:border-white/10 dark:text-white dark:placeholder:text-gray-400">

                    <input placeholder="CVC"
                           class="rounded-2xl border border-gray-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-black/10
                                  dark:bg-white/5 dark:border-white/10 dark:text-white dark:placeholder:text-gray-400">
                </div>

                {{-- Buttons --}}
                <div class="flex flex-wrap gap-2 pt-2">
                    <a href="{{ url('/map?land_id='.$land->id) }}"
                       class="inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-semibold transition shadow-sm
                              bg-white border border-gray-200 hover:bg-gray-50
                              dark:bg-white/5 dark:border-white/10 dark:text-white dark:hover:bg-white/10">
                        Cancel
                    </a>

                    <button id="payBtn" type="submit"
                            class="inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-extrabold transition shadow-sm
                                   bg-black text-white hover:opacity-90 dark:bg-white dark:text-black">
                        Pay Now (Fake) ✅
                    </button>
                </div>

                {{-- Fake processing message --}}
                <div id="processing" class="hidden mt-3 text-sm text-gray-500 dark:text-gray-300">
                    Processing payment... please wait
                </div>
            </form>
        </div>
    </div>

    <script>
        // مجرد UX: يظهر "Processing..." ثانية قبل submit
        const form = document.getElementById('payForm');
        const btn = document.getElementById('payBtn');
        const processing = document.getElementById('processing');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            btn.disabled = true;
            btn.style.opacity = "0.7";
            processing.classList.remove('hidden');

            setTimeout(() => {
                form.submit();
            }, 900);
        });
    </script>
</x-app-layout>
