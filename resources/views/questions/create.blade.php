@extends('layouts.app')

@section('title', 'Add Question')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <section class="rounded-[2rem] border border-slate-200 bg-white/95 p-8 shadow-xl shadow-slate-200/50 backdrop-blur-md">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-4xl font-semibold tracking-tight text-slate-900">Add Question</h1>
                    <p class="mt-2 text-slate-500">Create a question for <span class="font-semibold text-slate-700">{{ $quiz->title }}</span> and configure answers, media, and scoring.</p>
                </div>
                <a href="{{ route('quizzes.show', $quiz) }}" class="inline-flex items-center rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-100">Back to Quiz</a>
            </div>
        </section>

        @if($errors->any())
            <section class="rounded-2xl border border-red-200 bg-red-50 p-5 text-red-700 shadow-sm">
                <h2 class="font-semibold">Please fix the following errors:</h2>
                <ul class="mt-3 list-disc space-y-1 pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </section>
        @endif

        <section class="rounded-[2rem] border border-slate-200 bg-white p-8 shadow-lg shadow-slate-200/40">
            <form method="POST" action="{{ route('questions.store', $quiz) }}" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="type" class="mb-2 block text-sm font-medium text-slate-700">Question Type</label>
                            <select id="type" name="type" class="w-full rounded-3xl border border-slate-300 bg-slate-50 px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100">
                                <option value="binary" {{ old('type') === 'binary' ? 'selected' : '' }}>Binary / True-False</option>
                                <option value="single_choice" {{ old('type') === 'single_choice' ? 'selected' : '' }}>Single Choice</option>
                                <option value="multiple_choice" {{ old('type') === 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="number" {{ old('type') === 'number' ? 'selected' : '' }}>Number Input</option>
                                <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>Text Input</option>
                            </select>
                        </div>

                        <div>
                            <label for="marks" class="mb-2 block text-sm font-medium text-slate-700">Marks</label>
                            <input id="marks" type="number" name="marks" value="{{ old('marks', 1) }}" min="1" class="w-full rounded-3xl border border-slate-300 bg-slate-50 px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                        </div>
                    </div>

                    <div>
                        <label for="question_text" class="mb-2 block text-sm font-medium text-slate-700">Question Text / HTML</label>
                        <textarea id="question_text" name="question_text" rows="5" placeholder="Enter the question text" class="w-full rounded-3xl border border-slate-300 bg-slate-50 px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100">{{ old('question_text') }}</textarea>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="image" class="mb-2 block text-sm font-medium text-slate-700">Image</label>
                            <input id="image" type="file" name="image" class="block w-full text-sm text-slate-600 file:rounded-3xl file:border-0 file:bg-slate-100 file:px-4 file:py-3 file:text-slate-700" />
                        </div>
                        <div>
                            <label for="video_url" class="mb-2 block text-sm font-medium text-slate-700">Video URL</label>
                            <input id="video_url" type="url" name="video_url" value="{{ old('video_url') }}" placeholder="https://example.com" class="w-full rounded-3xl border border-slate-300 bg-slate-50 px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900">Options</h3>
                                <p class="text-sm text-slate-500">Use these for Binary, Single Choice, or Multiple Choice questions.</p>
                            </div>
                        </div>

                        <div class="mt-5 space-y-4">
                            @for($i = 0; $i < 4; $i++)
                                <div class="grid gap-4 sm:grid-cols-[1fr_auto] items-center">
                                    <input type="text" name="options[{{ $i }}]" value="{{ old('options.' . $i) }}" placeholder="Option {{ $i + 1 }}" class="w-full rounded-3xl border border-slate-300 bg-white px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                                    <label class="inline-flex items-center gap-2 rounded-3xl border border-slate-300 bg-white px-4 py-4 text-sm text-slate-700 shadow-sm">
                                        <input type="checkbox" name="correct_options[]" value="{{ $i }}" class="h-4 w-4 rounded border-slate-300 text-indigo-600" {{ is_array(old('correct_options')) && in_array($i, old('correct_options')) ? 'checked' : '' }} />
                                        Correct
                                    </label>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">Correct Answer</h3>
                            <p class="mt-1 text-sm text-slate-500">Use this field for Number Input and Text Input question types.</p>
                        </div>
                        <input type="text" name="correct_answer" value="{{ old('correct_answer') }}" placeholder="Enter the correct answer" class="mt-4 w-full rounded-3xl border border-slate-300 bg-white px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-indigo-600 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/15 transition hover:bg-indigo-700">Save Question</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection