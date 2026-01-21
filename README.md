<div align="center">

# 🏋️ FitLife

### ⚡ Personal Fitness & Wellness Platform

<br/>

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

[![Tests](https://github.com/Ichiro149/FitLife_new/actions/workflows/tests.yml/badge.svg)](https://github.com/Ichiro149/FitLife_new/actions/workflows/tests.yml)
[![Pest](https://img.shields.io/badge/Pest-3.x-F472B6?style=flat-square&logo=php)](https://pestphp.com)
[![Code Style](https://img.shields.io/badge/Code%20Style-Laravel%20Pint-orange?style=flat-square)](https://laravel.com/docs/pint)

<br/>

<p align="center">
  <a href="#-quick-start">Quick Start</a> •
  <a href="#-features">Features</a> •
  <a href="#-screenshots">Screenshots</a> •
  <a href="#-tech-stack">Tech Stack</a> •
  <a href="#-testing">Testing</a>
</p>

<br/>

**Complete fitness tracking solution with Nutrition, Sleep, Goals, Progress Photos & Social Community**

<br/>

> 🌍 **Multi-language**: Supports English, Russian, and Latvian

</div>

<br/>

---

<br/>

## 🚀 Quick Start

```bash
# Clone & Install
git clone https://github.com/Ichiro149/FitLife_new.git
cd FitLife_new && composer install && npm install

# Setup
cp .env.example .env && php artisan key:generate
php artisan migrate --seed && php artisan storage:link

# Run
npm run build && php artisan serve
```

**Visit:** http://localhost:8000

<br/>

---

<br/>

## ✨ Features

<table>
<tr>
<td width="50%">

### 🍎 Health Tracking

- 🍽️ **Meal Tracker** — Log meals with 40+ foods database
- 💧 **Water Tracker** — Daily hydration monitoring
- 😴 **Sleep Tracker** — Duration & quality tracking
- 🔥 **Calorie Calculator** — BMR & macro calculation
- 📊 **Progress Photos** — Visual transformation gallery
- 🎯 **Goals** — Custom fitness goals with progress

</td>
<td width="50%">

### 👥 Social Features

- 📝 **Posts** — Share updates with photo/video
- 💬 **Comments** — Nested replies & likes
- 👫 **Friends** — Connect with fitness buddies
- 👤 **Profiles** — Customizable user profiles
- 📅 **Activity Calendar** — Plan workouts & events
- 🔔 **Notifications** — Stay updated

</td>
</tr>
</table>

<br/>

### 📅 Activity Calendar

<table>
<tr>
<td width="25%" align="center">

**🏃 Workouts**

Running, Cycling,
Swimming, CrossFit

</td>
<td width="25%" align="center">

**🧘 Wellness**

Yoga, Meditation,
Dance, Walking

</td>
<td width="25%" align="center">

**💪 Strength**

Weightlifting, Boxing,
Gym sessions

</td>
<td width="25%" align="center">

**🌿 Recovery**

Rest days, Hiking,
Light activities

</td>
</tr>
</table>

<br/>

### 🔐 Role System

| Role | Access Level |
|:-----|:-------------|
| 🔴 **Admin** | Full system access, user management, content moderation |
| 🟢 **User** | Track health, post updates, connect with friends |

<br/>

### 🌍 Multi-language Support

<table>
<tr>
<td align="center">🇬🇧 <b>English</b></td>
<td align="center">🇷🇺 <b>Русский</b></td>
<td align="center">🇱🇻 <b>Latviešu</b></td>
</tr>
</table>

<br/>

---

<br/>

## 🛠️ Tech Stack

<table>
<tr>
<td align="center" width="20%">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="80"/><br/>
<b>Laravel 11</b><br/>
<sub>Backend Framework</sub>
</td>
<td align="center" width="20%">
<img src="https://www.vectorlogo.zone/logos/tailwindcss/tailwindcss-icon.svg" width="50"/><br/>
<b>Tailwind CSS</b><br/>
<sub>Styling</sub>
</td>
<td align="center" width="20%">
<img src="https://alpinejs.dev/alpine_long.svg" width="80"/><br/>
<b>Alpine.js</b><br/>
<sub>JavaScript</sub>
</td>
<td align="center" width="20%">
<img src="https://vitejs.dev/logo.svg" width="50"/><br/>
<b>Vite</b><br/>
<sub>Build Tool</sub>
</td>
<td align="center" width="20%">
<img src="https://pestphp.com/www/assets/logo.svg" width="50"/><br/>
<b>Pest PHP</b><br/>
<sub>Testing</sub>
</td>
</tr>
</table>

<br/>

| Layer | Technologies |
|:------|:------------|
| **Backend** | PHP 8.4, Laravel 11, Blade Templates |
| **Frontend** | Tailwind CSS 3, Alpine.js, Vite |
| **Database** | MySQL 8.0+ (prod), SQLite (testing) |
| **Testing** | Pest PHP 3.x with parallel execution |

<br/>

---

<br/>

## 🧪 Testing

<div align="center">

```
✅ 243 Tests | ✅ 418 Assertions | ⚡ ~1s (parallel)
```

</div>

<br/>

```bash
# Run all tests
./vendor/bin/pest

# Parallel execution (faster)
./vendor/bin/pest --parallel

# With coverage
./vendor/bin/pest --coverage
```

<br/>

### Test Coverage

| Module | Tests | What's Covered |
|:-------|:-----:|:---------------|
| 🔐 Auth | 15 | Registration, login, password reset |
| 🍽️ Meals | 18 | CRUD, calorie calculation |
| 😴 Sleep | 15 | Logging, duration tracking |
| 💧 Water | 12 | Daily logging, history |
| 🎯 Goals | 21 | CRUD, progress tracking |
| 📝 Posts | 24 | CRUD, media, likes, comments |
| 👫 Friends | 18 | Requests, accept/reject |
| 📅 Calendar | 15 | Events CRUD, filtering |
| 📊 Progress | 12 | Photo upload, gallery |
| 👤 Profile | 18 | Edit, biography, avatar |
| 🛡️ Admin | 15 | Dashboard, user management |

<br/>

---

<br/>

## 📁 Project Structure

```
app/
├── 📂 Http/
│   ├── Controllers/        # Web controllers
│   ├── Middleware/         # Auth, Admin, Locale
│   └── Requests/           # Form validation
│
├── 📂 Models/              # Eloquent models
│   ├── User.php
│   ├── Post.php
│   ├── Goal.php
│   ├── Sleep.php
│   ├── MealLog.php
│   └── ...
│
└── 📂 View/Components/     # Blade components

database/
├── 📂 factories/           # Test factories
├── 📂 migrations/          # Database schema
└── 📂 seeders/             # Sample data

resources/
├── 📂 css/                 # Stylesheets
├── 📂 js/                  # Alpine components
├── 📂 lang/                # Translations (en, ru, lv)
│   ├── en/
│   ├── ru/
│   └── lv/
└── 📂 views/               # Blade templates

tests/
├── 📂 Feature/             # 243 feature tests
└── 📂 Unit/                # Unit tests
```

<br/>

---

<br/>

## ⚙️ Configuration

### Environment Variables

```env
# App
APP_NAME=FitLife
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_DATABASE=fitlife

# Mail (optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

<br/>

---

<br/>

## 🔌 Main Routes

<details>
<summary><b>🏠 Dashboard & Tracking</b></summary>

| Route | Description |
|:------|:------------|
| `/dashboard` | Main dashboard with stats |
| `/foods` | Meal tracker |
| `/sleep` | Sleep tracker |
| `/water` | Water tracker |
| `/goals` | Goals management |
| `/progress` | Progress photos |
| `/calories` | Calorie calculator |

</details>

<details>
<summary><b>👥 Social</b></summary>

| Route | Description |
|:------|:------------|
| `/posts` | Community feed |
| `/profile/{user}` | User profile |
| `/profile/edit` | Edit profile |
| `/profile/friends` | Friends list |

</details>

<details>
<summary><b>📅 Calendar</b></summary>

| Route | Description |
|:------|:------------|
| `/activity-calendar` | Activity calendar |
| `/biography/edit` | Edit biography |
| `/settings` | Language settings |

</details>

<details>
<summary><b>🛡️ Admin</b></summary>

| Route | Description |
|:------|:------------|
| `/admin` | Admin dashboard |
| `/admin/users` | User management |
| `/admin/posts` | Posts moderation |
| `/admin/statistics` | Statistics |

</details>

<br/>

---

<br/>

## 📝 License

This project is open-sourced under the [MIT License](https://opensource.org/licenses/MIT).

<br/>

---

<br/>

<div align="center">

### 🌟 Star this repo if you find it helpful!

<br/>

**Built with ❤️ using**

<br/>

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind](https://img.shields.io/badge/Tailwind-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![Pest](https://img.shields.io/badge/Pest-F472B6?style=for-the-badge&logo=php&logoColor=white)](https://pestphp.com)

<br/>

<sub>Made by <a href="https://github.com/Ichiro149">@Ichiro149</a></sub>

</div>
