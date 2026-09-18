<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manhati | Student Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --bg: #07131f;
            --bg-soft: #0b1d2c;
            --card: rgba(11, 29, 44, 0.84);
            --card-strong: rgba(12, 34, 51, 0.95);
            --border: rgba(255,255,255,.09);

            --text: #f5f8fb;
            --muted: #91a7b8;

            --primary: #45d6c8;
            --primary-dark: #19a99b;
            --blue: #6ea8ff;
            --success: #51d88a;
            --warning: #f9c74f;

            --shadow: 0 20px 60px rgba(0,0,0,.25);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            font-family: 'Inter', sans-serif;
            background:
                linear-gradient(
                    rgba(4, 14, 24, .89),
                    rgba(4, 14, 24, .95)
                ),
                url('/images/minhati.jpg') center/cover fixed;
        }

        button,
        a {
            font-family: inherit;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .hidden {
            display: none !important;
        }

        /* =========================
           Loading
        ========================= */

        #loadingScreen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 18px;
        }

        .loader {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(255,255,255,.12);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-text {
            color: var(--muted);
            font-size: 14px;
        }

        /* =========================
           Topbar
        ========================= */

        .topbar {
            position: sticky;
            top: 0;
            z-index: 30;
            border-bottom: 1px solid var(--border);
            background: rgba(5, 18, 29, .88);
            backdrop-filter: blur(20px);
        }

        .topbar-inner {
            width: min(1180px, calc(100% - 32px));
            margin: auto;
            height: 74px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .brand-mark {
            width: 39px;
            height: 39px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), #438cff);
            color: #04131c;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(69,214,200,.25);
        }

        .brand-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -.4px;
        }

        .brand-name span {
            color: var(--primary);
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link,
        .logout-btn {
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 600;
            transition: .2s ease;
        }

        .nav-link {
            color: var(--muted);
        }

        .nav-link:hover {
            color: var(--text);
            background: rgba(255,255,255,.06);
        }

        .logout-btn {
            border: 1px solid var(--border);
            color: #ffb2b2;
            background: rgba(255,255,255,.03);
            cursor: pointer;
        }

        .logout-btn:hover {
            background: rgba(255,90,90,.1);
        }

        /* =========================
           Main
        ========================= */

        main {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 42px 0 70px;
        }

        .hero {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            align-items: flex-end;
            margin-bottom: 30px;
        }

        .eyebrow {
            margin: 0 0 8px;
            text-transform: uppercase;
            letter-spacing: 1.8px;
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
        }

        .hero h1 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(30px, 4vw, 45px);
            line-height: 1.08;
            letter-spacing: -1.3px;
        }

        .hero p {
            margin: 10px 0 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            border: 0;
            border-radius: 12px;
            padding: 12px 16px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: transform .2s ease, opacity .2s ease, background .2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #4ba6ff);
            color: #04141d;
        }

        .btn-secondary {
            color: var(--text);
            background: rgba(255,255,255,.07);
            border: 1px solid var(--border);
        }

        .btn:disabled {
            opacity: .55;
            cursor: wait;
            transform: none;
        }

        /* =========================
           Cards
        ========================= */

        .glass {
            background: var(--card);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            backdrop-filter: blur(18px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .stat-card {
            border-radius: 17px;
            padding: 21px;
            min-height: 126px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            right: -35px;
            bottom: -50px;
            background: radial-gradient(circle, rgba(69,214,200,.18), transparent 70%);
        }

        .stat-label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 17px;
        }

        .stat-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 29px;
            font-weight: 700;
            line-height: 1;
        }

        .stat-note {
            color: var(--muted);
            font-size: 11px;
            margin-top: 10px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(280px, .75fr);
            gap: 18px;
            margin-bottom: 18px;
        }

        .section-card {
            border-radius: 19px;
            padding: 24px;
        }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }

        .section-heading h2 {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 18px;
        }

        .section-heading p {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        .section-tag {
            font-size: 10px;
            color: var(--primary);
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(69,214,200,.08);
            border: 1px solid rgba(69,214,200,.18);
            white-space: nowrap;
        }

        /* =========================
           Best opportunity
        ========================= */

        .best-opportunity {
            border-radius: 16px;
            padding: 22px;
            background:
                linear-gradient(
                    135deg,
                    rgba(69,214,200,.12),
                    rgba(110,168,255,.08)
                );
            border: 1px solid rgba(69,214,200,.17);
        }

        .opportunity-top {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .opportunity-title {
            margin: 0 0 7px;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 21px;
        }

        .provider {
            color: var(--muted);
            font-size: 13px;
        }

        .location {
            color: #c9d6df;
            margin-top: 12px;
            font-size: 13px;
        }

        .match-score {
            width: 76px;
            height: 76px;
            flex: 0 0 76px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border: 6px solid rgba(69,214,200,.3);
            background: rgba(5,20,29,.7);
        }

        .match-score strong {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 19px;
            color: var(--primary);
        }

        .match-score small {
            color: var(--muted);
            font-size: 9px;
        }

        .opportunity-description {
            color: #c0cdd6;
            line-height: 1.65;
            font-size: 13px;
            margin: 20px 0 0;
        }

        /* =========================
           Journey
        ========================= */

        .journey {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .journey-item {
            display: grid;
            grid-template-columns: 30px 1fr;
            gap: 12px;
            min-height: 59px;
        }

        .journey-marker {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .journey-circle {
            width: 25px;
            height: 25px;
            flex: 0 0 25px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.16);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            background: #0a1c29;
        }

        .journey-item.done .journey-circle {
            background: rgba(81,216,138,.15);
            border-color: rgba(81,216,138,.45);
            color: var(--success);
        }

        .journey-line {
            width: 1px;
            flex: 1;
            background: rgba(255,255,255,.1);
        }

        .journey-content strong {
            display: block;
            font-size: 13px;
            margin-top: 3px;
        }

        .journey-content small {
            display: block;
            color: var(--muted);
            margin-top: 4px;
            font-size: 11px;
        }

        /* =========================
           Matches
        ========================= */

        .matches-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .match-card {
            min-height: 180px;
            padding: 18px;
            border-radius: 15px;
            background: rgba(255,255,255,.035);
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
        }

        .match-percent {
            width: fit-content;
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
            padding: 6px 9px;
            border-radius: 999px;
            background: rgba(69,214,200,.09);
        }

        .match-card h3 {
            margin: 15px 0 7px;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 15px;
            line-height: 1.4;
        }

        .match-card .provider {
            font-size: 11px;
        }

        .match-country {
            margin-top: auto;
            padding-top: 16px;
            color: #c8d3da;
            font-size: 11px;
        }

        /* =========================
           Application
        ========================= */

        .application-card {
            border-radius: 15px;
            border: 1px solid var(--border);
            padding: 18px;
            background: rgba(255,255,255,.03);
        }

        .application-card + .application-card {
            margin-top: 10px;
        }

        .application-top {
            display: flex;
            justify-content: space-between;
            gap: 18px;
        }

        .application-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 600;
            font-size: 15px;
        }

        .status-badge {
            flex: 0 0 auto;
            text-transform: capitalize;
            font-size: 10px;
            font-weight: 700;
            padding: 6px 9px;
            border-radius: 999px;
            background: rgba(110,168,255,.11);
            color: #94bdff;
            height: fit-content;
        }

        .application-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 14px;
            color: var(--muted);
            font-size: 11px;
        }

        /* =========================
           Quick actions
        ========================= */

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .quick-action {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 17px;
            background: rgba(255,255,255,.03);
            cursor: pointer;
            transition: .2s;
            text-align: left;
        }

        .quick-action:hover {
            background: rgba(255,255,255,.07);
            transform: translateY(-2px);
        }

        .quick-action strong {
            display: block;
            color: var(--text);
            font-size: 13px;
        }

        .quick-action span {
            display: block;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
            margin-top: 5px;
        }

        /* =========================
           Empty / errors
        ========================= */

        .empty-state {
            padding: 28px 15px;
            text-align: center;
            color: var(--muted);
            border-radius: 14px;
            border: 1px dashed rgba(255,255,255,.12);
        }

        .empty-state strong {
            display: block;
            color: var(--text);
            margin-bottom: 6px;
        }

        /* =========================
           Toast
        ========================= */

        .toast {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 100;
            min-width: 250px;
            max-width: 360px;
            padding: 14px 16px;
            background: #102939;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--shadow);
            font-size: 13px;
            transition: .25s;
        }

        /* =========================
           Responsive
        ========================= */

        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .matches-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 620px) {
            .topbar-inner,
            main {
                width: min(100% - 22px, 1180px);
            }

            .topbar-inner {
                height: 66px;
            }

            .brand-name {
                font-size: 17px;
            }

            .nav-link {
                display: none;
            }

            main {
                padding-top: 27px;
            }

            .hero {
                display: block;
            }

            .hero-actions {
                margin-top: 20px;
            }

            .hero-actions .btn {
                flex: 1;
            }

            .stats-grid,
            .matches-grid,
            .quick-actions {
                grid-template-columns: 1fr;
            }

            .opportunity-top {
                flex-direction: column;
            }

            .match-score {
                width: 67px;
                height: 67px;
                flex-basis: 67px;
            }

            .section-card {
                padding: 18px;
            }
        }
    </style>
