<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Estadísticas URL corta</title>
</head>
<body>

<h2>Consulta estadísticas de tu URL corta</h2>

<form id="statsForm">
    <label for="code">Código corto:</label>
    <input type="text" id="code" name="code" required maxlength="10" />
    <button type="submit">Consultar</button>
</form>

<div id="result" style="margin-top: 20px;"></div>

<script>
document.getElementById('statsForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const code = document.getElementById('code').value.trim();
    const resultDiv = document.getElementById('result');
    resultDiv.textContent = 'Cargando...';

    fetch(`/stats/${code}`)  // ruta relativa funciona bien en Laravel
        .then(response => {
            if (!response.ok) {
                throw new Error('Código no encontrado o error en el servidor.');
            }
            return response.json();
        })
        .then(data => {
            resultDiv.innerHTML = `
                <p><strong>URL Original:</strong> <a href="${data.original_url}" target="_blank">${data.original_url}</a></p>
                <p><strong>Clics:</strong> ${data.clicks}</p>
                <p><strong>Creado el:</strong> ${new Date(data.created_at).toLocaleString()}</p>
            `;
        })
        .catch(error => {
            resultDiv.textContent = error.message;
        });
});
</script>

</body>
</html>
