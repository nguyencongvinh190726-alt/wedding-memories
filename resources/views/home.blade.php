```blade
<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $wedding?->bride_name ?? 'Bride' }}
        &
        {{ $wedding?->groom_name ?? 'Groom' }}
    </title>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Montserrat:wght@300;400;500&display=swap"
        rel="stylesheet"
    >

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #faf8f4;
            color: #333;
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;
            overflow-x: hidden;
        }

        body.lightbox-open {
            overflow: hidden;
        }

        img {
            max-width: 100%;
        }

        a {
            color: inherit;
        }


        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;

            padding: 22px 5%;

            display: flex;
            justify-content: space-between;
            align-items: center;

            background: rgba(250, 248, 244, .88);

            backdrop-filter: blur(12px);

            border-bottom: 1px solid rgba(0, 0, 0, .04);
        }

        .logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 27px;
            color: #333;
            white-space: nowrap;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: #666;
            font-size: 10px;
            letter-spacing: 2px;
            transition: .3s;
        }

        .nav-links a:hover {
            color: #a18b72;
        }

        .menu-button {
            display: none;
            border: none;
            background: transparent;
            font-size: 25px;
            cursor: pointer;
        }


        /* =========================
           HERO
        ========================= */

        .hero {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            text-align: center;

            padding: 150px 20px 100px;

            position: relative;
        }

        .hero-content {
            width: 100%;
            max-width: 1100px;
        }

        .eyebrow {
            font-size: 10px;
            letter-spacing: 7px;
            color: #999;
            margin-bottom: 30px;
        }

        .names {
            font-family: 'Cormorant Garamond', serif;

            font-size: clamp(55px, 9vw, 115px);

            line-height: .8;

            font-weight: 400;

            animation: fadeUp 1s ease both;
        }

        .ampersand {
            font-family: 'Cormorant Garamond', serif;

            font-size: 60px;

            color: #a18b72;

            margin: 35px 0;
        }

        .date {
            margin-top: 40px;

            font-size: 13px;

            letter-spacing: 7px;

            color: #777;
        }

        .hero-photo {
            margin: 70px auto 0;

            max-width: 850px;

            position: relative;
        }

        .hero-photo img {
            width: 100%;

            height: 650px;

            object-fit: cover;

            display: block;

            box-shadow: 0 25px 60px rgba(0, 0, 0, .08);
        }

        .empty-cover {
            height: 650px;

            display: flex;

            justify-content: center;

            align-items: center;

            background: #e9e3da;

            color: #999;

            letter-spacing: 4px;
        }


        /* =========================
           MUSIC BUTTON
        ========================= */

        .music-button {
            position: fixed;

            right: 25px;
            bottom: 25px;

            width: 58px;
            height: 58px;

            border: 1px solid rgba(255, 255, 255, .35);

            border-radius: 50%;

            background: #292725;

            color: #fff;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 25px;

            cursor: pointer;

            z-index: 9998;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, .18);

            transition:
                transform .3s ease,
                background .3s ease;
        }

        .music-button:hover {
            transform: scale(1.08);

            background: #a18b72;
        }

        .music-button.playing {
            background: #a18b72;

            animation:
                musicRotate 3s linear infinite;
        }

        .music-icon {
            display: block;

            line-height: 1;
        }

        @keyframes musicRotate {

            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }

        }


        /* =========================
           COMMON SECTION
        ========================= */

        .section {
            padding: 120px 6%;
        }

        .section-inner {
            max-width: 1100px;
            margin: auto;
        }

        .section-label {
            text-align: center;

            font-size: 10px;

            letter-spacing: 5px;

            color: #aaa;

            margin-bottom: 15px;
        }

        .section-title {
            text-align: center;

            font-family: 'Cormorant Garamond', serif;

            font-size: 58px;

            font-weight: 400;

            margin-bottom: 35px;
        }


        /* =========================
           COUNTDOWN
        ========================= */

        .countdown-section {
            text-align: center;

            background: #292725;

            color: #fff;
        }

        .countdown-section .section-label {
            color: #aaa;
        }

        .countdown-section .section-title {
            color: #fff;
        }

        .countdown {
            display: grid;

            grid-template-columns: repeat(4, 1fr);

            max-width: 650px;

            margin: 45px auto 0;

            gap: 15px;
        }

        .count-item {
            padding: 20px 10px;

            border: 1px solid rgba(255, 255, 255, .15);
        }

        .count-number {
            display: block;

            font-family: 'Cormorant Garamond', serif;

            font-size: 48px;
        }

        .count-label {
            font-size: 9px;

            letter-spacing: 2px;

            color: #aaa;
        }


        /* =========================
           SAVE THE DATE
        ========================= */

        .save-date {
            text-align: center;

            background: #eee9e1;
        }

        .save-date-text {
            max-width: 600px;

            margin: auto;

            color: #777;

            line-height: 2;

            font-size: 14px;
        }

        .big-date {
            margin: 45px 0;

            font-family: 'Cormorant Garamond', serif;

            font-size: 70px;

            color: #333;
        }


        /* =========================
           STORY
        ========================= */

        .story {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 80px;

            align-items: center;
        }

        .story-image {
            height: 600px;

            background: #e9e3da;

            overflow: hidden;
        }

        .story-image img {
            width: 100%;

            height: 100%;

            object-fit: cover;

            transition: transform 1s ease;
        }

        .story-image:hover img {
            transform: scale(1.04);
        }

        .story-content {
            padding: 20px;
        }

        .story-content h3 {
            font-family: 'Cormorant Garamond', serif;

            font-size: 45px;

            font-weight: 400;

            margin-bottom: 25px;
        }

        .story-content p {
            color: #777;

            line-height: 2;

            font-size: 14px;
        }


        /* =========================
           WEDDING DAY
        ========================= */

        .day-section {
            background: #f1ede6;
        }

        .events {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 25px;

            max-width: 800px;

            margin: 50px auto 0;
        }

        .event {
            background: #fff;

            text-align: center;

            padding: 45px 25px;

            transition: .4s;
        }

        .event:hover {
            transform: translateY(-6px);

            box-shadow:
                0 15px 35px rgba(0, 0, 0, .06);
        }

        .event-number {
            font-family: 'Cormorant Garamond', serif;

            font-size: 45px;

            color: #a18b72;
        }

        .event h3 {
            font-family: 'Cormorant Garamond', serif;

            font-size: 28px;

            margin: 15px 0;
        }

        .event p {
            color: #888;

            font-size: 13px;

            line-height: 1.8;
        }


        /* =========================
           GALLERY
        ========================= */

        .gallery-description {
            text-align: center;

            max-width: 550px;

            margin: 0 auto 60px;

            color: #888;

            line-height: 1.8;

            font-size: 14px;
        }

        .gallery {
            columns: 3 280px;

            column-gap: 18px;
        }

        .photo {
            break-inside: avoid;

            margin-bottom: 18px;

            overflow: hidden;

            background: #eee;

            cursor: pointer;

            position: relative;
        }

        .photo img {
            width: 100%;

            display: block;

            transition: transform .7s ease;
        }

        .photo:hover img {
            transform: scale(1.04);
        }

        .photo-title {
            padding: 12px;

            background: #fff;

            text-align: center;

            font-size: 11px;

            color: #777;
        }

        .photo-number {
            position: absolute;

            top: 10px;
            left: 10px;

            background: rgba(0, 0, 0, .55);

            color: #fff;

            padding: 5px 8px;

            font-size: 9px;

            letter-spacing: 1px;

            z-index: 2;
        }

        .empty-gallery {
            text-align: center;

            padding: 100px 20px;

            color: #999;

            letter-spacing: 3px;
        }


        /* =========================
           LIGHTBOX
        ========================= */

        .lightbox {
            display: none;

            position: fixed;

            inset: 0;

            z-index: 9999;

            background: rgba(0, 0, 0, .94);

            align-items: center;

            justify-content: center;

            padding: 50px;
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox-image {
            max-width: 90vw;

            max-height: 88vh;

            object-fit: contain;

            user-select: none;
        }

        .lightbox-close {
            position: absolute;

            top: 20px;
            right: 30px;

            border: none;

            background: transparent;

            color: white;

            font-size: 42px;

            cursor: pointer;

            z-index: 2;
        }

        .lightbox-prev,
        .lightbox-next {
            position: absolute;

            top: 50%;

            transform: translateY(-50%);

            border: none;

            background: rgba(255, 255, 255, .12);

            color: white;

            width: 55px;

            height: 55px;

            border-radius: 50%;

            font-size: 32px;

            cursor: pointer;

            transition: .3s;

            z-index: 3;
        }

        .lightbox-prev {
            left: 25px;
        }

        .lightbox-next {
            right: 25px;
        }

        .lightbox-prev:hover,
        .lightbox-next:hover {
            background: rgba(255, 255, 255, .3);
        }

        .lightbox-counter {
            position: absolute;

            bottom: 20px;

            left: 50%;

            transform: translateX(-50%);

            color: #aaa;

            font-size: 11px;

            letter-spacing: 2px;
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            padding: 100px 20px;

            text-align: center;

            background: #292725;

            color: #fff;
        }

        .footer-small {
            font-size: 10px;

            letter-spacing: 5px;

            opacity: .6;

            margin-bottom: 20px;
        }

        .footer-names {
            font-family: 'Cormorant Garamond', serif;

            font-size: 50px;
        }

        .footer-love {
            margin-top: 20px;

            color: #aaa;

            font-size: 13px;
        }


        /* =========================
           ANIMATION
        ========================= */

        .reveal {
            opacity: 0;

            transform: translateY(35px);

            transition:
                opacity .8s ease,
                transform .8s ease;
        }

        .reveal.show {
            opacity: 1;

            transform: translateY(0);
        }

        @keyframes fadeUp {

            from {
                opacity: 0;

                transform: translateY(30px);
            }

            to {
                opacity: 1;

                transform: translateY(0);
            }

        }


        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 700px) {

            .navbar {
                padding: 17px 20px;
            }

            .logo {
                font-size: 23px;
            }

            .menu-button {
                display: block;
            }

            .nav-links {
                display: none;

                position: absolute;

                top: 100%;

                left: 0;

                width: 100%;

                padding: 20px;

                background: #faf8f4;

                flex-direction: column;

                gap: 20px;

                text-align: center;
            }

            .nav-links.open {
                display: flex;
            }

            .hero {
                padding-top: 130px;
            }

            .names {
                font-size: 60px;
            }

            .ampersand {
                font-size: 45px;

                margin: 25px 0;
            }

            .hero-photo img,
            .empty-cover {
                height: 450px;
            }

            .section {
                padding: 80px 20px;
            }

            .section-title {
                font-size: 45px;
            }

            .big-date {
                font-size: 48px;
            }

            .countdown {
                grid-template-columns: repeat(2, 1fr);
            }

            .count-number {
                font-size: 40px;
            }

            .story {
                grid-template-columns: 1fr;

                gap: 40px;
            }

            .story-image {
                height: 450px;
            }

            .events {
                grid-template-columns: 1fr;
            }

            .gallery {
                columns: 2 140px;

                column-gap: 10px;
            }

            .photo {
                margin-bottom: 10px;
            }

            .footer-names {
                font-size: 40px;
            }

            .lightbox {
                padding: 20px;
            }

            .lightbox-image {
                max-width: 95vw;

                max-height: 80vh;
            }

            .lightbox-prev,
            .lightbox-next {
                width: 42px;

                height: 42px;

                font-size: 23px;
            }

            .lightbox-prev {
                left: 8px;
            }

            .lightbox-next {
                right: 8px;
            }

            .lightbox-close {
                top: 8px;

                right: 15px;

                font-size: 35px;
            }

            .music-button {
                width: 50px;
                height: 50px;

                right: 18px;
                bottom: 18px;

                font-size: 22px;
            }

        }

    </style>

</head>


<body>


<!-- =========================
     WEDDING MUSIC
========================= -->

<audio
    id="weddingMusic"
    loop
    preload="auto"
>
    <source
        src="{{ asset('music/wedding.mp3') }}"
        type="audio/mpeg"
    >
</audio>


<button
    id="musicButton"
    class="music-button"
    type="button"
    aria-label="Bật nhạc"
    title="Bật nhạc"
>
    <span
        id="musicIcon"
        class="music-icon"
    >
        ♫
    </span>
</button>


<!-- =========================
     NAVBAR
========================= -->

<nav class="navbar">

    <div class="logo">

        {{ $wedding?->bride_name ?? 'Bride' }}

        &

        {{ $wedding?->groom_name ?? 'Groom' }}

    </div>


    <button
        class="menu-button"
        onclick="toggleMenu()"
        aria-label="Menu"
    >
        ☰
    </button>


    <ul
        class="nav-links"
        id="navLinks"
    >

        <li>
            <a
                href="#home"
                onclick="closeMenu()"
            >
                HOME
            </a>
        </li>

        <li>
            <a
                href="#story"
                onclick="closeMenu()"
            >
                OUR STORY
            </a>
        </li>

        <li>
            <a
                href="#day"
                onclick="closeMenu()"
            >
                THE DAY
            </a>
        </li>

        <li>
            <a
                href="#moments"
                onclick="closeMenu()"
            >
                MOMENTS
            </a>
        </li>

    </ul>

</nav>


<!-- =========================
     HERO
========================= -->

<section
    class="hero"
    id="home"
>

    <div class="hero-content">

        <div class="eyebrow">
            OUR WEDDING
        </div>


        <div class="names">

            {{ $wedding?->bride_name ?? 'Bride' }}

        </div>


        <div class="ampersand">
            &
        </div>


        <div class="names">

            {{ $wedding?->groom_name ?? 'Groom' }}

        </div>


        <div class="date">

            @if ($wedding?->wedding_date)

                {{ $wedding->wedding_date->format('d . m . Y') }}

            @else

                DD . MM . YYYY

            @endif

        </div>


        <div class="hero-photo">

            @if ($wedding?->cover_image)

                <img
                    src="{{ asset('storage/' . $wedding->cover_image) }}"
                    alt="Wedding Cover"
                >

            @elseif ($photos->count())

                <img
                    src="{{ asset('storage/' . $photos->first()->image) }}"
                    alt="Wedding"
                >

            @else

                <div class="empty-cover">

                    WEDDING PHOTO

                </div>

            @endif

        </div>

    </div>

</section>


<!-- =========================
     COUNTDOWN
========================= -->

<section class="section countdown-section">

    <div class="section-inner">

        <div class="section-label">
            COUNTING DOWN
        </div>


        <h2 class="section-title">
            Until Our Big Day
        </h2>


        <div
            class="countdown"
            id="countdown"
        >

            <div class="count-item">

                <span
                    class="count-number"
                    id="days"
                >
                    00
                </span>

                <span class="count-label">
                    DAYS
                </span>

            </div>


            <div class="count-item">

                <span
                    class="count-number"
                    id="hours"
                >
                    00
                </span>

                <span class="count-label">
                    HOURS
                </span>

            </div>


            <div class="count-item">

                <span
                    class="count-number"
                    id="minutes"
                >
                    00
                </span>

                <span class="count-label">
                    MINUTES
                </span>

            </div>


            <div class="count-item">

                <span
                    class="count-number"
                    id="seconds"
                >
                    00
                </span>

                <span class="count-label">
                    SECONDS
                </span>

            </div>

        </div>

    </div>

</section>


<!-- =========================
     SAVE THE DATE
========================= -->

<section class="section save-date">

    <div class="section-inner">

        <div class="section-label">
            SAVE THE DATE
        </div>


        <h2 class="section-title">
            A Day To Remember
        </h2>


        @if ($wedding?->wedding_date)

            <div class="big-date">

                {{ $wedding->wedding_date->format('d . m . Y') }}

            </div>

        @else

            <div class="big-date">

                DD . MM . YYYY

            </div>

        @endif


        <p class="save-date-text">

            Một ngày đặc biệt,
            một lời hứa trọn đời
            và một hành trình mới bắt đầu.

            <br>

            Cảm ơn bạn đã cùng chúng mình
            lưu giữ những khoảnh khắc tuyệt đẹp này.

        </p>

    </div>

</section>


<!-- =========================
     STORY
========================= -->

<section
    class="section"
    id="story"
>

    <div class="section-inner">

        <div class="section-label">
            OUR STORY
        </div>


        <h2 class="section-title">
            Two Hearts, One Story
        </h2>


        <div class="story reveal">

            <div class="story-image">

                @if ($photos->count() > 1)

                    <img
                        src="{{ asset('storage/' . $photos->skip(1)->first()->image) }}"
                        alt="Our Story"
                    >

                @elseif ($photos->count())

                    <img
                        src="{{ asset('storage/' . $photos->first()->image) }}"
                        alt="Our Story"
                    >

                @else

                    <div class="empty-cover">
                        OUR STORY
                    </div>

                @endif

            </div>


            <div class="story-content">

                <h3>
                    From this moment,
                    forever.
                </h3>


                <p>

                    Có những cuộc gặp gỡ tưởng như
                    rất bình thường,
                    nhưng lại trở thành một phần
                    quan trọng nhất trong cuộc đời.

                    <br><br>

                    Từ những ngày đầu tiên cho đến hôm nay,
                    chúng mình đã cùng nhau đi qua rất nhiều
                    khoảnh khắc đáng nhớ.

                    <br><br>

                    Và hôm nay,
                    chúng mình viết tiếp câu chuyện ấy
                    bằng một lời hứa cho cả cuộc đời.

                </p>

            </div>

        </div>

    </div>

</section>


<!-- =========================
     WEDDING DAY
========================= -->

<section
    class="section day-section"
    id="day"
>

    <div class="section-inner">

        <div class="section-label">
            THE WEDDING DAY
        </div>


        <h2 class="section-title">
            Our Special Day
        </h2>


        <div class="events reveal">

            <div class="event">

                <div class="event-number">
                    01
                </div>

                <h3>
                    Lễ Cưới
                </h3>

                <p>

                    Cùng nhau bắt đầu
                    một chương mới
                    của cuộc đời.

                </p>

            </div>


            <div class="event">

                <div class="event-number">
                    02
                </div>

                <h3>
                    Tiệc Cưới
                </h3>

                <p>

                    Cùng gia đình và bạn bè
                    chia sẻ niềm vui
                    trong ngày đặc biệt.

                </p>

            </div>

        </div>

    </div>

</section>


<!-- =========================
     GALLERY
========================= -->

<section
    class="section"
    id="moments"
>

    <div class="section-inner">

        <div class="section-label">
            OUR MEMORIES
        </div>


        <h2 class="section-title">
            Our Moments
        </h2>


        <p class="gallery-description">

            Những khoảnh khắc nhỏ,
            những nụ cười và những kỷ niệm
            mà chúng mình muốn lưu giữ mãi mãi.

        </p>


        @if ($photos->count())

            <div class="gallery">

                @foreach ($photos as $photo)

                    <div
                        class="photo"
                        onclick="openLightbox({{ $loop->index }})"
                    >

                        <div class="photo-number">

                            {{ str_pad(
                                $loop->iteration,
                                2,
                                '0',
                                STR_PAD_LEFT
                            ) }}

                        </div>


                        <img
                            src="{{ asset('storage/' . $photo->image) }}"
                            alt="{{ $photo->title ?? 'Wedding Photo' }}"
                            loading="lazy"
                        >


                        @if ($photo->title)

                            <div class="photo-title">

                                {{ $photo->title }}

                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty-gallery">

                OUR WEDDING MEMORIES

            </div>

        @endif

    </div>

</section>


<!-- =========================
     FOOTER
========================= -->

<footer>

    <div class="footer-small">
        WITH LOVE
    </div>


    <div class="footer-names">

        {{ $wedding?->bride_name ?? 'Bride' }}

        &

        {{ $wedding?->groom_name ?? 'Groom' }}

    </div>


    <div class="footer-love">

        Forever begins here.

    </div>

</footer>


<!-- =========================
     LIGHTBOX
========================= -->

<div
    class="lightbox"
    id="lightbox"
    onclick="handleLightboxBackground(event)"
>

    <button
        class="lightbox-close"
        onclick="closeLightbox()"
        aria-label="Close"
    >
        ×
    </button>


    <button
        class="lightbox-prev"
        onclick="previousPhoto(event)"
        aria-label="Previous"
    >
        ‹
    </button>


    <img
        id="lightboxImage"
        class="lightbox-image"
        src=""
        alt="Wedding Photo"
    >


    <button
        class="lightbox-next"
        onclick="nextPhoto(event)"
        aria-label="Next"
    >
        ›
    </button>


    <div
        class="lightbox-counter"
        id="lightboxCounter"
    >
        01 / 01
    </div>

</div>


<script>

    /* =========================
       WEDDING MUSIC
    ========================= */

    const weddingMusic =
        document.getElementById('weddingMusic');

    const musicButton =
        document.getElementById('musicButton');

    const musicIcon =
        document.getElementById('musicIcon');


    musicButton.addEventListener(
        'click',
        function () {

            if (weddingMusic.paused) {

                weddingMusic
                    .play()
                    .then(function () {

                        musicButton
                            .classList
                            .add('playing');

                        musicIcon.textContent = '♫';

                        musicButton.setAttribute(
                            'aria-label',
                            'Tắt nhạc'
                        );

                        musicButton.setAttribute(
                            'title',
                            'Tắt nhạc'
                        );

                    })
                    .catch(function (error) {

                        console.log(
                            'Không thể phát nhạc:',
                            error
                        );

                    });

            } else {

                weddingMusic.pause();

                musicButton
                    .classList
                    .remove('playing');

                musicIcon.textContent = '♪';

                musicButton.setAttribute(
                    'aria-label',
                    'Bật nhạc'
                );

                musicButton.setAttribute(
                    'title',
                    'Bật nhạc'
                );

            }

        }
    );


    /* =========================
       PHOTOS
    ========================= */

    const weddingPhotos = @json(
        $photos->map(function ($photo) {
            return asset('storage/' . $photo->image);
        })->values()
    );


    let currentPhoto = 0;


    /* =========================
       LIGHTBOX
    ========================= */

    function openLightbox(index)
    {
        if (!weddingPhotos.length) {
            return;
        }

        currentPhoto = index;

        updateLightbox();

        document
            .getElementById('lightbox')
            .classList
            .add('active');

        document.body.classList.add('lightbox-open');
    }


    function closeLightbox()
    {
        document
            .getElementById('lightbox')
            .classList
            .remove('active');

        document.body.classList.remove('lightbox-open');
    }


    function updateLightbox()
    {
        const image =
            document.getElementById('lightboxImage');

        const counter =
            document.getElementById('lightboxCounter');


        image.src =
            weddingPhotos[currentPhoto];


        counter.textContent =
            String(currentPhoto + 1).padStart(2, '0')
            +
            ' / '
            +
            String(weddingPhotos.length).padStart(2, '0');
    }


    function previousPhoto(event)
    {
        if (event) {
            event.stopPropagation();
        }

        if (!weddingPhotos.length) {
            return;
        }

        currentPhoto--;

        if (currentPhoto < 0) {
            currentPhoto =
                weddingPhotos.length - 1;
        }

        updateLightbox();
    }


    function nextPhoto(event)
    {
        if (event) {
            event.stopPropagation();
        }

        if (!weddingPhotos.length) {
            return;
        }

        currentPhoto++;

        if (
            currentPhoto >= weddingPhotos.length
        ) {
            currentPhoto = 0;
        }

        updateLightbox();
    }


    function handleLightboxBackground(event)
    {
        if (
            event.target.id === 'lightbox'
        ) {
            closeLightbox();
        }
    }


    /* =========================
       KEYBOARD
    ========================= */

    document.addEventListener(
        'keydown',
        function(event)
        {
            const lightbox =
                document.getElementById('lightbox');


            if (
                !lightbox.classList.contains('active')
            ) {
                return;
            }


            if (event.key === 'Escape') {
                closeLightbox();
            }


            if (event.key === 'ArrowLeft') {
                previousPhoto();
            }


            if (event.key === 'ArrowRight') {
                nextPhoto();
            }
        }
    );


    /* =========================
       MOBILE MENU
    ========================= */

    function toggleMenu()
    {
        document
            .getElementById('navLinks')
            .classList
            .toggle('open');
    }


    function closeMenu()
    {
        document
            .getElementById('navLinks')
            .classList
            .remove('open');
    }


    /* =========================
       COUNTDOWN
    ========================= */

    @if ($wedding?->wedding_date)

        const weddingDate =
            new Date(
                "{{ $wedding->wedding_date->format('Y-m-d') }}T00:00:00"
            );


        function updateCountdown()
        {
            const now =
                new Date();


            const difference =
                weddingDate.getTime()
                -
                now.getTime();


            if (difference <= 0) {

                document.getElementById('days')
                    .textContent = '00';

                document.getElementById('hours')
                    .textContent = '00';

                document.getElementById('minutes')
                    .textContent = '00';

                document.getElementById('seconds')
                    .textContent = '00';

                return;
            }


            const days =
                Math.floor(
                    difference /
                    (1000 * 60 * 60 * 24)
                );


            const hours =
                Math.floor(
                    (difference /
                    (1000 * 60 * 60))
                    % 24
                );


            const minutes =
                Math.floor(
                    (difference /
                    (1000 * 60))
                    % 60
                );


            const seconds =
                Math.floor(
                    (difference / 1000)
                    % 60
                );


            document.getElementById('days')
                .textContent =
                String(days).padStart(2, '0');


            document.getElementById('hours')
                .textContent =
                String(hours).padStart(2, '0');


            document.getElementById('minutes')
                .textContent =
                String(minutes).padStart(2, '0');


            document.getElementById('seconds')
                .textContent =
                String(seconds).padStart(2, '0');
        }


        updateCountdown();

        setInterval(
            updateCountdown,
            1000
        );

    @endif


    /* =========================
       SCROLL REVEAL
    ========================= */

    const revealElements =
        document.querySelectorAll('.reveal');


    const revealObserver =
        new IntersectionObserver(
            function(entries)
            {
                entries.forEach(
                    function(entry)
                    {
                        if (
                            entry.isIntersecting
                        ) {

                            entry.target
                                .classList
                                .add('show');

                        }
                    }
                );
            },
            {
                threshold: 0.15
            }
        );


    revealElements.forEach(
        function(element)
        {
            revealObserver.observe(element);
        }
    );

</script>


</body>

</html>
```
