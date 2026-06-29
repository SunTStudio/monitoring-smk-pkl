@extends('layouts.app')

@section('title', '{{ $code ?? "Error" }} — Terjadi Kesalahan')

@section('styles')
<style>
    body { background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%); min-height: 100vh; }
    .error-page-wrapper { min-height: 80vh; display: flex; align-items: center; justify-content: center; }
    .ghost-char { animation: floatGhost 3s ease-in-out infinite; filter: drop-shadow(0 20px 40px rgba(148,163,184,0.3)); }
    @keyframes floatGhost { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-14px);} }
    .eye-wander { animation: wander 3s ease-in-out infinite; }
    @keyframes wander { 0%,100%{transform:translate(0,0);} 30%{transform:translate(3px,-2px);} 60%{transform:translate(-3px,1px);} }
    .wiggle { animation: wiggle 2s ease-in-out infinite; }
    @keyframes wiggle { 0%,100%{transform:scaleX(1);} 50%{transform:scaleX(0.9);} }
    .error-code { font-size:7rem;font-weight:900;letter-spacing:-.05em;background:linear-gradient(135deg,#94a3b8,#64748b,#475569);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1; }
    .badge-err{display:inline-block;background:rgba(100,116,139,.15);border:1px solid rgba(100,116,139,.4);color:#cbd5e1;font-size:.7rem;font-weight:700;letter-spacing:.15em;padding:4px 14px;border-radius:999px;text-transform:uppercase;margin-bottom:1rem;}
    .error-title{color:#f1f5f9;font-size:1.75rem;font-weight:800;margin-bottom:.75rem;}
    .error-desc{color:#94a3b8;font-size:.95rem;line-height:1.7;max-width:400px;}
    .btn-home{background:linear-gradient(135deg,#475569,#334155);color:white;border:none;padding:10px 28px;border-radius:999px;font-weight:700;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;box-shadow:0 4px 20px rgba(71,85,105,.4);}
    .btn-home:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(71,85,105,.55);color:white;}
    .btn-back{background:transparent;color:#94a3b8;border:1px solid rgba(148,163,184,.3);padding:10px 24px;border-radius:999px;font-weight:600;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s ease;}
    .btn-back:hover{background:rgba(148,163,184,.1);color:#f1f5f9;}
    .dot-bg{position:fixed;inset:0;background-image:radial-gradient(circle,rgba(148,163,184,.06) 1px,transparent 1px);background-size:32px 32px;pointer-events:none;z-index:0;}
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
                <svg viewBox="0 0 320 380" xmlns="http://www.w3.org/2000/svg" class="ghost-char" style="width:100%;max-width:280px;">
                    <defs>
                        <radialGradient id="glowGen" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" style="stop-color:#64748b;stop-opacity:.2"/>
                            <stop offset="100%" style="stop-color:#0f172a;stop-opacity:0"/>
                        </radialGradient>
                        <filter id="glowGenF">
                            <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
                            <feMerge><feMergeNode in="coloredBlur"/><feMergeNode in="SourceGraphic"/></feMerge>
                        </filter>
                    </defs>

                    <circle cx="160" cy="185" r="130" fill="url(#glowGen)"/>

                    <!-- Ghost body -->
                    <g class="wiggle">
                        <!-- Ghost main body -->
                        <path d="M90 200 Q90 130 160 125 Q230 130 230 200 L230 290 Q215 278 200 290 Q185 302 170 290 Q155 278 140 290 Q125 302 110 290 Q95 278 90 290 Z" fill="#e2e8f0" opacity=".9"/>
                        <!-- Ghost shine -->
                        <path d="M112 165 Q108 145 125 138 Q135 134 138 145 Q130 148 125 158 Z" fill="rgba(255,255,255,0.4)"/>
                        <!-- Ghost bottom ruffles shadow -->
                        <path d="M90 290 Q95 278 110 290 Q125 302 140 290 Q155 278 170 290 Q185 302 200 290 Q215 278 230 290" fill="none" stroke="#cbd5e1" stroke-width="2"/>

                        <!-- Eyes -->
                        <g class="eye-wander" style="transform-origin:140px 205px">
                            <ellipse cx="140" cy="195" rx="18" ry="20" fill="#1e293b"/>
                            <ellipse cx="140" cy="195" rx="12" ry="14" fill="#0f172a"/>
                            <ellipse cx="144" cy="190" rx="5" ry="5" fill="white" opacity=".9"/>
                        </g>
                        <g class="eye-wander" style="transform-origin:180px 205px">
                            <ellipse cx="180" cy="195" rx="18" ry="20" fill="#1e293b"/>
                            <ellipse cx="180" cy="195" rx="12" ry="14" fill="#0f172a"/>
                            <ellipse cx="184" cy="190" rx="5" ry="5" fill="white" opacity=".9"/>
                        </g>

                        <!-- Confused mouth -->
                        <path d="M148 230 Q155 225 160 230 Q165 235 172 230" stroke="#94a3b8" stroke-width="3" fill="none" stroke-linecap="round"/>

                        <!-- Little hands waving -->
                        <ellipse cx="85" cy="240" rx="14" ry="12" fill="#e2e8f0" opacity=".8"/>
                        <ellipse cx="235" cy="240" rx="14" ry="12" fill="#e2e8f0" opacity=".8"/>
                    </g>

                    <!-- Error badge floating above ghost -->
                    <rect x="120" y="75" width="80" height="40" rx="10" fill="#1e293b" stroke="#475569" stroke-width="1.5"/>
                    <text x="160" y="91" font-family="monospace" font-size="9" fill="#94a3b8" text-anchor="middle">ERROR CODE</text>
                    <text x="160" y="108" font-family="monospace" font-size="16" fill="#cbd5e1" text-anchor="middle" font-weight="bold">{{ $code ?? '???' }}</text>

                    <!-- Question marks floating around -->
                    <text x="62" y="170" font-family="sans-serif" font-size="22" fill="#64748b" opacity=".5" transform="rotate(-15,62,170)">?</text>
                    <text x="248" y="155" font-family="sans-serif" font-size="18" fill="#64748b" opacity=".4" transform="rotate(10,248,155)">?</text>
                    <text x="50" y="300" font-family="sans-serif" font-size="14" fill="#64748b" opacity=".3" transform="rotate(-20,50,300)">?</text>
                    <text x="260" y="290" font-family="sans-serif" font-size="16" fill="#64748b" opacity=".35" transform="rotate(15,260,290)">?</text>

                    <!-- Shadow -->
                    <ellipse cx="160" cy="350" rx="80" ry="14" fill="rgba(0,0,0,.3)"/>
                    <!-- Ghost shadow (lighter) -->
                    <ellipse cx="160" cy="350" rx="60" ry="9" fill="rgba(226,232,240,.06)"/>
                </svg>
            </div>

            <div class="col-lg-5 col-md-6 text-center text-md-start order-md-2 order-1">
                <span class="badge-err">Error {{ $code ?? 'Unknown' }}</span>
                <h1 class="error-code mb-3">{{ $code ?? '???' }}</h1>
                <h2 class="error-title">Terjadi Kesalahan!</h2>
                <p class="error-desc mb-4">
                    Sepertinya <strong style="color:#cbd5e1;">sesuatu yang tidak terduga</strong> terjadi di balik layar. Hantu error ini muncul tanpa peringatan.
                    <br><br>
                    <span style="color:#64748b;font-size:.85rem;">
                        {{ $message ?? 'Sistem mengalami masalah yang tidak dapat dijelaskan saat ini. Silakan coba beberapa saat lagi atau hubungi administrator.' }}
                    </span>
                </p>
                <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-md-start">
                    <a href="{{ url('/') }}" class="btn-home"><i class="bi bi-house-fill"></i> Kembali ke Beranda</a>
                    <a href="javascript:history.back()" class="btn-back"><i class="bi bi-arrow-left"></i> Halaman Sebelumnya</a>
                </div>
                <div class="mt-5 p-3 rounded-3" style="background:rgba(71,85,105,.1);border:1px solid rgba(71,85,105,.25);max-width:380px;">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-bug-fill fs-5 mt-1" style="color:#94a3b8;"></i>
                        <p class="mb-0 small" style="color:#64748b;font-size:.82rem;">
                            <strong style="color:#cbd5e1;">Kode Status:</strong> {{ $code ?? 'Unknown Error' }}<br>
                            Masalah ini telah dicatat secara otomatis. Anda juga dapat melaporkan ke administrator untuk penanganan lebih lanjut.
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
(function(){const c=document.getElementById('particles-container');if(!c)return;const cols=['#64748b','#475569','#94a3b8','#334155','#cbd5e1'];for(let i=0;i<18;i++){const el=document.createElement('div');const s=Math.random()*14+5;el.className='particle';el.style.cssText=`width:${s}px;height:${s}px;left:${Math.random()*100}%;top:${Math.random()*100}%;background:${cols[Math.floor(Math.random()*cols.length)]};animation-duration:${Math.random()*12+8}s;animation-delay:${Math.random()*6}s;`;c.appendChild(el);}})();
</script>
@endsection
