<h1>Quiz System</h1>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<a href="{{ route('quizzes.create') }}">Create New Quiz</a>

<hr>

@forelse($quizzes as $quiz)
    <h3>{{ $quiz->title }}</h3>
    <p>{{ $quiz->description }}</p>
    <a href="{{ route('quizzes.show', $quiz) }}">View Quiz</a>
    <hr>
@empty
    <p>No quizzes yet</p>
@endforelse