<!DOCTYPE html>
<html
    lang="{{ app()->getLocale() }}"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jisr AI | {{ __('common.cv_upload_title') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <style>
        #appShell { display: none; }

        .topbar-links {
            display: flex;
            align-items: center;
            gap: var(--sp-3);
        }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: var(--fs-sm);
            font-weight: 600;
        }
        .back-link:hover { color: var(--text); }

        main {
            max-width: 640px;
            margin: 3rem auto;
            padding: 0 var(--sp-6);
        }

        .dropzone {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 2.25rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: border-color var(--ease), background var(--ease);
        }
        .dropzone:hover,
        .dropzone.dragover {
            border-color: var(--accent);
            background: rgba(56, 223, 234, .06);
        }
        .dropzone input[type="file"] { display: none; }
        .dropzone .dz-icon { font-size: 2rem; margin-bottom: var(--sp-2); }
        .dropzone .dz-text { font-size: var(--fs-sm); color: var(--text-muted); }
        .dropzone .dz-hint { font-size: var(--fs-xs); color: var(--text-faint); margin-top: var(--sp-1); }

        .file-chip {
            display: none;
            align-items: center;
            justify-content: space-between;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: var(--sp-3);
            margin-top: var(--sp-4);
            font-size: var(--fs-sm);
        }
        .file-chip.show { display: flex; }
        .file-chip .remove-file {
            color: var(--err);
            cursor: pointer;
            font-weight: 600;
            background: none;
            border: none;
            font-size: var(--fs-sm);
        }

        .field-error {
            display: none;
            color: var(--err);
            font-size: var(--fs-xs);
            margin-top: var(--sp-2);
        }
        .field-error.show { display: block; }

        #reviewSection { display: none; }

        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: var(--sp-2);
            margin-top: var(--sp-2);
        }
        .tag {
            display: flex;
            align-items: center;
            gap: var(--sp-2);
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-pill);
            padding: .35rem .75rem;
            font-size: var(--fs-sm);
        }
        .tag button {
            background: none;
            border: none;
            color: var(--text-faint);
            cursor: pointer;
            font-size: var(--fs-sm);
            line-height: 1;
        }
        .tag button:hover { color: var(--err); }

        .add-tag-row {
            display: flex;
            gap: var(--sp-2);
            margin-top: var(--sp-3);
        }
        .add-tag-row input {
            flex: 1;
            padding: .55rem .75rem;
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            font-size: var(--fs-sm);
        }
        .add-tag-row button {
            padding: .55rem .9rem;
            background: var(--surface-3);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text);
            cursor: pointer;
            font-size: var(--fs-sm);
            font-weight: 600;
        }
        .add-tag-row button:hover { background: rgba(255,255,255,.18); }

        .review-block { margin-bottom: var(--sp-6); }

        .confirm-btn {
            width: 100%;
            padding: .8rem;
            background: linear-gradient(135deg, #34D399, #22C55E);
            color: #06210F;
            border: none;
            border-radius: var(--radius);
            font-size: var(--fs-base);
            font-weight: 700;
            font-family: var(--font);
            cursor: pointer;
            transition: filter var(--ease);
        }
        .confirm-btn:hover { filter: brightness(1.08); }
        .confirm-btn:disabled { opacity: .6; cursor: not-allowed; }

        .loading-screen {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: var(--text);
            font-size: var(--fs-sm);
            opacity: .7;
        }

        @media (max-width: 720px) {
            main { padding: 0 var(--sp-4); margin: var(--sp-6) auto; }
        }
    </style>
<style>
/* Jisr shared profile/CV page styling. Header and footer remain shared components. */
html { color-scheme: light; }
html[data-theme="dark"] { color-scheme: dark; }
body { font-family: 'Cairo','Inter',system-ui,sans-serif; background: radial-gradient(circle at 85% 0%,rgba(0,198,255,.09),transparent 32%),#f5f9ff; color:#163456; }
body.theme-dark { background:radial-gradient(circle at 80% 0%,rgba(0,198,255,.09),transparent 34%),#08172d; }
#appShell { min-height:100vh; }
#appShell main { max-width:850px; width:calc(100% - 36px); margin:42px auto 60px; padding:0; }
#appShell .card { border-radius:22px; padding:clamp(22px,4vw,42px); border:1px solid #dce9f6; background:#fff; box-shadow:0 15px 45px rgba(10,46,107,.055); margin-bottom:22px; }
#appShell h1 { font-family:'Cairo','Inter',sans-serif; font-size:clamp(24px,3vw,32px); color:#0a2e6b; }
#appShell h2 { font-family:'Cairo','Inter',sans-serif; color:#0a2e6b; }
#appShell .sub { line-height:1.85; font-size:14px; color:#667d97; }
#appShell label { font-family:inherit; font-size:14px; font-weight:700; }
#appShell input:not([type=file]),#appShell textarea,#appShell select { font-family:inherit; border-radius:12px; min-height:48px; }
#appShell input:focus,#appShell textarea:focus,#appShell select:focus { outline:2px solid rgba(0,198,255,.25); outline-offset:1px; border-color:#00a7db; }
#appShell .save-btn,#appShell .btn-primary,#appShell .confirm-btn { background:linear-gradient(110deg,#0a2e6b,#087ec0); color:white; border-radius:12px; min-height:48px; font-family:inherit; font-weight:700; }
#appShell .dropzone { background:#f6fbff; border-color:#a9cfe6; border-radius:18px; }
#appShell .dropzone:hover,#appShell .dropzone.dragover { background:#eaf6ff; border-color:#00a7db; }
#appShell .dropzone:focus-visible { outline:3px solid #00c6ff; outline-offset:3px; }
#appShell .tag { border-radius:10px; }
html[data-theme="dark"] body,body.theme-dark { color:#e3ecfa; }
html[data-theme="dark"] #appShell .card,body.theme-dark #appShell .card { background:#10233f; border-color:#26415f; box-shadow:0 16px 48px rgba(0,0,0,.14); }
html[data-theme="dark"] #appShell h1,html[data-theme="dark"] #appShell h2,body.theme-dark #appShell h1,body.theme-dark #appShell h2 { color:#edf7ff; }
html[data-theme="dark"] #appShell .sub,body.theme-dark #appShell .sub { color:#afc6dc; }
html[data-theme="dark"] #appShell .dropzone,body.theme-dark #appShell .dropzone { background:#132b48; border-color:#3a6580; }
html[dir="rtl"] #appShell input,html[dir="rtl"] #appShell textarea,html[dir="rtl"] #appShell select { text-align:right; }
@media(max-width:600px){#appShell main{width:calc(100% - 24px);margin:24px auto 42px}#appShell .card{padding:22px 18px}}
</style>
</head>

<body>

<div class="loading-screen" id="loadingScreen">{{ __('common.preparing_dashboard') }}</div>

<div id="appShell">

    @include('components.jisr-header')

    <main>

        <div class="card">
            <h1>{{ __('common.cv_upload_title') }}</h1>
            <p class="sub" id="pageSub">{{ __('common.cv_upload_subtitle') }}</p>

            <div id="globalAlert" class="alert"></div>

            <form id="uploadForm" novalidate>

                <div class="dropzone" id="dropzone" role="button" tabindex="0" aria-label="{{ __('common.dropzone_text') }}">
                    <input type="file" id="fileInput" name="file" accept="application/pdf">
                    <div class="dz-icon">&#128196;</div>
                    <div class="dz-text">{{ __('common.dropzone_text') }}</div>
                    <div class="dz-hint">{{ __('common.dropzone_hint') }}</div>
                </div>
                <div class="field-error" id="err_file"></div>

                <div class="file-chip" id="fileChip">
                    <span id="fileChipName"></span>
                    <button type="button" class="remove-file" id="removeFile">{{ __('common.remove_file') }}</button>
                </div>

                <button type="submit" class="btn-primary btn-block" id="uploadBtn" style="margin-top:1.1rem;">
                    {{ __('common.upload_cv_btn') }}
                </button>

            </form>
        </div>

        <div class="card" id="reviewSection">
            <h2>{{ __('common.review_extracted_info') }}</h2>
            <p class="sub">{{ __('common.review_extracted_subtitle') }}</p>

            <div id="reviewAlert" class="alert"></div>

            <div class="review-block">
                <label>{{ __('common.skills_label') }}</label>
                <div class="tag-list" id="skillsTags"></div>
                <div class="add-tag-row">
                    <input type="text" id="newSkill" placeholder="{{ __('common.add_skill_placeholder') }}">
                    <button type="button" id="addSkillBtn">{{ __('common.add_btn') }}</button>
                </div>
            </div>

            <div class="review-block">
                <label>{{ __('common.education_label') }}</label>
                <div class="tag-list" id="educationTags"></div>
                <div class="add-tag-row">
                    <input type="text" id="newEducation" placeholder="{{ __('common.add_education_placeholder') }}">
                    <button type="button" id="addEducationBtn">{{ __('common.add_btn') }}</button>
                </div>
            </div>

            <div class="review-block">
                <label>{{ __('common.qualifications_label') }}</label>
                <div class="tag-list" id="qualificationsTags"></div>
                <div class="add-tag-row">
                    <input type="text" id="newQualification" placeholder="{{ __('common.add_qualification_placeholder') }}">
                    <button type="button" id="addQualificationBtn">{{ __('common.add_btn') }}</button>
                </div>
            </div>

            <button type="button" class="confirm-btn" id="confirmBtn">
                {{ __('common.confirm_and_continue') }}
            </button>
        </div>

    </main>
    @include('components.jisr-footer')

</div>

<script>
    const API_BASE_URL = "/api";
    const LOGIN_URL = "{{ route('login') }}";
    const DASHBOARD_URL = "{{ route('dashboard') }}";

    const TEXT = {
        uploading: @json(__('common.uploading')),
        analyzingCv: @json(__('common.analyzing_cv')),
        pdfOnlyError: @json(__('common.pdf_only_error')),
        fileSizeError: @json(__('common.file_size_error')),
        choosePdfError: @json(__('common.choose_pdf_error')),
        cvUploadedAnalyzing: @json(__('common.cv_uploaded_analyzing')),
        cvAnalyzedSuccess: @json(__('common.cv_analyzed_success')),
        cvUploadFailed: @json(__('common.cv_upload_failed')),
        cvAnalyzeFailed: @json(__('common.cv_analyze_failed')),
        saveFailed: @json(__('common.save_failed')),
        savedRedirecting: @json(__('common.saved_redirecting')),
        connectionError: @json(__('common.connection_error')),
        uploadCvBtn: @json(__('common.upload_cv_btn')),
        saving: @json(__('common.saving')),
        confirmAndContinue: @json(__('common.confirm_and_continue')),
    };

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
            'Accept-Language': document.documentElement.lang || 'en',
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

    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const fileChip = document.getElementById('fileChip');
    const fileChipName = document.getElementById('fileChipName');
    const errFile = document.getElementById('err_file');

    dropzone.addEventListener('click', () => fileInput.click());
    dropzone.addEventListener('keydown', (e) => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); fileInput.click(); } });

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
            errFile.textContent = TEXT.pdfOnlyError;
            errFile.classList.add('show');
            selectedFile = null;
            fileChip.classList.remove('show');
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            errFile.textContent = TEXT.fileSizeError;
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
            errFile.textContent = TEXT.choosePdfError;
            errFile.classList.add('show');
            return;
        }

        const formData = new FormData();
        formData.append('file', selectedFile);

        uploadBtn.disabled = true;
        uploadBtn.innerHTML = '<span class="spinner" style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-inline-end:6px;"></span>' + TEXT.uploading;

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
                    showAlert(alertBox, uploadData.message || TEXT.cvUploadFailed, 'error');
                }
                return;
            }

            currentCv = uploadData;
            showAlert(alertBox, TEXT.cvUploadedAnalyzing, 'success');

            uploadBtn.innerHTML = '<span class="spinner" style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-inline-end:6px;"></span>' + TEXT.analyzingCv;

            const extractResponse = await fetch(`${API_BASE_URL}/cvs/${currentCv.cv_id}/extract`, {
                method: 'POST',
                headers: authHeaders(token)
            });

            const extractData = await extractResponse.json();

            if (!extractResponse.ok) {
                showAlert(alertBox, extractData.message || TEXT.cvAnalyzeFailed, 'error');
                return;
            }

            currentCv = extractData;
            showAlert(alertBox, TEXT.cvAnalyzedSuccess, 'success');
            loadReviewData(extractData);
            document.getElementById('reviewSection').style.display = 'block';
            document.getElementById('reviewSection').scrollIntoView({ behavior: 'smooth' });
        } catch (error) {
            showAlert(alertBox, TEXT.connectionError, 'error');
        } finally {
            uploadBtn.disabled = false;
            uploadBtn.textContent = TEXT.uploadCvBtn;
        }
    });

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
        confirmBtn.innerHTML = '<span class="spinner" style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-inline-end:6px;"></span>' + TEXT.saving;

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
                showAlert(reviewAlert, data.message || TEXT.saveFailed, 'error');
                return;
            }

            showAlert(reviewAlert, TEXT.savedRedirecting, 'success');
            setTimeout(function () {
                window.location.href = DASHBOARD_URL + '?cv_updated=1#recommendations';
            }, 900);
        } catch (error) {
            showAlert(reviewAlert, TEXT.connectionError, 'error');
        } finally {
            confirmBtn.disabled = false;
            confirmBtn.textContent = TEXT.confirmAndContinue;
        }
    });
</script>


</body>
</html>