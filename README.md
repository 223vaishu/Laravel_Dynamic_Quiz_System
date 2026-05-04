

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

## 🚢 Deployment Guide

### ✅ Pre-Deployment Checklist

- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Generate application key: `php artisan key:generate`
- [ ] Configure database credentials
- [ ] Configure mail driver (if needed)
- [ ] Set up proper file permissions

### 📋 Deployment Commands (in order)

```bash
# 1. Install PHP dependencies (production only)
composer install --optimize-autoloader --no-dev

# 2. Install frontend dependencies
npm install

# 3. Compile assets for production
npm run build

# 4. Generate application key (if not already done)
php artisan key:generate

# 5. Run database migrations
php artisan migrate --force

# 6. Create storage symlink
php artisan storage:link

# 7. Cache configuration & routes for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Clear any existing cache
php artisan cache:clear
```

### 🌐 Deployment Options

#### **Option 1: Shared Hosting (cPanel, Plesk)**
- Upload files via FTP
- Set document root to `public` folder
- Create database and import credentials in `.env`
- Run migrations via SSH or control panel
- Ensure `storage/` and `bootstrap/cache/` are writable

#### **Option 2: VPS (DigitalOcean, Linode, AWS EC2)**
```bash
# SSH into server
ssh user@your-server-ip

# Clone repository
git clone <your-repo-url>
cd quiz-system

# Follow deployment commands above
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan key:generate
php artisan migrate --force
php artisan storage:link
```

Then configure Nginx or Apache to point to `public/` folder.

#### **Option 3: Platform as a Service (Laravel Forge, Heroku, Render)**
- Connect your Git repository
- Set environment variables in dashboard
- Platform automatically runs migrations & builds assets
- Refer to platform-specific documentation

#### **Option 4: Docker**
Create a `Dockerfile`:
```dockerfile
FROM php:8.2-fpm
WORKDIR /app
COPY . .
RUN composer install --no-dev
RUN npm install && npm run build
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
```

### ⚙️ Production Environment Variables (.env)

```env
APP_NAME="Quiz System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=quiz_system
DB_USERNAME=db_user
DB_PASSWORD=strong_password

FILESYSTEM_DISK=public
```

### 🔒 Security Considerations

- Use HTTPS (SSL certificate required)
- Keep `.env` file private (not in version control)
- Set proper file permissions: `chmod -R 755 storage bootstrap/cache`
- Disable directory listing in web server config
- Keep Laravel and dependencies updated
- Use strong database passwords
- Consider adding rate limiting for API endpoints

### 📊 Post-Deployment Checks

1. Test quiz creation and deletion
2. Test question creation with all 5 types
3. Test image uploads
4. Verify email notifications (if configured)
5. Monitor server logs: `tail -f storage/logs/laravel.log`
6. Check storage symlink is working: `ls -la public/storage`

### 🆘 Troubleshooting Deployment

**Permission Denied Errors:**
```bash
sudo chown -R www-data:www-data /path/to/quiz-system
chmod -R 775 storage bootstrap/cache
```

**Database Migration Fails:**
- Verify database connection in `.env`
- Check MySQL user has proper privileges
- Run: `php artisan migrate --force`

**Assets Not Loading:**
```bash
npm run build
php artisan config:cache
```

**File Upload Issues:**
```bash
php artisan storage:link
chmod -R 775 storage/app/public
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


