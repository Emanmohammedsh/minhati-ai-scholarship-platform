<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AI StudyPort - Sign Up</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap');

  *{ box-sizing:border-box; margin:0; padding:0; }

  body{
    font-family:'Inter', system-ui, sans-serif;
    min-height:100vh;
    background:
      linear-gradient(90deg, rgba(6,10,20,0.55) 0%, rgba(6,10,20,0.15) 42%, rgba(6,10,20,0.05) 60%),
      url('/images/minhati.jpg') center/cover no-repeat;
    display:flex;
    align-items:center;
    padding:3rem;
  }

  .card{
    width:100%;
    max-width:400px;
    background:rgba(13,20,38,0.68);
    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);
    border:1px solid rgba(255,255,255,0.14);
    border-radius:20px;
    padding:2.25rem 2rem;
    box-shadow:0 24px 60px rgba(0,0,0,0.45);
    color:#fff;
  }

  .card-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:2rem;
  }
  .brand{
    display:flex;
    align-items:center;
    gap:0.55rem;
    font-family:'Space Grotesk', sans-serif;
    font-weight:600;
    font-size:1.05rem;
  }
  .brand .mark{
    width:26px; height:26px;
    border-radius:8px;
    background:linear-gradient(135deg, #38DFEA, #4F8CFF);
    display:flex; align-items:center; justify-content:center;
    font-size:0.85rem; font-weight:700; color:#0B1220;
  }
  .lang{
    font-size:0.78rem;
    color:rgba(255,255,255,0.65);
    display:flex;
    align-items:center;
    gap:0.3rem;
    cursor:pointer;
  }

  h1{
    font-family:'Space Grotesk', sans-serif;
    font-weight:700;
    font-size:1.65rem;
    line-height:1.25;
    margin-bottom:1.75rem;
    max-width:15ch;
  }

  .form-group{ margin-bottom:1.15rem; }
  label{
    display:block;
    font-size:0.78rem;
    font-weight:600;
    color:rgba(255,255,255,0.75);
    margin-bottom:0.45rem;
  }
  .input-wrap{ position:relative; }
  .input-wrap svg{
    position:absolute;
    left:0.85rem;
    top:50%;
    transform:translateY(-50%);
    opacity:0.55;
    pointer-events:none;
  }
  .input-wrap input{
    width:100%;
    padding:0.75rem 0.9rem 0.75rem 2.5rem;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.16);
    border-radius:10px;
    color:#fff;
    font-size:0.92rem;
    font-family:'Inter', sans-serif;
    transition:border-color .15s, background .15s;
  }
  .input-wrap input::placeholder{ color:rgba(255,255,255,0.35); }
  .input-wrap input:focus{
    outline:none;
    border-color:#38DFEA;
    background:rgba(255,255,255,0.09);
  }
  .input-wrap input.invalid{
    border-color:#FCA5A5;
  }
  .toggle-eye{
    position:absolute;
    right:0.85rem;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    opacity:0.55;
    background:none;
    border:none;
    padding:0;
    display:flex;
  }
  .toggle-eye:hover{ opacity:0.85; }

  .field-error{
    display:none;
    color:#FCA5A5;
    font-size:0.75rem;
    margin-top:0.35rem;
  }
  .field-error.show{ display:block; }

  .signup-btn{
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
  .signup-btn:hover{ filter:brightness(1.08); }
  .signup-btn:disabled{ opacity:0.6; cursor:not-allowed; }

  .footer{
    margin-top:1.6rem;
    text-align:center;
    font-size:0.85rem;
    color:rgba(255,255,255,0.6);
  }
  .footer a{
    color:#7DD3FC;
    text-decoration:none;
    font-weight:600;
  }
  .footer a:hover{ text-decoration:underline; }

  .alert{
    padding:0.65rem 0.85rem;
    border-radius:8px;
    margin-bottom:1.1rem;
    font-size:0.82rem;
    display:none;
  }
  .alert-error{ background:rgba(239,68,68,0.16); color:#FCA5A5; border:1px solid rgba(239,68,68,0.35); }
  .alert-success{ background:rgba(34,197,94,0.16); color:#86EFAC; border:1px solid rgba(34,197,94,0.35); }

  @media (max-width: 720px){
    body{ padding:1.25rem; align-items:flex-end; }
    .card{ max-width:100%; }
  }
</style>
</head>
<body>

  <div class="card">
    <div class="card-top">
      <div class="brand">
        <span class="mark">A</span>
        AI StudyPort
      </div>
      <div class="lang">English (US) ▾</div>
    </div>

    <h1>Create Your Account</h1>

    <div id="globalAlert" class="alert"></div>

    <form id="registerForm" novalidate>
      <div class="form-group">
        <label for="full_name">Full Name</label>
        <div class="input-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-44-6 8-6s8 2 8 6"/></svg>
          <input type="text" id="full_name" name="full_name" placeholder="Your full name" required>
        </div>
        <div class="field-error" id="err_full_name"></div>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <div class="input-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M4 6l8 7 8-7"/></svg>
          <input type="email" id="email" name="email" placeholder="you@example.com" required>
        </div>
        <div class="field-error" id="err_email"></div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
          <input type="password" id="password" name="password" placeholder="At least 8 characters" required>
          <button type="button" class="toggle-eye" data-target="password" aria-label="Show password">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
        <div class="field-error" id="err_password"></div>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <div class="input-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
          <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password" required>
          <button type="button" class="toggle-eye" data-target="password_confirmation" aria-label="Show password">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
        <div class="field-error" id="err_password_confirmation"></div>
      </div>

      <button type="submit" class="signup-btn" id="signupBtn">Create Account</button>
    </form>

    <div class="footer">
      Already have an account? <a href="{{ route('login') }}">Log In</a>
    </div>
  </div>

<script>
  const API_BASE_URL = "{{ url('/api') }}";
  const LOGIN_URL = "{{ route('login') }}";

  document.querySelectorAll('.toggle-eye').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const input = document.getElementById(btn.dataset.target);
      input.type = input.type === 'password' ? 'text' : 'password';
    });
  });

  function clearFieldErrors() {
    document.querySelectorAll('.field-error').forEach(function(el) {
      el.textContent = '';
      el.classList.remove('show');
    });
    document.querySelectorAll('.input-wrap input').forEach(function(el) {
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

  // US-01 client-side pre-check, mirrors FR-01's acceptance criteria so
  // the student sees the problem immediately, before hitting the network.
  function validateClientSide(values) {
    const errors = {};
    if (!values.full_name.trim()) {
      errors.full_name = 'Full name is required.';
    }
    if (!/^\S+@\S+\.\S+$/.test(values.email)) {
      errors.email = 'Enter a valid email address.';
    }
    if (values.password.length < 8) {
      errors.password = 'Password must be at least 8 characters long.';
    }
    if (values.password !== values.password_confirmation) {
      errors.password_confirmation = 'Password confirmation does not match.';
    }
    return errors;
  }

  document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const signupBtn = document.getElementById('signupBtn');
    const alertBox = document.getElementById('globalAlert');
    alertBox.style.display = 'none';
    clearFieldErrors();

    const values = {
      full_name: document.getElementById('full_name').value,
      email: document.getElementById('email').value,
      password: document.getElementById('password').value,
      password_confirmation: document.getElementById('password_confirmation').value,
    };

    const clientErrors = validateClientSide(values);
    if (Object.keys(clientErrors).length > 0) {
      Object.entries(clientErrors).forEach(function([field, message]) {
        showFieldError(field, message);
      });
      return;
    }

    signupBtn.disabled = true;
    signupBtn.textContent = 'Creating account...';

    try {
      const response = await fetch(`${API_BASE_URL}/register`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(values)
      });

      const data = await response.json();

      if (response.ok) {
        alertBox.textContent = 'Account created successfully. Redirecting to login...';
        alertBox.className = 'alert alert-success';
        alertBox.style.display = 'block';

        setTimeout(function() { window.location.href = LOGIN_URL; }, 900);
      } else if (response.status === 422 && data.errors) {
        // Laravel validation errors: { field: ["message", ...] }
        // Alt scenarios: duplicate email / short password rejected with
        // a clear, field-adjacent message (US-01, NFR-12).
        Object.entries(data.errors).forEach(function([field, messages]) {
          showFieldError(field, messages[0]);
        });
      } else {
        alertBox.textContent = data.message || 'Registration failed. Please try again.';
        alertBox.className = 'alert alert-error';
        alertBox.style.display = 'block';
      }
    } catch (error) {
      alertBox.textContent = 'Could not connect to the server. Make sure your Laravel backend is running.';
      alertBox.className = 'alert alert-error';
      alertBox.style.display = 'block';
    } finally {
      signupBtn.disabled = false;
      signupBtn.textContent = 'Create Account';
    }
  });
</script>

</body>
</html>