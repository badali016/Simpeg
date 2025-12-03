<style>
    /* --- 1. ANIMASI & BACKGROUND --- */
    :root {
        --neon-primary: #0ea5e9; /* Sky Blue */
        --neon-dark: #0f172a;    /* Slate 900 */
        --glass-bg: rgba(15, 23, 42, 0.75); /* Warna kaca gelap */
        --glass-border: rgba(56, 189, 248, 0.2);
    }

    /* Reset Body Sneat */
    body {
        background-color: var(--neon-dark) !important;
        color: #e2e8f0 !important; /* Teks jadi putih gading */
    }

    .neon-background-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: -1; /* Taruh paling belakang */
        overflow: hidden;
        background-color: var(--neon-dark);
    }

    /* Grid Animation */
    .tech-grid {
        position: absolute;
        inset: 0;
        background-image: 
            linear-gradient(rgba(56, 189, 248, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(56, 189, 248, 0.05) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: gridMove 25s linear infinite;
    }

    /* Floating Shapes */
    .shape-blob {
        position: absolute;
        opacity: 0.2;
        color: var(--neon-primary);
        animation: floatShape 8s ease-in-out infinite;
    }
    .shape-1 { top: 10%; left: 5%; width: 150px; height: 150px; animation-delay: 0s; }
    .shape-2 { bottom: 15%; right: 5%; width: 100px; height: 100px; animation-delay: 2s; color: #6366f1; }

    .ambient-glow {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 600px; height: 600px;
        background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, rgba(15, 23, 42, 0) 70%);
        pointer-events: none;
    }

    @keyframes gridMove {
        0% { background-position: 0 0; }
        100% { background-position: 50px 50px; }
    }
    @keyframes floatShape {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* --- 2. OVERRIDE SNEAT TEMPLATE (GLASSMORPHISM) --- */
    
    /* Navbar Transparan */
    #layout-navbar {
        background-color: rgba(30, 41, 59, 0.7) !important; /* Slate 800 transparan */
        backdrop-filter: blur(10px) !important;
        border-bottom: 1px solid var(--glass-border);
        box-shadow: none !important;
    }
    
    /* Sidebar Transparan */
    #layout-menu {
        background-color: rgba(15, 23, 42, 0.85) !important; /* Lebih gelap dari navbar */
        backdrop-filter: blur(10px);
        border-right: 1px solid var(--glass-border);
    }
    
    /* Text di Sidebar & Navbar */
    .menu-link, .nav-link, .app-brand-text, .fw-semibold {
        color: #e2e8f0 !important;
    }
    .menu-item.active .menu-link {
        background-color: rgba(14, 165, 233, 0.15) !important; /* Biru muda transparan */
        color: #38bdf8 !important; /* Sky 400 */
        border-right: 3px solid #38bdf8;
    }
    .menu-icon {
        color: #94a3b8 !important; /* Slate 400 */
    }
    .menu-item.active .menu-icon {
        color: #38bdf8 !important;
    }

    /* Content Area & Cards */
    .content-wrapper {
        background: transparent !important;
    }
    
    /* Card Sneat jadi Glass */
    /* --- CARD STYLE: TOTAL SOLID (BLOCK) --- */
    .card {
        /* PENTING: Gunakan warna Hex Solid, jangan RGBa */
        background-color: #1e293b !important; /* Warna dasar Slate-800 Solid */
        
        /* Opsi Gradasi Solid (Agar terlihat metalik tapi tetap tidak tembus) */
        background: linear-gradient(to bottom, #1e293b 0%, #0f172a 100%) !important;
        
        /* MATIKAN BLUR (Karena sudah solid, blur tidak berguna) */
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;

        /* Pastikan Opacity 100% */
        opacity: 1 !important;

        /* Border Tech: Biru Muda Terang */
        border: 1px solid #38bdf8 !important; 
        
        /* Shadow Tebal agar terlihat melayang jauh dari background */
        box-shadow: 
            0 0 0 1px rgba(15, 23, 42, 1), /* Outline hitam tipis */
            0 20px 50px rgba(0, 0, 0, 0.9), /* Bayangan bawah pekat */
            0 0 20px rgba(56, 189, 248, 0.15) /* Glow biru tipis di luar */
            !important;
            
        color: #fff !important;
        border-radius: 12px !important;
        
        /* Supaya isinya tidak ikutan transparan */
        isolation: isolate;
    }

    /* Header Card Solid */
    .card-header {
        background-color: #0f172a !important; /* Warna lebih gelap solid */
        border-bottom: 1px solid #334155 !important;
        color: #fff !important;
    }

    /* --- TABLE STYLE --- */
    .table {
        background-color: transparent !important; /* Ikut warna card */
    }

    /* Header Tabel Solid */
    .table thead th {
        background-color: #020617 !important; /* Hitam pekat solid */
        color: #38bdf8 !important; /* Teks Biru Neon */
        border-bottom: 2px solid #334155 !important;
        text-transform: uppercase;
        font-weight: bold;
        letter-spacing: 0.5px;
    }

    /* Baris Tabel */
    .table tbody tr {
        background-color: transparent !important;
    }
    
    /* Warna selang-seling (Zebra striping) tapi SOLID */
    .table tbody tr:nth-of-type(odd) {
        background-color: rgba(255, 255, 255, 0.03) !important; /* Sangat tipis di atas solid */
    }

    /* Hover Effect */
    .table tbody tr:hover {
        background-color: #334155 !important; /* Warna highlight solid saat mouse lewat */
        cursor: pointer;
    }

    .table td {
        border-color: #334155 !important; /* Warna garis pemisah */
        color: #e2e8f0 !important;
    }

    /* Dropdown User */
    .dropdown-menu {
        background-color: #1e293b !important;
        border: 1px solid var(--glass-border) !important;
    }
    .dropdown-item {
        color: #e2e8f0 !important;
    }
    .dropdown-item:hover {
        background-color: rgba(56, 189, 248, 0.1) !important;
    }

    /* Footer */
    .footer {
        background-color: transparent !important;
    }
</style>