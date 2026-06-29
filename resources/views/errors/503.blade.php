@extends('layouts.app')

@section('title', '503 — Layanan Tidak Tersedia')

@section('styles')
<style>
    body { background: linear-gradient(135deg, #0a1628 0%, #0d1f38 50%, #071020 100%); min-height: 100vh; }
    .error-page-wrapper { min-height: 80vh; display: flex; align-items: center; justify-content: center; }
    .construction-char { animation: sway 4s ease-in-out infinite; filter: drop-shadow(0 20px 40px rgba(20,184,166,0.35)); }
    @keyframes sway { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-12px);} }
    .gear { animation: gearSpin linear infinite; transform-origin: center; }
    @keyframes gearSpin { from{transform:rotate(0deg);} to{transform:rotate(360deg);} }
    .gear-reverse { animation: gearSpinRev linear infinite; transform-origin: center; }
    @keyframes gearSpinRev { from{transform:rotate(0deg);} to{transform:rotate(-360deg);} }
    .progress-bar-loader { animation: loadBar 3s ease-in-out infinite; }
    @keyframes loadBar { 0%{width:5%;} 40%{width:75%;} 60%{width:75%;} 100%{width:5%;} }
    .blink-light { animation: blinkLight 1s ease-in-out infinite; }
    @keyframes blinkLight { 0%,100%{opacity:1;} 50%{opacity:.2;} }
    .error-code { font-size:7rem;font-weight:900;letter-spacing:-.05em;background:linear-gradient(135deg,#2dd4bf,#14b8a6,#0d9488);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1; }
    .badge-err{display:inline-block;background:rgba(20,184,166,.15);border:1px solid rgba(20,184,166,.4);color:#99f6e4;font-size:.7rem;font-weight:700;letter-spacing:.15em;padding:4px 14px;border-radius:999px;text-transform:uppercase;margin-bottom:1rem;}
    .error-title{color:#f1f5f9;font-size:1.75rem;font-weight:800;margin-bottom:.75rem;}
    .error-desc{color:#94a3b8;font-size:.95rem;line-height:1.7;max-width:400px;}
    .btn-home{background:linear-gradient(135deg,#14b8a6,#0d9488);color:white;border:none;padding:10px 28px;border-radius:999px;font-weight:700;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;box-shadow:0 4px 20px rgba(20,184,166,.4);}
    .btn-home:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(20,184,166,.55);color:white;}
    .btn-back{background:transparent;color:#94a3b8;border:1px solid rgba(148,163,184,.3);padding:10px 24px;border-radius:999px;font-weight:600;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;}
    .btn-back:hover{background:rgba(148,163,184,.1);color:#f1f5f9;}
    .dot-bg{position:fixed;inset:0;background-image:radial-gradient(circle,rgba(20,184,166,.06) 1px,transparent 1px);background-size:32px 32px;pointer-events:none;z-index:0;}
    .particle{position:absolute;border-radius:50%;opacity:.08;animation:drift linear infinite;}
    @keyframes drift{0%{transform:translate(0,100vh) rotate(0deg);opacity:0;}10%{opacity:.1;}90%{opacity:.1;}100%{transform:translate(20px,-80px) rotate(360deg);opacity:0;}}
    .content-err{position:relative;z-index:1;}
    .countdown { font-size:2rem; font-weight:900; color:#2dd4bf; }
</style>
@endsection

@section('content')
<div class="dot-bg"></div>
<div class="position-fixed inset-0 overflow-hidden" style="pointer-events:none;z-index:0;" id="particles-container"></div>

<div class="error-page-wrapper content-err">
    <div class="container">
        <div class="row align-items-center justify-content-center g-5">
            <div class="col-lg-5 col-md-6 text-center order-md-1 order-2">
                <svg viewBox="0 0 320 380" xmlns="http://www.w3.org/2000/svg" class="construction-char" style="width:100%;max-width:290px;">
                    <defs>
                        <radialGradient id="glow503" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" style="stop-color:#14b8a6;stop-opacity:.2"/>
                            <stop offset="100%" style="stop-color:#0a1628;stop-opacity:0"/>
                        </radialGradient>
                        <filter id="glow503f">
                            <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                            <feMerge><feMergeNode in="coloredBlur"/><feMergeNode in="SourceGraphic"/></feMerge>
                        </filter>
                    </defs>

                    <circle cx="160" cy="185" r="130" fill="url(#glow503)"/>

                    <!-- Gears in background -->
                    <g style="transform-origin:80px 90px">
                        <g class="gear" style="animation-duration:6s;transform-origin:80px 90px">
                            <circle cx="80" cy="90" r="28" fill="none" stroke="#0d9488" stroke-width="5" opacity=".4"/>
                            <circle cx="80" cy="90" r="18" fill="#0d9488" opacity=".3"/>
                            <circle cx="80" cy="90" r="7" fill="#0a1628"/>
                            <!-- Gear teeth -->
                            <rect x="77" y="58" width="6" height="12" rx="2" fill="#0d9488" opacity=".4"/>
                            <rect x="77" y="110" width="6" height="12" rx="2" fill="#0d9488" opacity=".4"/>
                            <rect x="48" y="87" width="12" height="6" rx="2" fill="#0d9488" opacity=".4"/>
                            <rect x="100" y="87" width="12" height="6" rx="2" fill="#0d9488" opacity=".4"/>
                            <rect x="56" y="65" width="10" height="6" rx="2" fill="#0d9488" opacity=".4" transform="rotate(-45,61,68)"/>
                            <rect x="102" y="65" width="10" height="6" rx="2" fill="#0d9488" opacity=".4" transform="rotate(45,107,68)"/>
                        </g>
                    </g>

                    <g style="transform-origin:250px 85px">
                        <g class="gear-reverse" style="animation-duration:4s;transform-origin:250px 85px">
                            <circle cx="250" cy="85" r="22" fill="none" stroke="#2dd4bf" stroke-width="4" opacity=".35"/>
                            <circle cx="250" cy="85" r="13" fill="#2dd4bf" opacity=".2"/>
                            <circle cx="250" cy="85" r="5" fill="#0a1628"/>
                            <rect x="247" y="59" width="6" height="10" rx="2" fill="#2dd4bf" opacity=".35"/>
                            <rect x="247" y="106" width="6" height="10" rx="2" fill="#2dd4bf" opacity=".35"/>
                            <rect x="224" y="82" width="10" height="6" rx="2" fill="#2dd4bf" opacity=".35"/>
                            <rect x="266" y="82" width="10" height="6" rx="2" fill="#2dd4bf" opacity=".35"/>
                        </g>
                    </g>

                    <!-- Shadow -->
                    <ellipse cx="160" cy="345" rx="70" ry="12" fill="rgba(0,0,0,.3)"/>

                    <!-- Platform / scaffolding base -->
                    <rect x="80" y="318" width="160" height="10" rx="4" fill="#0d3d3a"/>
                    <rect x="90" y="302" width="12" height="20" rx="3" fill="#0d9488" opacity=".7"/>
                    <rect x="218" y="302" width="12" height="20" rx="3" fill="#0d9488" opacity=".7"/>

                    <!-- Character body — worker in jumpsuit -->
                    <!-- Legs -->
                    <rect x="132" y="282" width="22" height="40" rx="9" fill="#0d3d3a"/>
                    <rect x="166" y="282" width="22" height="40" rx="9" fill="#0d3d3a"/>
                    <rect x="126" y="314" width="32" height="14" rx="7" fill="#0a2828"/>
                    <rect x="162" y="314" width="32" height="14" rx="7" fill="#0a2828"/>

                    <!-- Body / jumpsuit -->
                    <rect x="118" y="195" width="84" height="92" rx="18" fill="#0d3d3a"/>
                    <!-- Reflective stripes -->
                    <rect x="118" y="218" width="84" height="6" rx="2" fill="#2dd4bf" opacity=".5"/>
                    <rect x="118" y="268" width="84" height="5" rx="2" fill="#2dd4bf" opacity=".4"/>
                    <!-- Tool belt -->
                    <rect x="118" y="254" width="84" height="14" rx="4" fill="#0a2828"/>
                    <rect x="145" y="257" width="30" height="8" rx="3" fill="#14b8a6" opacity=".7"/>

                    <!-- Arms -->
                    <rect x="85" y="205" width="34" height="20" rx="10" fill="#0d3d3a"/>
                    <!-- Left arm holding wrench -->
                    <rect x="66" y="215" width="26" height="16" rx="8" fill="#0d3d3a"/>
                    <!-- Wrench -->
                    <path d="M50 232 Q45 220 55 212 Q65 204 70 215 L62 220 Z" fill="#64748b"/>
                    <rect x="50" y="228" width="5" height="22" rx="2" fill="#64748b" transform="rotate(-30,52,239)"/>

                    <rect x="201" y="205" width="34" height="20" rx="10" fill="#0d3d3a"/>
                    <rect x="226" y="212" width="26" height="16" rx="8" fill="#0d3d3a"/>
                    <!-- Clipboard / tablet in right hand -->
                    <rect x="238" y="198" width="30" height="36" rx="4" fill="#1e293b"/>
                    <rect x="240" y="205" width="26" height="2" rx="1" fill="#2dd4bf" opacity=".6"/>
                    <rect x="240" y="210" width="20" height="2" rx="1" fill="#94a3b8" opacity=".4"/>
                    <rect x="240" y="215" width="24" height="2" rx="1" fill="#94a3b8" opacity=".4"/>
                    <rect x="240" y="220" width="16" height="2" rx="1" fill="#94a3b8" opacity=".4"/>

                    <!-- Neck -->
                    <rect x="146" y="183" width="28" height="16" rx="6" fill="#0d3d3a"/>

                    <!-- Hard hat / helmet -->
                    <ellipse cx="160" cy="160" rx="52" ry="44" fill="#0a2828"/>
                    <!-- Hard hat brim -->
                    <ellipse cx="160" cy="176" rx="60" ry="12" fill="#f59e0b"/>
                    <!-- Hat top -->
                    <ellipse cx="160" cy="128" rx="42" ry="34" fill="#f59e0b"/>
                    <!-- Hat shine -->
                    <ellipse cx="148" cy="125" rx="10" ry="6" fill="rgba(255,255,255,0.2)"/>
                    <!-- Face visor -->
                    <rect x="128" y="145" width="64" height="40" rx="10" fill="#0a1628"/>
                    <rect x="128" y="145" width="64" height="40" rx="10" fill="none" stroke="#2dd4bf" stroke-width="1.5" opacity=".5"/>
                    <!-- Eyes -->
                    <ellipse cx="148" cy="162" rx="9" ry="9" fill="#2dd4bf" filter="url(#glow503f)"/>
                    <ellipse cx="148" cy="162" rx="5" ry="5" fill="#0a1628"/>
                    <circle cx="150" cy="160" r="1.5" fill="white"/>
                    <ellipse cx="172" cy="162" rx="9" ry="9" fill="#2dd4bf" filter="url(#glow503f)"/>
                    <ellipse cx="172" cy="162" rx="5" ry="5" fill="#0a1628"/>
                    <circle cx="174" cy="160" r="1.5" fill="white"/>
                    <!-- Mouth: determined/focused -->
                    <path d="M152 175 L168 175" stroke="#2dd4bf" stroke-width="2.5" stroke-linecap="round"/>
                    <!-- Hard hat light -->
                    <circle class="blink-light" cx="160" cy="118" r="7" fill="#fbbf24" filter="url(#glow503f)"/>
                    <circle cx="160" cy="118" r="4" fill="#fde68a"/>

                    <!-- Construction sign -->
                    <rect x="90" y="305" width="140" height="18" rx="4" fill="#f59e0b" opacity=".8"/>
                    <text x="160" y="318" font-family="monospace" font-size="8" fill="#1a0a00" text-anchor="middle" font-weight="bold">⚠ UNDER MAINTENANCE ⚠</text>
                </svg>
            </div>

            <div class="col-lg-5 col-md-6 text-center text-md-start order-md-2 order-1">
                <span class="badge-err">Error 503 Service Unavailable</span>
                <h1 class="error-code mb-3">503</h1>
                <h2 class="error-title">Sedang Dalam Pemeliharaan!</h2>
                <p class="error-desc mb-4">
                    Tim teknisi kami sedang <strong style="color:#2dd4bf;">bekerja keras</strong> memperbaiki dan meningkatkan layanan ini. Kami mohon maaf atas ketidaknyamanan yang terjadi.
                    <br><br>
                    <span style="color:#64748b;font-size:.85rem;">Layanan akan kembali normal secepatnya. Silakan coba lagi dalam beberapa saat.</span>
                </p>
                <!-- Loading bar -->
                <div class="mb-4" style="max-width:380px;">
                    <div class="d-flex justify-content-between mb-1">
                        <small style="color:#64748b;font-size:.78rem;">Progres Perbaikan...</small>
                        <small style="color:#2dd4bf;font-size:.78rem;font-weight:700;">Dalam Proses</small>
                    </div>
                    <div style="background:rgba(20,184,166,.1);border:1px solid rgba(20,184,166,.2);border-radius:999px;height:8px;overflow:hidden;">
                        <div class="progress-bar-loader" style="height:100%;border-radius:999px;background:linear-gradient(90deg,#14b8a6,#2dd4bf);box-shadow:0 0 10px rgba(20,184,166,.5);"></div>
                    </div>
                </div>
                <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-md-start">
                    <a href="javascript:location.reload()" class="btn-home"><i class="bi bi-arrow-clockwise"></i> Coba Lagi</a>
                    <a href="{{ url('/') }}" class="btn-back"><i class="bi bi-house"></i> Ke Beranda</a>
                </div>
                <div class="mt-5 p-3 rounded-3" style="background:rgba(20,184,166,.07);border:1px solid rgba(20,184,166,.2);max-width:380px;">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-tools fs-5 mt-1" style="color:#2dd4bf;"></i>
                        <p class="mb-0 small" style="color:#64748b;font-size:.82rem;">
                            <strong style="color:#99f6e4;">Kode Status:</strong> 503 Service Unavailable<br>
                            Server tidak dapat menangani permintaan saat ini karena kelebihan beban atau sedang dalam pemeliharaan terjadwal.
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
(function(){const c=document.getElementById('particles-container');if(!c)return;const cols=['#14b8a6','#2dd4bf','#0d9488','#0a2828','#f59e0b'];for(let i=0;i<18;i++){const el=document.createElement('div');const s=Math.random()*14+5;el.className='particle';el.style.cssText=`width:${s}px;height:${s}px;left:${Math.random()*100}%;top:${Math.random()*100}%;background:${cols[Math.floor(Math.random()*cols.length)]};animation-duration:${Math.random()*12+8}s;animation-delay:${Math.random()*6}s;`;c.appendChild(el);}})();
</script>
@endsection
