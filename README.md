# DevDZ 🇩🇿

> A community platform built by and for Algerian developers — share projects, find jobs, ask questions.

[![Live Demo](https://img.shields.io/badge/Demo-Live_App-blue?style=for-the-badge)](https://devdz-production.up.railway.app/)
[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)

**Live:** [devdz-production.up.railway.app](https://devdz-production.up.railway.app/)

https://github.com/user-attachments/assets/14bb56a3-ea57-475d-aaf6-4fd4a10e3e62

---

## Features

- **Posts** — Project / Job / Question types, tag & city filtering, keyword search, sort by Latest or Top
- **Voting** — Reddit-style upvote/downvote with toggle logic (same vote undoes it, opposite switches it)
- **Comments** — with per-comment like/dislike
- **Saved posts** — bookmark anything, manage from `/saved`
- **Profiles** — bio, city, GitHub link, avatar upload, stats
- **Custom auth** — built from scratch (no Breeze/Jetstream) — session handling, hashing, CSRF, middleware all hand-written

## Tech Stack

Laravel 11 · Blade + Tailwind CSS v4 · MySQL/SQLite · Vite · Railway

## Setup

```bash
git clone https://github.com/your-username/devdz.git
cd devdz
composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

npm run build
php artisan serve
```

**Test account:** `abbes@devdz.dz` / `password` (more seeded accounts in `DatabaseSeeder.php`)

## Key design decisions

- **Custom auth over Breeze** — to actually understand Laravel's session/CSRF/middleware layer, not abstract it away
- **Votes table** with `unique(user_id, post_id)` — toggle logic: same vote = undo, opposite = switch
- **Strict componentization** — Blade components only created once a pattern is genuinely reused across views, not preemptively

## Deploying

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
```
