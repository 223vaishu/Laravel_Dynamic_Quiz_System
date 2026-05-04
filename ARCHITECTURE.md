# ARCHITECTURE.md - Quiz System Design & Extensibility

## System Architecture Overview

The Quiz System follows a **modular, data-driven architecture** designed for extensibility and maintainability. It implements Laravel's MVC pattern with clear separation of concerns.

## High-Level Architecture

```
┌─────────────────────────────────────────────────┐
│         Presentation Layer (Blade Views)        │
│  - Quiz Index/Create/Show                       │
│  - Question Editor                              │
│  - Attempt Interface                            │
│  - Results Dashboard                            │
└──────────────┬──────────────────────────────────┘
               │ HTTP Requests/Responses
┌──────────────▼──────────────────────────────────┐
│        Application Layer (Controllers)          │
│  - QuizController (CRUD)                        │
│  - QuestionController (CRUD)                    │
│  - AttemptController (Logic)                    │
└──────────────┬──────────────────────────────────┘
               │ Eloquent Queries
┌──────────────▼──────────────────────────────────┐
│          Data Layer (Models & DB)               │
│  - Quiz, Question, Option                       │
│  - Attempt, Answer (Results)                    │
│  - MySQL/SQLite Database                        │
└─────────────────────────────────────────────────┘
```

## Core Design Patterns

### 1. **Polymorphic Question Types**

Instead of hardcoding logic for each question type, the system uses a **data-driven approach**:

```php
// Question type is stored in database
$question->type ∈ ['binary', 'single_choice', 'multiple_choice', 'number', 'text']

// Same evaluation logic handles all types
if ($question->type === 'binary') { /* logic */ }
if ($question->type === 'single_choice') { /* logic */ }
// ... etc
```

**Why this approach?**
- Easy to add new question types
- No changes to UI (form handles all types generically)
- Database-driven configuration

### 2. **Flexible Option Storage**

```php
// Options can be used or ignored based on question type
Options: Used for binary, single_choice, multiple_choice
Ignored for number, text

// Multiple correct answers supported
Option::create(['option_text' => '...', 'is_correct' => true/false])
```

### 3. **Evaluation Engine**

The `AttemptController@store()` method implements evaluation logic:

```php
foreach ($quiz->questions as $question) {
    // Route to appropriate evaluator
    $isCorrect = evaluateQuestion($question, $submittedAnswer);
    $marksAwarded = $isCorrect ? $question->marks : 0;
    
    Answer::create([...]);
}
```

## Database Schema Design

### Entity Relationship Diagram

```
Quiz (1) ──── (n) Question
 │              │
 │              ├─ (n) Option
 │              │
 │              └─ (n) Answer (results)
 │                      │
 ├─ (n) Attempt ────────┘
 │
 └─ (n) User (future)
```

### Key Design Decisions

**1. Normalized Structure**
- Separate `options` table for flexibility
- `Answer` table stores actual responses
- Cascade deletes on quiz/question deletion

**2. JSON Storage for Complex Data**
```php
Answer.selected_options = JSON array of option IDs
Answer.is_correct = Boolean (for quick filtering)
Answer.marks_awarded = Integer (for scoring)
```

**3. Denormalization for Performance**
```php
Attempt.score = Pre-calculated total
Attempt.total_marks = Pre-calculated max score
```

## Extensibility Framework

### Adding a New Question Type

**Step 1:** Update Database Migration
```php
// In migration, add new type to enum
$table->enum('type', ['binary', 'single_choice', 'multiple_choice', 'number', 'text', 'matching']);
```

**Step 2:** Update Controller - Store Logic
```php
// In QuestionController@store()
if ($request->type === 'matching') {
    // Handle matching-specific option format
}
```

**Step 3:** Update View - Form
```blade
<!-- In questions/create.blade.php -->
@if($question->type === 'matching')
    <!-- Matching pair inputs -->
@endif
```

**Step 4:** Update Controller - Evaluation Logic
```php
// In AttemptController@store()
if ($question->type === 'matching') {
    $isCorrect = compareMatchingPairs($submittedAnswer, $question->options);
}
```

**Step 5:** Update View - Attempt Form
```blade
<!-- In attempts/create.blade.php -->
@if($question->type === 'matching')
    <!-- Matching UI -->
@endif
```

### Future Evaluator Pattern (Recommended)

Instead of if-else chains, create evaluator classes:

```php
// App/Services/Evaluators/QuestionEvaluator.php
abstract class QuestionEvaluator {
    abstract public function evaluate($question, $answer): bool;
}

class BinaryEvaluator extends QuestionEvaluator {
    public function evaluate($question, $answer): bool {
        // Binary evaluation logic
    }
}

class MatchingEvaluator extends QuestionEvaluator {
    public function evaluate($question, $answer): bool {
        // Matching evaluation logic
    }
}

// Usage
$evaluator = EvaluatorFactory::create($question->type);
$isCorrect = $evaluator->evaluate($question, $answer);
```

## Current Question Type Implementation

