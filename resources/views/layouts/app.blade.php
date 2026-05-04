<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quiz System')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-slate-50 via-sky-50 to-indigo-100 min-h-screen font-sans text-slate-900 antialiased">
    <div class="min-h-screen">
        <header class="sticky top-0 z-30 border-b border-slate-200/70 bg-white/90 backdrop-blur-lg shadow-sm">
            <div class="container mx-auto flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 px-4 py-4 sm:px-6">
                <div>
                    <a href="{{ route('quizzes.index') }}" class="inline-flex items-center gap-3 text-slate-900 hover:text-indigo-700">
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-lg">Q</span>
                        <div>
                            <p class="text-base font-semibold tracking-tight">Quiz System</p>
                            <p class="text-sm text-slate-500">Professional quiz management interface</p>
                        </div>
                    </a>
                </div>
                <nav class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('quizzes.index') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-indigo-300 hover:text-indigo-700">All Quizzes</a>
                    <a href="{{ route('quizzes.create') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">Create New Quiz</a>
                </nav>
            </div>
        </header>

        <main class="container mx-auto px-4 py-10 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
