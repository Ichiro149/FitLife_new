<p align="center">
  <img src="https://img.icons8.com/color/96/000000/dumbbell.png" alt="FitLife Logo"/>
</p>

<h1 align="center">🏋️ FitLife</h1>

<p align="center">
  <strong>Your Personal Fitness & Wellness Companion</strong>
</p>

<p align="center">
  <a href="https://github.com/Ichiro149/FitLife_new/actions/workflows/tests.yml">
    <img src="https://github.com/Ichiro149/FitLife_new/actions/workflows/tests.yml/badge.svg" alt="Tests">
  </a>
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white" alt="PHP 8.4">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License MIT">
</p>

<p align="center">
  <a href="#-features">Features</a> •
  <a href="#-tech-stack">Tech Stack</a> •
  <a href="#-installation">Installation</a> •
  <a href="#-testing">Testing</a> •
  <a href="#-screenshots">Screenshots</a>
</p>

---

## 📖 About

**FitLife** is a comprehensive fitness tracking web application designed to help users achieve their health and wellness goals. Track your nutrition, monitor sleep patterns, set fitness goals, and connect with friends on your fitness journey.

## ✨ Features

### 🍎 Nutrition Tracking
- Log daily meals (breakfast, lunch, dinner, snacks)
- Automatic calorie calculation from 40+ foods database
- View meal history and daily summaries
- Personalized nutrition feedback

### 😴 Sleep Monitoring
- Track sleep duration and quality
- Sleep quality ratings (1-5 scale)
- View sleep patterns and statistics
- Get insights for better rest

### 🎯 Goal Management
- Create custom fitness goals
- Track progress with visual indicators
- Log daily achievements
- Multiple goal types support

### 💧 Water Intake
- Log water consumption
- Daily hydration goals
- Visual progress tracking

### 📅 Calendar & Events
- Schedule workouts and activities
- Set reminders for fitness events
- View monthly activity overview

### 👥 Social Features
- Connect with friends
- Share progress and achievements
- Like and comment on posts
- Build your fitness community

### 📊 Dashboard
- Comprehensive overview of all metrics
- Weekly and monthly statistics
- Progress visualization
- Quick access to all features

## 🛠 Tech Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| **PHP** | 8.4 | Backend Language |
| **Laravel** | 11 | PHP Framework |
| **MySQL/SQLite** | 8.0+ | Database |
| **Tailwind CSS** | 3.x | Styling |
| **Vite** | 5.x | Asset Bundling |
| **Pest PHP** | 3.x | Testing Framework |

## 📦 Installation

### Prerequisites
- PHP 8.4+
- Composer 2.x
- Node.js 18+
- MySQL 8.0+ or SQLite

### Setup

```bash
# Clone the repository
git clone https://github.com/Ichiro149/FitLife_new.git
cd FitLife_new

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# (Optional) Seed the database
php artisan db:seed

# Build frontend assets
npm run build

# Start the development server
php artisan serve
```

Visit `http://localhost:8000` in your browser.

### Development Mode

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Start Vite dev server with hot reload
npm run dev
```

## 🧪 Testing

FitLife includes a comprehensive test suite with **243 tests** covering all major features.

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test file
php artisan test --filter=GoalTest

# Run only unit tests
php artisan test --testsuite=Unit

# Run only feature tests
php artisan test --testsuite=Feature
```

### Test Coverage

| Category | Tests | Description |
|----------|-------|-------------|
| Authentication | 14 | Login, Register, Logout |
| Authorization | 12 | Access Control |
| Goals | 18 | CRUD & Progress |
| Posts | 16 | Social Features |
| Comments | 10 | Commenting System |
| Sleep Tracker | 10 | Sleep Logging |
| Food Tracker | 9 | Meal Logging |
| Water Tracker | 7 | Hydration |
| Calendar | 10 | Events |
| Friends | 9 | Social Connections |
| Unit Tests | 45 | Business Logic |

## 📸 Screenshots

<details>
<summary>Click to view screenshots</summary>

### Dashboard
*Your personal fitness overview*

### Goals Tracker
*Set and achieve your fitness goals*

### Nutrition Log
*Track your daily meals and calories*

### Sleep Monitor
*Monitor your sleep quality*

</details>

## 📁 Project Structure

```
FitLife_new/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Request handlers
│   │   ├── Middleware/      # HTTP middleware
│   │   └── Requests/        # Form validation
│   ├── Models/              # Eloquent models
│   ├── Policies/            # Authorization policies
│   └── Providers/           # Service providers
├── database/
│   ├── factories/           # Model factories
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript
│   └── views/               # Blade templates
├── routes/
│   ├── web.php              # Web routes
│   ├── auth.php             # Auth routes
│   └── admin.php            # Admin routes
├── tests/
│   ├── Feature/             # Feature tests
│   └── Unit/                # Unit tests
└── public/                  # Public assets
```

## 🔧 Configuration

Key environment variables:

```env
APP_NAME=FitLife
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fitlife
DB_USERNAME=root
DB_PASSWORD=
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Vladislav** - [@Ichiro149](https://github.com/Ichiro149)

---

<p align="center">
  Made with ❤️ and Laravel
</p>

<p align="center">
  <a href="#-fitlife">Back to top ⬆️</a>
</p>
