@extends('layouts.app')

@section('title', '404 — Halaman Tidak Ditemukan')

@section('styles')
<style>
    body { background: linear-gradient(135deg, #0f172a 0%, #1a1f35 50%, #0f172a 100%); min-height: 100vh; }
    .error-page-wrapper { min-height: 80vh; display: flex; align-items: center; justify-content: center; }
    .astronaut-char { animation: floatSpin 5s ease-in-out infinite; filter: drop-shadow(0 20px 40px rgba(99,102,241,0.4)); }
    @keyframes floatSpin {
        0%, 100% { transform: translateY(0px) rotate(-2deg); }
        50% { transform: translateY(-18px) rotate(2deg); }
    }
    .star { animation: twinkle linear infinite; }
    @keyframes twinkle {
        0%, 100% { opacity: 0.1; } 50% { opacity: 1; }
    }
    .error-code {
        font-size: 7rem; font-weight: 900; letter-spacing: -0.05em;
        background: linear-gradient(135deg, #818cf8, #6366f1, #4f46e5);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1;
        animation: glitchPop 5s ease-in-out infinite;
    }
    @keyframes glitchPop {
        0%, 90%, 100% { transform: translateX(0); filter: none; }
        92% { transform: translateX(-3px); filter: hue-rotate(60deg); }
        94% { transform: translateX(3px); filter: hue-rotate(-60deg); }
        96% { transform: translateX(-1px); } 98% { transform: translateX(1px); }
    }
    .badge-err { display:inline-block; background:rgba(99,102,241,0.15); border:1px solid rgba(99,102,241,0.4); color:#c7d2fe; font-size:.7rem; font-weight:700; letter-spacing:.15em; padding:4px 14px; border-radius:999px; text-transform:uppercase; margin-bottom:1rem; }
    .error-title { color:#f1f5f9; font-size:1.75rem; font-weight:800; margin-bottom:.75rem; }
    .error-desc { color:#94a3b8; font-size:.95rem; line-height:1.7; max-width:400px; }
    .btn-home { background:linear-gradient(135deg,#6366f1,#4f46e5); color:white; border:none; padding:10px 28px; border-radius:999px; font-weight:700; font-size:.9rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all .25s ease; box-shadow:0 4px 20px rgba(99,102,241,0.4); }
    .btn-home:hover { transform:translateY(-2px); box-shadow:0 8px 30px rgba(99,102,241,0.55); color:white; }
    .btn-back { background:transparent; color:#94a3b8; border:1px solid rgba(148,163,184,.3); padding:10px 24px; border-radius:999px; font-weight:600; font-size:.9rem; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all .25s ease; }
    .btn-back:hover { background:rgba(148,163,184,.1); color:#f1f5f9; border-color:rgba(148,163,184,.5); }
    .dot-bg { position:fixed; inset:0; background-image:radial-gradient(circle,rgba(148,163,184,.06) 1px,transparent 1px); background-size:32px 32px; pointer-events:none; z-index:0; }
    .particle { position:absolute; border-radius:50%; opacity:.08; animation:drift linear infinite; }
    @keyframes drift { 0%{transform:translate(0,100vh) rotate(0deg);opacity:0;} 10%{opacity:.1;} 90%{opacity:.1;} 100%{transform:translate(20px,-80px) rotate(360deg);opacity:0;} }
    .content-err { position:relative; z-index:1; }
    .orbit { animation: orbitSpin 6s linear infinite; transform-origin: 160px 200px; }
    @keyframes orbitSpin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .signal-ring { animation: signalPulse 2s ease-out infinite; transform-origin: 160px 180px; }
    @keyframes signalPulse { 0%{opacity:1;transform:scale(0.5);} 100%{opacity:0;transform:scale(1.8);} }
</style>
@endsection

@section('content')
<div class="dot-bg"></div>
<div class="position-fixed inset-0 overflow-hidden" style="pointer-events:none;z-index:0;" id="particles-container"></div>

<div class="error-page-wrapper content-err">
    <div class="container">
        <div class="row align-items-center justify-content-center g-5">
            <div class="col-lg-5 col-md-6 text-center order-md-1 order-2">
                <svg viewBox="0 0 320 380" xmlns="http://www.w3.org/2000/svg" class="astronaut-char" style="width:100%;max-width:290px;">
                    <defs>
                        <radialGradient id="glow404" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" style="stop-color:#6366f1;stop-opacity:.25"/>
                            <stop offset="100%" style="stop-color:#0f172a;stop-opacity:0"/>
                        </radialGradient>
                        <linearGradient id="suitGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#e2e8f0;"/>
                            <stop offset="100%" style="stop-color:#cbd5e1;"/>
                        </linearGradient>
                        <linearGradient id="helmetGrad404" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#bfdbfe;stop-opacity:.7"/>
                            <stop offset="100%" style="stop-color:#93c5fd;stop-opacity:.4"/>
                        </linearGradient>
                        <filter id="glow404f">
                            <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                            <feMerge><feMergeNode in="coloredBlur"/><feMergeNode in="SourceGraphic"/></feMerge>
                        </filter>
                    </defs>

                    <!-- Stars background -->
                    <circle class="star" cx="30" cy="40" r="2" fill="#818cf8" style="animation-duration:2.1s"/>
                    <circle class="star" cx="280" cy="60" r="1.5" fill="#c7d2fe" style="animation-duration:3.2s"/>
                    <circle class="star" cx="50" cy="120" r="1" fill="#a5b4fc" style="animation-duration:1.8s;animation-delay:.5s"/>
                    <circle class="star" cx="290" cy="150" r="2" fill="#818cf8" style="animation-duration:2.8s;animation-delay:1s"/>
                    <circle class="star" cx="20" cy="200" r="1.5" fill="#c7d2fe" style="animation-duration:4s;animation-delay:.3s"/>
                    <circle class="star" cx="300" cy="280" r="1" fill="#a5b4fc" style="animation-duration:2.4s;animation-delay:.8s"/>
                    <circle class="star" cx="260" cy="320" r="2" fill="#818cf8" style="animation-duration:3.5s"/>

                    <!-- Background glow -->
                    <circle cx="160" cy="190" r="130" fill="url(#glow404)"/>

                    <!-- Signal rings -->
                    <circle class="signal-ring" cx="160" cy="180" r="55" fill="none" stroke="#6366f1" stroke-width="1.5"/>
                    <circle class="signal-ring" cx="160" cy="180" r="55" fill="none" stroke="#6366f1" stroke-width="1" style="animation-delay:.7s"/>

                    <!-- Planet / broken map at bottom -->
                    <ellipse cx="160" cy="355" rx="90" ry="20" fill="rgba(99,102,241,0.15)" stroke="#6366f1" stroke-width="1" opacity=".5"/>
                    <text x="160" y="360" font-family="monospace" font-size="9" fill="#818cf8" text-anchor="middle" opacity=".7">?? UNKNOWN TERRITORY ??</text>

                    <!-- Shadow -->
                    <ellipse cx="160" cy="338" rx="60" ry="10" fill="rgba(0,0,0,.3)"/>

                    <!-- Legs -->
                    <rect x="132" y="285" width="22" height="42" rx="9" fill="#cbd5e1"/>
                    <rect x="166" y="285" width="22" height="42" rx="9" fill="#cbd5e1"/>
                    <!-- Boots -->
                    <rect x="125" y="318" width="32" height="14" rx="7" fill="#475569"/>
                    <rect x="163" y="318" width="32" height="14" rx="7" fill="#475569"/>

                    <!-- Body -->
                    <rect x="116" y="200" width="88" height="90" rx="20" fill="url(#suitGrad)"/>
                    <!-- Body stripes / NASA style -->
                    <rect x="116" y="218" width="88" height="5" rx="2" fill="#6366f1" opacity=".5"/>
                    <rect x="116" y="270" width="88" height="4" rx="2" fill="#6366f1" opacity=".4"/>
                    <!-- Control panel on chest -->
                    <rect x="134" y="230" width="52" height="32" rx="7" fill="#1e293b"/>
                    <circle cx="146" cy="242" r="5" fill="#22c55e"/>
                    <circle cx="160" cy="242" r="5" fill="#f59e0b"/>
                    <circle cx="174" cy="242" r="5" fill="#ef4444"/>
                    <rect x="138" y="252" width="44" height="4" rx="2" fill="#334155"/>
                    <rect x="138" y="258" width="30" height="4" rx="2" fill="#4f46e5" opacity=".7"/>

                    <!-- Arms -->
                    <rect x="85" y="208" width="34" height="22" rx="10" fill="#cbd5e1"/>
                    <rect x="67" y="220" width="26" height="18" rx="9" fill="#e2e8f0"/>
                    <!-- Glove left with question mark -->
                    <circle cx="72" cy="250" r="14" fill="#6366f1"/>
                    <text x="72" y="255" font-family="sans-serif" font-size="14" fill="white" text-anchor="middle" font-weight="900">?</text>

                    <rect x="201" y="208" width="34" height="22" rx="10" fill="#cbd5e1"/>
                    <rect x="227" y="218" width="26" height="18" rx="9" fill="#e2e8f0"/>
                    <!-- Glove right raised -->
                    <circle cx="245" cy="225" r="14" fill="#4f46e5"/>
                    <text x="245" y="230" font-family="sans-serif" font-size="14" fill="white" text-anchor="middle">🔦</text>

                    <!-- Neck ring -->
                    <rect x="144" y="188" width="32" height="16" rx="6" fill="#94a3b8"/>
                    <rect x="146" y="191" width="28" height="10" rx="4" fill="#6366f1" opacity=".4"/>

                    <!-- Helmet -->
                    <circle cx="160" cy="155" r="60" fill="#e2e8f0"/>
                    <circle cx="160" cy="155" r="60" fill="none" stroke="#94a3b8" stroke-width="4"/>
                    <!-- Visor -->
                    <ellipse cx="160" cy="158" rx="42" ry="38" fill="url(#helmetGrad404)"/>
                    <ellipse cx="160" cy="158" rx="42" ry="38" fill="none" stroke="#93c5fd" stroke-width="2"/>
                    <!-- Visor shine -->
                    <ellipse cx="148" cy="140" rx="12" ry="8" fill="rgba(255,255,255,0.25)" transform="rotate(-20,148,140)"/>

                    <!-- Face inside helmet -->
                    <!-- Eyes: big round, confused look -->
                    <circle cx="147" cy="155" r="10" fill="white"/>
                    <circle cx="173" cy="155" r="10" fill="white"/>
                    <circle cx="149" cy="157" r="6" fill="#4f46e5"/>
                    <circle cx="175" cy="157" r="6" fill="#4f46e5"/>
                    <circle cx="151" cy="155" r="2.5" fill="white"/>
                    <circle cx="177" cy="155" r="2.5" fill="white"/>
                    <!-- Sweat drop -->
                    <path d="M180 165 Q183 160 186 165 Q186 170 183 170 Z" fill="#93c5fd"/>
                    <!-- Confused eyebrows -->
                    <path d="M140 144 Q147 140 152 145" stroke="#334155" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                    <path d="M168 145 Q172 140 180 144" stroke="#334155" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                    <!-- Mouth: wavy / confused -->
                    <path d="M153 172 Q157 168 160 172 Q163 176 167 172" stroke="#334155" stroke-width="2" fill="none" stroke-linecap="round"/>

                    <!-- Helmet bolts -->
                    <circle cx="105" cy="145" r="5" fill="#94a3b8"/>
                    <circle cx="215" cy="145" r="5" fill="#94a3b8"/>
                    <circle cx="130" cy="100" r="4" fill="#94a3b8"/>
                    <circle cx="190" cy="100" r="4" fill="#94a3b8"/>

                    <!-- Orbiting question mark satellite -->
                    <g class="orbit">
                        <circle cx="220" cy="110" r="10" fill="#6366f1" filter="url(#glow404f)"/>
                        <text x="220" y="115" font-family="sans-serif" font-size="11" fill="white" text-anchor="middle" font-weight="900">?</text>
                    </g>
                </svg>
            </div>

            <div class="col-lg-5 col-md-6 text-center text-md-start order-md-2 order-1">
                <span class="badge-err">Error 404 Not Found</span>
                <h1 class="error-code mb-3">404</h1>
                <h2 class="error-title">Halaman Tak Ditemukan!</h2>
                <p class="error-desc mb-4">
                    Astronaut kami sudah menjelajah seluruh galaksi digital ini, tapi
                    <strong style="color:#a5b4fc;">halaman yang Anda cari tidak ada di sini.</strong>
                    Mungkin URL-nya salah, atau halaman tersebut sudah dipindahkan.
                    <br><br>
                    <span style="color:#64748b;font-size:.85rem;">Periksa kembali alamat URL yang Anda ketik atau kembali ke halaman utama.</span>
                </p>
                <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-md-start">
                    <a href="{{ url('/') }}" class="btn-home"><i class="bi bi-house-fill"></i> Kembali ke Beranda</a>
                    <a href="javascript:history.back()" class="btn-back"><i class="bi bi-arrow-left"></i> Halaman Sebelumnya</a>
                </div>
                <div class="mt-5 p-3 rounded-3" style="background:rgba(99,102,241,.07);border:1px solid rgba(99,102,241,.2);max-width:380px;">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-map-fill fs-5 mt-1" style="color:#818cf8;"></i>
                        <p class="mb-0 small" style="color:#64748b;font-size:.82rem;">
                            <strong style="color:#a5b4fc;">Kode Status:</strong> 404 Not Found<br>
                            Sumber daya yang diminta tidak ditemukan di server ini.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
(function(){const c=document.getElementById('particles-container');if(!c)return;const cols=['#818cf8','#6366f1','#a5b4fc','#4f46e5','#c7d2fe'];for(let i=0;i<20;i++){const el=document.createElement('div');const s=Math.random()*16+5;el.className='particle';el.style.cssText=`width:${s}px;height:${s}px;left:${Math.random()*100}%;top:${Math.random()*100}%;background:${cols[Math.floor(Math.random()*cols.length)]};animation-duration:${Math.random()*12+8}s;animation-delay:${Math.random()*6}s;`;c.appendChild(el);}})();
</script>
@endsection