</head>

<body>

<div id="loadingScreen">
    <div class="loader"></div>
    <div class="loading-text">Preparing your scholarship dashboard...</div>
</div>

<div id="appShell" class="hidden">

    <header class="topbar">
        <div class="topbar-inner">

            <a href="{{ route('dashboard') }}" class="brand">
                <div class="brand-mark">M</div>
                <div class="brand-name">Manhati<span> AI</span></div>
            </a>

            <div class="top-actions">
                <a class="nav-link" href="{{ route('profile') }}">Profile</a>
                <a class="nav-link" href="{{ route('cv-upload') }}">My CV</a>

                <button
                    id="logoutBtn"
                    class="logout-btn"
                    type="button"
                >
                    Logout
                </button>
            </div>

        </div>
    </header>

    <main>

        <section class="hero">

            <div>
                <p class="eyebrow">Student Dashboard</p>

                <h1 id="welcomeHeading">
                    Welcome back
                </h1>

                <p>
                    Discover the right opportunities, understand your match,
                    and keep your scholarship journey moving forward.
                </p>
            </div>

            <div class="hero-actions">

                <a
                    href="{{ route('cv-upload') }}"
                    class="btn btn-secondary"
                >
                    Upload CV
                </a>

                <button
                    id="refreshRecommendationsBtn"
                    type="button"
                    class="btn btn-primary"
                >
                    Refresh AI Matches
                </button>

            </div>

        </section>

        <!-- Statistics -->
        <section class="stats-grid">

            <div class="stat-card glass">
                <div class="stat-label">AI Scholarship Matches</div>
                <div class="stat-value" id="matchCount">—</div>
                <div class="stat-note">
                    Opportunities matched to your profile
                </div>
            </div>

            <div class="stat-card glass">
                <div class="stat-label">My Applications</div>
                <div class="stat-value" id="applicationCount">—</div>
                <div class="stat-note">
                    Saved and tracked applications
                </div>
            </div>

            <div class="stat-card glass">
                <div class="stat-label">Profile Completion</div>
                <div class="stat-value" id="profileCompletion">—</div>
                <div class="stat-note">
                    Based on your academic profile
                </div>
            </div>

            <div class="stat-card glass">
                <div class="stat-label">Upcoming Deadline</div>
                <div class="stat-value" id="deadlineValue">—</div>
                <div class="stat-note" id="deadlineNote">
                    From your tracked applications
                </div>
            </div>

        </section>

        <section class="dashboard-grid">

            <!-- Best opportunity -->
            <div class="section-card glass">

                <div class="section-heading">
                    <div>
                        <h2>Your Best Opportunity</h2>
                        <p>
                            Highest result from the current matching engine
                        </p>
                    </div>

                    <span class="section-tag">
                        AI MATCH
                    </span>
                </div>

                <div id="bestOpportunity"></div>

            </div>

            <!-- Journey -->
            <div class="section-card glass">

                <div class="section-heading">
                    <div>
                        <h2>Your Journey</h2>
                        <p>Application progress</p>
                    </div>
                </div>

                <div class="journey">

                    <div class="journey-item" id="journeyProfile">
                        <div class="journey-marker">
                            <div class="journey-circle">✓</div>
                            <div class="journey-line"></div>
                        </div>

                        <div class="journey-content">
                            <strong>Build Profile</strong>
                            <small>Academic background and interests</small>
                        </div>
                    </div>

                    <div class="journey-item" id="journeyMatch">
                        <div class="journey-marker">
                            <div class="journey-circle">✓</div>
                            <div class="journey-line"></div>
                        </div>

                        <div class="journey-content">
                            <strong>Discover Matches</strong>
                            <small>AI-powered scholarship matching</small>
                        </div>
                    </div>

                    <div class="journey-item" id="journeyPrepare">
                        <div class="journey-marker">
                            <div class="journey-circle">3</div>
                            <div class="journey-line"></div>
                        </div>

                        <div class="journey-content">
                            <strong>Prepare Application</strong>
                            <small>CV and cover letter preparation</small>
                        </div>
                    </div>

                    <div class="journey-item" id="journeyApply">
                        <div class="journey-marker">
                            <div class="journey-circle">4</div>
                        </div>

                        <div class="journey-content">
                            <strong>Apply & Track</strong>
                            <small>Follow application progress</small>
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <!-- Matches -->
        <section class="section-card glass" style="margin-bottom:18px;">

            <div class="section-heading">
                <div>
                    <h2>Top AI Matches</h2>
                    <p>
                        Scholarships ranked using your current profile
                    </p>
                </div>

                <span id="matchesGeneratedAt" class="section-tag">
                    MATCHING ENGINE
                </span>
            </div>

            <div id="matchesGrid" class="matches-grid"></div>

        </section>

        <section class="dashboard-grid">

            <!-- Applications -->
            <div class="section-card glass">

                <div class="section-heading">
                    <div>
                        <h2>My Applications</h2>
                        <p>Keep track of opportunities you are pursuing</p>
                    </div>
                </div>

                <div id="applicationsList"></div>

            </div>

            <!-- Quick actions -->
            <div class="section-card glass">

                <div class="section-heading">
                    <div>
                        <h2>Quick Actions</h2>
                        <p>Continue your scholarship journey</p>
                    </div>
                </div>

                <div class="quick-actions">

                    <a href="{{ route('profile') }}" class="quick-action">
                        <strong>Update Profile</strong>
                        <span>
                            Keep your academic information accurate.
                        </span>
                    </a>

                    <a href="{{ route('cv-upload') }}" class="quick-action">
                        <strong>Manage CV</strong>
                        <span>
                            Upload your CV and review AI extraction.
                        </span>
                    </a>

                    <button
                        id="refreshRecommendationsQuick"
                        type="button"
                        class="quick-action"
                    >
                        <strong>Generate Matches</strong>
                        <span>
                            Re-run scholarship matching using your latest data.
                        </span>
                    </button>

                </div>

            </div>

        </section>

    </main>

