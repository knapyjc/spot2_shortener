<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Spot2 Shortener</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #f8f8f8; }
        .container { max-width: 600px; margin: auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        input[type="url"] { width: 100%; padding: 10px; margin: 1rem 0; border-radius: 5px; border: 1px solid #ccc; }
        button { padding: 10px 20px; background: #3490dc; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .result { margin-top: 1rem; padding: 10px; background: #e6ffed; border: 1px solid #b6f7c1; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Spot2 Shortener</h1>
        <form action="{{ route('shortener.shorten') }}" method="POST">
            @csrf
            <label for="url">Create New URL:</label>
            <input type="url" name="url" id="url" placeholder="https://example.com/..." required>
            <button type="submit">Create</button>
        </form>

        @if(session('short_url'))
            <div class="result">
                <strong>URL corta:</strong>
                <a href="{{ session('short_url') }}" target="_blank">{{ session('short_url') }}</a>
            </div>
        @endif

        @if ($errors->any())
            <div class="result" style="background:#ffe6e6; border-color:#f5b5b5;">
                <strong>Errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>
