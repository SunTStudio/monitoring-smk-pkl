@extends('layouts.app')

@section('title', '403 — Akses Terlarang')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        min-height: 100vh;
    }

    .error-page-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Shield Character */
    .shield-char {
        animation: floatBounce 3s ease-in-out infinite;
        filter: drop-shadow(0 20px 40px rgba(239, 68, 68, 0.4));
    }

    @keyframes floatBounce {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-16px); }
    }

    /* Laser beams */
    .laser-bar {
        animation: laserPulse 1.5s ease-in-out infinite alternate;
    }
    @keyframes laserPulse {
        0% { opacity: 0.6; }
        100% { opacity: 1; }
    }

    /* Number 403 */
    .error-code {
        font-size: 7rem;
        font-weight: 900;
        letter-spacing: -0.05em;
        background: linear-gradient(135deg, #ef4444, #f97316, #fbbf24);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        text-shadow: none;
    }

    /* Glitch effect on error code */
    .error-code {
        position: relative;
        animation: glitchPop 4s ease-in-out infinite;
    }
    @keyframes glitchPop {
        0%, 90%, 100% { transform: translateX(0); filter: none; }
        92% { transform: translateX(-3px); filter: hue-rotate(90deg); }
        94% { transform: translateX(3px); filter: hue-rotate(-90deg); }
        96% { transform: translateX(-2px); }
        98% { transform: translateX(2px); }
    }

    .badge-403 {
        display: inline-block;
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.4);
        color: #fca5a5;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        padding: 4px 14px;
        border-radius: 999px;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .error-title {
        color: #f1f5f9;
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
    }

    .error-desc {
        color: #94a3b8;
        font-size: 0.95rem;
        line-height: 1.7;
        max-width: 400px;
    }

    /* Action buttons */
    .btn-home {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border: none;
        padding: 10px 28px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.25s ease;
        box-shadow: 0 4px 20px rgba(239, 68, 68, 0.4);
    }
    .btn-home:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(239, 68, 68, 0.55);
        color: white;
    }

    .btn-back {
        background: transparent;
        color: #94a3b8;
        border: 1px solid rgba(148, 163, 184, 0.3);
        padding: 10px 24px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.25s ease;
    }
    .btn-back:hover {
        background: rgba(148, 163, 184, 0.1);
        color: #f1f5f9;
        border-color: rgba(148, 163, 184, 0.5);
    }

    /* Background particles */
    .particle-grid {
        position: fixed;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
        z-index: 0;
    }

    .particle {
        position: absolute;
        border-radius: 50%;
        opacity: 0.08;
        animation: drift linear infinite;
    }

    @keyframes drift {
        0% { transform: translate(0, 100vh) rotate(0deg); opacity: 0; }
        10% { opacity: 0.1; }
        90% { opacity: 0.1; }
        100% { transform: translate(20px, -80px) rotate(360deg); opacity: 0; }
    }

    .content-404 {
        position: relative;
        z-index: 1;
    }

    /* Grid dots background */
    .dot-bg {
        position: fixed;
        inset: 0;
        background-image: radial-gradient(circle, rgba(148,163,184,0.07) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
        z-index: 0;
    }

    .scan-line {
        animation: scanPulse 2s ease-in-out infinite;
    }
    @keyframes scanPulse {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 0.9; }
    }

    .eye-blink {
        animation: blink 4s ease-in-out infinite;
    }
    @keyframes blink {
        0%, 94%, 100% { transform: scaleY(1); }
        96% { transform: scaleY(0.1); }
    }

    .alert-dot {
        animation: alertPing 1.2s ease-in-out infinite;
    }
    @keyframes alertPing {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.4); opacity: 0.5; }
    }
</style>
@endsection

@section('content')
<!-- Dot Grid BG -->
<div class="dot-bg"></div>

<!-- Floating particles -->
<div class="particle-grid" id="particles"></div>

