<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo enviado</title>
</head>
<body>
    <h1>Ingresar código</h1>
    <p>Por favor ingresa el código generado desde móvil</p>

    <form method="POST" action="{{ route('cargar-segundo-codigo') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <input type="text" id="code" name="code"><br><br>
            <input type="submit" value="Submit">
        </div>
    </form>

    <p style="color: red;">{{ $message }}</p>
</body>
</html>