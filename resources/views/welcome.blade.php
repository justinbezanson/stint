<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script>
            document.documentElement.classList.remove('dark');
        </script>

        <style>
            html { background-color: oklch(1 0 0); }
            html.dark { background-color: oklch(0.145 0 0); }

            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            @keyframes wiggle {
                0%, 100% { transform: rotate(0deg); }
                25% { transform: rotate(-5deg); }
                75% { transform: rotate(5deg); }
            }

            @keyframes slide-up {
                0% { opacity: 0; transform: translateY(20px); }
                100% { opacity: 1; transform: translateY(0); }
            }

            @keyframes shimmer {
                0% { background-position: -200% 0; }
                100% { background-position: 200% 0; }
            }

            .animate-float { animation: float 4s ease-in-out infinite; }
            .animate-float-delayed { animation: float 5s ease-in-out 1s infinite; }
            .animate-wiggle { animation: wiggle 3s ease-in-out infinite; }
            .animate-shimmer { background-size: 200% 100%; animation: shimmer 3s ease-in-out infinite; }
        </style>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts
        @vite(['resources/css/app.css'])

        <title>{{ config('app.name', 'Stint') }}</title>
    </head>
    <body class="font-sans antialiased bg-white text-gray-900 dark:bg-gray-950 dark:text-gray-100">
        <div class="flex min-h-screen flex-col">
            {{-- Navigation --}}
            <nav class="relative z-20 flex items-center justify-between px-6 py-4 lg:px-12">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-xl font-bold tracking-tight">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-500 text-sm text-white shadow-md shadow-violet-500/30">S</span>
                    <span class="text-gray-800 dark:text-gray-100">{{ config('app.name', 'Stint') }}</span>
                </a>

                <div class="flex items-center gap-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 transition-colors dark:text-gray-400 dark:hover:text-gray-100">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-violet-500/25 hover:shadow-lg hover:shadow-violet-500/30 hover:scale-105 active:scale-100 transition-all duration-200">
                            Get started free
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    @endguest

                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-violet-500/25 hover:shadow-lg hover:shadow-violet-500/30 hover:scale-105 active:scale-100 transition-all duration-200">
                            Dashboard
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    @endauth
                </div>
            </nav>

            {{-- Hero Section --}}
            <section class="relative overflow-hidden px-6 pb-32 pt-16 lg:pb-48 lg:pt-28">
                {{-- Vibrant gradient background --}}
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-br from-violet-50 via-white to-fuchsia-50 dark:from-gray-950 dark:via-gray-950 dark:to-violet-950/30"></div>
                <div class="pointer-events-none absolute top-0 left-1/4 right-0 h-[600px] bg-gradient-to-bl from-violet-200/30 via-fuchsia-100/20 to-transparent blur-3xl dark:from-violet-800/10 dark:via-fuchsia-800/5"></div>
                <div class="pointer-events-none absolute bottom-0 left-0 right-1/3 h-[400px] bg-gradient-to-tr from-sky-100/30 via-transparent to-transparent blur-3xl dark:from-sky-800/5"></div>

                {{-- Floating decorative elements --}}
                <div class="pointer-events-none absolute left-[8%] top-24 animate-float text-3xl">📚</div>
                <div class="pointer-events-none absolute right-[12%] top-32 animate-float-delayed text-3xl">🌟</div>
                <div class="pointer-events-none absolute left-[20%] bottom-40 animate-float text-2xl" style="animation-delay: 1.5s;">📖</div>
                <div class="pointer-events-none absolute right-[25%] top-64 animate-wiggle text-2xl">🐛</div>

                <div class="relative mx-auto max-w-4xl text-center">
                    <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-violet-100 to-fuchsia-100 px-5 py-2 text-sm font-semibold text-violet-700 shadow-sm dark:from-violet-900/30 dark:to-fuchsia-900/30 dark:text-violet-300">
                        <span>📖</span>
                        Your reading journey starts here
                    </div>

                    <h1 class="text-5xl font-extrabold leading-tight tracking-tight sm:text-6xl lg:text-7xl">
                        <span class="block text-gray-900 dark:text-gray-100">Track every page,</span>
                        <span class="block bg-gradient-to-r from-violet-600 via-fuchsia-500 to-pink-500 bg-clip-text text-transparent">fall in love with reading</span>
                        <span class="block text-gray-900 dark:text-gray-100">all over again.</span>
                    </h1>

                    <p class="mx-auto mt-6 max-w-2xl text-lg text-gray-500 sm:text-xl dark:text-gray-400">
                        Stint makes it simple to log your reading sessions, build streaks,
                        and look back on everything you've read. Think of it as a cozy reading journal
                        that does the math for you.
                    </p>

                    <div class="mt-10 flex items-center justify-center gap-4">
                        @guest
                            <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-10 py-4 text-base font-bold text-white shadow-lg shadow-violet-500/30 hover:shadow-xl hover:shadow-violet-500/40 hover:scale-105 active:scale-100 transition-all duration-200">
                                Start reading
                                <svg class="h-5 w-5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border-2 border-gray-200 bg-white px-10 py-4 text-base font-bold text-gray-700 hover:border-gray-300 hover:bg-gray-50 hover:shadow-sm active:scale-[0.97] transition-all duration-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:bg-gray-800">
                                Log in
                            </a>
                        @endguest

                        @auth
                            <a href="{{ route('dashboard') }}" class="group inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-10 py-4 text-base font-bold text-white shadow-lg shadow-violet-500/30 hover:shadow-xl hover:shadow-violet-500/40 hover:scale-105 active:scale-100 transition-all duration-200">
                                Go to your library
                                <svg class="h-5 w-5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </section>

            {{-- How It Works --}}
            <section class="relative px-6 py-20 lg:py-28">
                <div class="mx-auto max-w-6xl">
                    <div class="mx-auto max-w-2xl text-center">
                        <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-sky-100 to-cyan-100 px-4 py-1.5 text-sm font-semibold text-sky-700 dark:from-sky-900/30 dark:to-cyan-900/30 dark:text-sky-300">
                            <span>✨</span>
                            Simple as 1-2-3
                        </div>
                        <h2 class="text-4xl font-bold tracking-tight sm:text-5xl text-gray-900 dark:text-gray-100">How it works</h2>
                        <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Three steps to building a reading habit you'll love.</p>
                    </div>

                    <div class="mt-16 grid gap-8 sm:grid-cols-3">
                        <div class="group rounded-3xl bg-gradient-to-b from-white to-gray-50 p-10 text-center shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-xl hover:shadow-violet-500/5 hover:-translate-y-1 dark:from-gray-900 dark:to-gray-950 dark:ring-gray-800">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-100 to-fuchsia-100 text-3xl shadow-sm dark:from-violet-900/30 dark:to-fuchsia-900/30">
                                <span class="animate-float">📖</span>
                            </div>
                            <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-gray-100">Log a session</h3>
                            <p class="mt-3 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Start a timer or enter pages manually. Add the book you're reading and a note about how it felt.</p>
                        </div>

                        <div class="group rounded-3xl bg-gradient-to-b from-white to-gray-50 p-10 text-center shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-xl hover:shadow-violet-500/5 hover:-translate-y-1 dark:from-gray-900 dark:to-gray-950 dark:ring-gray-800">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 text-3xl shadow-sm dark:from-sky-900/30 dark:to-cyan-900/30">
                                <span class="animate-float-delayed">📊</span>
                            </div>
                            <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-gray-100">Watch your progress</h3>
                            <p class="mt-3 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Beautiful stats on your reading time, pages turned, and streaks. Watch your habit take shape.</p>
                        </div>

                        <div class="group rounded-3xl bg-gradient-to-b from-white to-gray-50 p-10 text-center shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-xl hover:shadow-violet-500/5 hover:-translate-y-1 dark:from-gray-900 dark:to-gray-950 dark:ring-gray-800">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-100 to-orange-100 text-3xl shadow-sm dark:from-amber-900/30 dark:to-orange-900/30">
                                <span class="animate-float" style="animation-delay: 2s;">🎯</span>
                            </div>
                            <h3 class="mt-6 text-xl font-bold text-gray-900 dark:text-gray-100">Hit your goals</h3>
                            <p class="mt-3 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Set daily or weekly targets. Build momentum, earn streaks, and surprise yourself with how much you read.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Features --}}
            <section class="relative overflow-hidden px-6 py-20 lg:py-28">
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-violet-50/50 via-white to-transparent dark:from-violet-950/10 dark:via-gray-950"></div>

                <div class="relative mx-auto max-w-6xl">
                    <div class="mx-auto max-w-2xl text-center">
                        <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-fuchsia-100 to-pink-100 px-4 py-1.5 text-sm font-semibold text-fuchsia-700 dark:from-fuchsia-900/30 dark:to-pink-900/30 dark:text-fuchsia-300">
                            <span>🚀</span>
                            Packed with goodies
                        </div>
                        <h2 class="text-4xl font-bold tracking-tight sm:text-5xl text-gray-900 dark:text-gray-100">Everything a reader needs</h2>
                        <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Simple, delightful tools to make tracking your reading feel like second nature.</p>
                    </div>

                    <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="group rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-xl hover:shadow-violet-500/5 hover:-translate-y-1 dark:bg-gray-900 dark:ring-gray-800">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-100 to-fuchsia-100 text-2xl shadow-sm dark:from-violet-900/30 dark:to-fuchsia-900/30">⏱️</div>
                            <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-gray-100">Session Timer</h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Hit start when you sit down to read. Stint quietly tracks your time so you can lose yourself in the story.</p>
                        </div>

                        <div class="group rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-xl hover:shadow-sky-500/5 hover:-translate-y-1 dark:bg-gray-900 dark:ring-gray-800">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 text-2xl shadow-sm dark:from-sky-900/30 dark:to-cyan-900/30">📊</div>
                            <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-gray-100">Reading Stats</h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Colorful charts showing your reading pace, time spent, and streaks. Data that actually motivates you.</p>
                        </div>

                        <div class="group rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-xl hover:shadow-emerald-500/5 hover:-translate-y-1 dark:bg-gray-900 dark:ring-gray-800">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-100 to-teal-100 text-2xl shadow-sm dark:from-emerald-900/30 dark:to-teal-900/30">📚</div>
                            <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-gray-100">Book Library</h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Every book you read, all in one place. Rate them, write notes, and build a personal reading history you'll treasure.</p>
                        </div>

                        <div class="group rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-xl hover:shadow-orange-500/5 hover:-translate-y-1 dark:bg-gray-900 dark:ring-gray-800">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-100 to-orange-100 text-2xl shadow-sm dark:from-amber-900/30 dark:to-orange-900/30">🔥</div>
                            <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-gray-100">Reading Streaks</h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Stay motivated with streaks. Never break the chain — your future self will thank you.</p>
                        </div>

                        <div class="group rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-xl hover:shadow-rose-500/5 hover:-translate-y-1 dark:bg-gray-900 dark:ring-gray-800">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-rose-100 to-pink-100 text-2xl shadow-sm dark:from-rose-900/30 dark:to-pink-900/30">🎯</div>
                            <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-gray-100">Reading Goals</h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Set custom daily and weekly targets. Get gentle nudges and celebrate when you hit them.</p>
                        </div>

                        <div class="group rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-xl hover:shadow-violet-500/5 hover:-translate-y-1 dark:bg-gray-900 dark:ring-gray-800">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-100 to-purple-100 text-2xl shadow-sm dark:from-violet-900/30 dark:to-purple-900/30">✍️</div>
                            <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-gray-100">Session Notes</h3>
                            <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Jot down your thoughts after each session. Remember quotes, impressions, and what stayed with you long after you turned the last page.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Testimonials --}}
            <section class="px-6 py-20 lg:py-28">
                <div class="mx-auto max-w-6xl">
                    <div class="mx-auto max-w-2xl text-center">
                        <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-100 to-orange-100 px-4 py-1.5 text-sm font-semibold text-amber-700 dark:from-amber-900/30 dark:to-orange-900/30 dark:text-amber-300">
                            <span>💬</span>
                            Loved by readers
                        </div>
                        <h2 class="text-4xl font-bold tracking-tight sm:text-5xl text-gray-900 dark:text-gray-100">What readers are saying</h2>
                        <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">From casual page-turners to book club enthusiasts.</p>
                    </div>

                    <div class="mt-12 grid gap-6 lg:grid-cols-3">
                        <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-md dark:bg-gray-900 dark:ring-gray-800">
                            <div class="flex gap-1 text-amber-400 text-lg">
                                <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">&ldquo;I read 12 books this year thanks to Stint. Seeing my streak made me pick up a book even on lazy Sundays.&rdquo;</p>
                            <div class="mt-6 flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-violet-100 to-fuchsia-100 text-sm font-bold text-violet-700 dark:from-violet-900/50 dark:to-fuchsia-900/50 dark:text-violet-300">E</div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-gray-100">Emma Liu</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Avid fiction reader</div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-md dark:bg-gray-900 dark:ring-gray-800">
                            <div class="flex gap-1 text-amber-400 text-lg">
                                <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">&ldquo;Perfect for my book club. I can see what everyone's reading and we all stay accountable to our monthly picks.&rdquo;</p>
                            <div class="mt-6 flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-sky-100 to-cyan-100 text-sm font-bold text-sky-700 dark:from-sky-900/50 dark:to-cyan-900/50 dark:text-sky-300">J</div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-gray-100">James Porter</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Book club organizer</div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 transition-all duration-200 hover:shadow-md dark:bg-gray-900 dark:ring-gray-800">
                            <div class="flex gap-1 text-amber-400 text-lg">
                                <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                            </div>
                            <p class="mt-4 text-sm leading-relaxed text-gray-500 dark:text-gray-400">&ldquo;The session notes feature is everything. I capture quotes and thoughts as I read. It's a reading journal that also tracks stats.&rdquo;</p>
                            <div class="mt-6 flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 text-sm font-bold text-emerald-700 dark:from-emerald-900/50 dark:to-teal-900/50 dark:text-emerald-300">M</div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-gray-100">Maya Rivera</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Non-fiction reader</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Stats Bar --}}
            <section class="px-6 py-16">
                <div class="mx-auto max-w-5xl">
                    <div class="rounded-3xl bg-gradient-to-r from-violet-50 via-fuchsia-50 to-pink-50 p-12 shadow-sm ring-1 ring-violet-100/50 dark:from-violet-950/30 dark:via-fuchsia-950/20 dark:to-pink-950/20 dark:ring-violet-800/20">
                        <div class="grid grid-cols-2 gap-8 lg:grid-cols-4">
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1 text-4xl font-extrabold text-gray-900 lg:text-5xl dark:text-gray-100">
                                    <span>📚</span>
                                    <span>12K+</span>
                                </div>
                                <div class="mt-1 text-sm font-medium text-gray-500 dark:text-gray-400">Books tracked</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1 text-4xl font-extrabold text-gray-900 lg:text-5xl dark:text-gray-100">
                                    <span>⏱️</span>
                                    <span>85K+</span>
                                </div>
                                <div class="mt-1 text-sm font-medium text-gray-500 dark:text-gray-400">Sessions logged</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1 text-4xl font-extrabold text-gray-900 lg:text-5xl dark:text-gray-100">
                                    <span>🔥</span>
                                    <span>4.9</span>
                                </div>
                                <div class="mt-1 text-sm font-medium text-gray-500 dark:text-gray-400">Avg. rating</div>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1 text-4xl font-extrabold text-gray-900 lg:text-5xl dark:text-gray-100">
                                    <span>🎯</span>
                                    <span>99%</span>
                                </div>
                                <div class="mt-1 text-sm font-medium text-gray-500 dark:text-gray-400">Goal achievement</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- CTA Section --}}
            <section class="relative overflow-hidden px-6 py-24 lg:py-36">
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-b from-transparent via-violet-50/50 to-transparent dark:via-violet-950/10"></div>
                <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-[500px] w-[500px] rounded-full bg-gradient-to-r from-violet-200/20 to-fuchsia-200/20 blur-3xl dark:from-violet-800/10 dark:to-fuchsia-800/5"></div>

                <div class="relative mx-auto max-w-3xl text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-violet-100 to-fuchsia-100 text-4xl shadow-sm dark:from-violet-900/30 dark:to-fuchsia-900/30">
                        <span>📚</span>
                    </div>

                    <h2 class="mt-8 text-4xl font-bold tracking-tight sm:text-5xl text-gray-900 dark:text-gray-100">Ready to read more?</h2>
                    <p class="mt-4 text-lg text-gray-500 dark:text-gray-400 max-w-xl mx-auto">Join thousands of readers who use Stint to track their pages, remember their thoughts, and build a lasting reading habit they're proud of.</p>

                    <div class="mt-10 flex items-center justify-center gap-4">
                        @guest
                            <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-10 py-4 text-base font-bold text-white shadow-lg shadow-violet-500/30 hover:shadow-xl hover:shadow-violet-500/40 hover:scale-105 active:scale-100 transition-all duration-200">
                                Get started free
                                <svg class="h-5 w-5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        @endguest

                        @auth
                            <a href="{{ route('dashboard') }}" class="group inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 px-10 py-4 text-base font-bold text-white shadow-lg shadow-violet-500/30 hover:shadow-xl hover:shadow-violet-500/40 hover:scale-105 active:scale-100 transition-all duration-200">
                                Go to your library
                                <svg class="h-5 w-5 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </section>

            {{-- Footer --}}
            <footer class="border-t border-gray-100 bg-white px-6 py-12 dark:border-gray-800 dark:bg-gray-950">
                <div class="mx-auto max-w-6xl">
                    <div class="flex flex-col items-center justify-between gap-6 lg:flex-row">
                        <div class="flex items-center gap-2.5 text-sm">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-500 text-xs text-white shadow-sm">S</span>
                            <span class="font-bold text-gray-800 dark:text-gray-100">{{ config('app.name', 'Stint') }}</span>
                            <span class="text-gray-400 dark:text-gray-500">&copy; {{ date('Y') }}</span>
                        </div>

                        <div class="flex items-center gap-8 text-sm font-medium text-gray-400 dark:text-gray-500">
                            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Privacy</a>
                            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Terms</a>
                            <a href="#" class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Contact</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
