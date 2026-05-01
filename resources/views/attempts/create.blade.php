<h1>Attempt Quiz: {{ $quiz->title }}</h1>

<form method="POST" action="{{ route('attempts.store', $quiz) }}">
    @csrf

    @foreach($quiz->questions as $question)
        <div style="margin-bottom: 30px;">
            <h3>{!! $question->question_text !!}</h3>
            <p>Marks: {{ $question->marks }}</p>

            @if($question->image)
                <img src="{{ asset('storage/' . $question->image) }}" width="200">
            @endif

            @if($question->video_url)
                <p><a href="{{ $question->video_url }}" target="_blank">Watch Video</a></p>
            @endif

            @if(in_array($question->type, ['binary', 'single_choice']))
                @foreach($question->options as $option)
                    <label>
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}">
                        {{ $option->option_text }}
                    </label><br>
                @endforeach
            @endif

            @if($question->type === 'multiple_choice')
                @foreach($question->options as $option)
                    <label>
                        <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->id }}">
                        {{ $option->option_text }}
                    </label><br>
                @endforeach
            @endif

            @if($question->type === 'number')
                <input type="number" name="answers[{{ $question->id }}]">
            @endif

            @if($question->type === 'text')
                <input type="text" name="answers[{{ $question->id }}]">
            @endif
        </div>
    @endforeach

    <button type="submit">Submit Quiz</button>
</form>