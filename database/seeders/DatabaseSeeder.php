<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Vote;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Tags ──────────────────────────────────────────────
        $tag = fn(string $name) => Tag::firstOrCreate(['name' => $name]);

        $laravel    = $tag('laravel');
        $react      = $tag('react');
        $flutter    = $tag('flutter');
        $python     = $tag('python');
        $django     = $tag('django');
        $vue        = $tag('vue');
        $tailwind   = $tag('tailwind');
        $freelance  = $tag('freelance');
        $remote     = $tag('remote');
        $internship = $tag('internship');
        $php        = $tag('php');
        $javascript = $tag('javascript');
        $devdz      = $tag('devdz');

        // ── Users ─────────────────────────────────────────────
        $abbes = User::create([
            'name'       => 'Brahmi Abbes',
            'email'      => 'abbes@devdz.dz',
            'password'   => Hash::make('password'),
            'city'       => 'Sétif',
            'bio'        => 'Full-stack dev, ENSTA student. Building DevDZ — a community platform for Algerian developers.',
            'github_url' => 'https://github.com/abbes',
        ]);

        $yacine = User::create([
            'name'       => 'Yacine Merabet',
            'email'      => 'yacine@devdz.dz',
            'password'   => Hash::make('password'),
            'city'       => 'Algiers',
            'bio'        => 'Laravel developer. 3 years freelancing. Love clean code and coffee.',
            'github_url' => 'https://github.com/yacine-dev',
        ]);

        $amine = User::create([
            'name'       => 'Amine Khelil',
            'email'      => 'amine@devdz.dz',
            'password'   => Hash::make('password'),
            'city'       => 'Oran',
            'bio'        => 'Mobile dev (Flutter). Previously at Sonatrach IT. Open to remote opportunities.',
            'github_url' => 'https://github.com/aminekhelil',
        ]);

        $sara = User::create([
            'name'       => 'Sara Ouali',
            'email'      => 'sara@devdz.dz',
            'password'   => Hash::make('password'),
            'city'       => 'Constantine',
            'bio'        => 'Frontend engineer. React + Tailwind. UI/UX enthusiast.',
            'github_url' => 'https://github.com/sara-ouali',
        ]);

        $riad = User::create([
            'name'     => 'Riad Benali',
            'email'    => 'riad@devdz.dz',
            'password' => Hash::make('password'),
            'city'     => 'Algiers',
            'bio'      => 'Backend engineer. Python/Django. Data pipelines and APIs.',
        ]);

        $hamza = User::create([
            'name'     => 'Hamza Tebbal',
            'email'    => 'hamza@devdz.dz',
            'password' => Hash::make('password'),
            'city'     => 'Annaba',
            'bio'      => 'Computer science student. Learning Laravel. Looking for internship.',
        ]);

        $lina = User::create([
            'name'       => 'Lina Cherif',
            'email'      => 'lina@devdz.dz',
            'password'   => Hash::make('password'),
            'city'       => 'Algiers',
            'bio'        => 'Fullstack dev. Vue.js + Laravel. Freelancer based in Algiers.',
            'github_url' => 'https://github.com/lina-cherif',
        ]);

        $karim = User::create([
            'name'       => 'Karim Saadi',
            'email'      => 'karim@devdz.dz',
            'password'   => Hash::make('password'),
            'city'       => 'Oran',
            'bio'        => 'DevOps engineer. Docker, CI/CD, Linux. Open source contributor.',
            'github_url' => 'https://github.com/karim-saadi',
        ]);

        // ── Posts ─────────────────────────────────────────────
        $devdzAnnouncement = Post::create([
            'user_id' => $abbes->id,
            'title'   => 'Introducing DevDZ — a community platform for Algerian developers 🇩🇿',
            'body'    => "Hey everyone! I've been working on DevDZ for the past few weeks and I'm excited to share it.\n\nDevDZ is a community platform built specifically for Algerian developers — share projects, find jobs, ask questions, and connect with devs across the country.\n\nStack: Laravel 11, Tailwind CSS v4.\n\nWould love your feedback — what features would you like to see next?",
            'type'    => 'project',
            'city'    => 'Sétif',
        ]);
        $devdzAnnouncement->tags()->attach([$laravel->id, $tailwind->id, $devdz->id]);

        $devdzReaction1 = Post::create([
            'user_id' => $yacine->id,
            'title'   => 'DevDZ is exactly what the Algerian dev community needed',
            'body'    => "Just discovered DevDZ and I'm impressed. Clean UI, fast, and actually useful.\n\nAs someone who's been freelancing for 3 years and always struggled to find local opportunities, this fills a real gap.\n\nGreat work @abbes. The Laravel codebase is clean too — I checked the GitHub 👀",
            'type'    => 'project',
            'city'    => 'Algiers',
        ]);
        $devdzReaction1->tags()->attach([$devdz->id, $laravel->id]);

        $devdzReaction2 = Post::create([
            'user_id' => $sara->id,
            'title'   => 'Finally a platform made by and for Algerian devs',
            'body'    => "Been waiting for something like DevDZ for years. Tired of posting on Facebook groups where nobody sees anything.\n\nThe UI is really clean. Is it built with Tailwind? Looks like a lot of care went into the design.",
            'type'    => 'question',
            'city'    => 'Constantine',
        ]);
        $devdzReaction2->tags()->attach([$devdz->id, $tailwind->id]);

        $laravelStructure = Post::create([
            'user_id' => $yacine->id,
            'title'   => 'How I structure large Laravel projects after 3 years of freelancing',
            'body'    => "After 20+ Laravel projects I've settled on a structure that works:\n\n- Feature-based folders inside app/\n- Form Requests for all validation\n- Action classes for business logic\n- Repository pattern only when needed\n- Policies for authorization\n\nThe biggest mistake I see is putting everything in controllers. Keep them thin.",
            'type'    => 'project',
            'city'    => 'Algiers',
        ]);
        $laravelStructure->tags()->attach([$laravel->id, $php->id]);

        $laravelVsReact = Post::create([
            'user_id' => $lina->id,
            'title'   => 'Laravel + Vue.js or Laravel + React — which do you prefer?',
            'body'    => "I've been using Laravel with Vue.js (Inertia) for 2 years but lately I'm seeing more job postings asking for React.\n\nConsidering switching my stack. Anyone using Laravel + React in production? Inertia vs separate API?",
            'type'    => 'question',
            'city'    => 'Algiers',
        ]);
        $laravelVsReact->tags()->attach([$laravel->id, $react->id, $vue->id]);

        $laravelAuth = Post::create([
            'user_id' => $hamza->id,
            'title'   => 'Struggling with Laravel authentication — any good resources?',
            'body'    => "I'm a student learning Laravel trying to build auth from scratch without Breeze.\n\nI understand the basic flow but I'm confused about session handling and CSRF tokens. Any advice from experienced devs?",
            'type'    => 'question',
            'city'    => 'Annaba',
        ]);
        $laravelAuth->tags()->attach([$laravel->id, $php->id]);

        $laravelJob = Post::create([
            'user_id' => $riad->id,
            'title'   => 'Looking for a Laravel developer — remote, serious applicants only',
            'body'    => "Our startup is looking for a mid-level Laravel developer.\n\nRequirements:\n- 2+ years Laravel\n- REST APIs\n- Git workflow\n\nDetails:\n- 100% remote\n- Flexible hours\n- Salary negotiable (DZD)\n\nSend your GitHub and a brief intro.",
            'type'    => 'job',
            'city'    => 'Algiers',
        ]);
        $laravelJob->tags()->attach([$laravel->id, $remote->id, $php->id]);

        $internshipPost = Post::create([
            'user_id' => $karim->id,
            'title'   => 'Internship opportunity — DevOps/Linux at tech company in Oran',
            'body'    => "We're offering a 3-month paid internship for CS students.\n\nYou'll work on:\n- Linux server administration\n- Docker containerization\n- CI/CD pipelines (GitLab)\n\nRequirements: CS student (3rd year+), basic Linux knowledge.\n\nBased in Oran, on-site.",
            'type'    => 'job',
            'city'    => 'Oran',
        ]);
        $internshipPost->tags()->attach([$internship->id]);

        $flutterProject = Post::create([
            'user_id' => $amine->id,
            'title'   => 'Built a Flutter delivery app with Chargily payments — looking for feedback',
            'body'    => "Spent 3 months building a delivery app in Flutter for a client in Oran. Just shipped it.\n\nFeatures:\n- Real-time order tracking\n- Chargily integration (CCP/Baridimob)\n- Arabic + French support\n- Offline mode for delivery agents\n\nHardest part was Chargily integration. Happy to share what I learned.",
            'type'    => 'project',
            'city'    => 'Oran',
        ]);
        $flutterProject->tags()->attach([$flutter->id, $freelance->id]);

        $paymentsQuestion = Post::create([
            'user_id' => $sara->id,
            'title'   => 'How are you handling payments in your Algerian apps in 2026?',
            'body'    => "Chargily seems to be the go-to but I've heard mixed things about reliability.\n\nHas anyone tried direct CCP integration? Or Satim? What's the actual developer experience like?\n\nBuilding a SaaS and need to figure out payments before launch.",
            'type'    => 'question',
            'city'    => 'Constantine',
        ]);
        $paymentsQuestion->tags()->attach([$freelance->id, $laravel->id]);

        $freelanceTips = Post::create([
            'user_id' => $abbes->id,
            'title'   => 'Tips for getting your first freelance client in Algeria',
            'body'    => "After helping a few junior devs land their first clients:\n\n1. Build one real project and put it on GitHub\n2. LinkedIn is underused by Algerian devs — fill your profile\n3. Local Facebook business groups still work for small clients\n4. Your first client comes from your network, not cold outreach\n5. Start cheaper than you think, then raise rates\n\nThe market is growing fast.",
            'type'    => 'project',
            'city'    => 'Sétif',
        ]);
        $freelanceTips->tags()->attach([$freelance->id]);

        $djangoVsLaravel = Post::create([
            'user_id' => $riad->id,
            'title'   => 'Python Django or Laravel for a new SaaS project?',
            'body'    => "Starting a new B2B SaaS and can't decide between Django and Laravel.\n\nI know both reasonably well. The app will be data-heavy with lots of background processing.\n\n- Django: better data science ecosystem, Celery for tasks\n- Laravel: Horizon for queues, cleaner ORM, better SaaS ecosystem\n\nWhat would you choose?",
            'type'    => 'question',
            'city'    => 'Algiers',
        ]);
        $djangoVsLaravel->tags()->attach([$python->id, $django->id, $laravel->id]);

        // ── Comments ──────────────────────────────────────────
        $comments = [
            // DevDZ announcement
            ['post_id' => $devdzAnnouncement->id, 'user_id' => $yacine->id, 'body' => 'This is incredible! Finally something built for us. The UI is clean and the concept is solid. Bookmarked.'],
            ['post_id' => $devdzAnnouncement->id, 'user_id' => $sara->id,   'body' => 'Love this. Is there a roadmap? Would love to see messaging eventually.'],
            ['post_id' => $devdzAnnouncement->id, 'user_id' => $amine->id,  'body' => 'Great work Abbes! Chargily integration for a paid tier would be a perfect fit.'],
            ['post_id' => $devdzAnnouncement->id, 'user_id' => $hamza->id,  'body' => 'Just registered. This is exactly what I needed to find internships locally.'],

            // DevDZ reaction 1
            ['post_id' => $devdzReaction1->id, 'user_id' => $abbes->id, 'body' => 'Thanks Yacine! Would love your feedback on what features to prioritize next.'],
            ['post_id' => $devdzReaction1->id, 'user_id' => $lina->id,  'body' => 'Agreed. Facebook groups are a mess. This is way better.'],

            // DevDZ reaction 2
            ['post_id' => $devdzReaction2->id, 'user_id' => $abbes->id,  'body' => "Yes it's Tailwind CSS v4! Really glad you like it 🙏"],
            ['post_id' => $devdzReaction2->id, 'user_id' => $karim->id,  'body' => 'Shared it with my whole team. Great project.'],

            // Laravel structure
            ['post_id' => $laravelStructure->id, 'user_id' => $lina->id,  'body' => 'This matches how I structure my projects. Thin controllers is the most important rule.'],
            ['post_id' => $laravelStructure->id, 'user_id' => $hamza->id, 'body' => 'Would love a post on the Actions pattern. I always put logic in controllers and it gets messy.'],

            // Laravel auth
            ['post_id' => $laravelAuth->id, 'user_id' => $yacine->id, 'body' => 'Start without Breeze — right call. Read the Laravel docs on session drivers. CSRF is auto-injected by @csrf.'],
            ['post_id' => $laravelAuth->id, 'user_id' => $lina->id,   'body' => 'Laracasts is still the best resource for this. Jeffrey Way explains auth from scratch really well.'],

            // Flutter project
            ['post_id' => $flutterProject->id, 'user_id' => $sara->id, 'body' => 'Would love a blog post or repo about the Chargily integration.'],
            ['post_id' => $flutterProject->id, 'user_id' => $riad->id, 'body' => 'Offline support is hard. Did you use Hive or Isar for local storage?'],

            // Django vs Laravel
            ['post_id' => $djangoVsLaravel->id, 'user_id' => $yacine->id, 'body' => 'Laravel for SaaS, no question. Horizon + Cashier + Telescope make it the best ecosystem.'],
            ['post_id' => $djangoVsLaravel->id, 'user_id' => $lina->id,   'body' => "Depends on the team. If your team knows Python well, Django is fine. But for SaaS Laravel's ecosystem is hard to beat."],
        ];

        Comment::insert(array_map(fn($c) => array_merge($c, [
            'created_at' => now()->subDays(rand(1, 14)),
            'updated_at' => now()->subDays(rand(0, 1)),
        ]), $comments));

        // ── Votes ─────────────────────────────────────────────
        $allUsers = [$abbes, $yacine, $amine, $sara, $riad, $hamza, $lina, $karim];

        $voteSets = [
            $devdzAnnouncement->id => ['up'   => [$yacine, $sara, $amine, $riad, $hamza, $lina, $karim]],
            $devdzReaction1->id    => ['up'   => [$abbes, $sara, $amine, $hamza, $lina, $karim]],
            $devdzReaction2->id    => ['up'   => [$abbes, $yacine, $amine, $riad, $lina]],
            $laravelStructure->id  => ['up'   => [$abbes, $sara, $amine, $hamza, $lina]],
            $flutterProject->id    => ['up'   => [$yacine, $sara, $riad, $lina, $karim]],
            $freelanceTips->id     => ['up'   => [$yacine, $sara, $amine, $riad, $hamza, $lina, $karim]],
            $laravelJob->id        => ['up'   => [$hamza, $abbes, $yacine], 'down' => [$karim]],
            $internshipPost->id    => ['up'   => [$hamza, $abbes]],
            $paymentsQuestion->id  => ['up'   => [$amine, $yacine, $lina]],
            $djangoVsLaravel->id   => ['up'   => [$abbes, $sara, $lina]],
        ];

        $voteRows = [];
        foreach ($voteSets as $postId => $types) {
            foreach ($types as $type => $users) {
                foreach ($users as $user) {
                    $voteRows[] = [
                        'user_id'    => $user->id,
                        'post_id'    => $postId,
                        'type'       => $type,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        DB::table('votes')->insert($voteRows);
    }
}