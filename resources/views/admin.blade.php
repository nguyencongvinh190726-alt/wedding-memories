
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Wedding Memories - Admin</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Montserrat:wght@300;400;500&display=swap"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #f6f3ee;
            color: #333;
            font-family: 'Montserrat', sans-serif;
        }

        .container {
            width: min(1100px, 92%);
            margin: auto;
            padding: 60px 0;
        }

        .header {
            text-align: center;
            margin-bottom: 50px;
        }

        .header span {
            font-size: 11px;
            letter-spacing: 5px;
            color: #999;
        }

        .header h1 {
            margin-top: 12px;
            font-family: 'Cormorant Garamond', serif;
            font-size: 52px;
            font-weight: 400;
        }

        .back {
            display: inline-block;
            margin-bottom: 30px;
            color: #777;
            text-decoration: none;
            font-size: 13px;
        }

        .back:hover {
            color: #a18b72;
        }

        .card {
            background: #fff;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, .04);
        }

        .card h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 400;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            letter-spacing: 1px;
            color: #777;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            background: #fff;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: #a18b72;
        }

        .button {
            border: none;
            padding: 14px 28px;
            background: #333;
            color: #fff;
            cursor: pointer;
            font-family: inherit;
            letter-spacing: 1px;
        }

        .button:hover {
            background: #a18b72;
        }

        .success {
            background: #e9f6ed;
            color: #27733d;
            padding: 15px;
            margin-bottom: 25px;
        }

        .error {
            background: #fae8e8;
            color: #a33;
            padding: 15px;
            margin-bottom: 25px;
        }

        .error ul {
            padding-left: 20px;
        }

        .upload-info {
            margin-bottom: 20px;
            color: #888;
            font-size: 13px;
        }

        .count {
            margin-bottom: 20px;
            color: #777;
            font-size: 13px;
        }

        .photos {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .photo {
            position: relative;
            overflow: hidden;
            background: #eee;
        }

        .photo img {
            display: block;
            width: 100%;
            height: 230px;
            object-fit: cover;
        }

        .photo-actions {
            position: absolute;
            left: 8px;
            right: 8px;
            top: 8px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 8px;
        }

        .cover-form,
        .delete-form {
            margin: 0;
        }

        .cover-button {
            border: none;
            background: rgba(255, 255, 255, .95);
            color: #333;
            padding: 8px 10px;
            cursor: pointer;
            font-size: 10px;
            letter-spacing: 1px;
        }

        .cover-button:hover {
            background: #a18b72;
            color: #fff;
        }

        .cover-active {
            background: #a18b72;
            color: #fff;
        }

        .delete-button {
            border: none;
            background: rgba(0, 0, 0, .75);
            color: #fff;
            width: 32px;
            height: 32px;
            cursor: pointer;
            border-radius: 50%;
            font-size: 18px;
        }

        .delete-button:hover {
            background: #b33;
        }

        .cover-label {
            position: absolute;
            left: 8px;
            bottom: 8px;
            background: #a18b72;
            color: #fff;
            padding: 6px 10px;
            font-size: 9px;
            letter-spacing: 2px;
        }

        .empty {
            color: #999;
        }

        @media (max-width: 800px) {
            .photos {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .container {
                padding: 35px 0;
            }

            .card {
                padding: 22px;
            }

            .header h1 {
                font-size: 42px;
            }

            .photos {
                grid-template-columns: 1fr;
            }

            .photo img {
                height: 300px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <a
        href="{{ route('home', [], false) }}"
        class="back"
    >
        ← Xem Wedding Memories
    </a>


    <div class="header">

        <span>
            WEDDING MEMORIES
        </span>

        <h1>
            Admin
        </h1>

    </div>


    @if (session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    @if ($errors->any())

        <div class="error">

            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- THÔNG TIN ĐÁM CƯỚI -->

    <div class="card">

        <h2>
            Thông tin đám cưới
        </h2>


        <form
            action="{{ route('admin.wedding.update', [], false) }}"
            method="POST"
        >

            @csrf


            <div class="form-group">

                <label>
                    TÊN CÔ DÂU
                </label>

                <input
                    type="text"
                    name="bride_name"
                    value="{{ old('bride_name', $wedding?->bride_name) }}"
                    placeholder="Nhập tên cô dâu"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    TÊN CHÚ RỂ
                </label>

                <input
                    type="text"
                    name="groom_name"
                    value="{{ old('groom_name', $wedding?->groom_name) }}"
                    placeholder="Nhập tên chú rể"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    NGÀY CƯỚI
                </label>

                <input
                    type="date"
                    name="wedding_date"
                    value="{{ old('wedding_date', $wedding?->wedding_date?->format('Y-m-d')) }}"
                    required
                >

            </div>


            <button
                type="submit"
                class="button"
            >
                LƯU THÔNG TIN
            </button>

        </form>

    </div>


    <!-- UPLOAD -->

    <div class="card">

        <h2>
            Upload ảnh cưới
        </h2>

        <p class="upload-info">
            Chọn tối đa 20 ảnh.
            Mỗi ảnh tối đa 10MB.
        </p>


        <form
            action="{{ route('admin.photos.upload', [], false) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="form-group">

                <label>
                    CHỌN ẢNH
                </label>

                <input
                    type="file"
                    name="photos[]"
                    accept="image/jpeg,image/png,image/webp"
                    multiple
                    required
                >

            </div>


            <button
                type="submit"
                class="button"
            >
                UPLOAD ẢNH
            </button>

        </form>

    </div>


    <!-- GALLERY -->

    <div class="card">

        <h2>
            Gallery
        </h2>


        <div class="count">

            Tổng số ảnh:

            <strong>
                {{ $photos->count() }}
            </strong>

            / 20

        </div>


        @if ($photos->count())

            <div class="photos">

                @foreach ($photos as $photo)

                    <div class="photo">

                        <img
                            src="{{ asset('storage/' . $photo->image) }}"
                            alt="Wedding Photo"
                        >


                        <div class="photo-actions">

                            <!-- SET COVER -->

                            <form
                                action="{{ route('admin.photos.cover', [$photo], false) }}"
                                method="POST"
                                class="cover-form"
                            >

                                @csrf


                                @if ($wedding?->cover_image === $photo->image)

                                    <button
                                        type="submit"
                                        class="cover-button cover-active"
                                    >
                                        ✓ COVER
                                    </button>

                                @else

                                    <button
                                        type="submit"
                                        class="cover-button"
                                    >
                                        ĐẶT COVER
                                    </button>

                                @endif

                            </form>


                            <!-- DELETE -->

                            <form
                                action="{{ route('admin.photos.delete', [$photo], false) }}"
                                method="POST"
                                class="delete-form"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="delete-button"
                                    onclick="return confirm('Bạn có chắc muốn xóa ảnh này?')"
                                >
                                    ×
                                </button>

                            </form>

                        </div>


                        @if ($wedding?->cover_image === $photo->image)

                            <div class="cover-label">
                                COVER IMAGE
                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

        @else

            <p class="empty">
                Chưa có ảnh cưới nào.
            </p>

        @endif

    </div>

</div>

</body>
</html>
EOF
