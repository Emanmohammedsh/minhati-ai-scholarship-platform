<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AI StudyPort - Login</title>
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

  .forgot{
    display:block;
    text-align:right;
    font-size:0.8rem;
    color:#7DD3FC;
    text-decoration:none;
    margin:-0.4rem 0 1.25rem;
  }
  .forgot:hover{ text-decoration:underline; }

  .login-btn{
    width:100%;
    padding:0.8rem;
    background:linear-gradient(135deg, #38DFEA, #4F8CFF);
    color:#0B1220;
    border:none;
    border-radius:10px;
    font-size:0.95rem;
    font-weight:700;
    font-family:'Inter', sans-serif;
    cursor:pointer;
    transition:filter .15s, transform .15s;
  }
  .login-btn:hover{ filter:brightness(1.08); }
  .login-btn:disabled{ opacity:0.6; cursor:not-allowed; }

  .divider{
    text-align:center;
    margin:1.4rem 0;
    color:rgba(255,255,255,0.45);
    font-size:0.8rem;
    position:relative;
  }
  .divider::before, .divider::after{
    content:"";
    position:absolute;
    top:50%;
    width:40%;
    height:1px;
    background:rgba(255,255,255,0.15);
  }
  .divider::before{ left:0; }
  .divider::after{ right:0; }

  .google-btn{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    padding:0.75rem;
    background:#fff;
    color:#1f2937;
    border:none;
    border-radius:10px;
    font-size:0.9rem;
    font-weight:600;
    text-decoration:none;
    cursor:pointer;
    transition:filter .15s;
  }
  .google-btn:hover{ filter:brightness(0.97); }

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

    <h1>Unlock Your Global Potential</h1>

    <div id="globalAlert" class="alert"></div>

    <form id="loginForm">
      <div class="form-group">
        <label for="email">Email or Student ID</label>
        <div class="input-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M4 4h16v16H4z" opacity="0"/><path d="M4 6l8 7 8-7"/><rect x="3" y="5" width="18" height="14" rx="2"/></svg>
          <input type="text" id="email" name="email" placeholder="you@example.com" required>
        </div>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
          <input type="password" id="password" name="password" placeholder="••••••••" required>
          <button type="button" class="toggle-eye" id="toggleEye" aria-label="Show password">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <a href="#" class="forgot">Forgot Password?</a>

      <button type="submit" class="login-btn" id="loginBtn">Log In with AI StudyPort</button>
    </form>

    <div class="divider">or</div>

    <a href="http://127.0.0.1:8000/api/auth/google/redirect" class="google-btn">
      <svg width="18" height="18" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59L2.56 13.22C.92 16.46 0 20.12 0 24s.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
      Sign in with Google
    </a>

    <div class="footer">
      Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
    </div>
  </div>

<script>
  const API_BASE_URL = "{{ url('/api') }}";
  const DASHBOARD_URL = "{{ route('dashboard') }}";

  document.getElementById('toggleEye').addEventListener('click', function() {
    const pw = document.getElementById('password');
    pw.type = pw.type === 'password' ? 'text' : 'password';
  });

  document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const loginBtn = document.getElementById('loginBtn');
    const alertBox = document.getElementById('globalAlert');
    alertBox.style.display = 'none';

    loginBtn.disabled = true;
    loginBtn.textContent = 'Signing in...';

    const payload = {
      email: document.getElementById('email').value,
      password: document.getElementById('password').value
    };

    try {
      const response = await fetch(`${API_BASE_URL}/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      const data = await response.json();

      if (response.ok) {
        // AuthController returns "access_token", not "token".
        if (data.access_token) {
          localStorage.setItem('auth_token', data.access_token);
          localStorage.setItem('auth_user', JSON.stringify(data.user));
        }

        alertBox.textContent = 'Signed in successfully!';
        alertBox.className = 'alert alert-success';
        alertBox.style.display = 'block';

        setTimeout(function () {
          window.location.href = DASHBOARD_URL;
        }, 600);
      } else if (response.status === 422 && data.errors) {
        const firstErrorKey = Object.keys(data.errors)[0];
        alertBox.textContent = data.errors[firstErrorKey][0];
        alertBox.className = 'alert alert-error';
        alertBox.style.display = 'block';
      } else {
        alertBox.textContent = data.message || 'Invalid email or password.';
        alertBox.className = 'alert alert-error';
        alertBox.style.display = 'block';
      }
    } catch (error) {
      alertBox.textContent = 'Could not connect to the server. Make sure your Laravel backend is running.';
      alertBox.className = 'alert alert-error';
      alertBox.style.display = 'block';
    } finally {
      loginBtn.disabled = false;
      loginBtn.textContent = 'Log In with AI StudyPort';
    }
  });
</script>

</body>
</html>