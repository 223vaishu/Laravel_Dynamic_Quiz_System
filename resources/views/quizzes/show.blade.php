@extends('layouts.app')

@section('title', $quiz->title . ' - Quiz Details')

@section('content')
    <div class="space-y-6">
        <section class="rounded-[2rem] border border-slate-200 bg-white/95 p-8 shadow-xl shadow-slate-200/50 backdrop-blur-md">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-3xl">
                    <h1 class="text-4xl font-semibold tracking-tight text-slate-900">{{ $quiz->title }}</h1>
                    <p class="mt-3 text-lg leading-8 text-slate-600">{{ $quiz->description }}</p>
                </div>
                <div class="flex flex-col gap-3 lg:flex-row">
                    <a href="{{ route('questions.create', $quiz) }}" class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/10 transition hover:bg-indigo-700">
                        Add Question
                    </a>
                    <button onclick="confirmDelete('{{ route('quizzes.destroy', $quiz) }}', '{{ $quiz->title }}', true)" class="inline-flex items-center justify-center rounded-2xl border border-red-300 bg-red-50 px-6 py-3 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-100">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Quiz
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-800 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
        </section>

        <section class="grid gap-6">
            <div class="rounded-[2rem] border border-slate-200 bg-white/95 p-8 shadow-xl shadow-slate-200/40">
                <div class="mb-8 flex items-center gap-3 text-slate-700">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-700">Q</span>
                    <div>
                        <h2 class="text-3xl font-semibold">Questions</h2>
                        <p class="text-sm text-slate-500">Review all questions in this quiz and see correct answers clearly.</p>
                    </div>
                </div>

                @forelse($quiz->questions as $question)
                    <article class="mb-6 rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="space-y-3 flex-1">
                                <h3 class="text-xl font-semibold text-slate-900">{!! $question->question_text !!}</h3>
                                <div class="flex flex-wrap gap-3 text-sm">
                                    <span class="rounded-full bg-indigo-100 px-3 py-1 font-medium text-indigo-700">{{ ucfirst($question->type) }}</span>
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 font-medium text-emerald-700">{{ $question->marks }} marks</span>
                                </div>
                            </div>
                            <button onclick="confirmDeleteQuestion('{{ route('questions.destroy', [$quiz, $question]) }}', 'Question', true)" class="inline-flex items-center justify-center rounded-2xl border border-red-300 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>

                        @if($question->image)
                            <div class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                                <img src="{{ asset('storage/' . $question->image) }}" alt="Question Image" class="w-full object-cover" />
                            </div>
                        @endif

                        @if($question->video_url)
                            <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                                <div class="flex items-center gap-3 text-slate-700">
                                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-100 text-indigo-700">▶</span>
                                    <div>
                                        <p class="text-sm font-semibold">Video Resource</p>
                                        <a href="{{ $question->video_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">{{ $question->video_url }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($question->options->count())
                            <div class="mt-6 space-y-3">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Options</p>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    @foreach($question->options as $option)
                                        <div class="flex items-center justify-between rounded-3xl border px-5 py-4 text-slate-700 transition {{ $option->is_correct ? 'border-emerald-300 bg-emerald-50 shadow-sm' : 'border-slate-200 bg-white' }}">
                                            <span>{{ $option->option_text }}</span>
                                            @if($option->is_correct)
                                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-600 px-3 py-1 text-[0.8rem] font-semibold text-white">Correct</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="mt-6 rounded-3xl border border-yellow-200 bg-yellow-50 p-5 text-slate-700">
                                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-yellow-700">Correct Answer</p>
                                <p class="mt-3 text-base font-medium">{{ $question->correct_answer }}</p>
                            </div>
                        @endif
                    </article>
                @empty
                    <div class="rounded-[1.75rem] border border-dashed border-slate-300 bg-white/80 p-12 text-center text-slate-500">
                        <p class="text-xl font-semibold">No questions added yet.</p>
                        <p class="mt-2">Use the Add Question button above to create your first question.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <div class="flex flex-col gap-4 sm:flex-row sm:justify-center">
            <a href="{{ route('quizzes.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                Back to Quizzes
            </a>
            <a href="{{ route('attempts.create', $quiz) }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/10 transition hover:bg-emerald-700">
                Attempt Quiz
            </a>
        </div>
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="rounded-3xl bg-white p-8 shadow-2xl max-w-sm mx-4 animate-scale-in">
            <svg class="w-14 h-14 text-red-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h2 class="text-2xl font-semibold text-slate-900 text-center mb-2" id="deleteTitle">Delete Item</h2>
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
        function confirmDelete(url, name, redirect = false) {
            document.getElementById('deleteTitle').textContent = 'Delete Quiz';
            document.getElementById('deleteMessage').textContent = `Are you sure you want to delete "${name}"? This action cannot be undone.`;
            document.getElementById('deleteForm').action = url;
            if (redirect) {
                document.getElementById('deleteForm').onsubmit = function() {
                    return true;
                };
            }
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function confirmDeleteQuestion(url, type, redirect = false) {
            document.getElementById('deleteTitle').textContent = 'Delete Question';
            document.getElementById('deleteMessage').textContent = `Are you sure you want to delete this question? This action cannot be undone.`;
            document.getElementById('deleteForm').action = url;
            if (redirect) {
                document.getElementById('deleteForm').onsubmit = function() {
                    return true;
                };
            }
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