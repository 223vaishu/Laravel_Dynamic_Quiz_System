@extends('layouts.app')

@section('title', 'Attempt Quiz')

@section('content')
    <div class="mx-auto max-w-5xl space-y-6">
        <section class="rounded-[2rem] border border-slate-200 bg-white/95 p-8 shadow-xl shadow-slate-200/50 backdrop-blur-md">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-4xl font-semibold tracking-tight text-slate-900">Attempt Quiz</h1>
                    <p class="mt-2 text-slate-500">Answer the questions below to submit your attempt for <span class="font-semibold text-slate-700">{{ $quiz->title }}</span>.</p>
                </div>
                <div class="rounded-3xl bg-slate-50 px-5 py-4 text-sm text-slate-600 shadow-sm">
                    <span class="font-semibold">Total Questions:</span> {{ $quiz->questions->count() }}
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-lg shadow-slate-200/40">
            <form method="POST" action="{{ route('attempts.store', $quiz) }}">
                @csrf
                <div class="space-y-8">
                    @foreach($quiz->questions as $question)
                        <article class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6 shadow-sm">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h2 class="text-xl font-semibold text-slate-900">{!! $question->question_text !!}</h2>
                                    <p class="mt-1 text-sm text-slate-500">Marks: <span class="font-medium text-slate-700">{{ $question->marks }}</span></p>
                                </div>
                                <span class="inline-flex items-center rounded-full bg-indigo-100 px-4 py-2 text-sm font-semibold text-indigo-700">{{ ucfirst(str_replace('_', ' ', $question->type)) }}</span>
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
                                            <p class="text-sm font-semibold">Video resource</p>
                                            <a href="{{ $question->video_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">{{ $question->video_url }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-6 space-y-4">
                                @if(in_array($question->type, ['binary', 'single_choice']))
                                    <div class="grid gap-4">
                                        @foreach($question->options as $option)
                                            <label class="cursor-pointer rounded-3xl border border-slate-300 bg-white px-5 py-4 text-slate-700 shadow-sm transition hover:border-indigo-300">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="mr-3 h-4 w-4 text-indigo-600" />
                                                {{ $option->option_text }}
                                            </label>
                                        @endforeach
                                    </div>
                                @endif

                                @if($question->type === 'multiple_choice')
                                    <div class="grid gap-4">
                                        @foreach($question->options as $option)
                                            <label class="cursor-pointer rounded-3xl border border-slate-300 bg-white px-5 py-4 text-slate-700 shadow-sm transition hover:border-indigo-300">
                                                <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->id }}" class="mr-3 h-4 w-4 text-indigo-600" />
                                                {{ $option->option_text }}
                                            </label>
                                        @endforeach
                                    </div>
                                @endif

                                @if($question->type === 'number')
                                    <input type="number" name="answers[{{ $question->id }}]" class="w-full rounded-3xl border border-slate-300 bg-white px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" placeholder="Enter numeric answer" />
                                @endif

                                @if($question->type === 'text')
                                    <input type="text" name="answers[{{ $question->id }}]" class="w-full rounded-3xl border border-slate-300 bg-white px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" placeholder="Enter your answer" />
                                @endif
                            </div>
                        </article>
                    @endforeach

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-emerald-600 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-600/15 transition hover:bg-emerald-700">Submit Quiz</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection