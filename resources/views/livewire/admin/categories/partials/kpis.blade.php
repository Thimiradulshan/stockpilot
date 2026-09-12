<section aria-label="{{ __('Category summary') }}">

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">


        {{-- =====================================================
            TOTAL
        ====================================================== --}}
        <article
            class="group relative overflow-hidden rounded-2xl border border-[#015B63]/30 bg-gradient-to-br from-[#C5E2E2] via-[#E2EEEE] to-[#F7FAF5] p-5 shadow-lg shadow-[#015B63]/10 transition duration-200 hover:-translate-y-1 hover:shadow-2xl dark:border-[#4FC3C7]/25 dark:from-[#1A4B4E] dark:via-[#254548] dark:to-[#2E2E2E]"
        >

            <div class="absolute -right-10 -top-10 h-36 w-36 rounded-full bg-[#015B63]/20 blur-3xl"></div>

            <div class="absolute bottom-0 left-0 h-24 w-24 rounded-full bg-[#4FC3C7]/10 blur-2xl"></div>

            <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#015B63] to-[#4FC3C7]"></div>


            <div class="relative flex items-center justify-between gap-5">

                <div>

                    <div class="flex items-center gap-2">

                        <span class="h-2 w-2 rounded-full bg-[#015B63] dark:bg-[#4FC3C7]"></span>

                        <p class="text-xs font-extrabold uppercase tracking-[0.08em] text-[#4E635E] dark:text-[#B8B8B8]">
                            {{ __('Total Categories') }}
                        </p>

                    </div>


                    <p class="mt-3 text-[40px] font-black leading-none tracking-tight text-[#015B63] dark:text-[#4FC3C7]">
                        {{ number_format($totalCategories) }}
                    </p>


                    <p class="mt-2 text-xs font-semibold text-[#4E635E] dark:text-[#8A8A8A]">
                        {{ __('Entire category catalog') }}
                    </p>

                </div>


                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[#015B63] text-white shadow-xl shadow-[#015B63]/30 transition duration-200 group-hover:scale-110 group-hover:rotate-3">

                    <svg
                        class="h-7 w-7"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect x="4" y="4" width="6.5" height="6.5" rx="1.4"/>
                        <rect x="13.5" y="4" width="6.5" height="6.5" rx="1.4"/>
                        <rect x="4" y="13.5" width="6.5" height="6.5" rx="1.4"/>
                        <rect x="13.5" y="13.5" width="6.5" height="6.5" rx="1.4"/>
                    </svg>

                </div>

            </div>

        </article>


        {{-- =====================================================
            ACTIVE
        ====================================================== --}}
        <article
            class="group relative overflow-hidden rounded-2xl border border-[#2F7D5B]/30 bg-gradient-to-br from-[#C7E4D1] via-[#E0F0E5] to-[#F7FAF5] p-5 shadow-lg shadow-[#2F7D5B]/10 transition duration-200 hover:-translate-y-1 hover:shadow-2xl dark:border-[#6FC49A]/25 dark:from-[#1A3A2E] dark:via-[#244335] dark:to-[#2E2E2E]"
        >

            <div class="absolute -right-10 -top-10 h-36 w-36 rounded-full bg-[#2F7D5B]/20 blur-3xl"></div>

            <div class="absolute bottom-0 left-0 h-24 w-24 rounded-full bg-[#6FC49A]/10 blur-2xl"></div>

            <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#2F7D5B] to-[#6FC49A]"></div>


            <div class="relative flex items-center justify-between gap-5">

                <div>

                    <div class="flex items-center gap-2">

                        <span class="h-2 w-2 rounded-full bg-[#2F7D5B] dark:bg-[#6FC49A]"></span>

                        <p class="text-xs font-extrabold uppercase tracking-[0.08em] text-[#4E635E] dark:text-[#B8B8B8]">
                            {{ __('Active Categories') }}
                        </p>

                    </div>


                    <p class="mt-3 text-[40px] font-black leading-none tracking-tight text-[#2F7D5B] dark:text-[#6FC49A]">
                        {{ number_format($activeCategories) }}
                    </p>


                    <p class="mt-2 text-xs font-semibold text-[#4E635E] dark:text-[#8A8A8A]">
                        {{ __('Available for products') }}
                    </p>

                </div>


                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[#2F7D5B] text-white shadow-xl shadow-[#2F7D5B]/30 transition duration-200 group-hover:scale-110 group-hover:rotate-3">

                    <svg
                        class="h-7 w-7"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m5 12.5 4.5 4.5L19 7.5"
                        />
                    </svg>

                </div>

            </div>

        </article>


        {{-- =====================================================
            INACTIVE
        ====================================================== --}}
        <article
            class="group relative overflow-hidden rounded-2xl border border-[#B98FC0]/40 bg-gradient-to-br from-[#E6D1E6] via-[#F0E1EF] to-[#FBF8FB] p-5 shadow-lg shadow-[#7A4E86]/10 transition duration-200 hover:-translate-y-1 hover:shadow-2xl dark:border-[#D9A9D6]/25 dark:from-[#33224A] dark:via-[#3B2B47] dark:to-[#2E2E2E]"
        >

            <div class="absolute -right-10 -top-10 h-36 w-36 rounded-full bg-[#B98FC0]/25 blur-3xl"></div>

            <div class="absolute bottom-0 left-0 h-24 w-24 rounded-full bg-[#F5784E]/10 blur-2xl"></div>

            <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#7A4E86] to-[#F5784E]"></div>


            <div class="relative flex items-center justify-between gap-5">

                <div>

                    <div class="flex items-center gap-2">

                        <span class="h-2 w-2 rounded-full bg-[#7A4E86] dark:bg-[#D9A9D6]"></span>

                        <p class="text-xs font-extrabold uppercase tracking-[0.08em] text-[#4E635E] dark:text-[#B8B8B8]">
                            {{ __('Inactive Categories') }}
                        </p>

                    </div>


                    <p class="mt-3 text-[40px] font-black leading-none tracking-tight text-[#7A4E86] dark:text-[#D9A9D6]">
                        {{ number_format($inactiveCategories) }}
                    </p>


                    <p class="mt-2 text-xs font-semibold text-[#4E635E] dark:text-[#8A8A8A]">
                        {{ __('Retained for history') }}
                    </p>

                </div>


                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[#7A4E86] text-white shadow-xl shadow-[#7A4E86]/30 transition duration-200 group-hover:scale-110 group-hover:rotate-3">

                    <svg
                        class="h-7 w-7"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="8.5"
                        />

                        <path
                            stroke-linecap="round"
                            d="M12 8v4M12 16h.01"
                        />
                    </svg>

                </div>

            </div>

        </article>

    </div>

</section>
