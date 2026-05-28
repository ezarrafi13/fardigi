<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Katalog Komponen Elektronika & IoT — RoboCore')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        @import url('https://fonts.cdnfonts.com/css/garet');

        :root {
            --primary:   #2072fb;
            --primary-d: #1558d6;
            --primary-l: #4a8fff;
            --primary-xl:#6aaaff;
            --navy:      #0b1f3a;
            --surface:   #f4f7fb;
            --white:     #ffffff;
            --text:      #1a2535;
            --muted:     #64748b;
            --border:    #e2e8f0;
            --accent:    #f59e0b;
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

        body {
            background: var(--surface);
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            margin: 0;
        }

        h1, h2, h3, h4, .garet { font-family: 'Garet', 'DM Sans', sans-serif; }

        /* Toasts */
        #toasts { position:fixed; top:72px; right:14px; z-index:9999; display:flex; flex-direction:column; gap:8px; pointer-events:none; }
        .toast { pointer-events:all; min-width:260px; max-width:340px; padding:13px 14px; border-radius:14px; font-size:12px; font-weight:600; display:flex; align-items:flex-start; gap:10px; box-shadow:0 8px 24px rgba(0,0,0,.1); animation:fadeUp .35s ease both; transition:opacity .4s; font-family:'DM Sans',sans-serif; }
        .t-ok  { background:#f0fdf4; border:1.5px solid #86efac; color:#166534; }
        .t-err { background:#fff1f2; border:1.5px solid #fca5a5; color:#991b1b; }
        @keyframes fadeUp { 0%{opacity:0;transform:translateY(10px)} 100%{opacity:1;transform:translateY(0)} }

        /* Scrollbar */
        ::-webkit-scrollbar { width:4px; height:4px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:2px; }

        @yield('extra-css')
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        mono: ['DM Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#2072fb',
                            hover: '#155fe0',
                            light: '#eaf2ff',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 selection:bg-brand selection:text-white">

    <div id="toasts"></div>

    @yield('content')

    <script>
        function toast(msg, type='ok') {
            const wrap = document.getElementById('toasts');
            const t = document.createElement('div');
            t.className = 'toast ' + (type==='ok'?'t-ok':'t-err');
            t.innerHTML = `<div style="padding-top:2px;">${type==='ok'?'✔':'⚠️'}</div><div style="line-height:1.4;">${msg}</div>`;
            wrap.appendChild(t);
            setTimeout(() => { t.style.opacity = '0'; setTimeout(()=>t.remove(), 400); }, 3500);
        }
        
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', () => toast(@json(session('success')), 'ok'));
        @endif
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', () => toast(@json(session('error')), 'err'));
        @endif
        @if($errors->any())
            document.addEventListener('DOMContentLoaded', () => toast(@json($errors->first()), 'err'));
        @endif
    </script>
    @yield('extra-js')
</body>
</html>
