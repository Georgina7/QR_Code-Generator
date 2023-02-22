<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Program QR Code</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Program QR Code</h2>
        </div>
        <div class="card-body">
            <img src="{{asset('storage/qrcodes/'.$qrcode_name)}}">
        </div>
        <div>
            <a href="{{route('download_qrcode', ['qrcode_name' => $qrcode_name])}}">Download</a>
        </div>
    </div>

</div>
</body>
</html>