<div class="error-page-wrapper content-404">
    <div class="container">
        <div class="row align-items-center justify-content-center g-5">

            <!-- Left: Illustration -->
            <div class="col-lg-5 col-md-6 text-center order-md-1 order-2">
                <svg viewBox="0 0 320 360" xmlns="http://www.w3.org/2000/svg" class="shield-char" style="width: 100%; max-width: 300px;">
                    <defs>
                        <radialGradient id="bgGlow" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:0.2"/>
                            <stop offset="100%" style="stop-color:#0f172a;stop-opacity:0"/>
                        </radialGradient>
                        <linearGradient id="shieldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#dc2626;"/>
                            <stop offset="100%" style="stop-color:#991b1b;"/>
                        </linearGradient>
                        <linearGradient id="shieldShine" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#fca5a5;stop-opacity:0.25"/>
                            <stop offset="60%" style="stop-color:#ef4444;stop-opacity:0"/>
                        </linearGradient>
                        <linearGradient id="bodyGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#1e3a5f;"/>
                            <stop offset="100%" style="stop-color:#0f2140;"/>
                        </linearGradient>
                        <linearGradient id="helmetGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#334155;"/>
                            <stop offset="100%" style="stop-color:#1e293b;"/>
                        </linearGradient>
                        <filter id="glow">
                            <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                            <feMerge><feMergeNode in="coloredBlur"/><feMergeNode in="SourceGraphic"/></feMerge>
                        </filter>
                    </defs>

                    <!-- Background glow circle -->
                    <ellipse cx="160" cy="310" rx="110" ry="25" fill="rgba(239,68,68,0.15)"/>
                    <circle cx="160" cy="185" r="140" fill="url(#bgGlow)"/>

                    <!-- === ROBOT GUARD CHARACTER === -->

                    <!-- Shadow -->
                    <ellipse cx="160" cy="345" rx="75" ry="12" fill="rgba(0,0,0,0.35)"/>

                    <!-- Legs -->
                    <rect x="128" y="295" width="24" height="40" rx="10" fill="#1e293b"/>
                    <rect x="168" y="295" width="24" height="40" rx="10" fill="#1e293b"/>
                    <!-- Boots -->
                    <rect x="123" y="326" width="32" height="16" rx="8" fill="#0f172a"/>
                    <rect x="163" y="326" width="32" height="16" rx="8" fill="#0f172a"/>

                    <!-- Body -->
                    <rect x="118" y="200" width="84" height="100" rx="18" fill="url(#bodyGrad)"/>
                    <!-- Body stripe detail -->
                    <rect x="118" y="220" width="84" height="6" rx="2" fill="rgba(239,68,68,0.4)"/>
                    <rect x="118" y="285" width="84" height="5" rx="2" fill="rgba(239,68,68,0.3)"/>
                    <!-- Belt buckle -->
                    <rect x="145" y="272" width="30" height="16" rx="5" fill="#1e293b"/>
                    <rect x="151" y="276" width="18" height="8" rx="3" fill="#ef4444"/>

                    <!-- Arms -->
                    <!-- Left arm -->
                    <rect x="88" y="208" width="32" height="22" rx="10" fill="#1e293b"/>
                    <rect x="68" y="218" width="28" height="20" rx="9" fill="#334155"/>
                    <!-- Left hand holding shield (lower) -->
                    <ellipse cx="76" cy="248" rx="14" ry="14" fill="#1e293b"/>
                    <!-- Right arm -->
                    <rect x="200" y="208" width="32" height="22" rx="10" fill="#1e293b"/>
                    <rect x="220" y="218" width="28" height="18" rx="9" fill="#334155"/>
                    <!-- Right hand stop gesture -->
                    <ellipse cx="248" cy="220" rx="13" ry="16" fill="#f5d0a9"/>
                    <!-- Palm lines -->
                    <line x1="241" y1="214" x2="255" y2="214" stroke="#d4956a" stroke-width="1.5" stroke-linecap="round"/>
                    <line x1="240" y1="220" x2="256" y2="220" stroke="#d4956a" stroke-width="1.5" stroke-linecap="round"/>
                    <line x1="241" y1="226" x2="255" y2="226" stroke="#d4956a" stroke-width="1.5" stroke-linecap="round"/>

                    <!-- Neck -->
                    <rect x="146" y="186" width="28" height="18" rx="6" fill="#1e293b"/>

                    <!-- Helmet / Head -->
                    <rect x="115" y="120" width="90" height="75" rx="30" fill="url(#helmetGrad)"/>
                    <!-- Helmet top bump -->
                    <ellipse cx="160" cy="122" rx="36" ry="12" fill="#2d3f55"/>
                    <!-- Helmet visor / face area -->
                    <rect x="128" y="138" width="64" height="44" rx="12" fill="#0f172a"/>
                    <!-- Visor glow border -->
                    <rect x="128" y="138" width="64" height="44" rx="12" fill="none" stroke="#ef4444" stroke-width="2" opacity="0.7"/>

                    <!-- Eyes -->
                    <g class="eye-blink" style="transform-origin: 148px 158px;">
                        <ellipse cx="148" cy="158" rx="10" ry="10" fill="#ef4444" filter="url(#glow)"/>
                        <ellipse cx="148" cy="158" rx="6" ry="6" fill="#fca5a5"/>
                        <ellipse cx="150" cy="156" rx="2" ry="2" fill="white"/>
                    </g>
                    <g class="eye-blink" style="transform-origin: 172px 158px;">
                        <ellipse cx="172" cy="158" rx="10" ry="10" fill="#ef4444" filter="url(#glow)"/>
                        <ellipse cx="172" cy="158" rx="6" ry="6" fill="#fca5a5"/>
                        <ellipse cx="174" cy="156" rx="2" ry="2" fill="white"/>
                    </g>

                    <!-- Scan line across visor -->
                    <rect class="scan-line" x="130" y="170" width="60" height="3" rx="1.5" fill="#ef4444" filter="url(#glow)"/>

                    <!-- Helmet details -->
                    <circle cx="126" cy="140" r="5" fill="#334155"/>
                    <circle cx="194" cy="140" r="5" fill="#334155"/>
                    <!-- Antenna -->
                    <rect x="157" y="105" width="6" height="20" rx="3" fill="#334155"/>
                    <circle class="alert-dot" cx="160" cy="102" r="7" fill="#ef4444" filter="url(#glow)"/>
                    <circle cx="160" cy="102" r="4" fill="#fca5a5"/>

                    <!-- Badge on chest -->
                    <rect x="134" y="232" width="52" height="30" rx="6" fill="rgba(239,68,68,0.15)" stroke="#ef4444" stroke-width="1.5" opacity="0.8"/>
                    <text x="160" y="244" font-family="monospace" font-size="7" fill="#fca5a5" text-anchor="middle" font-weight="bold">SECURITY</text>
                    <text x="160" y="256" font-family="monospace" font-size="8" fill="#ef4444" text-anchor="middle" font-weight="bold">GUARD</text>

                    <!-- SHIELD (in left hand / front) -->
                    <g transform="translate(52, 240)">
                        <!-- Shield body -->
                        <path d="M35 5 L65 5 Q72 5 72 18 L72 42 Q72 62 35 78 Q-2 62 -2 42 L-2 18 Q-2 5 5 5 Z" fill="url(#shieldGrad)"/>
                        <!-- Shield shine -->
                        <path d="M35 5 L65 5 Q72 5 72 18 L72 42 Q72 62 35 78 Q-2 62 -2 42 L-2 18 Q-2 5 5 5 Z" fill="url(#shieldShine)"/>
                        <!-- Shield border -->
                        <path d="M35 5 L65 5 Q72 5 72 18 L72 42 Q72 62 35 78 Q-2 62 -2 42 L-2 18 Q-2 5 5 5 Z" fill="none" stroke="#fca5a5" stroke-width="2.5" opacity="0.5"/>
                        <!-- Shield inner border -->
                        <path d="M35 13 L59 13 Q65 13 65 24 L65 42 Q65 57 35 69 Q5 57 5 42 L5 24 Q5 13 11 13 Z" fill="none" stroke="#fca5a5" stroke-width="1" opacity="0.3"/>
                        <!-- Lock icon on shield -->
                        <rect x="28" y="36" width="14" height="12" rx="3" fill="#fca5a5"/>
                        <path d="M30 36 L30 30 Q30 22 35 22 Q40 22 40 30 L40 36" fill="none" stroke="#fca5a5" stroke-width="2.5" stroke-linecap="round"/>
                        <circle cx="35" cy="41" r="2" fill="#dc2626"/>
                    </g>

                    <!-- Laser beam barriers -->
                    <line class="laser-bar" x1="20" y1="310" x2="300" y2="310" stroke="#ef4444" stroke-width="3" stroke-linecap="round" filter="url(#glow)" opacity="0.8"/>
                    <line class="laser-bar" x1="20" y1="310" x2="300" y2="310" stroke="#fca5a5" stroke-width="1" stroke-linecap="round" opacity="0.5"/>
                    <!-- Laser nodes -->
                    <circle cx="20" cy="310" r="5" fill="#ef4444" filter="url(#glow)"/>
                    <circle cx="300" cy="310" r="5" fill="#ef4444" filter="url(#glow)"/>
                    <!-- Laser posts -->
                    <rect x="14" y="285" width="12" height="30" rx="5" fill="#334155"/>
                    <rect x="294" y="285" width="12" height="30" rx="5" fill="#334155"/>
                </svg>
            </div>

            <!-- Right: Error content -->
            <div class="col-lg-5 col-md-6 text-center text-md-start order-md-2 order-1">
                <span class="badge-403">Error 403 Forbidden</span>
                <h1 class="error-code mb-3">403</h1>
                <h2 class="error-title">Akses Anda Diblokir!</h2>
                <p class="error-desc mb-4">
                    Penjaga keamanan sistem menolak permintaan Anda. Halaman ini membutuhkan
                    <strong class="text-orange-300" style="color: #fdba74;">hak akses khusus</strong>
                    yang tidak dimiliki akun Anda saat ini.
                    <br><br>
                    <span class="text-slate-400" style="color: #94a3b8; font-size: 0.85rem;">
                        Jika Anda merasa ini adalah kesalahan, silakan hubungi Administrator sekolah untuk mendapatkan hak akses yang sesuai.
                    </span>
                </p>

                <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-md-start">
                    <a href="{{ url('/') }}" class="btn-home">
                        <i class="bi bi-house-fill"></i> Kembali ke Beranda
                    </a>
                    <a href="javascript:history.back()" class="btn-back">
                        <i class="bi bi-arrow-left"></i> Halaman Sebelumnya
                    </a>
                </div>

                <div class="mt-5 p-3 rounded-3" style="background: rgba(239, 68, 68, 0.06); border: 1px solid rgba(239, 68, 68, 0.2); max-width: 380px;">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-shield-lock-fill text-danger fs-5 mt-1"></i>
                        <div>
                            <p class="mb-0 small" style="color: #94a3b8; font-size: 0.82rem;">
                                <strong style="color: #fca5a5;">Kode Status:</strong> 403 Forbidden — User does not have the right roles.<br>
                                Akun Anda login dengan peran yang tidak memiliki izin untuk mengakses sumber daya ini.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Generate floating particle background
    (function() {
        const container = document.getElementById('particles');
        const colors = ['#ef4444','#f97316','#fbbf24','#64748b','#3b82f6'];
        for (let i = 0; i < 22; i++) {
            const el = document.createElement('div');
            const size = Math.random() * 20 + 6;
            el.className = 'particle';
            el.style.cssText = `
                width: ${size}px;
                height: ${size}px;
                left: ${Math.random() * 100}%;
                top: ${Math.random() * 100}%;
                background: ${colors[Math.floor(Math.random() * colors.length)]};
                animation-duration: ${Math.random() * 12 + 8}s;
                animation-delay: ${Math.random() * 6}s;
            `;
            container.appendChild(el);
        }
    })();
</script>
@endsection
