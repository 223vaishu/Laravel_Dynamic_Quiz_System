@extends('layouts.app')

@section('title', 'Quiz System')

@section('content')
    <div class="space-y-6">
        <section class="rounded-[2rem] border border-slate-200 bg-white/95 p-8 shadow-xl shadow-slate-200/50 backdrop-blur-md">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-4xl font-semibold tracking-tight text-slate-900">Quiz System</h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-500">Manage quizzes, add questions, and launch assessments with a polished interface designed for modern workflows.</p>
                </div>
                <a href="{{ route('quizzes.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/10 transition hover:bg-indigo-700">
                    Create New Quiz
                </a>
            </div>
        </section>

        @if(session('success'))
            <section class="rounded-2xl border border-green-200 bg-green-50 px-6 py-4 text-green-800 shadow-sm">
                {{ session('success') }}
            </section>
        @endif

        <section class="grid gap-4">
            @forelse($quizzes as $quiz)
                <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold text-slate-900">{{ $quiz->title }}</h2>
                            <p class="mt-2 text-slate-600">{{ $quiz->description }}</p>
                        </div>
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <a href="{{ route('quizzes.show', $quiz) }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                View Quiz
                            </a>
                            <button onclick="confirmDelete('{{ route('quizzes.destroy', $quiz) }}', '{{ $quiz->title }}')" class="inline-flex items-center gap-2 rounded-full border border-red-300 bg-red-50 px-5 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-100 hover:border-red-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-[1.75rem] border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                    <p class="text-lg font-medium">No quizzes yet</p>
                    <p class="mt-2 text-sm">Start by creating your first quiz to see it listed here.</p>
                </div>
            @endforelse
        </section>
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="rounded-3xl bg-white p-8 shadow-2xl max-w-sm mx-4 animate-scale-in">
            <svg class="w-14 h-14 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h2 class="text-2xl font-semibold text-slate-900 text-center mb-2">Delete Quiz</h2>
            <p class="text-slate-600 text-center mb-6" id="deleteMessage"></p>
            <div class="flex gap-4 justify-center">
                <button onclick="closeDeleteModal()" class="rounded-2xl border border-slate-300 bg-white px-6 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-2xl bg-red-600 px-6 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        .animate-scale-in {
            animation: scale-in 0.2s ease-out;
        }
    </style>

    <script>
        function confirmDelete(url, name) {
            document.getElementById('deleteMessage').textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
            document.getElementById('deleteForm').action = url;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
@endsection