</div>

<div id="toast" class="toast hidden"></div>

<script>
    const API_BASE_URL = "{{ url('/api') }}";
    const LOGIN_URL = "{{ route('login') }}";

    let currentUser = null;
    let currentProfile = null;
    let recommendations = [];
    let applications = [];

    function getToken() {
        return localStorage.getItem('auth_token');
    }

    function goToLogin() {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('auth_user');
        window.location.href = LOGIN_URL;
    }

    function authHeaders() {
        return {
            'Authorization': `Bearer ${getToken()}`,
            'Accept': 'application/json'
        };
    }

    function normalizeCollection(payload) {
        if (Array.isArray(payload)) {
            return payload;
        }

        if (payload && Array.isArray(payload.data)) {
            return payload.data;
        }

        if (payload && Array.isArray(payload.value)) {
            return payload.value;
        }

        return [];
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function showToast(message) {
        const toast = document.getElementById('toast');

        toast.textContent = message;
        toast.classList.remove('hidden');

        clearTimeout(window.manhatiToastTimer);

        window.manhatiToastTimer = setTimeout(() => {
            toast.classList.add('hidden');
        }, 3200);
    }

    function formatDate(dateValue) {
        if (!dateValue) {
            return 'Not specified';
        }

        const date = new Date(dateValue);

        if (Number.isNaN(date.getTime())) {
            return 'Not specified';
        }

        return new Intl.DateTimeFormat('en', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        }).format(date);
    }

    function daysUntil(dateValue) {
        if (!dateValue) {
            return null;
        }

        const target = new Date(dateValue);
        const today = new Date();

        target.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);

        return Math.ceil(
            (target.getTime() - today.getTime()) /
            (1000 * 60 * 60 * 24)
        );
    }

    function calculateProfileCompletion(profile) {
        if (!profile) {
            return 0;
        }

        const fields = [
            profile.academic_background,
            profile.degree_level,
            profile.interests,
            profile.country
        ];

        const completed = fields.filter(value => {
            return value !== null &&
                   value !== undefined &&
                   String(value).trim() !== '';
        }).length;

        return Math.round((completed / fields.length) * 100);
    }

    function getUpcomingApplicationDeadline() {
        const upcoming = applications
            .filter(item => item.scholarship?.application_deadline)
            .map(item => ({
                item,
                days: daysUntil(
                    item.scholarship.application_deadline
                )
            }))
            .filter(entry => entry.days !== null && entry.days >= 0)
            .sort((a, b) => a.days - b.days);

        return upcoming.length ? upcoming[0] : null;
    }

    function renderStats() {
        document.getElementById('matchCount').textContent =
            recommendations.length;

        document.getElementById('applicationCount').textContent =
            applications.length;

        document.getElementById('profileCompletion').textContent =
            `${calculateProfileCompletion(currentProfile)}%`;

        const nearestDeadline = getUpcomingApplicationDeadline();

        const deadlineValue =
            document.getElementById('deadlineValue');

        const deadlineNote =
            document.getElementById('deadlineNote');

        if (!nearestDeadline) {
            deadlineValue.textContent = '—';
            deadlineNote.textContent =
                'No upcoming tracked deadline';
            return;
        }

        if (nearestDeadline.days === 0) {
            deadlineValue.textContent = 'Today';
        } else if (nearestDeadline.days === 1) {
            deadlineValue.textContent = '1 day';
        } else {
            deadlineValue.textContent =
                `${nearestDeadline.days} days`;
        }

        deadlineNote.textContent =
            nearestDeadline.item.scholarship?.title ??
            'Upcoming scholarship deadline';
    }

    function renderBestOpportunity() {
        const container =
            document.getElementById('bestOpportunity');

        if (!recommendations.length) {
            container.innerHTML = `
                <div class="empty-state">
                    <strong>No matches generated yet</strong>
                    Generate your scholarship recommendations
                    to see your strongest opportunity.
                </div>
            `;
            return;
        }

        const best = [...recommendations].sort(
            (a, b) =>
                Number(b.match_score || 0) -
                Number(a.match_score || 0)
        )[0];

        const scholarship = best.scholarship || {};

        container.innerHTML = `
            <div class="best-opportunity">

                <div class="opportunity-top">

                    <div>
                        <h3 class="opportunity-title">
                            ${escapeHtml(
                                scholarship.title ||
                                'Scholarship Opportunity'
                            )}
                        </h3>

                        <div class="provider">
                            ${escapeHtml(
                                scholarship.provider_name ||
                                'Provider not specified'
                            )}
                        </div>

                        <div class="location">
                            ${escapeHtml(
                                scholarship.country ||
                                'International / Not specified'
                            )}
                        </div>
                    </div>

                    <div class="match-score">
                        <strong>
                            ${Math.round(
                                Number(best.match_score || 0)
                            )}%
                        </strong>
                        <small>MATCH</small>
                    </div>

                </div>

                <p class="opportunity-description">
                    ${escapeHtml(
                        scholarship.description ||
                        'No scholarship description is available.'
                    )}
                </p>

            </div>
        `;
    }

    function renderMatches() {
        const grid =
            document.getElementById('matchesGrid');

        if (!recommendations.length) {
            grid.innerHTML = `
                <div class="empty-state"
                     style="grid-column:1/-1;">
                    <strong>No AI matches available</strong>
                    Use “Refresh AI Matches” to generate
                    recommendations from your current profile.
                </div>
            `;

            document.getElementById(
                'matchesGeneratedAt'
            ).textContent = 'MATCHING ENGINE';

            return;
        }

        const sorted = [...recommendations].sort(
            (a, b) =>
                Number(b.match_score || 0) -
                Number(a.match_score || 0)
        );

        const topMatches = sorted.slice(0, 6);

        grid.innerHTML = topMatches.map(item => {
            const scholarship = item.scholarship || {};

            return `
                <article class="match-card">

                    <span class="match-percent">
                        ${Math.round(
                            Number(item.match_score || 0)
                        )}% Match
                    </span>

                    <h3>
                        ${escapeHtml(
                            scholarship.title ||
                            'Scholarship'
                        )}
                    </h3>

                    <div class="provider">
                        ${escapeHtml(
                            scholarship.provider_name ||
                            'Provider not specified'
                        )}
                    </div>

                    <div class="match-country">
                        ${escapeHtml(
                            scholarship.country ||
                            'International'
                        )}
                    </div>

                </article>
            `;
        }).join('');

        const generatedAt =
            recommendations[0]?.generated_at;

        if (generatedAt) {
            document.getElementById(
                'matchesGeneratedAt'
            ).textContent =
                `Updated ${formatDate(generatedAt)}`;
        }
    }

    function renderApplications() {
        const container =
            document.getElementById('applicationsList');

        if (!applications.length) {
            container.innerHTML = `
                <div class="empty-state">
                    <strong>No saved applications yet</strong>
                    When you save a scholarship, its application
                    progress will appear here.
                </div>
            `;
            return;
        }

        const ordered = [...applications].sort(
            (a, b) =>
                new Date(b.status_updated_at || b.saved_at) -
                new Date(a.status_updated_at || a.saved_at)
        );

        container.innerHTML = ordered.map(application => {
            const scholarship =
                application.scholarship || {};

            return `
                <article class="application-card">

                    <div class="application-top">

                        <div>
                            <div class="application-title">
                                ${escapeHtml(
                                    scholarship.title ||
                                    'Scholarship Application'
                                )}
                            </div>

                            <div class="provider"
                                 style="margin-top:5px;">
                                ${escapeHtml(
                                    scholarship.provider_name ||
                                    'Provider not specified'
                                )}
                            </div>
                        </div>

                        <span class="status-badge">
                            ${escapeHtml(
                                application.status || 'saved'
                            )}
                        </span>

                    </div>

                    <div class="application-meta">
                        <span>
                            ${escapeHtml(
                                scholarship.country ||
                                'International'
                            )}
                        </span>

                        <span>
                            Deadline:
                            ${escapeHtml(
                                formatDate(
                                    scholarship.application_deadline
                                )
                            )}
                        </span>

                        <span>
                            Updated:
                            ${escapeHtml(
                                formatDate(
                                    application.status_updated_at
                                )
                            )}
                        </span>
                    </div>

                </article>
            `;
        }).join('');
    }

    function renderJourney() {
        const profileComplete =
            calculateProfileCompletion(currentProfile) > 0;

        const hasMatches =
            recommendations.length > 0;

        const hasApplications =
            applications.length > 0;

        const hasSubmittedApplication =
            applications.some(application => {
                return String(
                    application.status || ''
                ).toLowerCase() === 'submitted';
            });

        document
            .getElementById('journeyProfile')
            .classList.toggle(
                'done',
                profileComplete
            );

        document
            .getElementById('journeyMatch')
            .classList.toggle(
                'done',
                hasMatches
            );

        document
            .getElementById('journeyPrepare')
            .classList.toggle(
                'done',
                hasApplications
            );

        document
            .getElementById('journeyApply')
            .classList.toggle(
                'done',
                hasSubmittedApplication
            );
    }

    function renderDashboard() {
        renderStats();
        renderBestOpportunity();
        renderMatches();
        renderApplications();
        renderJourney();
    }

    async function requestJson(url, options = {}) {
        const response = await fetch(url, options);

        if (response.status === 401) {
            goToLogin();
            throw new Error('Unauthenticated');
        }

        if (!response.ok) {
            let message =
                `Request failed with status ${response.status}`;

            try {
                const body = await response.json();

                if (body?.message) {
                    message = body.message;
                }
            } catch (_) {}

            throw new Error(message);
        }

        return response.json();
    }

    async function loadDashboard() {
        const token = getToken();

        if (!token) {
            goToLogin();
            return;
        }

        try {
            currentUser = await requestJson(
                `${API_BASE_URL}/me`,
                {
                    headers: authHeaders()
                }
            );

            localStorage.setItem(
                'auth_user',
                JSON.stringify(currentUser)
            );

            const displayName =
                currentUser.full_name ||
                currentUser.name ||
                'Student';

            document.getElementById(
                'welcomeHeading'
            ).textContent =
                `Welcome back, ${displayName}`;

            const results = await Promise.allSettled([
                requestJson(
                    `${API_BASE_URL}/profile`,
                    { headers: authHeaders() }
                ),

                requestJson(
                    `${API_BASE_URL}/recommendations`,
                    { headers: authHeaders() }
                ),

                requestJson(
                    `${API_BASE_URL}/saved-applications`,
                    { headers: authHeaders() }
                )
            ]);

            if (results[0].status === 'fulfilled') {
                currentProfile = results[0].value;
            }

            if (results[1].status === 'fulfilled') {
                recommendations =
                    normalizeCollection(results[1].value);
            }

            if (results[2].status === 'fulfilled') {
                applications =
                    normalizeCollection(results[2].value);
            }

            renderDashboard();

            document
                .getElementById('loadingScreen')
                .classList.add('hidden');

            document
                .getElementById('appShell')
                .classList.remove('hidden');

        } catch (error) {
            console.error(
                'Dashboard loading error:',
                error
            );

            if (error.message !== 'Unauthenticated') {
                document.getElementById(
                    'loadingScreen'
                ).innerHTML = `
                    <div class="empty-state"
                         style="max-width:420px;">
                        <strong>
                            Dashboard could not be loaded
                        </strong>
                        ${escapeHtml(error.message)}
                    </div>
                `;
            }
        }
    }

    async function refreshRecommendations() {
        const buttons = [
            document.getElementById(
                'refreshRecommendationsBtn'
            ),
            document.getElementById(
                'refreshRecommendationsQuick'
            )
        ];

        buttons.forEach(button => {
            if (button) {
                button.disabled = true;
            }
        });

        try {
            const result = await requestJson(
                `${API_BASE_URL}/recommendations/generate`,
                {
                    method: 'POST',
                    headers: authHeaders()
                }
            );

            recommendations =
                normalizeCollection(
                    result.data ?? result
                );

            if (!recommendations.length) {
                const latest =
                    await requestJson(
                        `${API_BASE_URL}/recommendations`,
                        {
                            headers: authHeaders()
                        }
                    );

                recommendations =
                    normalizeCollection(latest);
            }

            renderDashboard();

            showToast(
                `${recommendations.length} scholarship matches generated successfully.`
            );

        } catch (error) {
            console.error(error);

            showToast(
                error.message ||
                'Could not refresh recommendations.'
            );

        } finally {
            buttons.forEach(button => {
                if (button) {
                    button.disabled = false;
                }
            });
        }
    }

    async function logout() {
        const token = getToken();

        try {
            if (token) {
                await fetch(
                    `${API_BASE_URL}/logout`,
                    {
                        method: 'POST',
                        headers: authHeaders()
                    }
                );
            }
        } catch (_) {
            // Local session is cleared even if
            // the server request cannot complete.
        }

        goToLogin();
    }

    document
        .getElementById('logoutBtn')
        .addEventListener(
            'click',
            logout
        );

    document
        .getElementById(
            'refreshRecommendationsBtn'
        )
        .addEventListener(
            'click',
            refreshRecommendations
        );

    document
        .getElementById(
            'refreshRecommendationsQuick'
        )
        .addEventListener(
            'click',
            refreshRecommendations
        );

    window.addEventListener(
        'pageshow',
        () => {
            loadDashboard();
        }
    );
</script>

</body>
</html>
