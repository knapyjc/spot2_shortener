<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spot2 Shortener</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Redirección automática después de 3 segundos -->
    <meta http-equiv="refresh" content="3;url={{ $original_url }}">

    <style>
        body {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .box {
            text-align: center;
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3490dc;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        p {
            font-size: 18px;
            color: #333;
        }

    </style>
</head>
<body>
    <div class="box">
        <div class="loader"></div>
        <p>Wait a moment... opening: <strong>{{ $short_url }}</strong></p>
    </div>
</body>
</html>
