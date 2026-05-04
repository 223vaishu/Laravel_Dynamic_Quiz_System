@extends('layouts.app')

@section('title', 'Create Quiz')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">
        <section class="rounded-[2rem] border border-slate-200 bg-white/95 p-8 shadow-xl shadow-slate-200/50 backdrop-blur-md">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-4xl font-semibold tracking-tight text-slate-900">Create Quiz</h1>
                    <p class="mt-2 text-slate-500">Build a new quiz to capture questions, set marks, and track results in a modern experience.</p>
                </div>
                <a href="{{ route('quizzes.index') }}" class="inline-flex items-center rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-100">Back to Quizzes</a>
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
            <form method="POST" action="{{ route('quizzes.store') }}">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700" for="title">Quiz Title</label>
                        <input id="title" name="title" value="{{ old('title') }}" placeholder="Enter quiz title" class="w-full rounded-3xl border border-slate-300 bg-slate-50 px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700" for="description">Description</label>
                        <textarea id="description" name="description" rows="6" placeholder="Describe the quiz" class="w-full rounded-3xl border border-slate-300 bg-slate-50 px-5 py-4 text-slate-900 shadow-sm outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-indigo-600 px-7 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/15 transition hover:bg-indigo-700">Save Quiz</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection