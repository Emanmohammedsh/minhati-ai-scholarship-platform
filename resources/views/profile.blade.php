<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AI StudyPort - Academic Profile</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap');

  *{ box-sizing:border-box; margin:0; padding:0; }

  body{
    font-family:'Inter', system-ui, sans-serif;
    min-height:100vh;
    background:
      linear-gradient(90deg, rgba(6,10,20,0.55) 0%, rgba(6,10,20,0.15) 42%, rgba(6,10,20,0.05) 60%),
      url('/images/minhati.jpg') center/cover no-repeat;
  }

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
  .topbar-links{ display:flex; align-items:center; gap:0.75rem; }
  .back-link{
    color:rgba(255,255,255,0.75);
    text-decoration:none;
    font-size:0.85rem;
    font-weight:600;
  }
  .back-link:hover{ color:#fff; }

  main{
    max-width:640px;
    margin:3rem auto;
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
  }

  h1{
    font-family:'Space Grotesk', sans-serif;
    font-weight:700;
    font-size:1.5rem;
    margin-bottom:0.4rem;
  }
  .sub{
    color:rgba(255,255,255,0.6);
    font-size:0.88rem;
    margin-bottom:1.75rem;
  }

  .form-group{ margin-bottom:1.15rem; }
  label{
    display:block;
    font-size:0.78rem;
    font-weight:600;
    color:rgba(255,255,255,0.75);
    margin-bottom:0.45rem;
  }
  input, select, textarea{
    width:100%;
    padding:0.75rem 0.9rem;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.16);
    border-radius:10px;
    color:#fff;
    font-size:0.92rem;
    font-family:'Inter', sans-serif;
    transition:border-color .15s, background .15s;
  }
  textarea{ resize:vertical; min-height:80px; }
  input::placeholder, textarea::placeholder{ color:rgba(255,255,255,0.35); }
  input:focus, select:focus, textarea:focus{
    outline:none;
    border-color:#38DFEA;
    background:rgba(255,255,255,0.09);
  }
  input.invalid, select.invalid, textarea.invalid{ border-color:#FCA5A5; }

  select option{ background:#0B1220; color:#fff; }

  .field-error{
    display:none;
    color:#FCA5A5;
    font-size:0.75rem;
    margin-top:0.35rem;
  }
  .field-error.show{ display:block; }

  .save-btn{
    width:100%;
    padding:0.8rem;
    margin-top:0.4rem;
    background:linear-gradient(135deg, #38DFEA, #4F8CFF);
    color:#0B1220;
    border:none;
    border-radius:10px;
    font-size:0.95rem;
    font-weight:700;
    font-family:'Inter', sans-serif;
    cursor:pointer;
    transition:filter .15s;
  }
  .save-btn:hover{ filter:brightness(1.08); }
  .save-btn:disabled{ opacity:0.6; cursor:not-allowed; }

  .alert{
    padding:0.65rem 0.85rem;
    border-radius:8px;
    margin-bottom:1.1rem;
    font-size:0.82rem;
    display:none;
  }
  .alert-error{ background:rgba(239,68,68,0.16); color:#FCA5A5; border:1px solid rgba(239,68,68,0.35); }
  .alert-success{ background:rgba(34,197,94,0.16); color:#86EFAC; border:1px solid rgba(34,197,94,0.35); }

  .loading-screen{
    display:flex;
    align-items:center;
    justify-content:center;
    min-height:100vh;
    color:#fff;
    font-size:0.9rem;
    opacity:0.7;
  }

  @media (max-width: 720px){
    main{ padding:0 1.25rem; margin:1.5rem auto; }
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
      <div class="topbar-links">
        <a href="{{ route('dashboard') }}" class="back-link">← Back to dashboard</a>
      </div>
    </div>

    <main>
      <div class="card">
        <h1>Academic Profile</h1>
        <p class="sub" id="pageSub">Complete your academic profile so we can match you with relevant scholarships.</p>

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
        </form>
      </div>
    </main>
  </div>

<script>
  const API_BASE_URL = "{{ url('/api') }}";
  const LOGIN_URL = "{{ route('login') }}";

  let profileExists = false;

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

  function clearFieldErrors() {
    document.querySelectorAll('.field-error').forEach(function(el) {
      el.textContent = '';
      el.classList.remove('show');
    });
    document.querySelectorAll('input, select, textarea').forEach(function(el) {
      el.classList.remove('invalid');
    });
  }

  function showFieldError(field, message) {
    const errEl = document.getElementById('err_' + field);
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
        headers: authHeaders(token)
      });

      if (response.status === 401) {
        goToLogin();
        return;
      }

      if (response.status === 404) {
        // US-04 main scenario: first time filling the profile.
        profileExists = false;
      } else if (response.ok) {
        const profile = await response.json();
        fillForm(profile);
        profileExists = true;
      }

      document.getElementById('loadingScreen').style.display = 'none';
      document.getElementById('appShell').style.display = 'block';
    } catch (error) {
      goToLogin();
    }
  }

  document.getElementById('profileForm').addEventListener('submit', async function(e) {
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
      // US-04: create on first save, update independently afterwards —
      // each field updates without affecting the others.
      const response = await fetch(`${API_BASE_URL}/student-profile`, {
        method: profileExists ? 'PUT' : 'POST',
        headers: {
          ...authHeaders(token),
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      const data = await response.json();

      if (response.ok) {
        profileExists = true;
        alertBox.textContent = 'Profile saved successfully.';
        alertBox.className = 'alert alert-success';
        alertBox.style.display = 'block';
      } else if (response.status === 422 && data.errors) {
        // NFR-12: validation message adjacent to each failed field.
        Object.entries(data.errors).forEach(function([field, messages]) {
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

  window.addEventListener('pageshow', function() {
    loadProfile();
  });
</script>

</body>
</html>