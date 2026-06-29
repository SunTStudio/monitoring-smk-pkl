@extends('layouts.app')

@section('title', '500 — Kesalahan Server')

@section('styles')
<style>
    body { background: linear-gradient(135deg, #1a0a00 0%, #1c1200 50%, #0f0a00 100%); min-height: 100vh; }
    .error-page-wrapper { min-height: 80vh; display: flex; align-items: center; justify-content: center; }
    .robot-broken { animation: shake 4s ease-in-out infinite; filter: drop-shadow(0 20px 40px rgba(245,158,11,0.4)); }
    @keyframes shake {
        0%,90%,100%{transform:translateX(0) rotate(0deg);}
        2%{transform:translateX(-4px) rotate(-1deg);}4%{transform:translateX(4px) rotate(1deg);}
        6%{transform:translateX(-3px) rotate(-0.5deg);}8%{transform:translateX(0) rotate(0deg);}
    }
    .smoke { animation: smokeRise 2.5s ease-in-out infinite; }
    @keyframes smokeRise {
        0%{transform:translateY(0) scale(1);opacity:.7;}
        100%{transform:translateY(-30px) scale(2);opacity:0;}
    }
    .spark { animation: sparkFly linear infinite; }
    @keyframes sparkFly {
        0%{transform:translate(0,0) scale(1);opacity:1;}
        100%{transform:translate(var(--tx),var(--ty)) scale(0);opacity:0;}
    }
    .error-code { font-size:7rem;font-weight:900;letter-spacing:-.05em;background:linear-gradient(135deg,#f59e0b,#d97706,#92400e);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;animation:glitchPop 3s ease-in-out infinite; }
    @keyframes glitchPop { 0%,88%,100%{transform:translateX(0);filter:none;} 90%{transform:translateX(-4px);filter:hue-rotate(30deg);} 93%{transform:translateX(4px);filter:hue-rotate(-30deg);} 96%{transform:translateX(-2px);} 98%{transform:translateX(2px);} }
    .badge-err{display:inline-block;background:rgba(245,158,11,.15);border:1px solid rgba(245,158,11,.4);color:#fde68a;font-size:.7rem;font-weight:700;letter-spacing:.15em;padding:4px 14px;border-radius:999px;text-transform:uppercase;margin-bottom:1rem;}
    .error-title{color:#f1f5f9;font-size:1.75rem;font-weight:800;margin-bottom:.75rem;}
    .error-desc{color:#94a3b8;font-size:.95rem;line-height:1.7;max-width:400px;}
    .btn-home{background:linear-gradient(135deg,#f59e0b,#d97706);color:#1a0a00;border:none;padding:10px 28px;border-radius:999px;font-weight:700;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;box-shadow:0 4px 20px rgba(245,158,11,.4);}
    .btn-home:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(245,158,11,.55);color:#1a0a00;}
    .btn-back{background:transparent;color:#94a3b8;border:1px solid rgba(148,163,184,.3);padding:10px 24px;border-radius:999px;font-weight:600;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;}
    .btn-back:hover{background:rgba(148,163,184,.1);color:#f1f5f9;}
    .dot-bg{position:fixed;inset:0;background-image:radial-gradient(circle,rgba(245,158,11,.05) 1px,transparent 1px);background-size:32px 32px;pointer-events:none;z-index:0;}
    .particle{position:absolute;border-radius:50%;opacity:.08;animation:drift linear infinite;}
    @keyframes drift{0%{transform:translate(0,100vh) rotate(0deg);opacity:0;}10%{opacity:.1;}90%{opacity:.1;}100%{transform:translate(20px,-80px) rotate(360deg);opacity:0;}}
    .content-err{position:relative;z-index:1;}
    .glitch-eye { animation: glitchEye 3s ease-in-out infinite; }
    @keyframes glitchEye { 0%,80%,100%{opacity:1;} 82%{opacity:0;} 84%{opacity:1;} 86%{opacity:0;} 88%{opacity:1;} }
    .progress-bar-anim { animation: progressLoad 2s ease-in-out infinite; }
    @keyframes progressLoad { 0%{width:90%;} 50%{width:20%;} 100%{width:90%;} }
    .bolt { animation: boltFlash .8s ease-in-out infinite alternate; }
    @keyframes boltFlash { 0%{opacity:.3;} 100%{opacity:1;} }
</style>
@endsection

@section('content')
<div class="dot-bg"></div>
<div class="position-fixed inset-0 overflow-hidden" style="pointer-events:none;z-index:0;" id="particles-container"></div>

<div class="error-page-wrapper content-err">
    <div class="container">
        <div class="row align-items-center justify-content-center g-5">
            <div class="col-lg-5 col-md-6 text-center order-md-1 order-2">
                <svg viewBox="0 0 320 380" xmlns="http://www.w3.org/2000/svg" class="robot-broken" style="width:100%;max-width:290px;">
                    <defs>
                        <radialGradient id="glow500" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" style="stop-color:#f59e0b;stop-opacity:.2"/>
                            <stop offset="100%" style="stop-color:#0f172a;stop-opacity:0"/>
                        </radialGradient>
                        <linearGradient id="bodyAmber" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#292524;"/>
                            <stop offset="100%" style="stop-color:#1c1917;"/>
                        </linearGradient>
                        <filter id="glow500f">
                            <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
                            <feMerge><feMergeNode in="coloredBlur"/><feMergeNode in="SourceGraphic"/></feMerge>
                        </filter>
                    </defs>

                    <circle cx="160" cy="185" r="130" fill="url(#glow500)"/>

                    <!-- Shadow -->
                    <ellipse cx="165" cy="344" rx="65" ry="11" fill="rgba(0,0,0,.4)"/>

                    <!-- Legs — tilted (robot falling over) -->
                    <rect x="130" y="288" width="22" height="44" rx="9" fill="#292524" transform="rotate(8,141,310)"/>
                    <rect x="166" y="290" width="22" height="44" rx="9" fill="#292524" transform="rotate(-12,177,312)"/>
                    <!-- Boots -->
                    <rect x="121" y="323" width="34" height="14" rx="7" fill="#1c1917" transform="rotate(8,138,330)"/>
                    <rect x="163" y="325" width="34" height="14" rx="7" fill="#1c1917" transform="rotate(-12,180,332)"/>

                    <!-- Body — slightly tilted -->
                    <g transform="rotate(-5,160,250)">
                        <rect x="116" y="200" width="88" height="92" rx="18" fill="url(#bodyAmber)"/>
                        <!-- Warning stripes -->
                        <rect x="116" y="215" width="88" height="8" rx="2" fill="#f59e0b" opacity=".4"/>
                        <rect x="116" y="273" width="88" height="6" rx="2" fill="#f59e0b" opacity=".3"/>
                        <!-- Screen on chest — error -->
                        <rect x="132" y="228" width="56" height="36" rx="6" fill="#0c0a09"/>
                        <text x="160" y="242" font-family="monospace" font-size="7" fill="#ef4444" text-anchor="middle">CRITICAL ERR</text>
                        <text x="160" y="253" font-family="monospace" font-size="9" fill="#f59e0b" text-anchor="middle" font-weight="bold">0x500</text>
                        <!-- Progress bar broken -->
                        <rect x="136" y="258" width="48" height="3" rx="1.5" fill="#292524"/>
                        <rect class="progress-bar-anim" x="136" y="258" height="3" rx="1.5" fill="#ef4444" style="max-width:48px;"/>
                        <!-- Steam/smoke from body -->
                        <circle class="smoke" cx="145" cy="200" r="8" fill="#78716c" style="animation-delay:0s"/>
                        <circle class="smoke" cx="160" cy="198" r="10" fill="#57534e" style="animation-delay:.4s"/>
                        <circle class="smoke" cx="175" cy="200" r="7" fill="#78716c" style="animation-delay:.8s"/>
                    </g>

                    <!-- Arms — one up, one drooping broken -->
                    <!-- Left arm: drooping broken -->
                    <rect x="84" y="215" width="34" height="20" rx="10" fill="#292524" transform="rotate(30,101,225)"/>
                    <rect x="68" y="240" width="26" height="18" rx="9" fill="#292524" transform="rotate(40,81,249)"/>

                    <!-- Right arm: crackling electricity -->
                    <rect x="202" y="208" width="34" height="20" rx="10" fill="#292524" transform="rotate(-15,219,218)"/>
                    <rect x="228" y="198" width="26" height="18" rx="9" fill="#292524" transform="rotate(-20,241,207)"/>
                    <!-- Spark electricity from right arm -->
                    <g class="bolt" filter="url(#glow500f)">
                        <path d="M253 195 L262 185 L257 188 L266 175" stroke="#fbbf24" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M258 198 L270 188 L263 192 L274 180" stroke="#f59e0b" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" opacity=".7"/>
                    </g>

                    <!-- Sparks flying -->
                    <circle cx="240" cy="170" r="3" fill="#fbbf24" filter="url(#glow500f)" style="animation:sparkFly 1.2s linear infinite;--tx:-20px;--ty:-30px;animation-delay:0s"/>
                    <circle cx="260" cy="180" r="2" fill="#f59e0b" filter="url(#glow500f)" style="animation:sparkFly 1s linear infinite;--tx:15px;--ty:-25px;animation-delay:.3s"/>
                    <circle cx="250" cy="160" r="2.5" fill="#fcd34d" filter="url(#glow500f)" style="animation:sparkFly .8s linear infinite;--tx:-10px;--ty:-20px;animation-delay:.6s"/>

                    <!-- Head — tilted & cracked -->
                    <g transform="rotate(-8,160,140)">
                        <!-- Head shape -->
                        <rect x="118" y="110" width="88" height="78" rx="24" fill="#292524"/>
                        <!-- Cracks on head -->
                        <path d="M148 110 L152 130 L158 126 L155 145" stroke="#f59e0b" stroke-width="1.5" fill="none" opacity=".8"/>
                        <path d="M175 115 L170 128 L176 132" stroke="#f59e0b" stroke-width="1" fill="none" opacity=".6"/>
                        <!-- Visor / eye area -->
                        <rect x="130" y="128" width="64" height="42" rx="10" fill="#0c0a09"/>
                        <rect x="130" y="128" width="64" height="42" rx="10" fill="none" stroke="#f59e0b" stroke-width="1.5" opacity=".5"/>
                        <!-- Left eye: glitching -->
                        <g class="glitch-eye">
                            <rect x="135" y="137" width="20" height="14" rx="4" fill="#ef4444" filter="url(#glow500f)"/>
                            <text x="145" y="148" font-family="monospace" font-size="9" fill="white" text-anchor="middle">X</text>
                        </g>
                        <!-- Right eye: spinning -->
                        <circle cx="179" cy="144" r="10" fill="#f59e0b" filter="url(#glow500f)"/>
                        <circle cx="179" cy="144" r="6" fill="#78350f"/>
                        <circle cx="181" cy="141" r="2" fill="#fde68a"/>
                        <!-- Error line across visor -->
                        <line x1="132" y1="160" x2="190" y2="160" stroke="#ef4444" stroke-width="2" stroke-dasharray="4,3"/>
                        <!-- Antenna broken / bent -->
                        <rect x="157" y="94" width="6" height="18" rx="3" fill="#44403c" transform="rotate(25,160,103)"/>
                        <path d="M158 94 Q165 85 170 90" stroke="#44403c" stroke-width="5" fill="none" stroke-linecap="round"/>
                        <circle cx="172" cy="91" r="6" fill="#ef4444" filter="url(#glow500f)"/>
                        <!-- Steam from head -->
                        <circle class="smoke" cx="158" cy="110" r="6" fill="#57534e" style="animation-delay:.2s"/>
                        <circle class="smoke" cx="175" cy="112" r="5" fill="#78716c" style="animation-delay:.9s"/>
                    </g>
                </svg>
            </div>

            <div class="col-lg-5 col-md-6 text-center text-md-start order-md-2 order-1">
                <span class="badge-err">Error 500 Internal Server</span>
                <h1 class="error-code mb-3">500</h1>
                <h2 class="error-title">Server Kami Meledak! 💥</h2>
                <p class="error-desc mb-4">
                    Robot server kami sedang mengalami <strong style="color:#fbbf24;">overload berat</strong> dan tidak bisa memproses permintaan Anda saat ini.
                    Tim kami sudah tahu masalah ini dan sedang bergegas memperbaikinya.
                    <br><br>
                    <span style="color:#64748b;font-size:.85rem;">Coba refresh halaman dalam beberapa menit. Jika masalah berlanjut, hubungi administrator sistem.</span>
                </p>
                <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-md-start">
                    <a href="{{ url('/') }}" class="btn-home"><i class="bi bi-house-fill"></i> Kembali ke Beranda</a>
                    <a href="javascript:location.reload()" class="btn-back"><i class="bi bi-arrow-clockwise"></i> Coba Lagi</a>
                </div>
                <div class="mt-5 p-3 rounded-3" style="background:rgba(245,158,11,.07);border:1px solid rgba(245,158,11,.2);max-width:380px;">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-exclamation-triangle-fill fs-5 mt-1" style="color:#fbbf24;"></i>
                        <p class="mb-0 small" style="color:#64748b;font-size:.82rem;">
                            <strong style="color:#fde68a;">Kode Status:</strong> 500 Internal Server Error<br>
                            Terjadi kesalahan tidak terduga di sisi server. Log error telah dicatat secara otomatis.
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
(function(){const c=document.getElementById('particles-container');if(!c)return;const cols=['#f59e0b','#d97706','#fbbf24','#78716c','#ef4444'];for(let i=0;i<20;i++){const el=document.createElement('div');const s=Math.random()*14+5;el.className='particle';el.style.cssText=`width:${s}px;height:${s}px;left:${Math.random()*100}%;top:${Math.random()*100}%;background:${cols[Math.floor(Math.random()*cols.length)]};animation-duration:${Math.random()*10+6}s;animation-delay:${Math.random()*5}s;`;c.appendChild(el);}})();
</script>
@endsection
