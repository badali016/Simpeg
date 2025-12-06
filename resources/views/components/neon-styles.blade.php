<style>
    /* Light Modern Theme: neutral palette, soft shadows, readable type */
    :root {
        --primary: #2563eb; /* Blue-600 */
        --muted: #6b7280;   /* Gray-500 */
        --bg: #f8fafc;      /* Gray-50 */
        --surface: #ffffff; /* White cards */
        --card-border: rgba(15, 23, 42, 0.06);
        --radius: 10px;
    }

    /* Global body */
    body {
        background-color: var(--bg) !important;
        color: #0f172a !important; /* Slate-900 text */
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Background wrapper: subtle gradient instead of heavy neon */
    .neon-background-wrapper {
        position: fixed;
        inset: 0;
        z-index: -1;
        background: linear-gradient(180deg, #ffffff 0%, #f1f5f9 100%);
        pointer-events: none;
    }

    /* Decorative soft shapes for a modern look */
    .tech-grid { display: none; }
    .shape-blob { opacity: 0.06; }
    .shape-1, .shape-2 { width: 200px; height: 200px; }
    .ambient-glow { display: none; }

    /* Navbar & Sidebar: light surfaces */
    #layout-navbar {
        background-color: var(--surface) !important;
        border-bottom: 1px solid var(--card-border) !important;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
    }

    #layout-menu {
        background-color: var(--surface) !important;
        border-right: 1px solid var(--card-border) !important;
        box-shadow: none;
    }

    /* Menu and nav text */
    .menu-link, .nav-link, .app-brand-text, .fw-semibold {
        color: #0f172a !important;
    }
    .menu-item.active .menu-link {
        background-color: rgba(37, 99, 235, 0.06) !important; /* subtle blue */
        color: var(--primary) !important;
        border-right: 3px solid var(--primary);
    }
    .menu-icon { color: var(--muted) !important; }
    .menu-item.active .menu-icon { color: var(--primary) !important; }

    /* Content wrapper: default background and padding preserved */
    .content-wrapper { background: transparent !important; }

    /* Card style: light, rounded, soft shadow */
    .card, .neon-card {
        background-color: var(--surface) !important;
        border: 1px solid var(--card-border) !important;
        border-radius: var(--radius) !important;
        box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06) !important;
        color: #0f172a !important;
    }

    .card-header { background-color: transparent !important; border-bottom: 1px solid rgba(15,23,42,0.04) !important; color: #0f172a !important; }

    /* Forms and inputs: make inputs visible and consistent */
    input[type="text"], input[type="email"], select, textarea {
        background-color: #fff !important;
        border: 1px solid rgba(15,23,42,0.08) !important;
        color: #0f172a !important;
        padding: 0.5rem 0.75rem !important;
        border-radius: 8px !important;
        box-shadow: none !important;
    }
    input:focus, select:focus, textarea:focus { outline: 2px solid rgba(37,99,235,0.12) !important; border-color: rgba(37,99,235,0.3) !important; }

    /* Table styles: light header, soft hover */
    .table thead th {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
        border-bottom: 1px solid rgba(15,23,42,0.06) !important;
        font-weight: 600;
    }
    .table tbody tr:hover { background-color: rgba(15,23,42,0.02) !important; cursor: pointer; }
    .table td { color: #0f172a !important; border-color: rgba(15,23,42,0.04) !important; }

    /* Dropdowns */
    .dropdown-menu { background-color: var(--surface) !important; border: 1px solid var(--card-border) !important; }
    .dropdown-item { color: #0f172a !important; }
    .dropdown-item:hover { background-color: rgba(37,99,235,0.06) !important; }

    /* Footer */
    .footer { background-color: transparent !important; color: var(--muted) !important; }
</style>

<style>
    /* Ensure readability for admin/pegawai pages that use the main layout
       This overrides leftover dark-theme utility classes (like Tailwind `text-white`)
       Only affects pages that include the main layout (`app.blade.php`) because
       login/register use their own standalone templates. */
    .layout-wrapper .content-wrapper, .layout-wrapper .layout-page {
        color: #0f172a !important;
    }

    /* Elements that still have `text-white` should be readable on light surfaces */
    .layout-wrapper .text-white {
        color: #0f172a !important;
    }

    /* Inputs previously styled as dark (bg-slate-800) -> make them light and readable */
    .layout-wrapper input.bg-slate-800,
    .layout-wrapper select.bg-slate-800,
    .layout-wrapper textarea.bg-slate-800,
    .layout-wrapper .rounded-md.bg-slate-800 {
        background-color: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid rgba(15,23,42,0.06) !important;
    }

    /* Buttons or badges that used white text on dark backgrounds: keep their background
       but ensure inner text color is readable. For most bg-* utilities we leave them.
       For specific accent badges that used `text-white`, ensure contrast. */
    .layout-wrapper .text-white.bg-emerald-600,
    .layout-wrapper .text-white.bg-red-600,
    .layout-wrapper .text-white.bg-indigo-600,
    .layout-wrapper .text-white.bg-slate-700 {
        color: #ffffff !important; /* keep white when background is colored */
    }

    /* Table cells forced to white text — make them dark */
    .layout-wrapper table .text-white { color: #0f172a !important; }

    /* Links that had text-white should look like primary links now */
    .layout-wrapper a.text-white { color: var(--primary) !important; }
</style>