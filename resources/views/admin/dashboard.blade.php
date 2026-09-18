<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manhati AI | Admin Dashboard</title>

    <link
        rel="stylesheet"
        href="{{ asset('adminlte/css/adminlte.min.css') }}"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        body {
            background: #f4f6f9;
        }

        .brand-text {
            font-weight: 700;
        }

        .content-header h1 {
            font-weight: 700;
        }

        .small-box h3 {
            font-size: 28px;
            font-weight: 700;
        }

        .small-box p {
            margin-bottom: 0;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-inactive {
            background: #f8d7da;
            color: #842029;
        }

        .loading-area {
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .sidebar-brand-text {
            font-weight: 700;
            font-size: 20px;
        }
    </style>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- Header -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        data-lte-toggle="sidebar"
                        href="#"
                        role="button"
                    >
                        <i class="bi bi-list"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <span
                        class="nav-link"
                        id="adminName"
                    >
                        Admin
                    </span>
                </li>

                <li class="nav-item">
                    <button
                        type="button"
                        class="btn btn-outline-danger btn-sm mt-1"
                        onclick="logout()"
                    >
                        Logout
                    </button>
                </li>
            </ul>

        </div>
    </nav>

    <!-- Sidebar -->
    <aside
        class="app-sidebar bg-body-secondary shadow"
        data-bs-theme="dark"
    >

        <div class="sidebar-brand">
            <a
                href="/admin/dashboard"
                class="brand-link text-decoration-none"
            >
                <span class="sidebar-brand-text">
                    Manhati AI
                </span>
            </a>
        </div>

        <div class="sidebar-wrapper">

            <nav class="mt-2">

                <ul
                    class="nav sidebar-menu flex-column"
                    data-lte-toggle="treeview"
                    role="menu"
                >

                    <li class="nav-item">
                        <a
                            href="/admin/dashboard"
                            class="nav-link active"
                        >
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            href="#usersSection"
                            class="nav-link"
                        >
                            <i class="nav-icon bi bi-people"></i>
                            <p>Users</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            href="#actionsSection"
                            class="nav-link"
                        >
                            <i class="nav-icon bi bi-clock-history"></i>
                            <p>Admin Activity</p>
                        </a>
                    </li>

                </ul>

            </nav>

        </div>

    </aside>

    <!-- Main -->
    <main class="app-main">

        <div class="app-content-header">
            <div class="container-fluid">

                <div class="row">

                    <div class="col-sm-6">
                        <h1 class="mb-0">
                            Admin Dashboard
                        </h1>

                        <p class="text-muted mb-0 mt-1">
                            Platform overview and impact statistics
                        </p>
                    </div>

                </div>

            </div>
        </div>

        <div class="app-content">

            <div class="container-fluid">

                <!-- Stats -->
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3 id="totalUsers">-</h3>
                                <p>Total Users</p>
                            </div>

                            <i
                                class="small-box-icon bi bi-people-fill"
                            ></i>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3 id="activeStudents">-</h3>
                                <p>Active Students</p>
                            </div>

                            <i
                                class="small-box-icon bi bi-mortarboard-fill"
                            ></i>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3 id="activeScholarships">-</h3>
                                <p>Active Scholarships</p>
                            </div>

                            <i
                                class="small-box-icon bi bi-award-fill"
                            ></i>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-danger">
                            <div class="inner">
                                <h3 id="recommendations">-</h3>
                                <p>AI Recommendations</p>
                            </div>

                            <i
                                class="small-box-icon bi bi-stars"
                            ></i>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Platform Activity
                                </h3>
                            </div>

                            <div class="card-body">

                                <div
                                    class="d-flex justify-content-between border-bottom py-3"
                                >
                                    <span>
                                        <i class="bi bi-shield-check me-2"></i>
                                        Administrators
                                    </span>

                                    <strong id="admins">-</strong>
                                </div>

                                <div
                                    class="d-flex justify-content-between border-bottom py-3"
                                >
                                    <span>
                                        <i class="bi bi-file-earmark-check me-2"></i>
                                        Saved Applications
                                    </span>

                                    <strong id="savedApplications">-</strong>
                                </div>

                                <div
                                    class="d-flex justify-content-between py-3"
                                >
                                    <span>
                                        <i class="bi bi-stars me-2"></i>
                                        Generated AI Matches
                                    </span>

                                    <strong id="recommendationsSecondary">-</strong>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Manhati AI Impact
                                </h3>
                            </div>

                            <div class="card-body">

                                <p class="text-muted">
                                    Manhati AI helps students move through a
                                    complete scholarship journey:
                                </p>

                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge text-bg-primary">
                                        Discover
                                    </span>

                                    <span class="badge text-bg-info">
                                        Match
                                    </span>

                                    <span class="badge text-bg-warning">
                                        Improve
                                    </span>

                                    <span class="badge text-bg-secondary">
                                        Prepare
                                    </span>

                                    <span class="badge text-bg-success">
                                        Apply
                                    </span>

                                    <span class="badge text-bg-dark">
                                        Track
                                    </span>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- Recent Users -->
                <div
                    class="card"
                    id="usersSection"
                >

                    <div class="card-header">
                        <h3 class="card-title">
                            Recent Users
                        </h3>
                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover mb-0">

                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>

                                <tbody id="recentUsers">

                                    <tr>
                                        <td colspan="5">
                                            <div class="loading-area">
                                                Loading users...
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

                <!-- Admin Activity -->
                <div
                    class="card"
                    id="actionsSection"
                >

                    <div class="card-header">
                        <h3 class="card-title">
                            Recent Admin Activity
                        </h3>
                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover mb-0">

                                <thead>
                                    <tr>
                                        <th>Admin</th>
                                        <th>Action</th>
                                        <th>Target</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody id="recentActions">

                                    <tr>
                                        <td colspan="4">
                                            <div class="loading-area">
                                                Loading activity...
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <footer class="app-footer">

        <strong>
            Manhati AI
        </strong>

        <div class="float-end d-none d-sm-inline">
            AI Scholarship Success Platform
        </div>

    </footer>

</div>

<script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>

<script>
    const API_BASE_URL = '/api';

    const token = localStorage.getItem('token');

    function authHeaders() {
        return {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
        };
    }

    function escapeHtml(value) {
        if (value === null || value === undefined) {
            return '';
        }

        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function formatDate(value) {
        if (!value) {
            return '-';
        }

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return '-';
        }

        return date.toLocaleDateString();
    }

    async function verifyAdmin() {

        if (!token) {
            window.location.href = '/login';
            return false;
        }

        try {

            const response = await fetch(
                `${API_BASE_URL}/me`,
                {
                    headers: authHeaders()
                }
            );

            if (!response.ok) {
                throw new Error('Authentication failed.');
            }

            const user = await response.json();

            if (user.role !== 'admin') {
                window.location.href = '/dashboard';
                return false;
            }

            document.getElementById('adminName').textContent =
                user.full_name || 'Admin';

            return true;

        } catch (error) {

            localStorage.removeItem('token');

            window.location.href = '/login';

            return false;
        }
    }

    async function loadDashboard() {

        try {

            const response = await fetch(
                `${API_BASE_URL}/admin/dashboard-stats`,
                {
                    headers: authHeaders()
                }
            );

            if (response.status === 401) {
                window.location.href = '/login';
                return;
            }

            if (response.status === 403) {
                window.location.href = '/dashboard';
                return;
            }

            if (!response.ok) {
                throw new Error(
                    'Unable to load dashboard statistics.'
                );
            }

            const data = await response.json();

            document.getElementById('totalUsers').textContent =
                data.total_users ?? 0;

            document.getElementById('activeStudents').textContent =
                data.active_students ?? 0;

            document.getElementById('admins').textContent =
                data.admins ?? 0;

            document.getElementById('activeScholarships').textContent =
                data.active_scholarships ?? 0;

            document.getElementById('recommendations').textContent =
                data.recommendations ?? 0;

            document.getElementById(
                'recommendationsSecondary'
            ).textContent =
                data.recommendations ?? 0;

            document.getElementById(
                'savedApplications'
            ).textContent =
                data.saved_applications ?? 0;

            renderRecentUsers(data.recent_users || []);

            renderRecentActions(
                data.recent_admin_actions || []
            );

        } catch (error) {

            console.error(error);

            document.getElementById('recentUsers').innerHTML = `
                <tr>
                    <td colspan="5" class="text-danger text-center py-4">
                        Unable to load dashboard data.
                    </td>
                </tr>
            `;

            document.getElementById('recentActions').innerHTML = `
                <tr>
                    <td colspan="4" class="text-danger text-center py-4">
                        Unable to load admin activity.
                    </td>
                </tr>
            `;
        }
    }

    function renderRecentUsers(users) {

        const tbody =
            document.getElementById('recentUsers');

        if (!users.length) {

            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-4">
                        No users found.
                    </td>
                </tr>
            `;

            return;
        }

        tbody.innerHTML = users.map(user => {

            const statusClass = user.is_active
                ? 'status-active'
                : 'status-inactive';

            const statusText = user.is_active
                ? 'Active'
                : 'Inactive';

            return `
                <tr>
                    <td>
                        ${escapeHtml(user.full_name || '-')}
                    </td>

                    <td>
                        ${escapeHtml(user.email || '-')}
                    </td>

                    <td>
                        ${escapeHtml(user.role || '-')}
                    </td>

                    <td>
                        <span class="status-badge ${statusClass}">
                            ${statusText}
                        </span>
                    </td>

                    <td>
                        ${formatDate(user.created_at)}
                    </td>
                </tr>
            `;

        }).join('');
    }

    function renderRecentActions(actions) {

        const tbody =
            document.getElementById('recentActions');

        if (!actions.length) {

            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-4">
                        No recent admin actions.
                    </td>
                </tr>
            `;

            return;
        }

        tbody.innerHTML = actions.map(action => {

            const adminName =
                action.admin?.full_name
                || action.admin?.email
                || `Admin #${action.admin_id}`;

            return `
                <tr>
                    <td>
                        ${escapeHtml(adminName)}
                    </td>

                    <td>
                        ${escapeHtml(action.action_type || '-')}
                    </td>

                    <td>
                        ${escapeHtml(action.target_table || '-')}
                        ${action.target_id
                            ? `#${escapeHtml(action.target_id)}`
                            : ''
                        }
                    </td>

                    <td>
                        ${formatDate(action.created_at)}
                    </td>
                </tr>
            `;

        }).join('');
    }

    async function logout() {

        try {

            await fetch(
                `${API_BASE_URL}/logout`,
                {
                    method: 'POST',
                    headers: authHeaders()
                }
            );

        } catch (error) {
            console.error(error);
        }

        localStorage.removeItem('token');

        window.location.href = '/login';
    }

    async function init() {

        const isAdmin = await verifyAdmin();

        if (!isAdmin) {
            return;
        }

        await loadDashboard();
    }

    init();
</script>

</body>
</html>