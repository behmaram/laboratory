<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('custom.css') }}">
    <title>{{__('Payment successfully')}}</title>
    <style>
        body{
            direction: rtl;
            text-align: right;
            background:#1384c9;
        }
        .card{
            padding:15px;
            width:350px;
            height:600px;
            background:#fff;
            position:relative;
            margin:25px auto;
            border-radius:10px;
        }
        .card h1{
            text-align: center;
            color:#4CAF50;
        }
        .card a{
            position: absolute;
            width:calc(100% - 30px);
            padding:10px 0;
            font-weight: bold;
            text-align: center;
            text-decoration:none;
            background:#1384c9;
            color:#fff;
            bottom: 15px;
            border-radius:5px;
            left:0;
            right: 0;
            margin: auto;
        }
        .space{
            height:2px;
            width: 300px;
            margin:auto;
            background:#4CAF50;
        }
        .payment_id{
            text-align: center;
            font-weight: bold;
        }
        .logo{
            text-align: center;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="space"></div>
    <h1>پرداخت با موفقیت انجام شد</h1>
    <div class="space"></div>
        <p>کد رهگیری : 153412568</p>
    <a href="">بازگشت به صفحه اصلی</a>
</div>
</body>
</html>
