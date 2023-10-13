<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation for {{ $qoutedMailData['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 40px;
            background-color: #f7f8fa;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 30px 40px;
            border: 1px solid #e4e4e4;
        }

        h1 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #444;
            border-bottom: 2px solid #e9e9e9;
            padding-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .prices {
            border: 1px solid #e9e9e9;
            border-radius: 6px;
            padding: 15px;
            background-color: #f7f7f7;
        }

        .price-item {
            margin-bottom: 10px;
        }

        .price-item:last-child {
            margin-bottom: 0;
        }

        .footer {
            font-size: 14px;
            color: #888;
            border-top: 1px solid #eee;
            margin-top: 20px;
            padding-top: 10px;
        }

    </style>
</head>
<body>
    <div class="email-container">
        <h1>Quotation Details for {{ $qoutedMailData['title'] }}</h1>
        <p>
            Dear {{ $qoutedMailData['customer_name'] }},
            <br>
            Thank you for expressing interest in our services. We are pleased to present our quotation for {{ $qoutedMailData['product'] }}.
        </p>
        <div class="prices">
            <div class="price-item">Full Payment: <strong>${{ $qoutedMailData['prices']['full_payment'] }}</strong></div>
            <div class="price-item">Down Payment: <strong>${{ $qoutedMailData['prices']['down_payment'] }}</strong></div>
            <div class="price-item">Monthly Payment: <strong>${{ $qoutedMailData['prices']['monthly_payment'] }}</strong></div>
        </div>
        <p>
            Should you have any questions or require further clarification, please don't hesitate to get in touch. We are looking forward to doing business with you.
        </p>
        <p class="footer">Regards, {{ $qoutedMailData['footer'] }}</p>
    </div>
</body>
</html>
