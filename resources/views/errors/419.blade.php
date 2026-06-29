@extends('layouts.app')

@section('title', '419 — Sesi Kedaluwarsa')

@section('styles')
<style>
    body { background: linear-gradient(135deg, #1a0f2e 0%, #12082a 50%, #0d0520 100%); min-height: 100vh; }
    .error-page-wrapper { min-height: 80vh; display: flex; align-items: center; justify-content: center; }
    .hourglass-char { animation: rotateFlip 4s ease-in-out infinite; filter: drop-shadow(0 20px 40px rgba(168,85,247,0.4)); }
    @keyframes rotateFlip { 0%,40%{transform:rotate(0deg);} 50%,90%{transform:rotate(180deg);} 100%{transform:rotate(180deg);} }
    .sand-particle { animation: sandFall linear infinite; }
    @keyframes sandFall { 0%{transform:translateY(-2px);opacity:.9;} 100%{transform:translateY(40px);opacity:0;} }
    .glow-ring { animation: ringPulse 2s ease-in-out infinite; }
    @keyframes ringPulse { 0%,100%{opacity:.3;transform:scale(1);} 50%{opacity:.7;transform:scale(1.05);} }
    .clock-hand { animation: clockTick .8s steps(60) infinite; transform-origin: 160px 175px; }
    @keyframes clockTick { from{transform:rotate(0deg);} to{transform:rotate(360deg);} }
    .error-code { font-size:7rem;font-weight:900;letter-spacing:-.05em;background:linear-gradient(135deg,#c084fc,#a855f7,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1; }
    .badge-err{display:inline-block;background:rgba(168,85,247,.15);border:1px solid rgba(168,85,247,.4);color:#e9d5ff;font-size:.7rem;font-weight:700;letter-spacing:.15em;padding:4px 14px;border-radius:999px;text-transform:uppercase;margin-bottom:1rem;}
    .error-title{color:#f1f5f9;font-size:1.75rem;font-weight:800;margin-bottom:.75rem;}
    .error-desc{color:#94a3b8;font-size:.95rem;line-height:1.7;max-width:400px;}
    .btn-home{background:linear-gradient(135deg,#a855f7,#7c3aed);color:white;border:none;padding:10px 28px;border-radius:999px;font-weight:700;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;box-shadow:0 4px 20px rgba(168,85,247,.4);}
    .btn-home:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(168,85,247,.55);color:white;}
    .btn-back{background:transparent;color:#94a3b8;border:1px solid rgba(148,163,184,.3);padding:10px 24px;border-radius:999px;font-weight:600;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;}
    .btn-back:hover{background:rgba(148,163,184,.1);color:#f1f5f9;}
    .dot-bg{position:fixed;inset:0;background-image:radial-gradient(circle,rgba(168,85,247,.06) 1px,transparent 1px);background-size:32px 32px;pointer-events:none;z-index:0;}
    .particle{position:absolute;border-radius:50%;opacity:.08;animation:drift linear infinite;}
    @keyframes drift{0%{transform:translate(0,100vh) rotate(0deg);opacity:0;}10%{opacity:.1;}90%{opacity:.1;}100%{transform:translate(20px,-80px) rotate(360deg);opacity:0;}}
    .content-err{position:relative;z-index:1;}
</style>
@endsection

@section('content')
<div class="dot-bg"></div>
<div class="position-fixed inset-0 overflow-hidden" style="pointer-events:none;z-index:0;" id="particles-container"></div>

<div class="error-page-wrapper content-err">
    <div class="container">
        <div class="row align-items-center justify-content-center g-5">
            <div class="col-lg-5 col-md-6 text-center order-md-1 order-2">
                <svg viewBox="0 0 320 380" xmlns="http://www.w3.org/2000/svg" class="hourglass-char" style="width:100%;max-width:280px;">
                    <defs>
                        <radialGradient id="glow419" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" style="stop-color:#a855f7;stop-opacity:.2"/>
                            <stop offset="100%" style="stop-color:#0f172a;stop-opacity:0"/>
                        </radialGradient>
                        <linearGradient id="sandGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#fde68a;"/>
                            <stop offset="100%" style="stop-color:#f59e0b;"/>
                        </linearGradient>
                        <filter id="glow419f">
                            <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
                            <feMerge><feMergeNode in="coloredBlur"/><feMergeNode in="SourceGraphic"/></feMerge>
                        </filter>
                    </defs>

                    <circle cx="160" cy="185" r="130" fill="url(#glow419)"/>

                    <!-- Pulsing glow rings -->
                    <circle class="glow-ring" cx="160" cy="185" r="85" fill="none" stroke="#a855f7" stroke-width="1.5"/>
                    <circle class="glow-ring" cx="160" cy="185" r="100" fill="none" stroke="#7c3aed" stroke-width="1" style="animation-delay:.5s"/>

                    <!-- Hourglass shape (large, main character) -->
                    <!-- Frame outer -->
                    <rect x="108" y="80" width="104" height="18" rx="6" fill="#6b21a8"/>
                    <rect x="108" y="290" width="104" height="18" rx="6" fill="#6b21a8"/>
                    <rect x="152" y="95" width="16" height="200" rx="4" fill="#6b21a8"/>

                    <!-- Top glass chamber -->
                    <path d="M115 98 L205 98 L175 190 L145 190 Z" fill="rgba(168,85,247,0.15)" stroke="#a855f7" stroke-width="2"/>
                    <!-- Top sand (nearly empty) -->
                    <path d="M145 185 L155 185 L165 185 L175 185 L165 160 L155 160 Z" fill="url(#sandGrad)" opacity=".7"/>

                    <!-- Bottom glass chamber -->
                    <path d="M145 200 L175 200 L205 292 L115 292 Z" fill="rgba(168,85,247,0.15)" stroke="#a855f7" stroke-width="2"/>
                    <!-- Bottom sand (mostly full) -->
                    <path d="M120 292 L200 292 L195 250 L125 250 Z" fill="url(#sandGrad)" opacity=".85"/>
                    <path d="M125 250 L195 250 L188 230 L132 230 Z" fill="#fde68a" opacity=".6"/>

                    <!-- Sand particles falling through middle -->
                    <circle class="sand-particle" cx="159" cy="192" r="2.5" fill="#fde68a" style="animation-duration:.6s;animation-delay:0s"/>
                    <circle class="sand-particle" cx="162" cy="192" r="2" fill="#f59e0b" style="animation-duration:.6s;animation-delay:.15s"/>
                    <circle class="sand-particle" cx="157" cy="195" r="1.5" fill="#fde68a" style="animation-duration:.6s;animation-delay:.3s"/>
                    <circle class="sand-particle" cx="161" cy="198" r="2" fill="#f59e0b" style="animation-duration:.6s;animation-delay:.45s"/>

                    <!-- Hourglass glow -->
                    <circle cx="160" cy="190" r="8" fill="#a855f7" opacity=".3" filter="url(#glow419f)"/>

                    <!-- "EXPIRED" stamp text with circle around hourglass -->
                    <circle cx="160" cy="190" r="115" fill="none" stroke="#7c3aed" stroke-width="1" stroke-dasharray="6,4" opacity=".3"/>

                    <!-- Session lock icon -->
                    <circle cx="160" cy="350" r="22" fill="#3b0764" stroke="#a855f7" stroke-width="2"/>
                    <rect x="151" y="350" width="18" height="14" rx="3" fill="#a855f7"/>
                    <path d="M153 350 L153 344 Q153 338 160 338 Q167 338 167 344 L167 350" fill="none" stroke="#a855f7" stroke-width="2.5" stroke-linecap="round"/>
                    <circle cx="160" cy="356" r="2.5" fill="#e9d5ff"/>

                    <!-- Shadow -->
                    <ellipse cx="160" cy="372" rx="50" ry="8" fill="rgba(0,0,0,.3)"/>

                    <!-- Decorative stars / sparkles -->
                    <path d="M60 150 L63 158 L71 158 L65 163 L67 171 L60 167 L53 171 L55 163 L49 158 L57 158 Z" fill="#a855f7" opacity=".5" filter="url(#glow419f)"/>
                    <path d="M255 230 L257 236 L263 236 L258 240 L260 246 L255 242 L250 246 L252 240 L247 236 L253 236 Z" fill="#c084fc" opacity=".4" filter="url(#glow419f)"/>
                    <path d="M70 280 L72 285 L77 285 L73 288 L74 293 L70 290 L66 293 L67 288 L63 285 L68 285 Z" fill="#7c3aed" opacity=".6"/>
                    <path d="M252 130 L254 135 L259 135 L255 138 L256 143 L252 140 L248 143 L249 138 L245 135 L250 135 Z" fill="#a855f7" opacity=".5"/>

                    <!-- Warning: TIME OUT text -->
                    <rect x="100" y="60" width="120" height="22" rx="6" fill="#3b0764" stroke="#a855f7" stroke-width="1.5"/>
                    <text x="160" y="75" font-family="monospace" font-size="9" fill="#c084fc" text-anchor="middle" font-weight="bold">⏰ SESSION EXPIRED</text>
                </svg>
            </div>

            <div class="col-lg-5 col-md-6 text-center text-md-start order-md-2 order-1">
                <span class="badge-err">Error 419 Session Expired</span>
                <h1 class="error-code mb-3">419</h1>
                <h2 class="error-title">Sesi Anda Kedaluwarsa!</h2>
                <p class="error-desc mb-4">
                    Pasir waktu sudah habis! <strong style="color:#c084fc;">Sesi login Anda telah kedaluwarsa</strong>
                    karena terlalu lama tidak ada aktivitas, atau token CSRF formulir sudah tidak valid.
                    <br><br>
                    <span style="color:#64748b;font-size:.85rem;">Silakan masuk kembali ke akun Anda untuk melanjutkan aktivitas. Data yang belum tersimpan mungkin perlu diisi ulang.</span>
                </p>
                <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-md-start">
                    <a href="{{ route('login') }}" class="btn-home"><i class="bi bi-box-arrow-in-right"></i> Masuk Kembali</a>
                    <a href="javascript:history.back()" class="btn-back"><i class="bi bi-arrow-left"></i> Halaman Sebelumnya</a>
                </div>
                <div class="mt-5 p-3 rounded-3" style="background:rgba(168,85,247,.07);border:1px solid rgba(168,85,247,.2);max-width:380px;">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-hourglass-split fs-5 mt-1" style="color:#c084fc;"></i>
                        <p class="mb-0 small" style="color:#64748b;font-size:.82rem;">
                            <strong style="color:#e9d5ff;">Kode Status:</strong> 419 Session Expired / CSRF Token Mismatch<br>
                            Token keamanan halaman tidak valid atau sesi telah habis. Silakan login ulang.
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
(function(){const c=document.getElementById('particles-container');if(!c)return;const cols=['#a855f7','#c084fc','#7c3aed','#6b21a8','#e9d5ff'];for(let i=0;i<18;i++){const el=document.createElement('div');const s=Math.random()*14+5;el.className='particle';el.style.cssText=`width:${s}px;height:${s}px;left:${Math.random()*100}%;top:${Math.random()*100}%;background:${cols[Math.floor(Math.random()*cols.length)]};animation-duration:${Math.random()*12+8}s;animation-delay:${Math.random()*6}s;`;c.appendChild(el);}})();
</script>
@endsection
