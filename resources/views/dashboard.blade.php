<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AI StudyPort - Dashboard</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap');

  *{ box-sizing:border-box; margin:0; padding:0; }

  body{
    font-family:'Inter', system-ui, sans-serif;
    min-height:100vh;
    background:
      linear-gradient(90deg, rgba(6,10,20,0.55) 0%, rgba(6,10,20,0.15) 42%, rgba(6,10,20,0.05) 60%),
      url('/images/minhati.jpg') center/cover no-repeat;
    background-attachment: fixed;
  }

  /* Hidden until we've confirmed the token is valid, so a logged-out
     visitor never sees a flash of dashboard content (FR-03 alt scenario). */
  #appShell{ display:none; }

  .topbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:1.25rem 2rem;
    background:rgba(13,20,38,0.72);
    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);
    border-bottom:1px solid rgba(255,255,255,0.12);
  }
  .brand{
    display:flex;
    align-items:center;
    gap:0.55rem;
    font-family:'Space Grotesk', sans-serif;
    font-weight:600;
    font-size:1.05rem;
    color:#fff;
  }
  .brand .mark{
    width:26px; height:26px;
    border-radius:8px;
    background:linear-gradient(135deg, #38DFEA, #4F8CFF);
    display:flex; align-items:center; justify-content:center;
    font-size:0.85rem; font-weight:700; color:#0B1220;
  }

  .logout-btn{
    padding:0.55rem 1.1rem;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.18);
    border-radius:8px;
    color:#fff;
    font-size:0.85rem;
    font-weight:600;
    cursor:pointer;
    transition:background .15s;
  }
  .logout-btn:hover{ background:rgba(255,255,255,0.16); }
  .logout-btn:disabled{ opacity:0.6; cursor:not-allowed; }

  main{
    max-width:820px;
    margin:3rem auto 5rem;
    padding:0 2rem;
  }

  .card{
    background:rgba(13,20,38,0.68);
    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);
    border:1px solid rgba(255,255,255,0.14);
    border-radius:20px;
    padding:2.25rem 2rem;
    box-shadow:0 24px 60px rgba(0,0,0,0.45);
    color:#fff;
    margin-bottom:1.75rem;
  }

  h1{
    font-family:'Space Grotesk', sans-serif;
    font-weight:700;
    font-size:1.6rem;
    margin-bottom:0.5rem;
  }
  h2{
    font-family:'Space Grotesk', sans-serif;
    font-weight:700;
    font-size:1.25rem;
    margin-bottom:0.4rem;
  }

  .sub{
    color:rgba(255,255,255,0.65);
    font-size:0.9rem;
    margin-bottom:1.75rem;
  }

  .nav-links{
    display:flex;
    flex-direction:column;
    gap:0.75rem;
  }
  .nav-links a{
    display:block;
    padding:0.85rem 1rem;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.14);
    border-radius:10px;
    color:#fff;
    text-decoration:none;
    font-size:0.92rem;
    font-weight:600;
    transition:background .15s, border-color .15s;
  }
  .nav-links a:hover{
    background:rgba(255,255,255,0.11);
    border-color:#38DFEA;
  }

  .loading-screen{
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:100vh;
    color:#fff;
    font-size:0.9rem;
    opacity:0.7;
  }

  .spinner{
    display:inline-block;
    width:14px; height:14px;
    border:2px solid rgba(255,255,255,0.3);
    border-top-color:#fff;
    border-radius:50%;
    animation:spin .7s linear infinite;
    margin-right:0.5rem;
    vertical-align:middle;
  }
  @keyframes spin{ to{ transform:rotate(360deg); } }

  /* --- Recommendations section (FR-09 / FR-10 / FR-11) --- */

  #recommendations{
    scroll-margin-top: 1.5rem; /* keeps the anchored section clear of the topbar when scrolled to */
  }

  .rec-state{
    font-size:0.88rem;
    color:rgba(255,255,255,0.65);
    padding:0.5rem 0;
  }
  .rec-state.error{ color:#FCA5A5; }

  .rec-list{
    display:flex;
    flex-direction:column;
    gap:1rem;
  }

  .rec-card{
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.14);
    border-radius:14px;
    padding:1.25rem 1.4rem;
  }

  .rec-card-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:1rem;
    margin-bottom:0.5rem;
  }

  .rec-title{
    font-family:'Space Grotesk', sans-serif;
    font-weight:600;
    font-size:1.02rem;
    margin-bottom:0.2rem;
  }

  .rec-provider{
    font-size:0.8rem;
    color:rgba(255,255,255,0.55);
  }

  .rec-score{
    flex-shrink:0;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    width:56px; height:56px;
    border-radius:50%;
    background:rgba(56,223,234,0.12);
    border:1px solid rgba(56,223,234,0.4);
    font-weight:700;
    font-size:0.92rem;
    color:#38DFEA;
  }
  .rec-score.low{
    background:rgba(255,255,255,0.06);
    border-color:rgba(255,255,255,0.2);
    color:rgba(255,255,255,0.7);
  }
  .rec-score small{
    font-size:0.55rem;
    font-weight:600;
    color:rgba(255,255,255,0.5);
  }

  .rec-meta{
    display:flex;
    gap:1rem;
    flex-wrap:wrap;
    font-size:0.8rem;
    color:rgba(255,255,255,0.6);
    margin-bottom:0.75rem;
  }

  .rec-criteria{
    display:flex;
    flex-wrap:wrap;
    gap:0.4rem;
  }
  .rec-criteria .tag{
    background:rgba(52,211,153,0.12);
    border:1px solid rgba(52,211,153,0.35);
    color:#86EFAC;
    border-radius:999px;
    padding:0.25rem 0.65rem;
    font-size:0.72rem;
    font-weight:600;
  }

  /* Brief flash used to draw attention to this section right after a
     student confirms a new CV and lands back here (see loadDashboard). */
  .highlight-flash{
    animation: flashBg 1.6s ease;
  }
  @keyframes flashBg{
    0%   { background-color: rgba(255, 235, 59, 0.28); }
    100% { background-color: transparent; }
  }

  @media (max-width: 720px){
    main{ padding:0 1.25rem; margin:1.5rem auto 3rem; }
    .rec-card-top{ flex-direction:row; }
  }
