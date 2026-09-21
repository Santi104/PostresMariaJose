<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio | Postres María José</title>
</head>
<body style="font-family: sans-serif; padding: 40px;">

    <h1>Bienvenido, {{ Auth::user()->nombre }}</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>

</body>
</html>