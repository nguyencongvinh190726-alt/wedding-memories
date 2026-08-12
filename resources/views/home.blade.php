@php
    $bride = $wedding?->bride_name ?? 'Bride';
    $groom = $wedding?->groom_name ?? 'Groom';
    $date = $wedding?->wedding_date;
    $cover = $wedding?->cover_image
        ? asset('storage/' . $wedding->cover_image)
        : ($photos->first() ? asset('storage/' . $photos->first()->image) : null);
    $storyImage = $photos->skip(1)->first() ?? $photos->first();
@endphp
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#18221d">
    <title>{{ $bride }} & {{ $groom }} — Wedding Memories</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#19221d; --forest:#23362a; --moss:#6f8565; --cream:#f7f4ed; --sand:#e8dfcf; --rose:#c98d7e; --line:rgba(25,34,29,.13); --serif:'Cormorant Garamond',Georgia,serif; --sans:'DM Sans',Arial,sans-serif; }
        * { box-sizing:border-box; margin:0; }
        html { scroll-behavior:smooth; }
        body { background:var(--cream); color:var(--ink); font-family:var(--sans); overflow-x:hidden; }
        body.lightbox-open { overflow:hidden; }
        a { color:inherit; text-decoration:none; }
        button { font:inherit; }
        img { max-width:100%; }
        .noise { position:fixed; inset:0; z-index:20; pointer-events:none; opacity:.045; background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 180 180' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.8'/%3E%3C/svg%3E"); }
        .progress { position:fixed; z-index:100; inset:0 auto auto 0; height:3px; width:0; background:var(--rose); transition:width .12s linear; }

        .nav { position:fixed; inset:0 0 auto; z-index:30; display:flex; align-items:center; justify-content:space-between; padding:25px clamp(20px,5vw,72px); color:#fff; transition:.35s ease; }
        .nav.scrolled { padding-top:15px; padding-bottom:15px; color:var(--ink); background:rgba(247,244,237,.88); backdrop-filter:blur(16px); border-bottom:1px solid var(--line); }
        .brand { display:flex; align-items:center; gap:11px; font:500 24px/1 var(--serif); letter-spacing:-.02em; }
        .brand::before { content:'✦'; color:var(--rose); font:12px/1 var(--sans); }
        .nav-links { display:flex; gap:clamp(16px,2.6vw,38px); list-style:none; padding:0; }
        .nav-links a { position:relative; font-size:10px; font-weight:600; letter-spacing:.17em; }
        .nav-links a::after { content:''; position:absolute; left:0; bottom:-7px; width:0; height:1px; background:currentColor; transition:width .25s; }
        .nav-links a:hover::after { width:100%; }
        .menu-toggle { display:none; border:0; background:none; color:inherit; font-size:25px; cursor:pointer; }

        .hero { position:relative; min-height:100svh; display:grid; grid-template-columns:minmax(0,1fr) minmax(340px,44vw); align-items:stretch; overflow:hidden; background:var(--forest); color:#fff; }
        .hero-copy { position:relative; z-index:2; display:flex; flex-direction:column; justify-content:center; padding:135px clamp(25px,8vw,135px) 90px; }
        .hero-copy::before { content:''; position:absolute; width:32vw; height:32vw; max-width:500px; max-height:500px; border:1px solid rgba(255,255,255,.15); border-radius:50%; top:18%; left:-13%; animation:drift 9s ease-in-out infinite alternate; }
        .hero-kicker, .section-kicker { display:flex; align-items:center; gap:11px; font-size:10px; font-weight:600; letter-spacing:.24em; text-transform:uppercase; }
        .hero-kicker { color:#e2d6c3; animation:rise .8s .05s both; }
        .hero-kicker::before, .section-kicker::before { content:''; width:30px; height:1px; background:currentColor; }
        .hero h1 { position:relative; margin:28px 0 25px; font:400 clamp(76px,10vw,158px)/.68 var(--serif); letter-spacing:-.065em; animation:rise 1s .12s both; }
        .hero h1 em { display:block; margin-left:clamp(32px,5vw,88px); color:#e6ccae; font-weight:400; }
        .hero h1 .and { position:absolute; top:50%; left:clamp(7px,1vw,19px); color:var(--rose); font-size:.32em; transform:translateY(-52%); }
        .hero-date { display:flex; align-items:center; gap:15px; font-size:12px; letter-spacing:.14em; animation:rise .9s .24s both; }
        .hero-date span { width:52px; height:1px; background:rgba(255,255,255,.55); }
        .hero-note { max-width:295px; margin-top:46px; color:rgba(255,255,255,.72); font-size:13px; line-height:1.8; animation:rise 1s .32s both; }
        .scroll-cue { position:absolute; left:clamp(25px,8vw,135px); bottom:28px; display:flex; align-items:center; gap:10px; color:rgba(255,255,255,.65); font-size:9px; font-weight:600; letter-spacing:.2em; animation:rise 1s .45s both; }
        .scroll-cue::before { content:''; display:block; width:1px; height:38px; background:var(--rose); animation:scrollLine 1.8s ease-in-out infinite; }
        .hero-media { position:relative; overflow:hidden; min-height:620px; }
        .hero-media::after { content:''; position:absolute; inset:0; background:linear-gradient(90deg,rgba(35,54,42,.34),transparent 35%),linear-gradient(0deg,rgba(15,24,17,.22),transparent 45%); }
        .hero-image { width:100%; height:100%; min-height:100svh; object-fit:cover; object-position:center; transform:scale(1.06); animation:heroZoom 1.8s .1s both; }
        .hero-placeholder { height:100%; min-height:100svh; display:grid; place-items:center; background:linear-gradient(135deg,#a0a988,#d7c2ae); color:rgba(255,255,255,.85); font:italic 42px var(--serif); }
        .hero-stamp { position:absolute; z-index:3; right:clamp(22px,5vw,72px); bottom:42px; display:grid; place-items:center; width:105px; aspect-ratio:1; border:1px solid rgba(255,255,255,.7); border-radius:50%; color:#fff; text-align:center; font-size:8px; font-weight:600; letter-spacing:.14em; line-height:1.6; transform:rotate(12deg); animation:spinIn 1s .5s both; }
        .hero-stamp::after { content:'♥'; position:absolute; font-size:14px; color:#f0bfaf; }
        .hero-stamp span { margin-top:41px; }

        .section { position:relative; padding:clamp(86px,11vw,160px) 6%; }
        .inner { width:min(1180px,100%); margin:auto; }
        .section-head { max-width:630px; margin-bottom:58px; }
        .section-kicker { color:var(--moss); }
        .section-title { margin-top:15px; font:400 clamp(48px,6vw,82px)/.9 var(--serif); letter-spacing:-.045em; }
        .section-title em { color:var(--rose); font-weight:400; }
        .intro { margin-top:24px; max-width:470px; color:#647068; font-size:14px; line-height:1.85; }
        .reveal { opacity:0; transform:translateY(34px); transition:opacity .85s ease,transform .85s cubic-bezier(.2,.7,.2,1); }
        .reveal.visible { opacity:1; transform:none; }

        .countdown-wrap { overflow:hidden; color:#fff; background:var(--ink); }
        .countdown-wrap::before { content:'FOREVER'; position:absolute; top:-.22em; right:-.03em; color:rgba(255,255,255,.035); font:600 clamp(120px,20vw,310px)/1 var(--sans); letter-spacing:-.08em; pointer-events:none; }
        .countdown-wrap .section-kicker { color:#d9b58f; }
        .countdown-wrap .section-title { color:#fff; }
        .countdown { position:relative; z-index:1; display:grid; grid-template-columns:repeat(4,1fr); margin-top:55px; border-top:1px solid rgba(255,255,255,.2); border-bottom:1px solid rgba(255,255,255,.2); }
        .count-item { padding:24px clamp(12px,3vw,44px) 28px; border-left:1px solid rgba(255,255,255,.2); }
        .count-item:first-child { border:0; }
        .count-number { display:block; font:400 clamp(52px,7vw,94px)/.9 var(--serif); color:#f3eadb; }
        .count-label { display:block; margin-top:13px; color:#aeb8ae; font-size:9px; font-weight:600; letter-spacing:.18em; }
        .past-date { margin-top:45px; color:#bfc7bd; font-size:14px; }

        .story-grid { display:grid; grid-template-columns:.93fr 1.07fr; align-items:center; gap:clamp(40px,9vw,130px); }
        .story-media { position:relative; }
        .story-image { display:block; width:100%; min-height:580px; object-fit:cover; box-shadow:18px 18px 0 var(--sand); }
        .story-placeholder { min-height:580px; display:grid; place-items:center; background:var(--sand); color:#8d7e69; font:italic 34px var(--serif); }
        .story-badge { position:absolute; right:-28px; top:44px; width:112px; aspect-ratio:1; display:grid; place-items:center; padding:20px; border-radius:50%; color:var(--forest); background:#e8c0af; font:500 17px/1 var(--serif); text-align:center; transform:rotate(11deg); }
        .story-copy h3 { font:400 clamp(42px,4vw,62px)/.9 var(--serif); letter-spacing:-.04em; }
        .story-copy h3 em { color:var(--rose); }
        .story-copy p { margin-top:26px; color:#626e65; font-size:15px; line-height:1.9; }
        .signature { display:inline-flex; align-items:center; gap:12px; margin-top:34px; color:var(--forest); font:italic 27px var(--serif); }
        .signature::before { content:'✦'; color:var(--rose); font:12px var(--sans); }

        .day { overflow:hidden; background:#e9e4d7; }
        .day::after { content:''; position:absolute; z-index:0; width:33vw; aspect-ratio:1; right:-11vw; bottom:-18vw; border:1px solid rgba(35,54,42,.16); border-radius:50%; }
        .event-grid { position:relative; z-index:1; display:grid; grid-template-columns:repeat(2,1fr); gap:18px; }
        .event-card { min-height:260px; padding:clamp(27px,4vw,48px); border:1px solid rgba(35,54,42,.15); background:rgba(247,244,237,.6); transition:transform .4s ease,background .4s ease,box-shadow .4s ease; }
        .event-card:hover { transform:translateY(-10px); background:#f9f7f1; box-shadow:0 25px 45px rgba(37,42,32,.08); }
        .event-number { color:var(--rose); font:500 54px/.8 var(--serif); }
        .event-card h3 { margin-top:37px; font:500 33px/1 var(--serif); }
        .event-card p { margin-top:12px; max-width:270px; color:#657067; font-size:13px; line-height:1.7; }

        .marquee { overflow:hidden; padding:17px 0 15px; color:#e4d2bc; background:#9d675c; white-space:nowrap; }
        .marquee-track { display:inline-flex; align-items:center; gap:26px; min-width:max-content; animation:marquee 25s linear infinite; font:500 17px/1 var(--serif); letter-spacing:.08em; text-transform:uppercase; }
        .marquee-track i { color:#f9ede0; font:11px var(--sans); }
        .letter-section { overflow:hidden; background:#f1eadf; }
        .letter-section::before { content:'LOVE'; position:absolute; top:50%; left:50%; color:rgba(92,69,48,.045); font:600 clamp(170px,27vw,430px)/.6 var(--serif); letter-spacing:-.08em; transform:translate(-50%,-50%) rotate(-11deg); pointer-events:none; }
        .letter { position:relative; width:min(720px,100%); z-index:1; margin:auto; padding:clamp(45px,7vw,90px) clamp(26px,7vw,85px); text-align:center; border:1px solid rgba(90,65,42,.2); background:rgba(255,253,248,.56); box-shadow:0 22px 60px rgba(71,49,29,.08), inset 0 0 0 7px rgba(225,210,190,.32); }
        .letter::before,.letter::after { position:absolute; color:#bc8172; font:42px/1 var(--serif); }.letter::before { content:'“'; top:23px; left:31px; }.letter::after { content:'”'; right:31px; bottom:14px; }
        .letter .section-kicker { justify-content:center; }.letter h2 { margin:22px auto 25px; max-width:520px; font:400 clamp(40px,5.2vw,68px)/.93 var(--serif); letter-spacing:-.04em; }.letter h2 em { color:#b8786d; font-weight:400; }
        .letter p { max-width:475px; margin:auto; color:#6e665d; font:15px/1.9 var(--sans); }.wax-seal { display:grid; place-items:center; width:58px; height:58px; margin:34px auto 0; border-radius:50%; color:#f7eee4; background:#a7665f; box-shadow:inset 0 0 0 5px rgba(255,255,255,.12), 0 5px 12px rgba(107,58,52,.18); font:22px var(--serif); transform:rotate(-10deg); }

        .timeline-section { background:var(--cream); }.timeline { position:relative; display:grid; grid-template-columns:repeat(3,1fr); gap:clamp(22px,5vw,70px); margin-top:20px; }.timeline::before { content:''; position:absolute; top:31px; left:9%; right:9%; height:1px; background:var(--line); }.timeline-item { position:relative; z-index:1; }.timeline-flower { display:grid; place-items:center; width:63px; height:63px; margin-bottom:29px; border:1px solid #bda894; border-radius:50%; color:#a66f62; background:var(--cream); font:23px var(--serif); transition:transform .5s,background .5s,color .5s; }.timeline-item:hover .timeline-flower { color:#fff; background:var(--forest); transform:rotate(180deg); }.timeline-item small { color:#a66f62; font-size:10px; font-weight:600; letter-spacing:.2em; }.timeline-item h3 { margin:11px 0; font:500 33px/.9 var(--serif); }.timeline-item p { color:#677168; font-size:13px; line-height:1.8; }

        .promise { padding-top:clamp(90px,12vw,170px); padding-bottom:clamp(90px,12vw,170px); overflow:hidden; color:#f8f0e6; text-align:center; background:var(--forest); }.promise::before,.promise::after { content:'✦'; position:absolute; color:rgba(232,213,190,.22); font-size:clamp(150px,18vw,280px); line-height:1; animation:floatStar 8s ease-in-out infinite alternate; }.promise::before { top:-.32em; left:4%; }.promise::after { right:4%; bottom:-.33em; animation-delay:-3.5s; }.promise-content { position:relative; z-index:1; width:min(780px,100%); margin:auto; }.promise .section-kicker { justify-content:center; color:#dcb18b; }.promise h2 { margin:23px 0 25px; font:400 clamp(54px,8vw,108px)/.78 var(--serif); letter-spacing:-.06em; }.promise h2 em { color:#e3b198; font-weight:400; }.promise p { max-width:500px; margin:auto; color:rgba(255,255,255,.75); font-size:15px; line-height:1.9; }.promise-date { display:inline-block; margin-top:36px; padding:11px 18px; border-top:1px solid rgba(255,255,255,.35); border-bottom:1px solid rgba(255,255,255,.35); color:#e9d5bd; font-size:10px; font-weight:600; letter-spacing:.23em; }

        .gallery-section { padding-bottom:clamp(90px,14vw,180px); }
        .gallery { display:grid; grid-template-columns:repeat(12,1fr); gap:clamp(10px,1.5vw,20px); }
        .gallery-card { position:relative; grid-column:span 4; overflow:hidden; cursor:pointer; background:var(--sand); isolation:isolate; }
        .gallery-card:nth-child(5n+1) { grid-column:span 7; }
        .gallery-card:nth-child(5n+2) { grid-column:span 5; }
        .gallery-card:nth-child(5n+4) { grid-column:span 5; }
        .gallery-card:nth-child(5n+5) { grid-column:span 7; }
        .gallery-card img { display:block; width:100%; height:380px; object-fit:cover; transition:transform .7s cubic-bezier(.2,.7,.2,1),filter .5s; }
        .gallery-card:nth-child(5n+1) img, .gallery-card:nth-child(5n+5) img { height:510px; }
        .gallery-card::after { content:''; position:absolute; inset:0; z-index:1; background:linear-gradient(0deg,rgba(19,31,23,.58),transparent 48%); opacity:0; transition:opacity .35s; }
        .gallery-card:hover img { transform:scale(1.07); filter:saturate(1.06); }
        .gallery-card:hover::after, .gallery-card:hover .gallery-meta { opacity:1; }
        .gallery-meta { position:absolute; z-index:2; bottom:20px; left:22px; right:22px; display:flex; justify-content:space-between; align-items:end; color:#fff; opacity:0; transform:translateY(8px); transition:.35s; }
        .gallery-meta span:first-child { font:italic 25px var(--serif); }
        .gallery-index { font-size:10px; font-weight:600; letter-spacing:.15em; }
        .empty-gallery { padding:80px 25px; border:1px dashed var(--line); color:#708078; text-align:center; font:italic 28px var(--serif); }

        footer { padding:70px 6% 35px; color:#f5efe7; background:var(--forest); text-align:center; }
        .footer-kicker { color:#d5b99b; font-size:10px; font-weight:600; letter-spacing:.24em; }
        .footer-names { margin-top:15px; font:400 clamp(48px,7vw,92px)/.8 var(--serif); letter-spacing:-.05em; }
        .footer-names em { color:#dfb79a; font-weight:400; }
        .footer-bottom { display:flex; justify-content:space-between; margin-top:70px; padding-top:20px; border-top:1px solid rgba(255,255,255,.17); color:rgba(255,255,255,.58); font-size:10px; letter-spacing:.12em; }

        .music-button { position:fixed; z-index:35; right:24px; bottom:24px; display:grid; place-items:center; width:52px; height:52px; border:1px solid rgba(255,255,255,.7); border-radius:50%; background:var(--cream); color:var(--forest); box-shadow:0 12px 32px rgba(20,30,22,.18); cursor:pointer; transition:transform .25s,background .25s,color .25s; }
        .music-button:hover { transform:scale(1.08); }
        .music-button.playing { color:#fff; background:var(--forest); animation:pulse 1.8s infinite; }
        .music-button span { font-size:20px; }
        .lightbox { position:fixed; z-index:80; inset:0; display:flex; align-items:center; justify-content:center; padding:70px 90px; background:rgba(12,19,14,.95); opacity:0; visibility:hidden; transition:.3s; }
        .lightbox.active { opacity:1; visibility:visible; }
        .lightbox img { max-width:100%; max-height:78vh; box-shadow:0 24px 80px rgba(0,0,0,.45); }
        .lightbox button { position:absolute; z-index:1; border:0; color:#fff; background:transparent; cursor:pointer; }
        .lightbox-close { top:22px; right:30px; font-size:38px; font-weight:200; }
        .lightbox-prev,.lightbox-next { top:50%; font:400 55px/.5 var(--serif); transform:translateY(-50%); }
        .lightbox-prev { left:30px; }.lightbox-next { right:30px; }
        .lightbox-counter { position:absolute; bottom:25px; color:rgba(255,255,255,.7); font-size:10px; letter-spacing:.18em; }

        @keyframes rise { from { opacity:0; transform:translateY(22px); } to { opacity:1; transform:none; } }
        @keyframes heroZoom { from { opacity:0; transform:scale(1.16); } to { opacity:1; transform:scale(1.06); } }
        @keyframes spinIn { from { opacity:0; transform:rotate(-25deg) scale(.7); } to { opacity:1; transform:rotate(12deg) scale(1); } }
        @keyframes drift { to { transform:translate(25px,35px); } }
        @keyframes scrollLine { 50% { transform:translateY(7px); opacity:.35; } }
        @keyframes pulse { 50% { box-shadow:0 0 0 9px rgba(35,54,42,.12),0 12px 32px rgba(20,30,22,.18); } }
        @keyframes marquee { to { transform:translateX(-50%); } }
        @keyframes floatStar { to { transform:translateY(28px) rotate(20deg); } }
        @media (max-width:760px) {
            .nav { padding:19px 20px; }.nav.scrolled { padding:14px 20px; }.brand { font-size:21px; }.menu-toggle { display:block; }.nav-links { position:absolute; top:100%; left:15px; right:15px; display:block; padding:13px 20px; background:#f7f4ed; color:var(--ink); box-shadow:0 15px 35px rgba(20,30,22,.12); opacity:0; transform:translateY(-10px); pointer-events:none; transition:.25s; }.nav-links.open { opacity:1; transform:none; pointer-events:auto; }.nav-links li { padding:13px 0; border-bottom:1px solid var(--line); }.nav-links li:last-child { border:0; }
            .hero { display:flex; flex-direction:column; min-height:auto; }.hero-copy { min-height:620px; padding:145px 28px 100px; }.hero h1 { font-size:clamp(76px,22vw,118px); }.hero-media { min-height:420px; order:-1; }.hero-image,.hero-placeholder { min-height:420px; }.hero-media::after { background:linear-gradient(0deg,var(--forest),transparent 42%); }.hero-copy::before { width:85vw; height:85vw; top:6%; left:-34%; }.hero-stamp { bottom:24px; right:24px; width:88px; }.scroll-cue { left:28px; }
            .section { padding:86px 20px; }.section-head { margin-bottom:42px; }.countdown { grid-template-columns:repeat(2,1fr); margin-top:38px; }.count-item:nth-child(3) { border-left:0; border-top:1px solid rgba(255,255,255,.2); }.count-item:nth-child(4) { border-top:1px solid rgba(255,255,255,.2); }.story-grid { grid-template-columns:1fr; gap:48px; }.story-image,.story-placeholder { min-height:420px; }.story-badge { right:14px; top:-25px; }.event-grid { grid-template-columns:1fr; }.event-card { min-height:220px; }.timeline { grid-template-columns:1fr; gap:40px; }.timeline::before { top:34px; bottom:34px; left:31px; right:auto; width:1px; height:auto; }.timeline-item { padding-left:87px; }.timeline-flower { position:absolute; left:0; top:0; margin:0; }.letter { box-shadow:0 15px 35px rgba(71,49,29,.07), inset 0 0 0 5px rgba(225,210,190,.32); }.gallery { gap:9px; }.gallery-card,.gallery-card:nth-child(n) { grid-column:span 6; }.gallery-card:nth-child(5n+1),.gallery-card:nth-child(5n+5) { grid-column:span 12; }.gallery-card img,.gallery-card:nth-child(5n+1) img,.gallery-card:nth-child(5n+5) img { height:250px; }.gallery-card:nth-child(5n+1) img,.gallery-card:nth-child(5n+5) img { height:370px; }.gallery-meta { opacity:1; transform:none; bottom:12px; left:13px; right:13px; }.gallery-card::after { opacity:1; }.footer-bottom { margin-top:52px; }.lightbox { padding:50px 16px; }.lightbox-prev { left:12px; }.lightbox-next { right:12px; }.lightbox-prev,.lightbox-next { font-size:46px; }.lightbox-close { top:15px; right:19px; }.music-button { right:16px; bottom:16px; }
        }
    </style>
</head>
<body>
    <div class="noise"></div>
    <div class="progress" id="scrollProgress"></div>
    <audio id="weddingMusic" loop preload="metadata"><source src="{{ asset('music/wedding.mp3') }}" type="audio/mpeg"></audio>
    <button id="musicButton" class="music-button" type="button" aria-label="Bật nhạc" title="Bật nhạc"><span id="musicIcon">♪</span></button>

    <nav class="nav" id="nav">
        <a class="brand" href="#home">{{ $bride }} <span>&</span> {{ $groom }}</a>
        <button class="menu-toggle" id="menuToggle" type="button" aria-label="Mở menu" aria-expanded="false">☰</button>
        <ul class="nav-links" id="navLinks">
            <li><a href="#home">TRANG CHỦ</a></li><li><a href="#story">CÂU CHUYỆN</a></li><li><a href="#day">NGÀY CƯỚI</a></li><li><a href="#moments">KỶ NIỆM</a></li>
        </ul>
    </nav>

    <main>
        <section class="hero" id="home">
            <div class="hero-copy">
                <div class="hero-kicker">A celebration of love</div>
                <h1>{{ $bride }} <span class="and">&</span><em>{{ $groom }}</em></h1>
                <div class="hero-date"><span></span>{{ $date ? $date->translatedFormat('d \T\H\Á\N\G m, Y') : 'NGÀY ĐẶC BIỆT CỦA CHÚNG MÌNH' }}</div>
                <p class="hero-note">Một hành trình mới bắt đầu từ khoảnh khắc hai trái tim cùng chung một nhịp đập.</p>
                <div class="scroll-cue">KHÁM PHÁ CÂU CHUYỆN</div>
            </div>
            <div class="hero-media">
                @if ($cover)<img class="hero-image" src="{{ $cover }}" alt="{{ $bride }} và {{ $groom }}">@else<div class="hero-placeholder">Our day, our story</div>@endif
                <div class="hero-stamp"><span>WITH<br>ALL OUR<br>LOVE</span></div>
            </div>
        </section>

        <section class="section countdown-wrap">
            <div class="inner reveal">
                <div class="section-kicker">Save the date</div>
                <h2 class="section-title">Counting down to <em>forever.</em></h2>
                @if ($date)
                    <div class="countdown" id="countdown"><div class="count-item"><strong class="count-number" id="days">00</strong><span class="count-label">NGÀY</span></div><div class="count-item"><strong class="count-number" id="hours">00</strong><span class="count-label">GIỜ</span></div><div class="count-item"><strong class="count-number" id="minutes">00</strong><span class="count-label">PHÚT</span></div><div class="count-item"><strong class="count-number" id="seconds">00</strong><span class="count-label">GIÂY</span></div></div>
                @else <p class="past-date">Ngày đặc biệt sẽ sớm được cập nhật.</p> @endif
            </div>
        </section>

        <div class="marquee" aria-hidden="true"><div class="marquee-track"><span>THE BEGINNING OF ALWAYS</span><i>✦</i><span>{{ $bride }} & {{ $groom }}</span><i>✦</i><span>WITH ALL OUR LOVE</span><i>✦</i><span>THE BEGINNING OF ALWAYS</span><i>✦</i><span>{{ $bride }} & {{ $groom }}</span><i>✦</i><span>WITH ALL OUR LOVE</span><i>✦</i></div></div>

        <section class="section" id="story">
            <div class="inner story-grid">
                <div class="story-media reveal">
                    @if ($storyImage)<img class="story-image" src="{{ asset('storage/' . $storyImage->image) }}" alt="Khoảnh khắc của {{ $bride }} và {{ $groom }}">@else<div class="story-placeholder">Our story</div>@endif
                    <div class="story-badge">Made for<br>each other</div>
                </div>
                <div class="story-copy reveal">
                    <div class="section-kicker">Our story</div>
                    <h3>Two hearts.<br><em>One beautiful</em> story.</h3>
                    <p>Có những cuộc gặp gỡ thật bình thường, nhưng lại trở thành điều quan trọng nhất trong cuộc đời. Từ những ngày đầu tiên đến hôm nay, chúng mình đã cùng nhau gom nhặt thật nhiều tiếng cười, những chuyến đi và cả những ước mơ.</p>
                    <p>Giờ đây, chúng mình viết tiếp câu chuyện ấy bằng một lời hứa — cùng nắm tay, cùng lớn lên và cùng đi về phía trước.</p>
                    <div class="signature">{{ $bride }} & {{ $groom }}</div>
                </div>
            </div>
        </section>

        <section class="section letter-section">
            <div class="letter reveal">
                <div class="section-kicker">A note from our hearts</div>
                <h2>"Và rồi chúng mình<br><em>chọn nhau,</em> mỗi ngày."</h2>
                <p>Không cần những điều quá lớn lao, chỉ cần mỗi sớm mai còn có nhau, mỗi hoàng hôn vẫn được nắm tay và mỗi chặng đường phía trước luôn có một mái nhà để trở về.</p>
                <div class="wax-seal">{{ mb_substr($bride, 0, 1) }}&{{ mb_substr($groom, 0, 1) }}</div>
            </div>
        </section>

        <section class="section day" id="day">
            <div class="inner">
                <div class="section-head reveal"><div class="section-kicker">The celebration</div><h2 class="section-title">A day made of <em>love.</em></h2><p class="intro">Ngày chúng mình chính thức bắt đầu một chương mới, với tất cả yêu thương từ gia đình và những người bạn thân quý.</p></div>
                <div class="event-grid reveal"><article class="event-card"><div class="event-number">01</div><h3>Lễ Thành Hôn</h3><p>Khoảnh khắc hai trái tim cùng thưa lời hẹn ước, mở đầu cho hành trình trọn đời bên nhau.</p></article><article class="event-card"><div class="event-number">02</div><h3>Tiệc Mừng</h3><p>Cùng gia đình, bạn bè nâng ly và lưu lại những nụ cười rạng rỡ nhất trong ngày vui.</p></article></div>
            </div>
        </section>

        <section class="section timeline-section">
            <div class="inner">
                <div class="section-head reveal"><div class="section-kicker">The little things</div><h2 class="section-title">Every chapter led <em>to this.</em></h2></div>
                <div class="timeline reveal">
                    <article class="timeline-item"><div class="timeline-flower">✦</div><small>CHƯƠNG I</small><h3>Gặp gỡ</h3><p>Một cuộc gặp tình cờ, mở ra một câu chuyện chẳng ai trong hai chúng mình có thể ngờ tới.</p></article>
                    <article class="timeline-item"><div class="timeline-flower">♡</div><small>CHƯƠNG II</small><h3>Thương yêu</h3><p>Từ những điều nhỏ bé hằng ngày, yêu thương lớn dần thành nơi bình yên nhất.</p></article>
                    <article class="timeline-item"><div class="timeline-flower">✧</div><small>CHƯƠNG III</small><h3>Hẹn ước</h3><p>Hôm nay, chúng mình cùng viết nên trang đầu tiên của hành trình mang tên “mãi mãi”.</p></article>
                </div>
            </div>
        </section>

        <section class="section promise">
            <div class="promise-content reveal"><div class="section-kicker">Our promise</div><h2>To have and<br><em>to hold.</em></h2><p>Yêu nhau không chỉ trong những ngày rực rỡ, mà còn trong mọi mùa của cuộc đời. Cảm ơn vì đã là điều dịu dàng nhất mà chúng mình tìm thấy.</p><div class="promise-date">{{ $date ? $date->translatedFormat('d \T\H\Á\N\G m · Y') : 'FOREVER BEGINS HERE' }}</div></div>
        </section>

        <section class="section gallery-section" id="moments">
            <div class="inner"><div class="section-head reveal"><div class="section-kicker">Captured moments</div><h2 class="section-title">A little album of <em>us.</em></h2><p class="intro">Những khung hình chân thật nhất, được lưu giữ để mỗi lần nhìn lại, chúng mình vẫn thấy ngày hôm ấy thật gần.</p></div>
                @if ($photos->count())<div class="gallery">@foreach ($photos as $photo)<article class="gallery-card" role="button" tabindex="0" data-photo-index="{{ $loop->index }}" aria-label="Xem ảnh {{ $loop->iteration }}"><img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title ?? 'Wedding memory ' . $loop->iteration }}" decoding="async"><div class="gallery-meta"><span>{{ $photo->title ?? 'Our memory' }}</span><span class="gallery-index">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span></div></article>@endforeach</div>@else<div class="empty-gallery">Những kỷ niệm đẹp sẽ sớm xuất hiện ở đây.</div>@endif
            </div>
        </section>
    </main>

    <footer><div class="footer-kicker">WITH ALL OUR LOVE</div><div class="footer-names">{{ $bride }} <em>&</em> {{ $groom }}</div><div class="footer-bottom"><span>{{ $date ? $date->format('d.m.Y') : 'WEDDING MEMORIES' }}</span><span>FOREVER STARTS HERE ✦</span></div></footer>
    <div class="lightbox" id="lightbox" aria-hidden="true"><button class="lightbox-close" type="button" aria-label="Đóng">×</button><button class="lightbox-prev" type="button" aria-label="Ảnh trước">‹</button><img id="lightboxImage" src="" alt="Wedding memory"><button class="lightbox-next" type="button" aria-label="Ảnh sau">›</button><div class="lightbox-counter" id="lightboxCounter">01 / 01</div></div>
    <script>
        const nav = document.getElementById('nav'), progress = document.getElementById('scrollProgress'), menu = document.getElementById('menuToggle'), links = document.getElementById('navLinks');
        const updateScroll = () => { const max = document.documentElement.scrollHeight - innerHeight; progress.style.width = `${max ? scrollY / max * 100 : 0}%`; nav.classList.toggle('scrolled', scrollY > 35); };
        addEventListener('scroll', updateScroll, { passive:true }); updateScroll();
        menu.addEventListener('click', () => { const open = links.classList.toggle('open'); menu.setAttribute('aria-expanded', open); menu.textContent = open ? '×' : '☰'; });
        links.querySelectorAll('a').forEach(link => link.addEventListener('click', () => { links.classList.remove('open'); menu.setAttribute('aria-expanded', 'false'); menu.textContent = '☰'; }));
        const observer = new IntersectionObserver(entries => entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); } }), { threshold:.12 }); document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        const music = document.getElementById('weddingMusic'), musicButton = document.getElementById('musicButton'), musicIcon = document.getElementById('musicIcon');
        musicButton.addEventListener('click', async () => { if (music.paused) { try { await music.play(); musicButton.classList.add('playing'); musicIcon.textContent = '♫'; musicButton.setAttribute('aria-label', 'Tắt nhạc'); } catch (_) {} } else { music.pause(); musicButton.classList.remove('playing'); musicIcon.textContent = '♪'; musicButton.setAttribute('aria-label', 'Bật nhạc'); } });
        const photos = @json($photos->map(fn ($photo) => asset('storage/' . $photo->image))->values()), lightbox = document.getElementById('lightbox'), lightboxImage = document.getElementById('lightboxImage'), counter = document.getElementById('lightboxCounter'); let current = 0;
        const renderLightbox = () => { lightboxImage.src = photos[current]; counter.textContent = `${String(current + 1).padStart(2, '0')} / ${String(photos.length).padStart(2, '0')}`; };
        const openLightbox = index => { if (!photos.length) return; current = index; renderLightbox(); lightbox.classList.add('active'); lightbox.setAttribute('aria-hidden','false'); document.body.classList.add('lightbox-open'); };
        const closeLightbox = () => { lightbox.classList.remove('active'); lightbox.setAttribute('aria-hidden','true'); document.body.classList.remove('lightbox-open'); };
        const changePhoto = offset => { if (!photos.length) return; current = (current + offset + photos.length) % photos.length; renderLightbox(); };
        document.querySelectorAll('[data-photo-index]').forEach(card => { const open = () => openLightbox(Number(card.dataset.photoIndex)); card.addEventListener('click', open); card.addEventListener('keydown', event => { if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); open(); } }); });
        document.querySelector('.lightbox-close').addEventListener('click', closeLightbox); document.querySelector('.lightbox-prev').addEventListener('click', () => changePhoto(-1)); document.querySelector('.lightbox-next').addEventListener('click', () => changePhoto(1)); lightbox.addEventListener('click', event => { if (event.target === lightbox) closeLightbox(); });
        document.addEventListener('keydown', event => { if (!lightbox.classList.contains('active')) return; if (event.key === 'Escape') closeLightbox(); if (event.key === 'ArrowLeft') changePhoto(-1); if (event.key === 'ArrowRight') changePhoto(1); });
        @if ($date) const weddingDate = new Date('{{ $date->format('Y-m-d') }}T00:00:00'); const updateCountdown = () => { let left = Math.max(0, weddingDate - new Date()); const unit = [86400000, 3600000, 60000, 1000], ids = ['days','hours','minutes','seconds']; unit.forEach((value, index) => { const amount = Math.floor(left / value); left %= value; document.getElementById(ids[index]).textContent = String(amount).padStart(2, '0'); }); }; updateCountdown(); setInterval(updateCountdown, 1000); @endif
    </script>
</body>
</html>
