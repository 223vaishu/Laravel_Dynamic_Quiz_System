<h1>Add Question to: {{ $quiz->title }}</h1>

@if($errors->any())
    @foreach($errors->all() as $error)
        <p style="color:red">{{ $error }}</p>
    @endforeach
@endif

<form method="POST" action="{{ route('questions.store', $quiz) }}" enctype="multipart/form-data">
    @csrf

    <label>Question Type</label><br>
    <select name="type">
        <option value="binary">Binary / True-False</option>
        <option value="single_choice">Single Choice</option>
        <option value="multiple_choice">Multiple Choice</option>
        <option value="number">Number Input</option>
        <option value="text">Text Input</option>
    </select>

    <br><br>

    <label>Question Text / HTML</label><br>
    <textarea name="question_text"></textarea>

    <br><br>

    <label>Image</label><br>
    <input type="file" name="image">

    <br><br>

    <label>Video URL</label><br>
    <input type="url" name="video_url">

    <br><br>

    <label>Marks</label><br>
    <input type="number" name="marks" value="1">

    <br><br>

    <h3>Options</h3>
    <p>Use these for Binary, Single Choice, Multiple Choice.</p>

    <input type="text" name="options[0]" placeholder="Option 1">
    Correct? <input type="checkbox" name="correct_options[]" value="0"><br><br>

    <input type="text" name="options[1]" placeholder="Option 2">
    Correct? <input type="checkbox" name="correct_options[]" value="1"><br><br>

    <input type="text" name="options[2]" placeholder="Option 3">
    Correct? <input type="checkbox" name="correct_options[]" value="2"><br><br>

    <input type="text" name="options[3]" placeholder="Option 4">
    Correct? <input type="checkbox" name="correct_options[]" value="3"><br><br>

    <h3>Correct Answer</h3>
    <p>Use this for Number Input and Text Input.</p>
    <input type="text" name="correct_answer" placeholder="Correct answer">

    <br><br>

    <button type="submit">Save Question</button>
</form>

<br>

<a href="{{ route('quizzes.show', $quiz) }}">Back to Quiz</a>