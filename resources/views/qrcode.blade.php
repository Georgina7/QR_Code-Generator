<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>How to Generate QR Code in Laravel 8</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body>

<div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h2>Program Details</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('generate_qrcode') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="name">Program Name</label>
                        <input name="name" type="text">
                    </div>
                    <div>
                        <label for="venue">Venue</label>
                        <input name="venue" type="text">
                    </div>
                    <div>
                        <label for="date">Date</label>
                        <input name="date" type="date">
                    </div>
                    <div>
                        <label for="start_time">Start Time</label>
                        <input name="start_time" type="time">
                    </div>
                    <div>
                        <label for="end_time">End Time</label>
                        <input name="end_time" type="time">
                    </div>
                    <div>
                        <label for="program">Upload Program</label>
                        <input name="program" type="file" accept=".pdf" required>
                    </div>
                    <div class="">
                        <button type="submit" name="submit" value="image">Generate Image</button>
                        <button type="submit" name="submit" value="document">Generate Document</button>
                    </div>
                </form>
{{--                {!! QrCode::size(300)->generate('https://5fe3-2c0f-fe38-2248-4316-f868-cb1d-6100-9fd.in.ngrok.io/qrcode') !!}--}}
            </div>
    </div>

</div>
</body>
</html>