### Binary (Yes/No, True/False)
- **Storage**: Single option marked as correct
- **Evaluation**: Exact ID match
- **UI**: Radio buttons (forced single selection)

### Single Choice
- **Storage**: Multiple options, one marked correct
- **Evaluation**: Submitted option ID must match correct option ID
- **UI**: Radio buttons

### Multiple Choice
- **Storage**: Multiple options, multiple marked correct
- **Evaluation**: All submitted options must match all correct options (order-independent)
- **UI**: Checkboxes
- **Logic**: Sort arrays, compare equality

### Number Input
- **Storage**: Correct answer in `correct_answer` field
- **Evaluation**: Float comparison (allows tolerance)
- **UI**: Number input field

### Text Input
- **Storage**: Correct answer in `correct_answer` field
- **Evaluation**: Case-insensitive, whitespace-trimmed string comparison
- **UI**: Text input field

## UI/UX Architecture

### Layout System

**Master Layout** (`layouts/app.blade.php`)
- Header with branding
- Navigation
- Container wrapper
- Used by all pages

**View Components**
- Quiz cards
- Question editor form
- Attempt form
- Result cards

### Styling Strategy

**Tailwind CSS Configuration**
```css
/* app.css */
@import 'tailwindcss';

@theme {
    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
}
```

**Design System**
- Color palette: Indigo (primary), Emerald (success), Red (danger)
- Border radius: `rounded-3xl` for modern look
- Shadows: Multi-layer shadows for depth
- Animations: Smooth transitions, scale-in modals

## Code Organization

### Controllers

**QuizController**
- `index()`: List all quizzes
- `create()`: Show creation form
- `store()`: Validate and save
- `show()`: Display details
- `destroy()`: Delete with cascade

**QuestionController**
- `create()`: Question form (type-specific fields)
- `store()`: Parse options based on type
- `destroy()`: Delete with cascade

**AttemptController**
- `create()`: Load quiz with questions
- `store()`: Evaluate all answers, calculate score
- `result()`: Display results

### Models

**Relationships**
```php
Quiz::questions() → hasMany(Question)
Question::options() → hasMany(Option)
Question::quiz() → belongsTo(Quiz)

Attempt::quiz() → belongsTo(Quiz)
Attempt::answers() → hasMany(Answer)

Answer::attempt() → belongsTo(Attempt)
Answer::question() → belongsTo(Question)
```

## Error Handling & Validation

### Input Validation

```php
// Quiz creation
'title' => 'required|string|max:255'
'description' => 'nullable|string'

// Question creation
'type' => 'required|in:binary,single_choice,multiple_choice,number,text'
'question_text' => 'required|string'
'marks' => 'required|integer|min:1'
'image' => 'nullable|image|max:5120'
'video_url' => 'nullable|url'
```

### Evaluation Safety

```php
// Type casting
$selectedOptions = array_map('intval', $submittedAnswer ?? []);

// Null-safe operations
$submittedAnswer = $request->input('answers.' . $question->id);
if ($submittedAnswer === null) { /* handle */ }

// Float comparison for numbers
(float) $submittedAnswer == (float) $question->correct_answer
```

## Performance Considerations

### Database Queries
- Eager loading: `$quiz->load('questions.options')`
- Avoid N+1 queries
- Cascade deletes for referential integrity

### Asset Optimization
- Vite for code splitting
- Tailwind CSS purging
- Lazy loading images
- CDN-ready structure

## Testing & Debugging

### Routes Testing
```bash
# List all routes
php artisan route:list

# Check specific route
php artisan route:show quizzes.store
```

### Database Testing
```bash
# Fresh migration
php artisan migrate:fresh

# Seed sample data
php artisan db:seed
```

## Security Considerations

### CSRF Protection
```blade
<!-- All forms include CSRF token -->
@csrf
@method('DELETE')
```

### Input Sanitization
```php
// HTML preserved in question text
{!! $question->question_text !!} <!-- XSS risk if user-generated -->

// Safe output for options
{{ $option->option_text }}
```

### File Upload Security
```php
if ($request->hasFile('image')) {
    $path = $request->file('image')->store('questions', 'public');
}
```

## Deployment Recommendations

1. **Database**: Use MySQL 8.0+ for JSON support
2. **Storage**: Symlink `/storage/app/public` to `/public/storage`
3. **Caching**: Clear config/view caches after deployment
4. **Assets**: Build with `npm run build` before deploying
5. **Environment**: Set `APP_ENV=production` and `APP_DEBUG=false`

## Monitoring & Analytics (Future)

- Track attempt completion time
- Monitor question difficulty
- Analytics dashboard
- User performance metrics
- Question effectiveness scoring

## Conclusion

The Quiz System architecture prioritizes:
- ✅ **Extensibility**: New question types easily added
- ✅ **Clarity**: Data-driven design, minimal hardcoding
- ✅ **Scalability**: Proper relationships, eager loading
- ✅ **Maintainability**: Clean separation of concerns
- ✅ **UX**: Modern, responsive interface
- ✅ **Performance**: Optimized queries, asset handling
