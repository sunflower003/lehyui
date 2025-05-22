<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cảm ơn bạn đã donate</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2b2b2b;
            font-size: 22px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #444;
            line-height: 1.6;
        }

        .amount {
            font-weight: bold;
            color: #0066cc;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Xin cảm ơn {{ $donation->email ?? 'bạn' }} đã ủng hộ <strong>LehyUI</strong>!</h2>
        <p>Số tiền đã ủng hộ: <span class="amount">{{ number_format($donation->amount) }} {{ $donation->currency }}</span></p>
        <p>Nội dung: <em>{{ $donation->description }}</em></p>
        <p>Chúng tôi trân trọng tấm lòng của bạn và cam kết sử dụng đóng góp này một cách ý nghĩa nhất.</p>
        <p class="footer">Chúc bạn một ngày tốt lành!<br/>— Đội ngũ LehyUI</p>
    </div>
</body>
</html>
