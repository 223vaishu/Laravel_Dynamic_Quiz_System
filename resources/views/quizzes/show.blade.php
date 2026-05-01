<h1>{{ $quiz->title }}</h1>
<p>{{ $quiz->description }}</p>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<a href="{{ route('questions.create', $quiz) }}">Add Question</a>

<hr>

<h2>Questions</h2>

@forelse($quiz->questions as $question)
    <div>
        <h3>{!! $question->question_text !!}</h3>
        <p>Type: {{ $question->type }}</p>
        <p>Marks: {{ $question->marks }}</p>

        @if($question->image)
            <img src="{{ asset('storage/' . $question->image) }}" width="200">
        @endif

        @if($question->video_url)
            <p>Video: <a href="{{ $question->video_url }}" target="_blank">{{ $question->video_url }}</a></p>
        @endif

        @if($question->options->count())
            <ul>
                @foreach($question->options as $option)
                    <li>
                        {{ $option->option_text }}
                        @if($option->is_correct)
                            ✅
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>Correct Answer: {{ $question->correct_answer }}</p>
        @endif

        <hr>
    </div>
@empty
    <p>No questions added yet.</p>
@endforelse

<a href="{{ route('quizzes.index') }}">Back to Quizzes</a>
<a href="{{ route('attempts.create', $quiz) }}">Attempt Quiz</a>