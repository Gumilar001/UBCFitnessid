<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kartu RFID Member</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .card {
            width: 340px;
            height: 210px;
            background-color: #000000;
            color: white;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            font-family: Arial, sans-serif;

            display: flex;
            flex-direction: column;
            justify-content: space-between; /* agar ada jarak antara atas dan bawah */
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: url("{{ public_path('images/background-biru-3.jpg') }}") no-repeat center center;
            background-size: cover;
            opacity: 0.25;
            z-index: 1;
        }

        .card-content {
            position: relative;
            z-index: 2;
            padding: 20px;
            flex-grow: 0; /* untuk bagian atas */
        }

        .top-section {
            /* untuk bagian atas */
        }

        .logo {
            width: 40px;
            height: 40px;
            background: url("{{ public_path('images/logo.jpg') }}") no-repeat center center;
            background-size: contain;
            margin-bottom: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #00BFFF; /* biru terang */
            margin-bottom: 5px;
        }

        .rfid {
            font-size: 12px;
            color: silver;
            margin-bottom: 0; /* agar rapat ke bawah */
        }

        .info {
            /* membuat div info mengisi ruang yang tersisa dan teks berada di tengah */
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center; /* tengah vertikal */
            align-items: center; /* tengah horizontal */
            font-size: 14px;
            line-height: 1.6;
            color: #f0f0f0;
            text-align: center;
            padding: 0 20px;
        }

        .footer {
            position: absolute;
            bottom: 10px;
            left: 20px;
            font-size: 10px;
            color: #aaaaaa;
            z-index: 2;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-content top-section">
            <div class="logo"></div>
            <div class="title">MEMBER CARD</div>
            <div class="rfid">RFID CODE: {{ $membership->rfid_code }}</div>
        </div>

        <div class="info">
            <div>Nama: {{ $membership->user->name }}</div>
            <div>Paket: {{ $membership->membership->name }}</div>
            <div>Tanggal: {{ $membership->created_at->format('d M Y') }}</div>
        </div>

        <div class="footer">UBC FITNESS ID © {{ date('Y') }}</div>
    </div>
</body>
</html>
