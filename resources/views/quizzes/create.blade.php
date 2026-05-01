<h1>Create Quiz</h1>

@if($errors->any())
    @foreach($errors->all() as $error)
        <p style="color:red">{{ $error }}</p>
    @endforeach
@endif

<form method="POST" action="{{ route('quizzes.store') }}">
    @csrf

    <input type="text" name="title" placeholder="Title"><br><br>

    <textarea name="description" placeholder="Description"></textarea><br><br>

    <button type="submit">Save</button>
</form>

<a href="{{ route('quizzes.index') }}">Back</a>