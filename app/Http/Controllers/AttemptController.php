<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\Answer;
use Illuminate\Http\Request;

class AttemptController extends Controller
{
    public function create(Quiz $quiz)
    {
        $quiz->load('questions.options');
        return view('attempts.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $quiz->load('questions.options');

        $attempt = Attempt::create([
            'quiz_id' => $quiz->id,
            'score' => 0,
            'total_marks' => $quiz->questions->sum('marks'),
        ]);

        $score = 0;

        foreach ($quiz->questions as $question) {
            $submittedAnswer = $request->input('answers.' . $question->id);
            $isCorrect = false;
            $marksAwarded = 0;
            $selectedOptions = null;
            $answerText = null;
            $answerNumber = null;

            if (in_array($question->type, ['binary', 'single_choice'])) {
                $selectedOptions = $submittedAnswer ? [(int) $submittedAnswer] : [];

                $correctOption = $question->options
                    ->where('is_correct', true)
                    ->pluck('id')
                    ->map(fn ($id) => (int) $id)
                    ->values()
                    ->toArray();

                $isCorrect = $selectedOptions === $correctOption;
            }

            if ($question->type === 'multiple_choice') {
                $selectedOptions = array_map('intval', $submittedAnswer ?? []);
                sort($selectedOptions);

                $correctOptions = $question->options
                    ->where('is_correct', true)
                    ->pluck('id')
                    ->map(fn ($id) => (int) $id)
                    ->values()
                    ->toArray();

                sort($correctOptions);

                $isCorrect = $selectedOptions === $correctOptions;
            }

            if ($question->type === 'number') {
                $answerNumber = $submittedAnswer;
                $isCorrect = (float) $submittedAnswer == (float) $question->correct_answer;
            }

            if ($question->type === 'text') {
                $answerText = $submittedAnswer;
                $isCorrect = strtolower(trim($submittedAnswer)) === strtolower(trim($question->correct_answer));
            }

            if ($isCorrect) {
                $marksAwarded = $question->marks;
                $score += $marksAwarded;
            }

            Answer::create([
                'attempt_id' => $attempt->id,
                'question_id' => $question->id,
                'answer_text' => $answerText,
                'answer_number' => $answerNumber,
                'selected_options' => $selectedOptions,
                'is_correct' => $isCorrect,
                'marks_awarded' => $marksAwarded,
            ]);
        }

        $attempt->update([
            'score' => $score,
        ]);

        return redirect()->route('attempts.result', $attempt);
    }

    public function result(Attempt $attempt)
    {
        $attempt->load('quiz', 'answers.question.options');
        return view('attempts.result', compact('attempt'));
    }
}