</style>
</head>
<body>

  <div class="loading-screen" id="loadingScreen">Loading...</div>

  <div id="appShell">
    <div class="topbar">
      <div class="brand">
        <span class="mark">A</span>
        AI StudyPort
      </div>
      <button class="logout-btn" id="logoutBtn">Log Out</button>
    </div>

    <main>
      <div class="card">
        <h1 id="welcomeHeading">Welcome</h1>
        <p class="sub" id="welcomeSub">Here's your student dashboard.</p>

        <div class="nav-links">
          {{-- TODO: build the profile page and route, then swap this href --}}
          <a href="{{ route('profile') }}">Manage my academic profile</a>
          <a href="{{ route('cv-upload') }}">Upload / update my CV</a>
        </div>
      </div>

      <div class="card" id="recommendations">
        <h2>Your scholarship recommendations</h2>
        <p class="sub">Ranked by how well your profile and CV match each scholarship's eligibility criteria.</p>

        <div id="recStatus" class="rec-state" role="status" aria-live="polite"></div>
        <div class="rec-list" id="recList"></div>
      </div>
    </main>
  </div>

<script>
  const API_BASE_URL = "{{ url('/api') }}";
  const LOGIN_URL = "{{ route('login') }}";

  function goToLogin() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('auth_user');
    window.location.replace(LOGIN_URL);
  }

  function authHeaders(token) {
    return {
      'Accept': 'application/json',
      'Authorization': `Bearer ${token}`
    };
  }

  // --- Dashboard bootstrap / auth check ---

  async function loadDashboard() {
    const token = localStorage.getItem('auth_token');

    // No token at all — nothing cached to protect, go straight to login.
    if (!token) {
      goToLogin();
      return;
    }

    try {
      // NFR-09 / FR-03: confirm with the backend that this token is still
      // valid before showing anything. If the 30-minute inactivity window
      // expired, or the token was revoked by a prior logout, this fails
      // and we bounce back to login instead of showing stale content.
      const response = await fetch(`${API_BASE_URL}/me`, {
        headers: authHeaders(token)
      });

      if (!response.ok) {
        goToLogin();
        return;
      }

      const user = await response.json();
      localStorage.setItem('auth_user', JSON.stringify(user));

      document.getElementById('welcomeHeading').textContent = `Welcome, ${user.full_name}`;
      document.getElementById('loadingScreen').style.display = 'none';
      document.getElementById('appShell').style.display = 'block';

      // Recommendations are independent of the auth check above: a slow
      // or failed recommendations fetch should never block the rest of
      // the dashboard from rendering.
      loadRecommendations(token);
      handlePostCvRedirect();
    } catch (error) {
      // Network/backend unreachable — safest default is to require login
      // again rather than trust a cached user object.
      goToLogin();
    }
  }

  // --- Recommendations (FR-09 / FR-10 / FR-11) ---

  function scoreClass(score) {
    return score >= 50 ? '' : 'low';
  }

  function formatDeadline(dateString) {
    if (!dateString) return null;
    const date = new Date(dateString);
    if (Number.isNaN(date.getTime())) return dateString;
    return date.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' });
  }

