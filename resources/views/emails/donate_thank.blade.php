<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cảm ơn bạn đã donate</title>
</head>
<body>
    <h2>Xin cảm ơn {{ $donation->email ?? 'bạn' }} đã ủng hộ LehyUI!</h2>
    <p>Số tiền: <strong>{{ number_format($donation->amount) }} {{ $donation->currency }}</strong></p>
    <p>Mô tả: {{ $donation->description }}</p>
    <p>Chúc bạn một ngày tốt lành!</p>
</body>
</html>
