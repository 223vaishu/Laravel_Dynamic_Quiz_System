@extends('layouts.app')

@section('title', 'Quiz Results')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <!-- Score Summary -->
        <section class="rounded-[2rem] border border-slate-200 bg-gradient-to-br from-emerald-50 to-blue-50 p-10 shadow-xl">
            <div class="text-center">
                <h1 class="text-5xl font-bold text-slate-900">Quiz Completed!</h1>
                <p class="mt-4 text-xl text-slate-600">{{ $attempt->quiz->title }}</p>
                
                <div class="mt-8 flex justify-center items-center gap-8">
                    <div class="rounded-3xl bg-white p-8 shadow-lg border border-slate-200">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Your Score</p>
                        <p class="mt-3 text-5xl font-bold text-emerald-600">{{ $attempt->score }}/{{ $attempt->total_marks }}</p>
                        <p class="mt-2 text-lg font-semibold text-slate-700">{{ round(($attempt->score / $attempt->total_marks) * 100, 1) }}%</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Results Breakdown -->
        <section class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-lg">
            <h2 class="flex items-center gap-3 mb-8 text-3xl font-semibold text-slate-900">
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-700">✓</span>
                Answer Review
            </h2>

            <div class="space-y-6">
                @foreach($attempt->answers as $answer)
                    <article class="rounded-[1.75rem] border-2 p-6 {{ $answer->is_correct ? 'border-emerald-200 bg-emerald-50' : 'border-red-200 bg-red-50' }}">
                        <!-- Question Header -->
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-slate-900">{!! $answer->question->question_text !!}</h3>
                                <p class="mt-2 text-sm text-slate-600">
                                    <span class="font-medium">Type:</span> {{ ucfirst(str_replace('_', ' ', $answer->question->type)) }} 
                                    | 
                                    <span class="font-medium">Marks:</span> {{ $answer->marks_awarded }}/{{ $answer->question->marks }}
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                @if($answer->is_correct)
                                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Correct
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        Incorrect
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Answer Details -->
                        <div class="mt-6 space-y-4">
                            @if($answer->question->type === 'binary' || $answer->question->type === 'single_choice')
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 mb-2">Your Answer:</p>
                                    @php
                                        $selectedOption = $answer->question->options->firstWhere('id', $answer->selected_options[0] ?? null);
                                    @endphp
                                    <p class="text-slate-900">{{ $selectedOption?->option_text ?? 'Not answered' }}</p>
                                </div>
                                @unless($answer->is_correct)
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700 mb-2">Correct Answer:</p>
                                        @php
                                            $correctOption = $answer->question->options->firstWhere('is_correct', true);
                                        @endphp
                                        <p class="text-emerald-700">{{ $correctOption->option_text }}</p>
                                    </div>
                                @endif
                            @endif

                            @if($answer->question->type === 'multiple_choice')
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 mb-2">Your Answers:</p>
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($answer->selected_options ?? [] as $optionId)
                                            @php
                                                $option = $answer->question->options->find($optionId);
                                            @endphp
                                            <li class="text-slate-900">{{ $option->option_text }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @unless($answer->is_correct)
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700 mb-2">Correct Answers:</p>
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($answer->question->options->where('is_correct', true) as $option)
                                                <li class="text-emerald-700">{{ $option->option_text }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endif

                            @if($answer->question->type === 'number')
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 mb-2">Your Answer:</p>
                                    <p class="text-slate-900">{{ $answer->answer_number ?? 'Not answered' }}</p>
                                </div>
                                @unless($answer->is_correct)
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700 mb-2">Correct Answer:</p>
                                        <p class="text-emerald-700">{{ $answer->question->correct_answer }}</p>
                                    </div>
                                @endif
                            @endif

                            @if($answer->question->type === 'text')
                                <div>
                                    <p class="text-sm font-semibold text-slate-700 mb-2">Your Answer:</p>
                                    <p class="text-slate-900">{{ $answer->answer_text ?? 'Not answered' }}</p>
                                </div>
                                @unless($answer->is_correct)
                                    <div>
                                        <p class="text-sm font-semibold text-slate-700 mb-2">Correct Answer:</p>
                                        <p class="text-emerald-700">{{ $answer->question->correct_answer }}</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <!-- Actions -->
        <div class="flex flex-col gap-4 sm:flex-row sm:justify-center">
            <a href="{{ route('quizzes.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                Back to Quizzes
            </a>
            <a href="{{ route('quizzes.show', $attempt->quiz) }}" class="inline-flex items-center justify-center rounded-2xl border border-indigo-300 bg-indigo-50 px-6 py-3 text-sm font-semibold text-indigo-600 transition hover:bg-indigo-100">
                View Quiz Details
            </a>
        </div>
    </div>
@endsection