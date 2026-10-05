body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f3f6fb;
    color: #1f2937;
}

* {
    box-sizing: border-box;
}

.login-body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
}

.login-card {
    width: min(420px, 90vw);
    background: #fff;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

.login-card h2 {
    margin-top: 0;
    margin-bottom: 20px;
    text-align: center;
}

.login-card form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.login-card input,
.login-card button,
.form-grid input,
.form-grid textarea,
.form-grid select,
.inline-form select,
button {
    width: 100%;
    padding: 10px 12px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    font-size: 14px;
}

.login-card button,
button {
    background: #2563eb;
    color: #fff;
    border: none;
    cursor: pointer;
    font-weight: 600;
}

.app-shell {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 250px;
    background: #0f172a;
    color: #fff;
    padding: 20px 18px;
}

.sidebar h2 {
    margin-bottom: 24px;
    font-size: 28px;
}

.sidebar nav {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sidebar nav a {
    color: #dbeafe;
    text-decoration: none;
    padding: 10px 12px;
    border-radius: 10px;
}

.sidebar nav a:hover {
    background: rgba(255,255,255,0.08);
}

.user-box {
    margin-top: 40px;
    background: rgba(255,255,255,0.06);
    padding: 12px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.content {
    flex: 1;
    padding: 28px;
}

.page-header {
    margin-bottom: 20px;
}

.page-header h1 {
    margin: 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card {
    background: #fff;
    padding: 20px;
    border-radius: 14px;
    box-shadow: 0 8px 18px rgba(15,23,42,0.06);
}

.stat-card span {
    display: block;
    color: #6b7280;
    margin-bottom: 10px;
    font-size: 14px;
}

.stat-card strong {
    font-size: 28px;
}

.panel {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 8px 18px rgba(15,23,42,0.06);
    margin-bottom: 20px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(220px, 1fr));
    gap: 14px;
}

.form-grid .full {
    grid-column: 1 / -1;
}

label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.table th,
.table td {
    border: 1px solid #e5e7eb;
    padding: 10px;
    vertical-align: top;
    text-align: left;
}

.table th {
    background: #f9fafb;
}

.inline-form {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.inline-form select {
    width: auto;
    min-width: 150px;
}

.btn {
    display: inline-block;
    background: #10b981;
    color: #fff;
    text-decoration: none;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
}

.alert {
    padding: 12px 14px;
    border-radius: 10px;
    margin-bottom: 18px;
}

.alert.success {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.error {
    color: #b91c1c;
    margin-bottom: 12px;
}

@media (max-width: 900px) {
    .app-shell {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
    }

    .content {
        padding: 18px;
    }
}
