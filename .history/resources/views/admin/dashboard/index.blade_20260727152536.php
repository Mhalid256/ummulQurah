<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modern Soft Dashboard</title>
    <!-- Google Fonts & Boxicons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <style>
        :root {
            /* Main Theme Colors (Green & Blue) */
            --bg-main: #f0fdfa; /* Light mint/cyan soft background */
            --sidebar-bg: #ffffff;
            --primary-blue: #2563eb;
            --primary-teal: #0d9488;
            --gradient-accent: linear-gradient(135deg, #0d9488 0%, #2563eb 100%);
            --card-bg: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --card-border: rgba(226, 232, 240, 0.8);
            
            /* Pastel Accent Badges */
            --badge-teal: #ccfbf1;
            --badge-blue: #dbeafe;
            --badge-green: #dcfce7;
            --badge-purple: #f3e8ff;
            --badge-orange: #ffedd5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
            padding: 20px;
            gap: 24px;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg);
            border-radius: 28px;
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.03);
            border: 1px solid var(--card-border);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 32px;
            padding-left: 10px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: var(--gradient-accent);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            box-shadow: 0 8px 16px rgba(13, 148, 136, 0.25);
        }

        .nav-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 15px;
            border-radius: 18px;
            transition: all 0.2s ease;
        }

        .nav-item.active a, .nav-item a:hover {
            background: #e0f2fe;
            color: #0284c7;
        }

        .nav-item.active a i {
            color: #0284c7;
        }

        /* --- MAIN CONTENT --- */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* NAVBAR / HEADER */
        .header {
            background: var(--card-bg);
            padding: 16px 28px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--card-border);
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: #f8fafc;
            padding: 10px 18px;
            border-radius: 16px;
            width: 320px;
            gap: 10px;
            border: 1px solid #f1f5f9;
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 14px;
            color: var(--text-dark);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #bfdbfe;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            object-fit: cover;
        }

        /* BANNER CARD */
        .welcome-banner {
            background: var(--gradient-accent);
            border-radius: 28px;
            padding: 36px 40px;
            color: white;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 15px 30px rgba(13, 148, 136, 0.2);
        }

        .banner-text h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .banner-text p {
            opacity: 0.9;
            font-size: 15px;
            max-width: 450px;
            line-height: 1.5;
        }

        .banner-btn {
            margin-top: 20px;
            padding: 12px 24px;
            background: white;
            color: var(--primary-teal);
            border: none;
            border-radius: 16px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .banner-btn:hover {
            transform: translateY(-2px);
        }

        /* GRID METRICS */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .metric-card {
            background: var(--card-bg);
            padding: 22px;
            border-radius: 24px;
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            gap: 16px;
            transition: transform 0.2s ease;
        }

        .metric-card:hover {
            transform: translateY(-4px);
        }

        .card-icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .metric-info h3 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .metric-info p {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 600;
            margin-top: 4px;
        }

        /* RECENT ACTIVITY / TABLES */
        .content-section {
            background: var(--card-bg);
            border-radius: 28px;
            padding: 28px;
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 18px;
            font-weight: 700;
        }

        .activity-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px dashed #f1f5f9;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-details {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
        }

        .status-completed {
            background: var(--badge-green);
            color: #15803d;
        }

        .status-pending {
            background: var(--badge-orange);
            color: #c2410c;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div>
            <div class="brand">
                <div class="brand-icon">
                    <i class="bx bxs-dashboard"></i>
                </div>
                <span>Analytics</span>
            </div>

            <ul class="nav-menu">
                <li class="nav-item active">
                    <a href="#"><i class="bx bxs-grid-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="bx bxs-bar-chart-alt-2"></i> Analytics</a>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="bx bxs-folder-open"></i> Projects</a>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="bx bxs-message-square-dots"></i> Messages</a>
                </li>
                <li class="nav-item">
                    <a href="#"><i class="bx bxs-cog"></i> Settings</a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="header">
            <div class="search-bar">
                <i class="bx bx-search" style="color: var(--text-muted)"></i>
                <input type="text" placeholder="Search anything..." />
            </div>

            <div class="user-profile">
                <i class="bx bx-bell" style="font-size: 22px; color: var(--text-muted); cursor: pointer;"></i>
                <img src="https://api.dicebear.com/7.x/bottts/svg?seed=ClayAvatar" class="user-avatar" alt="User Avatar" />
            </div>
        </header>

        <!-- BANNER -->
        <section class="welcome-banner">
            <div class="banner-text">
                <h1>Welcome Back, Alex! 👋</h1>
                <p>Your platform activity grew by 24% this week. Here is an overview of your progress and stats.</p>
                <button class="banner-btn">Explore Metrics</button>
            </div>
        </section>

        <!-- METRICS CARDS -->
        <section class="metrics-grid">
            <div class="metric-card">
                <div class="card-icon-wrapper" style="background: var(--badge-teal); color: var(--primary-teal);">
                    <i class="bx bxs-wallet"></i>
                </div>
                <div class="metric-info">
                    <h3>$12,480</h3>
                    <p>Total Balance</p>
                </div>
            </div>

            <div class="metric-card">
                <div class="card-icon-wrapper" style="background: var(--badge-blue); color: var(--primary-blue);">
                    <i class="bx bxs-user-detail"></i>
                </div>
                <div class="metric-info">
                    <h3>1,240</h3>
                    <p>Active Users</p>
                </div>
            </div>

            <div class="metric-card">
                <div class="card-icon-wrapper" style="background: var(--badge-green); color: #16a34a;">
                    <i class="bx bxs-check-shield"></i>
                </div>
                <div class="metric-info">
                    <h3>98.5%</h3>
                    <p>Success Rate</p>
                </div>
            </div>

            <div class="metric-card">
                <div class="card-icon-wrapper" style="background: var(--badge-purple); color: #9333ea;">
                    <i class="bx bxs-time-five"></i>
                </div>
                <div class="metric-info">
                    <h3>34.2 hrs</h3>
                    <p>Hours Logged</p>
                </div>
            </div>
        </section>

        <!-- RECENT ACTIVITY -->
        <section class="content-section">
            <div class="section-header">
                <h2>Recent Transactions</h2>
                <i class="bx bx-dots-horizontal-rounded" style="font-size: 20px; color: var(--text-muted);"></i>
            </div>

            <div class="activity-item">
                <div class="activity-details">
                    <div class="card-icon-wrapper" style="background: var(--badge-teal); color: var(--primary-teal); width: 42px; height: 42px; font-size: 18px;">
                        <i class="bx bxs-shopping-bag"></i>
                    </div>
                    <div>
                        <strong style="display: block; font-size: 15px;">Store Earnings</strong>
                        <span style="font-size: 13px; color: var(--text-muted);">Today, 2:45 PM</span>
                    </div>
                </div>
                <span class="status-badge status-completed">+$320.00</span>
            </div>

            <div class="activity-item">
                <div class="activity-details">
                    <div class="card-icon-wrapper" style="background: var(--badge-orange); color: #ea580c; width: 42px; height: 42px; font-size: 18px;">
                        <i class="bx bxs-credit-card"></i>
                    </div>
                    <div>
                        <strong style="display: block; font-size: 15px;">Server Renewal</strong>
                        <span style="font-size: 13px; color: var(--text-muted);">Yesterday, 11:20 AM</span>
                    </div>
                </div>
                <span class="status-badge status-pending">-$45.00</span>
            </div>
        </section>

    </main>

</body>
</html>