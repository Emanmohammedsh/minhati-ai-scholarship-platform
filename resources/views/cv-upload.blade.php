<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AI StudyPort - Upload CV</title>
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
    margin-bottom:1.5rem;
  }

  h1{
    font-family:'Space Grotesk', sans-serif;
    font-weight:700;
    font-size:1.5rem;
    margin-bottom:0.4rem;
  }
  h2{
    font-family:'Space Grotesk', sans-serif;
    font-weight:600;
    font-size:1.1rem;
    margin-bottom:0.9rem;
  }
  .sub{
    color:rgba(255,255,255,0.6);
    font-size:0.88rem;
    margin-bottom:1.75rem;
  }

  .dropzone{
    border:2px dashed rgba(255,255,255,0.25);
    border-radius:14px;
    padding:2.25rem 1.5rem;
    text-align:center;
    cursor:pointer;
    transition:border-color .15s, background .15s;
  }
  .dropzone:hover, .dropzone.dragover{
    border-color:#38DFEA;
    background:rgba(56,223,234,0.06);
  }
  .dropzone input[type="file"]{ display:none; }
  .dropzone .dz-icon{ font-size:2rem; margin-bottom:0.6rem; }
  .dropzone .dz-text{ font-size:0.9rem; color:rgba(255,255,255,0.75); }
  .dropzone .dz-hint{ font-size:0.75rem; color:rgba(255,255,255,0.45); margin-top:0.35rem; }

  .file-chip{
    display:none;
    align-items:center;
    justify-content:space-between;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.16);
    border-radius:10px;
    padding:0.65rem 0.9rem;
    margin-top:1rem;
    font-size:0.85rem;
  }
  .file-chip.show{ display:flex; }
  .file-chip .remove-file{
    color:#FCA5A5;
    cursor:pointer;
    font-weight:600;
    background:none;
    border:none;
    font-size:0.85rem;
  }

  .field-error{
    display:none;
    color:#FCA5A5;
    font-size:0.75rem;
    margin-top:0.5rem;
  }
  .field-error.show{ display:block; }

  .upload-btn{
    width:100%;
    padding:0.8rem;
    margin-top:1.1rem;
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
  .upload-btn:hover{ filter:brightness(1.08); }
  .upload-btn:disabled{ opacity:0.6; cursor:not-allowed; }

  .alert{
    padding:0.65rem 0.85rem;
    border-radius:8px;
    margin-bottom:1.1rem;
    font-size:0.82rem;
    display:none;
  }
  .alert-error{ background:rgba(239,68,68,0.16); color:#FCA5A5; border:1px solid rgba(239,68,68,0.35); }
  .alert-success{ background:rgba(34,197,94,0.16); color:#86EFAC; border:1px solid rgba(34,197,94,0.35); }
  .alert-info{ background:rgba(79,140,255,0.16); color:#93C5FD; border:1px solid rgba(79,140,255,0.35); }

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

  #reviewSection{ display:none; }

  .tag-list{
    display:flex;
    flex-wrap:wrap;
    gap:0.5rem;
    margin-top:0.5rem;
  }
  .tag{
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.16);
    border-radius:999px;
    padding:0.35rem 0.75rem;
    font-size:0.8rem;
    display:flex;
    align-items:center;
    gap:0.4rem;
  }
  .tag button{
    background:none;
    border:none;
    color:rgba(255,255,255,0.5);
    cursor:pointer;
    font-size:0.8rem;
    line-height:1;
  }
  .tag button:hover{ color:#FCA5A5; }

  .add-tag-row{
    display:flex;
    gap:0.5rem;
    margin-top:0.6rem;
  }
  .add-tag-row input{
    flex:1;
    padding:0.55rem 0.75rem;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.16);
    border-radius:8px;
    color:#fff;
    font-size:0.85rem;
  }
  .add-tag-row button{
    padding:0.55rem 0.9rem;
    background:rgba(255,255,255,0.1);
    border:1px solid rgba(255,255,255,0.16);
    border-radius:8px;
    color:#fff;
    cursor:pointer;
    font-size:0.85rem;
    font-weight:600;
  }
  .add-tag-row button:hover{ background:rgba(255,255,255,0.16); }

  .review-block{ margin-bottom:1.4rem; }
  .review-block label{
    display:block;
    font-size:0.78rem;
    font-weight:600;
    color:rgba(255,255,255,0.75);
    margin-bottom:0.3rem;
  }

  .confirm-btn{
    width:100%;
    padding:0.8rem;
    background:linear-gradient(135deg, #34D399, #22C55E);
    color:#06210F;
    border:none;
    border-radius:10px;
    font-size:0.95rem;
    font-weight:700;
    font-family:'Inter', sans-serif;
    cursor:pointer;
    transition:filter .15s;
  }
  .confirm-btn:hover{ filter:brightness(1.08); }
  .confirm-btn:disabled{ opacity:0.6; cursor:not-allowed; }

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
        <a href="{{ route('dashboard') }}" class="back-link">&larr; Back to dashboard</a>
      </div>
    </div>

    <main>
      <div class="card">
        <h1>Upload your CV</h1>
        <p class="sub" id="pageSub">Upload a PDF of your CV so we can extract your skills, education, and qualifications and match you with scholarships.</p>

        <div id="globalAlert" class="alert"></div>

        <form id="uploadForm" novalidate>
          <div class="dropzone" id="dropzone">
            <input type="file" id="fileInput" name="file" accept="application/pdf">
            <div class="dz-icon">&#128196;</div>
            <div class="dz-text">Click to choose a file or drag it here</div>
            <div class="dz-hint">PDF only, max 5MB</div>
          </div>
          <div class="field-error" id="err_file"></div>

          <div class="file-chip" id="fileChip">
            <span id="fileChipName"></span>
            <button type="button" class="remove-file" id="removeFile">Remove</button>
          </div>

          <button type="submit" class="upload-btn" id="uploadBtn">Upload CV</button>
        </form>
      </div>

      <div class="card" id="reviewSection">
        <h2>Review extracted information</h2>
        <p class="sub">We pulled the following details from your CV. Review and adjust before we use this to match you with scholarships.</p>

        <div id="reviewAlert" class="alert"></div>

        <div class="review-block">
          <label>Skills</label>
          <div class="tag-list" id="skillsTags"></div>
          <div class="add-tag-row">
            <input type="text" id="newSkill" placeholder="Add a skill">
            <button type="button" id="addSkillBtn">Add</button>
          </div>
        </div>

        <div class="review-block">
          <label>Education</label>
          <div class="tag-list" id="educationTags"></div>
          <div class="add-tag-row">
            <input type="text" id="newEducation" placeholder="Add an education entry">
            <button type="button" id="addEducationBtn">Add</button>
          </div>
        </div>

        <div class="review-block">
          <label>Qualifications</label>
          <div class="tag-list" id="qualificationsTags"></div>
          <div class="add-tag-row">
            <input type="text" id="newQualification" placeholder="Add a qualification">
            <button type="button" id="addQualificationBtn">Add</button>
          </div>
        </div>

        <button type="button" class="confirm-btn" id="confirmBtn">Confirm and continue</button>
      </div>
    </main>
  </div>

<script>
  const API_BASE_URL = "{{ url('/api') }}";
  const LOGIN_URL = "{{ route('login') }}";
  const DASHBOARD_URL = "{{ route('dashboard') }}";

  let selectedFile = null;
  let currentCv = null;
  let reviewData = { skills: [], education: [], qualifications: [] };

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

  function showAlert(box, message, type) {
    box.textContent = message;
    box.className = 'alert alert-' + type;
    box.style.display = 'block';
  }

  function hideAlert(box) {
    box.style.display = 'none';
  }

  document.addEventListener('DOMContentLoaded', function () {
    const token = localStorage.getItem('auth_token');
    if (!token) {
      goToLogin();
      return;
    }
    document.getElementById('loadingScreen').style.display = 'none';
    document.getElementById('appShell').style.display = 'block';
  });

  // --- File selection ---
  const dropzone = document.getElementById('dropzone');
  const fileInput = document.getElementById('fileInput');
  const fileChip = document.getElementById('fileChip');
  const fileChipName = document.getElementById('fileChipName');
  const errFile = document.getElementById('err_file');

  dropzone.addEventListener('click', () => fileInput.click());

  dropzone.addEventListener('dragover', function (e) {
    e.preventDefault();
    dropzone.classList.add('dragover');
  });
  dropzone.addEventListener('dragleave', function () {
    dropzone.classList.remove('dragover');
  });
  dropzone.addEventListener('drop', function (e) {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    if (e.dataTransfer.files && e.dataTransfer.files[0]) {
      setSelectedFile(e.dataTransfer.files[0]);
    }
  });

  fileInput.addEventListener('change', function () {
    if (fileInput.files && fileInput.files[0]) {
      setSelectedFile(fileInput.files[0]);
    }
  });

  function setSelectedFile(file) {
    errFile.textContent = '';
    errFile.classList.remove('show');

    if (file.type !== 'application/pdf') {
      errFile.textContent = 'PDF only.';
      errFile.classList.add('show');
      selectedFile = null;
      fileChip.classList.remove('show');
      return;
    }
    if (file.size > 5 * 1024 * 1024) {
      errFile.textContent = 'File exceeds 5MB.';
      errFile.classList.add('show');
      selectedFile = null;
      fileChip.classList.remove('show');
      return;
    }

    selectedFile = file;
    fileChipName.textContent = file.name;
    fileChip.classList.add('show');
  }

  document.getElementById('removeFile').addEventListener('click', function () {
    selectedFile = null;
    fileInput.value = '';
    fileChip.classList.remove('show');
  });

  // --- Upload + extract ---
  document.getElementById('uploadForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const token = localStorage.getItem('auth_token');
    if (!token) {
      goToLogin();
      return;
    }

    const uploadBtn = document.getElementById('uploadBtn');
    const alertBox = document.getElementById('globalAlert');
    hideAlert(alertBox);
    errFile.textContent = '';
    errFile.classList.remove('show');

    if (!selectedFile) {
      errFile.textContent = 'Please choose a PDF file to upload.';
      errFile.classList.add('show');
      return;
    }

    const formData = new FormData();
    formData.append('file', selectedFile);

    uploadBtn.disabled = true;
    uploadBtn.innerHTML = '<span class="spinner"></span>Uploading...';

    try {
      const uploadResponse = await fetch(`${API_BASE_URL}/cvs`, {
        method: 'POST',
        headers: authHeaders(token),
        body: formData
      });

      const uploadData = await uploadResponse.json();

      if (uploadResponse.status === 401) {
        goToLogin();
        return;
      }

      if (!uploadResponse.ok) {
        if (uploadResponse.status === 422 && uploadData.errors && uploadData.errors.file) {
          errFile.textContent = uploadData.errors.file[0];
          errFile.classList.add('show');
        } else {
          showAlert(alertBox, uploadData.message || 'Could not upload your CV. Please try again.', 'error');
        }
        return;
      }

      currentCv = uploadData;
      showAlert(alertBox, 'CV uploaded. Analyzing your CV\u2026', 'info');

      uploadBtn.innerHTML = '<span class="spinner"></span>Analyzing...';

      const extractResponse = await fetch(`${API_BASE_URL}/cvs/${currentCv.cv_id}/extract`, {
        method: 'POST',
        headers: authHeaders(token)
      });

      const extractData = await extractResponse.json();

      if (!extractResponse.ok) {
        showAlert(alertBox, extractData.message || 'We could not analyze this CV. You can try uploading it again.', 'error');
        return;
      }

      currentCv = extractData;
      showAlert(alertBox, 'CV analyzed successfully. Review the details below.', 'success');
      loadReviewData(extractData);
      document.getElementById('reviewSection').style.display = 'block';
      document.getElementById('reviewSection').scrollIntoView({ behavior: 'smooth' });
    } catch (error) {
      showAlert(alertBox, 'Could not connect to the server. Make sure your Laravel backend is running.', 'error');
    } finally {
      uploadBtn.disabled = false;
      uploadBtn.textContent = 'Upload CV';
    }
  });

  // --- Review / tag editing ---
  function loadReviewData(cv) {
    reviewData.skills = Array.isArray(cv.extracted_skills) ? cv.extracted_skills.slice() : [];
    reviewData.education = Array.isArray(cv.extracted_education) ? cv.extracted_education.slice() : [];
    reviewData.qualifications = Array.isArray(cv.extracted_qualifications) ? cv.extracted_qualifications.slice() : [];
    renderTags('skills', 'skillsTags');
    renderTags('education', 'educationTags');
    renderTags('qualifications', 'qualificationsTags');
  }

  function renderTags(key, containerId) {
    const container = document.getElementById(containerId);
    container.innerHTML = '';
    reviewData[key].forEach(function (value, index) {
      const tag = document.createElement('span');
      tag.className = 'tag';
      const label = document.createElement('span');
      label.textContent = (typeof value === 'object' && value !== null)
        ? [value.degree, value.institution, value.year].filter(Boolean).join(' \u2014 ')
        : value;
      const removeBtn = document.createElement('button');
      removeBtn.type = 'button';
      removeBtn.textContent = '\u00D7';
      removeBtn.addEventListener('click', function () {
        reviewData[key].splice(index, 1);
        renderTags(key, containerId);
      });
      tag.appendChild(label);
      tag.appendChild(removeBtn);
      container.appendChild(tag);
    });
  }

  function wireAddTag(key, inputId, buttonId, containerId) {
    const input = document.getElementById(inputId);
    const button = document.getElementById(buttonId);
    function add() {
      const value = input.value.trim();
      if (!value) return;
      reviewData[key].push(value);
      input.value = '';
      renderTags(key, containerId);
    }
    button.addEventListener('click', add);
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        add();
      }
    });
  }

  wireAddTag('skills', 'newSkill', 'addSkillBtn', 'skillsTags');
  wireAddTag('education', 'newEducation', 'addEducationBtn', 'educationTags');
  wireAddTag('qualifications', 'newQualification', 'addQualificationBtn', 'qualificationsTags');

  // --- Confirm reviewed data (FR-08 / US-04) ---
  document.getElementById('confirmBtn').addEventListener('click', async function () {
    const token = localStorage.getItem('auth_token');
    if (!token) {
      goToLogin();
      return;
    }
    if (!currentCv) return;

    const confirmBtn = document.getElementById('confirmBtn');
    const reviewAlert = document.getElementById('reviewAlert');
    hideAlert(reviewAlert);

    confirmBtn.disabled = true;
    confirmBtn.innerHTML = '<span class="spinner"></span>Saving...';

    try {
      const response = await fetch(`${API_BASE_URL}/cvs/${currentCv.cv_id}/confirm`, {
        method: 'PUT',
        headers: {
          ...authHeaders(token),
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          skills: reviewData.skills,
          education: reviewData.education,
          qualifications: reviewData.qualifications
        })
      });

      const data = await response.json();

      if (response.status === 401) {
        goToLogin();
        return;
      }

      if (!response.ok) {
        showAlert(reviewAlert, data.message || 'Could not save your reviewed information. Please try again.', 'error');
        return;
      }

      showAlert(reviewAlert, 'Saved. Redirecting to your recommendations\u2026', 'success');
      setTimeout(function () {
        window.location.href = DASHBOARD_URL;
      }, 900);
    } catch (error) {
      showAlert(reviewAlert, 'Could not connect to the server. Make sure your Laravel backend is running.', 'error');
    } finally {
      confirmBtn.disabled = false;
      confirmBtn.textContent = 'Confirm and continue';
    }
  });
</script>

</body>
</html>
