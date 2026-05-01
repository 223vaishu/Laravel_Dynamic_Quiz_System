<h1>Quiz Result</h1>

<h2>{{ $attempt->quiz->title }}</h2>

<p>
    Score: {{ $attempt->score }} / {{ $attempt->total_marks }}
</p>

<hr>

@foreach($attempt->answers as $answer)
    <div>
        <h3>{!! $answer->question->question_text !!}</h3>

        @if($answer->is_correct)
            <p style="color: green;">Correct ✅</p>
        @else
            <p style="color: red;">Incorrect ❌</p>
        @endif

        <p>Marks: {{ $answer->marks_awarded }} / {{ $answer->question->marks }}</p>
    </div>

    <hr>
@endforeach

<a href="{{ route('quizzes.index') }}">Back to Quizzes</a>