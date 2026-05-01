<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Quiz $quiz)
    {
        return view('questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'type' => 'required|in:binary,single_choice,multiple_choice,number,text',
            'question_text' => 'required|string',
            'image' => 'nullable|image',
            'video_url' => 'nullable|url',
            'marks' => 'required|integer|min:1',
            'correct_answer' => 'nullable|string',
            'options' => 'nullable|array',
            'correct_options' => 'nullable|array',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions', 'public');
        }

        $question = Question::create([
            'quiz_id' => $quiz->id,
            'type' => $validated['type'],
            'question_text' => $validated['question_text'],
            'image' => $imagePath,
            'video_url' => $validated['video_url'] ?? null,
            'marks' => $validated['marks'],
            'correct_answer' => $validated['correct_answer'] ?? null,
        ]);

        if (in_array($validated['type'], ['binary', 'single_choice', 'multiple_choice'])) {
            foreach ($request->options ?? [] as $index => $optionText) {
                if ($optionText !== null && $optionText !== '') {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $optionText,
                        'is_correct' => in_array($index, $request->correct_options ?? []),
                    ]);
                }
            }
        }

        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Question added successfully.');
    }
}