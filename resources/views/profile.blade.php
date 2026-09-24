<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jisr AI | Academic Profile</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap');

  * { box-sizing: border-box; margin: 0; padding: 0; }

  /* -------------------------------------------------
     Theme tokens (light = default, dark = .theme-dark)
     Kept identical to dashboard.blade.php so both pages
     stay visually and behaviorally in sync.
  ------------------------------------------------- */
  :root {
    --primary: #0E7C90;
    --accent-a: #38DFEA;
    --accent-b: #4F8CFF;

    --text: rgba(15, 23, 42, .75);
    --heading: #0F172A;
    --muted: rgba(15, 23, 42, .55);
    --placeholder: rgba(15, 23, 42, .35);

    --border: rgba(15, 23, 42, .14);

    --topbar-bg: rgba(255, 255, 255, .82);
    --topbar-border: rgba(15, 23, 42, .10);
    --topbar-text: rgba(15, 23, 42, .75);
    --topbar-heading: #0F172A;
    --topbar-hover: rgba(15, 23, 42, .06);

    --card-bg: rgba(255, 255, 255, .82);
    --card-border: rgba(15, 23, 42, .12);
    --card-shadow: 0 24px 60px rgba(15, 23, 42, .14);

    --input-bg: rgba(15, 23, 42, .04);
    --input-border: rgba(15, 23, 42, .16);
    --input-focus-bg: rgba(15, 23, 42, .06);

    --page-bg: #F4F7FB;
    --page-glow-1: rgba(14,124,144,.06);
    --page-glow-2: rgba(79,140,255,.07);

    --error: #DC2626;
    --error-bg: rgba(220, 38, 38, .10);
    --error-border: rgba(220, 38, 38, .30);
    --success: #16A34A;
    --success-bg: rgba(22, 163, 74, .10);
    --success-border: rgba(22, 163, 74, .30);

    --toggle-icon-color: #0F172A;
  }

  body.theme-dark {
    --text: rgba(255, 255, 255, .78);
    --heading: #FFFFFF;
    --muted: rgba(255, 255, 255, .6);
    --placeholder: rgba(255, 255, 255, .35);

    --border: rgba(255, 255, 255, .14);

    --topbar-bg: rgba(13, 20, 38, .72);
    --topbar-border: rgba(255, 255, 255, .12);
    --topbar-text: rgba(255, 255, 255, .85);
    --topbar-heading: #FFFFFF;
    --topbar-hover: rgba(255, 255, 255, .10);

    --card-bg: rgba(13, 20, 38, .68);
    --card-border: rgba(255, 255, 255, .14);
    --card-shadow: 0 24px 60px rgba(0, 0, 0, .45);

    --input-bg: rgba(255, 255, 255, .06);
    --input-border: rgba(255, 255, 255, .16);
    --input-focus-bg: rgba(255, 255, 255, .09);

    --page-bg: #0B1220;
    --page-glow-1: rgba(56,223,234,.13);
    --page-glow-2: rgba(79,140,255,.16);

    --error: #FCA5A5;
    --error-bg: rgba(239, 68, 68, .16);
    --error-border: rgba(239, 68, 68, .35);
    --success: #86EFAC;
    --success-bg: rgba(34, 197, 94, .16);
    --success-border: rgba(34, 197, 94, .35);
  }

  body {
    font-family: 'Inter', system-ui, sans-serif;
    min-height: 100vh;
    color: var(--text);
    /* Same branded gradient background as dashboard.blade.php —
       no external background image, so nothing to go stale/missing. */
    background:
      radial-gradient(circle at 92% 5%, var(--page-glow-1), transparent 26%),
      radial-gradient(circle at 5% 65%, var(--page-glow-2), transparent 25%),
      var(--page-bg);
    transition: background-color .25s ease, color .25s ease;
  }

  #appShell { display: none; }

  /* Topbar */
  .topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem 2rem;
    background: var(--topbar-bg);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border-bottom: 1px solid var(--topbar-border);
    transition: background-color .25s ease, border-color .25s ease;
  }
  .brand {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 600;
    font-size: 1.05rem;
    color: var(--topbar-heading);
  }
  .brand-logo {
    width: 30px;
    height: 30px;
    object-fit: contain;
    border-radius: 8px;
  }
  .topbar-links { display: flex; align-items: center; gap: 0.6rem; }
  .back-link {
    color: var(--topbar-text);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.5rem 0.7rem;
    border-radius: 8px;
    transition: background-color .2s ease, color .2s ease;
  }
  .back-link:hover { color: var(--topbar-heading); background: var(--topbar-hover); }

  .theme-toggle-btn {
    width: 36px;
    height: 36px;
    flex: 0 0 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    border: 1px solid var(--topbar-border);
    background: var(--topbar-hover);
    color: var(--topbar-text);
    font-size: 15px;
    cursor: pointer;
    transition: background-color .2s ease, transform .2s ease;
  }
  .theme-toggle-btn:hover { transform: translateY(-1px); }

  /* Layout */
  main {
    max-width: 640px;
    margin: 3rem auto;
    padding: 0 2rem;
  }

  .card {
    background: var(--card-bg);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border: 1px solid var(--card-border);
    border-radius: 20px;
    padding: 2.25rem 2rem;
    box-shadow: var(--card-shadow);
    color: var(--text);
    transition: background-color .25s ease, border-color .25s ease, box-shadow .25s ease;
  }

  h1 {
    font-family: 'Space Grotesk', sans-serif;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 0.4rem;
    color: var(--heading);
  }
  .sub { color: var(--muted); font-size: 0.88rem; margin-bottom: 1.75rem; }

  /* Form */
  .form-group { margin-bottom: 1.15rem; }
  label {
    display: block;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.45rem;
  }
  input, select, textarea {
    width: 100%;
    padding: 0.75rem 0.9rem;
    background: var(--input-bg);
    border: 1px solid var(--input-border);
    border-radius: 10px;
    color: var(--heading);
    font-size: 0.92rem;
    font-family: 'Inter', sans-serif;
    transition: border-color .15s, background .15s;
  }
  textarea { resize: vertical; min-height: 80px; }
  input::placeholder, textarea::placeholder { color: var(--placeholder); }
  input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: var(--accent-a);
    background: var(--input-focus-bg);
  }
  input.invalid, select.invalid, textarea.invalid { border-color: #FCA5A5; }

  select option { background: #0B1220; color: #fff; }
  body:not(.theme-dark) select option { background: #FFFFFF; color: #0F172A; }

  .field-error { display: none; color: var(--error); font-size: 0.75rem; margin-top: 0.35rem; }
  .field-error.show { display: block; }

  .save-btn {
    width: 100%;
    padding: 0.8rem;
    margin-top: 0.4rem;
    background: linear-gradient(135deg, var(--accent-a), var(--accent-b));
    color: #0B1220;
    border: none;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    transition: filter .15s;
  }
  .save-btn:hover { filter: brightness(1.08); }
  .save-btn:disabled { opacity: 0.6; cursor: not-allowed; }

  .alert {
    padding: 0.65rem 0.85rem;
    border-radius: 8px;
    margin-bottom: 1.1rem;
    font-size: 0.82rem;
    display: none;
  }
  .alert-error { background: var(--error-bg); color: var(--error); border: 1px solid var(--error-border); }
  .alert-success { background: var(--success-bg); color: var(--success); border: 1px solid var(--success-border); }

  .loading-screen {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    color: var(--heading);
    font-size: 0.9rem;
    opacity: 0.7;
  }

  @media (max-width: 720px) {
    main { padding: 0 1.25rem; margin: 1.5rem auto; }
  }
</style>
</head>
<body>

<script>
  // Apply saved theme before first paint to avoid a light/dark flash.
  (function () {
    try {
      if (localStorage.getItem('jisr_theme') === 'dark') {
        document.body.classList.add('theme-dark');
      }
    } catch (e) {}
  })();
</script>

  <div class="loading-screen" id="loadingScreen">Loading...</div>

  <div id="appShell">
    <div class="topbar">
      <div class="brand">
        <img src="/images/jisr-logo.jpeg" class="brand-logo" alt="Jisr AI">
        Jisr AI
      </div>
      <div class="topbar-links">
        <a href="{{ route('dashboard') }}" class="back-link">&larr; Back to dashboard</a>
        <button id="themeToggleBtn" class="theme-toggle-btn" type="button" title="Dark / Light">🌙</button>
      </div>
    </div>

    <main>
      <div class="card">
        <h1>Academic Profile</h1>
        <p class="sub" id="pageSub">Complete your academic profile so we can match you with relevant scholarships and career opportunities.</p>

        <div id="globalAlert" class="alert"></div>

        <form id="profileForm" novalidate>
          <div class="form-group">
            <label for="academic_background">Academic Background</label>
            <textarea id="academic_background" name="academic_background" placeholder="e.g. BSc in Cybersecurity Engineering, graduated 2026"></textarea>
            <div class="field-error" id="err_academic_background"></div>
          </div>

          <div class="form-group">
            <label for="field_of_study">Field of Study *</label>
            <input type="text" id="field_of_study" name="field_of_study" placeholder="e.g. Computer Science" required>
            <div class="field-error" id="err_field_of_study"></div>
          </div>

          <div class="form-group">
            <label for="degree_level">Degree Level *</label>
            <select id="degree_level" name="degree_level" required>
              <option value="">Select...</option>
              <option value="diploma">Diploma</option>
              <option value="bachelor">Bachelor's</option>
              <option value="master">Master's</option>
              <option value="phd">PhD</option>
            </select>
            <div class="field-error" id="err_degree_level"></div>
          </div>

          <div class="form-group">
            <label for="interests">Areas of Interest</label>
            <textarea id="interests" name="interests" placeholder="e.g. AI, cybersecurity, renewable energy"></textarea>
            <div class="field-error" id="err_interests"></div>
          </div>

          <div class="form-group">
            <label for="country">Country *</label>
            <input type="text" id="country" name="country" placeholder="e.g. Palestine" required>
            <div class="field-error" id="err_country"></div>
          </div>

          <button type="submit" class="save-btn" id="saveBtn">Save Profile</button>
          <a href="{{ route('cv-upload') }}" class="save-btn" id="continueBtn" style="display:none;text-decoration:none;text-align:center;margin-top:0.9rem;background:linear-gradient(135deg, #34D399, #22C55E);color:#06210F;">Continue to CV Upload &rarr;</a>
        </form>
      </div>
    </main>
  </div>

<script>
  const API_BASE_URL = "{{ url('/api') }}";
  const LOGIN_URL = "{{ route('login') }}";
  const CONTINUE_URL = "{{ route('cv-upload') }}";

  let profileExists = false;

  function goToLogin() {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('auth_user');
    window.location.replace(LOGIN_URL);
  }

  function authHeaders(token) {
    return {
      Accept: 'application/json',
      Authorization: `Bearer ${token}`,
    };
  }

  function clearFieldErrors() {
    document.querySelectorAll('.field-error').forEach((el) => {
      el.textContent = '';
      el.classList.remove('show');
    });
    document.querySelectorAll('input, select, textarea').forEach((el) => {
      el.classList.remove('invalid');
    });
  }

  function showFieldError(field, message) {
    const errEl = document.getElementById(`err_${field}`);
    const inputEl = document.getElementById(field);
    if (errEl) {
      errEl.textContent = message;
      errEl.classList.add('show');
    }
    if (inputEl) {
      inputEl.classList.add('invalid');
    }
  }

  function fillForm(profile) {
    document.getElementById('academic_background').value = profile.academic_background || '';
    document.getElementById('field_of_study').value = profile.field_of_study || '';
    document.getElementById('degree_level').value = profile.degree_level || '';
    document.getElementById('interests').value = profile.interests || '';
    document.getElementById('country').value = profile.country || '';
  }

  async function loadProfile() {
    const token = localStorage.getItem('auth_token');
    if (!token) {
      goToLogin();
      return;
    }

    try {
      const response = await fetch(`${API_BASE_URL}/student-profile`, {
        headers: authHeaders(token),
      });

      if (response.status === 401) {
        goToLogin();
        return;
      }

      if (response.status === 404) {
        // First time filling the profile — nothing to prefill.
        profileExists = false;
      } else if (response.ok) {
        const profile = await response.json();
        fillForm(profile);
        profileExists = true;
        document.getElementById('continueBtn').style.display = 'block';
      }

      document.getElementById('loadingScreen').style.display = 'none';
      document.getElementById('appShell').style.display = 'block';
    } catch (error) {
      goToLogin();
    }
  }

  document.getElementById('profileForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const token = localStorage.getItem('auth_token');
    if (!token) {
      goToLogin();
      return;
    }

    const saveBtn = document.getElementById('saveBtn');
    const alertBox = document.getElementById('globalAlert');
    alertBox.style.display = 'none';
    clearFieldErrors();

    const payload = {
      academic_background: document.getElementById('academic_background').value,
      field_of_study: document.getElementById('field_of_study').value,
      degree_level: document.getElementById('degree_level').value,
      interests: document.getElementById('interests').value,
      country: document.getElementById('country').value,
    };

    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving...';

    try {
      // Create on first save, update independently afterwards.
      const response = await fetch(`${API_BASE_URL}/student-profile`, {
        method: profileExists ? 'PUT' : 'POST',
        headers: {
          ...authHeaders(token),
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(payload),
      });

      const data = await response.json();

      if (response.ok) {
        profileExists = true;
        document.getElementById('continueBtn').style.display = 'block';
        alertBox.textContent = 'Profile saved successfully.';
        alertBox.className = 'alert alert-success';
        alertBox.style.display = 'block';
      } else if (response.status === 422 && data.errors) {
        // Validation message rendered adjacent to each failed field.
        Object.entries(data.errors).forEach(([field, messages]) => {
          showFieldError(field, messages[0]);
        });
      } else {
        alertBox.textContent = data.message || 'Could not save your profile. Please try again.';
        alertBox.className = 'alert alert-error';
        alertBox.style.display = 'block';
      }
    } catch (error) {
      alertBox.textContent = 'Could not connect to the server. Make sure your Laravel backend is running.';
      alertBox.className = 'alert alert-error';
      alertBox.style.display = 'block';
    } finally {
      saveBtn.disabled = false;
      saveBtn.textContent = 'Save Profile';
    }
  });

  function applyTheme(theme) {
    document.body.classList.toggle('theme-dark', theme === 'dark');
    try {
      localStorage.setItem('jisr_theme', theme);
    } catch (_) {}

    const toggleBtn = document.getElementById('themeToggleBtn');
    if (toggleBtn) {
      toggleBtn.textContent = theme === 'dark' ? '☀️' : '🌙';
    }
  }

  (function initTheme() {
    let savedTheme = 'light';
    try {
      savedTheme = localStorage.getItem('jisr_theme') || 'light';
    } catch (_) {}
    applyTheme(savedTheme);
  })();

  document.getElementById('themeToggleBtn').addEventListener('click', () => {
    const isDark = document.body.classList.contains('theme-dark');
    applyTheme(isDark ? 'light' : 'dark');
  });

  window.addEventListener('pageshow', loadProfile);
</script>

</body>
</html>