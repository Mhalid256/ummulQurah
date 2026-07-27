<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connect with causes that matter. Support children, families and communities in need through transparent charitable giving with {{ config('app.name') }}.">
    <title>{{ config('app.name') }} - Give Hope, Change Lives Today</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #16a34a;
            --primary-dark: #14532d;
            --primary-light: #bbf7d0;
            --secondary: #f97316;
            --accent: #06b6d4;
            --gray-900: #111827;
            --gray-800: #1f2937;
            --gray-700: #374151;
            --gray-600: #4b5563;
            --gray-500: #6b7280;
            --gray-400: #9ca3af;
            --gray-300: #d1d5db;
            --gray-200: #e5e7eb;
            --gray-100: #f3f4f6;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
        }

        html, body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--white);
            color: var(--gray-900);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header Styles */
        header {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        nav a {
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: var(--primary);
        }

        nav a.active {
            color: var(--primary);
        }

        .donate-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .donate-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(22, 163, 74, 0.3);
            color: var(--white);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--gray-900) 0%, var(--gray-800) 100%);
            color: var(--white);
            padding: 80px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(22, 163, 74, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(-20px) translateX(-10px); }
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero h1 .gradient {
            background: linear-gradient(135deg, var(--primary-light), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            color: var(--gray-300);
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(22, 163, 74, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(22, 163, 74, 0.4);
            color: var(--white);
        }

        .btn-secondary {
            background: transparent;
            color: var(--white);
            border: 2px solid var(--white);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: var(--white);
            color: var(--primary);
        }

        /* Stats Section */
        .stats {
            background: var(--gray-100);
            padding: 60px 20px;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            margin-bottom: 50px;
            color: var(--gray-900);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .stat-card {
            background: var(--white);
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
        }

        .stat-card .icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .stat-card .number {
            font-size: 36px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .stat-card .label {
            font-size: 16px;
            color: var(--gray-600);
            font-weight: 500;
        }

        /* Campaigns Section */
        .campaigns {
            padding: 60px 20px;
            background: var(--white);
        }

        .campaigns-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .campaigns-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .campaign-card {
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: slideUp 0.6s ease-out;
        }

        .campaign-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
        }

        .campaign-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            color: var(--white);
            background-size: cover;
            background-position: center;
        }

        .campaign-content {
            padding: 25px;
        }

        .campaign-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--gray-900);
        }

        .campaign-description {
            color: var(--gray-600);
            font-size: 14px;
            margin-bottom: 15px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .progress-bar {
            background: var(--gray-200);
            height: 8px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 10px;
        }

        .progress-fill {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .progress-text {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: var(--gray-700);
            margin-bottom: 15px;
            font-weight: 500;
        }

        .campaign-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: all 0.3s ease;
        }

        .campaign-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(22, 163, 74, 0.3);
            color: var(--white);
        }

        .no-campaigns {
            text-align: center;
            color: var(--gray-500);
            padding: 40px 20px;
            grid-column: 1 / -1;
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, var(--gray-900), var(--gray-800));
            color: var(--white);
            padding: 60px 20px;
            text-align: center;
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 18px;
            margin-bottom: 30px;
            color: var(--gray-300);
        }

        .donation-tiers {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }

        .tier-btn {
            background: rgba(255,255,255,0.1);
            color: var(--white);
            border: 2px solid rgba(255,255,255,0.2);
            padding: 20px 15px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
        }

        .tier-btn:hover {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-color: transparent;
            color: var(--white);
        }

        /* Footer */
        footer {
            background: var(--gray-900);
            color: var(--white);
            padding: 50px 20px 30px;
            border-top: 1px solid var(--gray-800);
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            margin-bottom: 15px;
            color: var(--primary-light);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section a {
            color: var(--gray-400);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--primary);
        }

        .footer-contact {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray-400);
        }

        .newsletter-form {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .newsletter-form input {
            flex: 1;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background: var(--gray-800);
            color: var(--white);
            font-size: 14px;
        }

        .newsletter-form input::placeholder {
            color: var(--gray-500);
        }

        .newsletter-form button {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .newsletter-form button:hover {
            transform: translateY(-2px);
        }

        .newsletter-message {
            font-size: 13px;
            margin-top: 8px;
            color: var(--primary-light);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
            text-decoration: none;
            color: var(--white);
        }

        .social-link:hover {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-color: transparent;
        }

        .footer-bottom {
            border-top: 1px solid var(--gray-800);
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            color: var(--gray-400);
            font-size: 14px;
        }

        /* Session flash message */
        .flash-message {
            max-width: 1200px;
            margin: 20px auto 0;
            padding: 0 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            nav {
                display: none;
            }

            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 16px;
            }

            .section-title {
                font-size: 28px;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .hero-buttons a {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .campaigns-grid {
                grid-template-columns: 1fr;
            }

            .donation-tiers {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    {{-- Session flash message (real backend feedback, e.g. after a donation) --}}
    @if (session('success'))
        <div class="flash-message">
            <div style="background: var(--primary-light); color: var(--primary-dark); padding: 14px 20px; border-radius: 8px; font-weight: 600;">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Header -->
    <header>
        <div class="header-container">
            <a href="{{ route('public.home') }}" class="logo">🤝 {{ config('app.name') }}</a>
            <nav>
                <a href="#campaigns">Campaigns</a>
                <a href="#impact">Impact</a>
                <a href="{{ route('public.about') }}" class="{{ request()->routeIs('public.about') ? 'active' : '' }}">About</a>
                <a href="{{ route('public.contact') }}" class="{{ request()->routeIs('public.contact') ? 'active' : '' }}">Contact</a>
                <a href="{{ route('public.campaigns') }}" class="donate-btn">Donate</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Give <span class="gradient">Hope</span>, Change Lives Today</h1>
            <p>Connect with causes that matter. Support children, families and communities in need through transparent charitable giving with {{ config('app.name') }}.</p>
            <div class="hero-buttons">
                <a href="{{ route('public.campaigns') }}" class="btn-primary">Start Donating</a>
                <a href="#campaigns" class="btn-secondary">See Campaigns</a>
            </div>
        </div>
    </section>

    <!-- Stats Section (rendered server-side from $stats passed by the controller) -->
    <section class="stats" id="impact">
        <div class="stats-container">
            <h2 class="section-title">Our Impact</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="icon">💰</div>
                    <div class="number">{{ number_format($stats['total_raised'], 0) }}</div>
                    <div class="label">Total Raised</div>
                </div>
                <div class="stat-card">
                    <div class="icon">🤝</div>
                    <div class="number">{{ number_format($stats['total_donors']) }}</div>
                    <div class="label">Donors &amp; Sponsors</div>
                </div>
                <div class="stat-card">
                    <div class="icon">🎯</div>
                    <div class="number">{{ number_format($stats['active_campaigns']) }}</div>
                    <div class="label">Active Campaigns</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Campaigns Section (rendered server-side from $featuredCampaigns, no client-side fetch) -->
    <section class="campaigns" id="campaigns">
        <div class="campaigns-container">
            <h2 class="section-title">Featured Campaigns</h2>
            <div class="campaigns-grid">
                @forelse ($featuredCampaigns as $campaign)
                    <div class="campaign-card">
                        <div class="campaign-image"
                            @if($campaign->cover_image)
                                style="background-image: url('{{ asset('storage/'.$campaign->cover_image) }}');"
                            @endif
                        >
                            @if(!$campaign->cover_image)
                                🎯
                            @endif
                        </div>
                        <div class="campaign-content">
                            <div class="campaign-title">{{ $campaign->title }}</div>
                            <div class="campaign-description">{{ $campaign->summary }}</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $campaign->progress_percent }}%"></div>
                            </div>
                            <div class="progress-text">
                                <span>{{ number_format($campaign->raised_amount, 0) }} {{ $campaign->currency }} raised</span>
                                <span>{{ number_format($campaign->goal_amount, 0) }} {{ $campaign->currency }} goal</span>
                            </div>
                            <a href="{{ route('public.campaign.show', $campaign) }}" class="campaign-btn">View &amp; Donate</a>
                        </div>
                    </div>
                @empty
                    <p class="no-campaigns">No active campaigns at the moment. Please check back soon.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="cta">
        <div class="cta-container">
            <h2>Ready to Make an Impact?</h2>
            <p>Every donation, no matter the size, helps us create meaningful change in communities that need it most.</p>
            <div class="donation-tiers">
                {{-- These link into the campaigns listing where a donor picks a campaign and amount.
                     If/when you add a dedicated quick-donate route, swap these hrefs for it,
                     e.g. route('public.donate', ['amount' => 50]) --}}
                <a href="{{ route('public.campaigns') }}" class="tier-btn">$50</a>
                <a href="{{ route('public.campaigns') }}" class="tier-btn">$100</a>
                <a href="{{ route('public.campaigns') }}" class="tier-btn">$250</a>
                <a href="{{ route('public.campaigns') }}" class="tier-btn">$500</a>
            </div>
            <a href="{{ route('public.campaigns') }}" class="btn-primary">Custom Amount</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>{{ config('app.name') }} is dedicated to supporting children, families, and communities in need through transparent charitable giving and meaningful projects.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#campaigns">Our Campaigns</a></li>
                        <li><a href="#impact">Our Impact</a></li>
                        <li><a href="{{ route('public.about') }}">About Us</a></li>
                        <li><a href="{{ route('public.contact') }}">Contact</a></li>
                        <li><a href="{{ route('login') }}">Staff / Donor Login</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <div class="footer-contact">
                        <div class="contact-item">
                            <span>📍</span>
                            <span>Kampala, Uganda</span>
                        </div>
                        <div class="contact-item">
                            <span>📧</span>
                            <span>info@hopefoundation.org</span>
                        </div>
                        <div class="contact-item">
                            <span>📱</span>
                            <span>+256 700 000 000</span>
                        </div>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Stay Updated</h3>
                    <p style="font-size: 14px; margin-bottom: 15px;">Subscribe to get updates on our campaigns and impact stories.</p>

                    {{-- Real POST form — no JS fetch/mock. Wire this route up in web.php
                         (e.g. Route::post('/newsletter', [NewsletterController::class, 'store'])->name('public.newsletter.subscribe');)
                         and it will just work once that controller exists. --}}
                    <form class="newsletter-form" method="POST" action="{{ Route::has('public.newsletter.subscribe') ? route('public.newsletter.subscribe') : '#' }}">
                        @csrf
                        <input type="email" name="email" placeholder="Your email" required>
                        <button type="submit">Subscribe</button>
                    </form>
                    @if (session('newsletter_success'))
                        <div class="newsletter-message">{{ session('newsletter_success') }}</div>
                    @endif

                    <div class="social-links">
                        <a href="#" class="social-link" title="Facebook">f</a>
                        <a href="#" class="social-link" title="Twitter">𝕏</a>
                        <a href="#" class="social-link" title="Instagram">📷</a>
                        <a href="#" class="social-link" title="LinkedIn">in</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
                <div>
                    <a href="#" style="color: var(--gray-400); text-decoration: none;">Privacy Policy</a> |
                    <a href="#" style="color: var(--gray-400); text-decoration: none;">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Purely presentational JS only — no data fetching, no mock data.
        // All numbers/campaigns above are rendered server-side by Blade from $stats / $featuredCampaigns.

        document.querySelectorAll('a[href^="#"]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href').slice(1);
                const targetEl = document.getElementById(targetId);
                if (targetEl) {
                    e.preventDefault();
                    targetEl.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>