<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connect with causes that matter. Support children, families and communities in need through transparent charitable giving with Ummul Qurah.">
    <title>Ummul Qurah - Give Hope, Change Lives Today</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #dc2626;
            --primary-dark: #991b1b;
            --primary-light: #fecaca;
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

        .donate-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .donate-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);
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
            background: radial-gradient(circle, rgba(220, 38, 38, 0.1) 0%, transparent 70%);
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
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
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

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 40px;
            margin-bottom: 15px;
            color: var(--gray-900);
            font-weight: 700;
        }

        .section-subtitle {
            font-size: 18px;
            color: var(--gray-600);
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
            transition: all 0.3s ease;
        }

        .campaign-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(220, 38, 38, 0.3);
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
            padding: 25px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .tier-btn:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.4);
            transform: translateY(-5px);
        }

        .tier-amount {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .tier-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .benefits {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 50px;
            text-align: left;
        }

        .benefit {
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .benefit-check {
            width: 28px;
            height: 28px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .benefit div {
            font-size: 16px;
            line-height: 1.6;
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

        /* Loading State */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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

            .hero-buttons button {
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
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo">Ummul Qurah</div>
            <nav>
                <a href="#impact">Impact</a>
                <a href="#campaigns">Campaigns</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
                <button class="donate-btn" onclick="scrollToCTA()">Donate Now</button>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Give <span class="gradient">Hope</span>,<br>Change <span class="gradient">Lives</span> Today</h1>
            <p>Connect with causes that matter. Support children, families and communities in need through transparent charitable giving with Ummul Qurah.</p>
            <div class="hero-buttons">
                <button class="btn-primary" onclick="scrollToCTA()">Start Donating</button>
                <button class="btn-secondary" onclick="document.getElementById('campaigns').scrollIntoView({behavior: 'smooth'})">View Campaigns</button>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats" id="impact">
        <div class="stats-container">
            <div class="section-header">
                <h2 class="section-title">Our Impact</h2>
                <p class="section-subtitle">Making a real difference in communities that need it most</p>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="icon">💰</div>
                    <div class="number" id="stat-raised">$0</div>
                    <div class="label">Total Raised</div>
                </div>
                <div class="stat-card">
                    <div class="icon">🤝</div>
                    <div class="number" id="stat-donors">0</div>
                    <div class="label">Active Donors</div>
                </div>
                <div class="stat-card">
                    <div class="icon">🎯</div>
                    <div class="number" id="stat-campaigns">0</div>
                    <div class="label">Active Campaigns</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Campaigns Section -->
    <section class="campaigns" id="campaigns">
        <div class="campaigns-container">
            <div class="section-header">
                <h2 class="section-title">Featured Campaigns</h2>
                <p class="section-subtitle">Support campaigns making real impact in your community</p>
            </div>
            <div class="campaigns-grid" id="campaigns-grid">
                <!-- Campaigns will be loaded here by JavaScript -->
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="cta">
        <div class="cta-container">
            <h2>Ready to Make an Impact?</h2>
            <p>Choose a donation amount that works for you and help us change lives</p>
            <div class="donation-tiers">
                <button class="tier-btn" onclick="handleDonation(25)">
                    <div class="tier-amount">$25</div>
                    <div class="tier-label">Help a child</div>
                </button>
                <button class="tier-btn" onclick="handleDonation(50)">
                    <div class="tier-amount">$50</div>
                    <div class="tier-label">Feed a family</div>
                </button>
                <button class="tier-btn" onclick="handleDonation(100)">
                    <div class="tier-amount">$100</div>
                    <div class="tier-label">Support education</div>
                </button>
                <button class="tier-btn" onclick="handleDonation(250)">
                    <div class="tier-amount">$250</div>
                    <div class="tier-label">Build community</div>
                </button>
            </div>
            <button class="btn-primary" style="margin-bottom: 40px;" onclick="handleCustomDonation()">Proceed to Donation</button>
            <div class="benefits">
                <div class="benefit">
                    <div class="benefit-check">✓</div>
                    <div>100% of your donation goes directly to those in need</div>
                </div>
                <div class="benefit">
                    <div class="benefit-check">✓</div>
                    <div>Your donation is tax-deductible and secure</div>
                </div>
                <div class="benefit">
                    <div class="benefit-check">✓</div>
                    <div>Receive quarterly updates on impact</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>Ummul Qurah is dedicated to supporting children, families, and communities in need through transparent charitable giving and meaningful projects.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#campaigns">Our Campaigns</a></li>
                        <li><a href="#impact">Our Impact</a></li>
                        <li><a href="#">How We Help</a></li>
                        <li><a href="#">Transparency</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <div class="footer-contact">
                        <div class="contact-item">
                            <span>📍</span>
                            <span>123 Charity Avenue, City, Country</span>
                        </div>
                        <div class="contact-item">
                            <span>📧</span>
                            <span>hello@ummulqurah.org</span>
                        </div>
                        <div class="contact-item">
                            <span>📱</span>
                            <span>+1 (555) 123-4567</span>
                        </div>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Stay Updated</h3>
                    <p style="font-size: 14px; margin-bottom: 15px;">Subscribe to get updates on our campaigns and impact stories.</p>
                    <form class="newsletter-form" onsubmit="handleNewsletter(event)">
                        <input type="email" placeholder="Your email" required>
                        <button type="submit">Subscribe</button>
                    </form>
                    <div class="social-links">
                        <a href="#" class="social-link" title="Facebook">f</a>
                        <a href="#" class="social-link" title="Twitter">𝕏</a>
                        <a href="#" class="social-link" title="Instagram">📷</a>
                        <a href="#" class="social-link" title="LinkedIn">in</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div>&copy; 2024 Ummul Qurah. All rights reserved.</div>
                <div>
                    <a href="#" style="color: var(--gray-400); text-decoration: none;">Privacy Policy</a> | 
                    <a href="#" style="color: var(--gray-400); text-decoration: none;">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // API Configuration - Change these to match your Laravel backend URLs
        const API_BASE_URL = 'http://localhost:8000/api'; // Update with your Laravel API URL
        
        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            loadStats();
            loadCampaigns();
        });

        // Load statistics from API
        async function loadStats() {
            try {
                const response = await fetch(`${API_BASE_URL}/stats`);
                if (!response.ok) throw new Error('Failed to fetch stats');
                const data = await response.json();
                
                document.getElementById('stat-raised').textContent = formatCurrency(data.total_raised || 0);
                document.getElementById('stat-donors').textContent = formatNumber(data.total_donors || 0);
                document.getElementById('stat-campaigns').textContent = formatNumber(data.active_campaigns || 0);
            } catch (error) {
                console.error('Error loading stats:', error);
                // Fallback to mock data
                document.getElementById('stat-raised').textContent = '$2,500,000';
                document.getElementById('stat-donors').textContent = '15,420';
                document.getElementById('stat-campaigns').textContent = '28';
            }
        }

        // Load campaigns from API
        async function loadCampaigns() {
            try {
                const response = await fetch(`${API_BASE_URL}/campaigns?featured=true&limit=3`);
                if (!response.ok) throw new Error('Failed to fetch campaigns');
                const data = await response.json();
                
                renderCampaigns(data.data || data);
            } catch (error) {
                console.error('Error loading campaigns:', error);
                // Fallback to mock data
                const mockCampaigns = [
                    {
                        id: 1,
                        title: 'Education for Underprivileged Children',
                        description: 'Help us build a future where every child has access to quality education regardless of their economic background.',
                        emoji: '📚',
                        raised: 45000,
                        goal: 100000,
                        donors: 320
                    },
                    {
                        id: 2,
                        title: 'Emergency Relief Fund',
                        description: 'Provide immediate assistance to families affected by natural disasters and humanitarian crises.',
                        emoji: '🆘',
                        raised: 62000,
                        goal: 150000,
                        donors: 485
                    },
                    {
                        id: 3,
                        title: 'Healthcare Initiative',
                        description: 'Ensure access to basic healthcare services for rural and underserved communities.',
                        emoji: '⚕️',
                        raised: 38000,
                        goal: 80000,
                        donors: 267
                    }
                ];
                renderCampaigns(mockCampaigns);
            }
        }

        // Render campaigns to the grid
        function renderCampaigns(campaigns) {
            const campaignsGrid = document.getElementById('campaigns-grid');
            campaignsGrid.innerHTML = '';
            
            campaigns.forEach(campaign => {
                const progress = (campaign.raised / campaign.goal) * 100;
                const campaignCard = document.createElement('div');
                campaignCard.className = 'campaign-card';
                campaignCard.innerHTML = `
                    <div class="campaign-image">${campaign.emoji || '🎯'}</div>
                    <div class="campaign-content">
                        <div class="campaign-title">${campaign.title}</div>
                        <div class="campaign-description">${campaign.description}</div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: ${progress}%"></div>
                        </div>
                        <div class="progress-text">
                            <span>${formatCurrency(campaign.raised)} raised</span>
                            <span>${formatCurrency(campaign.goal)} goal</span>
                        </div>
                        <button class="campaign-btn" onclick="handleCampaignDonation(${campaign.id}, '${campaign.title}')">View & Donate</button>
                    </div>
                `;
                campaignsGrid.appendChild(campaignCard);
            });
        }

        // Handle donation button click
        function handleDonation(amount) {
            alert(`Thank you for your generosity! Redirecting to payment for $${amount}...`);
            // Replace with your actual donation/payment processing
            // window.location.href = `/donate?amount=${amount}`;
        }

        // Handle custom donation
        function handleCustomDonation() {
            const amount = prompt('Enter donation amount:');
            if (amount && !isNaN(amount) && amount > 0) {
                handleDonation(amount);
            }
        }

        // Handle campaign-specific donation
        function handleCampaignDonation(campaignId, campaignTitle) {
            alert(`Thank you for your interest in "${campaignTitle}"! Redirecting to campaign page...`);
            // Replace with your actual campaign donation page
            // window.location.href = `/campaigns/${campaignId}/donate`;
        }

        // Handle newsletter subscription
        function handleNewsletter(event) {
            event.preventDefault();
            const email = event.target.querySelector('input[type="email"]').value;
            alert(`Thank you for subscribing with ${email}! Check your email for confirmation.`);
            event.target.reset();
        }

        // Scroll to CTA section
        function scrollToCTA() {
            document.getElementById('cta').scrollIntoView({ behavior: 'smooth' });
        }

        // Format currency
        function formatCurrency(value) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 0
            }).format(value);
        }

        // Format number with commas
        function formatNumber(value) {
            return new Intl.NumberFormat('en-US').format(value);
        }

        // Log for debugging
        console.log('Landing page loaded. API Base URL:', API_BASE_URL);
    </script>
</body>
</html>