function renderRecommendations(items) {
  const list = document.getElementById('recList');
  const status = document.getElementById('recStatus');
  list.innerHTML = '';

  if (!items || items.length === 0) {
    status.textContent = 'No matching scholarships yet. Try updating your profile or CV.';
    status.classList.remove('error');
    return;
  }

  status.textContent = '';

  items.forEach(function (item) {
    const scholarship = item.scholarship || {};

    const card = document.createElement('div');
    card.className = 'rec-card';

    const top = document.createElement('div');
    top.className = 'rec-card-top';

    const titleWrap = document.createElement('div');
    const title = document.createElement('div');
    title.className = 'rec-title';
    title.textContent = scholarship.title || 'Untitled scholarship';
    const provider = document.createElement('div');
    provider.className = 'rec-provider';
    provider.textContent = scholarship.provider_name || '';
    titleWrap.appendChild(title);
    titleWrap.appendChild(provider);

    const score = document.createElement('div');
    const scoreValue = typeof item.match_score === 'number' ? Math.round(item.match_score) : (item.match_score ? Math.round(parseFloat(item.match_score)) : null);
    score.className = 'rec-score ' + (scoreValue !== null ? scoreClass(scoreValue) : 'low');
    const scoreNum = document.createElement('span');
    scoreNum.textContent = scoreValue !== null ? `${scoreValue}%` : '—';
    const scoreLabel = document.createElement('small');
    scoreLabel.textContent = 'match';
    score.appendChild(scoreNum);
    score.appendChild(scoreLabel);

    top.appendChild(titleWrap);
    top.appendChild(score);

    const meta = document.createElement('div');
    meta.className = 'rec-meta';
    if (scholarship.field_of_study) {
      const field = document.createElement('span');
      field.textContent = scholarship.field_of_study;
      meta.appendChild(field);
    }
    if (scholarship.degree_level) {
      const level = document.createElement('span');
      level.textContent = scholarship.degree_level;
      meta.appendChild(level);
    }
    const deadlineText = formatDeadline(scholarship.application_deadline);
    if (deadlineText) {
      const deadline = document.createElement('span');
      deadline.textContent = `Deadline: ${deadlineText}`;
      meta.appendChild(deadline);
    }

    card.appendChild(top);
    card.appendChild(meta);

    // FR-11: show which criteria the student actually satisfied.
    const matches = Array.isArray(item.criteria_matches) ? item.criteria_matches : [];
    const satisfiedLabels = matches
      .filter(function (m) { return m.is_satisfied && m.criterion; })
      .map(function (m) { return m.criterion.criterion; });

    if (satisfiedLabels.length > 0) {
      const criteriaWrap = document.createElement('div');
      criteriaWrap.className = 'rec-criteria';
      satisfiedLabels.forEach(function (label) {
        const tag = document.createElement('span');
        tag.className = 'tag';
        tag.textContent = label;
        criteriaWrap.appendChild(tag);
      });
      card.appendChild(criteriaWrap);
    }

    list.appendChild(card);
  });
}

     

  async function loadRecommendations(token) {
    const status = document.getElementById('recStatus');
    status.textContent = 'Loading your recommendations...';
    status.classList.remove('error');

    try {
      // TODO: confirm this matches the real backend route name.
      const response = await fetch(`${API_BASE_URL}/recommendations`, {
        headers: authHeaders(token)
      });

      if (response.status === 401) {
        goToLogin();
        return;
      }

      if (!response.ok) {
        status.textContent = 'Could not load your recommendations right now. Please try refreshing the page.';
        status.classList.add('error');
        return;
      }

      const data = await response.json();
      // Support either a bare array or a { data: [...] } envelope.
      const items = Array.isArray(data) ? data : (Array.isArray(data.data) ? data.data : []);
      renderRecommendations(items);
    } catch (error) {
      status.textContent = 'Could not connect to the server. Make sure your Laravel backend is running.';
      status.classList.add('error');
    }
  }

  // --- Post-CV-upload landing: scroll to and briefly highlight the
  // recommendations section so the student sees what just changed
  // (see cv-upload.blade.php, which appends ?cv_updated=1#recommendations). ---

  function handlePostCvRedirect() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('cv_updated') !== '1') return;

    const target = document.getElementById('recommendations');
    if (target) {
      // Small delay so this runs after the recommendations request has
      // had a moment to start rendering, rather than scrolling to an
      // empty section.
      setTimeout(function () {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        target.classList.add('highlight-flash');
        setTimeout(function () { target.classList.remove('highlight-flash'); }, 2000);
      }, 300);
    }

    // Clean the query param out of the URL so a manual refresh doesn't
    // re-trigger the scroll/highlight every time.
    const cleanUrl = window.location.pathname + window.location.hash;
    window.history.replaceState({}, document.title, cleanUrl);
  }

  // --- Logout ---

  document.getElementById('logoutBtn').addEventListener('click', async function() {
    const btn = this;
    const token = localStorage.getItem('auth_token');

    btn.disabled = true;
    btn.textContent = 'Logging out...';

    try {
      if (token) {
        await fetch(`${API_BASE_URL}/logout`, {
          method: 'POST',
          headers: authHeaders(token)
        });
      }
    } catch (error) {
      // Even if the request fails (e.g. token already expired), we still
      // clear local state below so the user isn't stuck.
    } finally {
      goToLogin();
    }
  });

  // FR-03 alt scenario: pressing the browser back button after logout
  // must not show cached dashboard content. `pageshow` fires even when
  // the page is restored from the back/forward cache (bfcache), so we
  // re-validate the token every time this page becomes visible again.
  window.addEventListener('pageshow', function(event) {
    loadDashboard();
  });

</script>

</body>
</html>