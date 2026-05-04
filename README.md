

---

# Quiz System (Laravel)

## 📌 Objective

Build a flexible Quiz System that supports multiple question types, media, and evaluation logic.
This project demonstrates Laravel fundamentals, data modeling, extensibility, and clean architecture.

---

## 🚀 Features

### 📝 Quiz Management

* Create quizzes with title and description
* Add multiple questions to a quiz

### ❓ Supported Question Types

1. Binary (Yes/No or True/False)
2. Single Choice (one correct option)
3. Multiple Choice (multiple correct options)
4. Number Input
5. Text Input

### 🛠 Question Editor

* Rich text / HTML support
* Image upload (stored locally)
* Video URL support (e.g., YouTube)

### 🔘 Options Handling

* Options can include:

  * Text
  * Image
  * Or both

### 🎯 Quiz Attempt

* Users can attempt quizzes
* Supports answering all question types
* Submit quiz for evaluation

### 📊 Evaluation Logic

* Each question has configurable marks (default = 1)
* Automatic score calculation
* Result displayed after submission

---

## 🧱 Tech Stack

* **Backend:** Laravel (latest stable)
* **Database:** MySQL / SQLite
* **Frontend:** Blade / Simple JavaScript
* **Storage:** Local filesystem

---

## 🗄 Database Structure

The system is designed with extensibility in mind:

* `quizzes` → Stores quiz metadata
* `questions` → Stores question details and type
* `options` → Stores answer options (if applicable)
* `attempts` → Stores quiz attempts
* `answers` → Stores user responses

---

## ⚙️ Installation & Setup

### 1. Clone Repository

```bash
git clone <your-repo-url>
cd quiz-system
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Update `.env` with your database credentials.

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Storage Link

```bash
php artisan storage:link
```

### 7. Start Server

```bash
php artisan serve
```

---

## 🧪 Usage

1. Create a quiz
2. Add questions with different types
3. Add options (if required)
4. Attempt quiz
5. Submit and view results

---

## 🧩 Design Principles

* **Extensible architecture** for adding new question types
* **Separation of concerns** for clean code
* **Reusable evaluation logic**
* Avoids hardcoded logic per question type

---

## 📁 Project Structure (Overview)

```
app/
 ├── Models/
 ├── Http/
 ├── Services/
database/
 ├── migrations/
resources/
 ├── views/
routes/
 ├── web.php
```

---

## 📄 Additional Documentation

* `ARCHITECTURE.md` → Design decisions & extensibility
* `AI_USAGE.md` → AI prompts, usage, and improvements

---

## 📌 Notes

* Authentication is not implemented (as per requirements)
* System is designed to be easily extendable for future features

---


