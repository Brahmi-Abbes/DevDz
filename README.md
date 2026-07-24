# DevDZ 🇩🇿

> A community platform built by and for Algerian developers — share projects, find jobs, ask questions, and connect with the local dev community.

[![Live Demo](https://img.shields.io/badge/Demo-Live_App-blue?style=for-the-badge)](https://devdz-production.up.railway.app/)
[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)

---

## 📹 Video Preview

https://github.com/user-attachments/assets/14bb56a3-ea57-475d-aaf6-4fd4a10e3e62

---

## ⚡ Overview

DevDZ is a full-stack web app built to solve a real gap for Algerian developers—replacing chaotic Facebook groups with a dedicated developer hub featuring structured posts, voting, comments, and verified developer profiles.

### Tech Stack
* **Backend:** Laravel 11 (Custom Auth, no Breeze/Jetstream)
* **Frontend:** Blade, Tailwind CSS v4, Vite
* **Database:** SQLite (Dev) / MySQL (Production)
* **Hosting:** Railway

---

## ✨ Core Features

* **Posts & Filtering:** Create Projects, Jobs, or Questions with tech tags, city filters, full-text search, and pagination.
* **Reddit-Style Voting:** Atomic upvote/downvote system with real-time score updates and toggle logic (`votes` table with constraints).
* **Comments & Reactions:** Direct post commentary with comment-level likes/dislikes.
* **User Profiles:** Public profile pages at `/users/{id}` displaying stats, user bio, GitHub link, saved posts (`/saved`), and avatar uploads.

---

## 🚀 Getting Started

```bash
# Clone & install dependencies
git clone [https://github.com/your-username/devdz.git](https://github.com/your-username/devdz.git) && cd devdz
composer install && npm install

# Setup environment & database
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

# Build & launch
npm run build
php artisan serve
