<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Spot2 Shortener</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #f8f8f8; }
        .container { max-width: 900px; margin: auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 10px; border-bottom: 1px solid #ccc; text-align: left; }
        th { background: #3490dc; color: white; }
        a { color: #007BFF; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div style="background: #d1ecf1; color: #0c5460; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                {{ session('info') }}
            </div>
        @endif
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">Shortened URLs</h2>
            <a href="{{ route('shorten.form') }}" style="text-decoration: none;">
                <button style="padding: 8px 12px; font-size: 20px; border-radius: 5px; background-color: #38c172; color: white; border: none; cursor: pointer;">
                    +
                </button>
            </a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Code</th>
                    <th>Original URL</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($urls as $url)
                    <tr>
                        <td>{{ $url->id }}</td>
                        <td>{{ $url->short_code }}</td>
                        <td style="word-break: break-word">{{ $url->original_url }}</td>
                        <td>
                            <!-- Botón para abrir la URL -->
                            <a href="{{ url($url->short_code) }}" target="_blank" title="Abrir URL">
                                🔗
                            </a>
                    
                            <!-- Formulario para eliminar -->
                            <form action="{{ route('shortener.destroy', $url->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta URL?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Eliminar URL" style="background: none; border: none; color: red; font-size: 16px; cursor: pointer;">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay URLs acortadas todavía.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
