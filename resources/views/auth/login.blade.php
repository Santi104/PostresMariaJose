<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Iniciar sesión | Postres María José</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: 'Outfit', system-ui, sans-serif;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #F6F5F4;
            color: #241C1B;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 24px;
        }

        .login-card {
            background: white;
            border: 1px solid #EFEDEC;
            border-radius: 18px;
            padding: 35px;

            box-shadow:
                0 12px 35px rgba(36, 28, 27, 0.08);
        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-icon img {
            width: 70px;
            height: 60px;
            margin: 0 auto 15px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: 700;
            overflow: hidden;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .logo p {
            color: #8A7E7C;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;

            font-size: 14px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 13px 14px;

            border: 1px solid #E3DEDB;
            border-radius: 9px;

            font-family: inherit;
            font-size: 15px;
            color: #241C1B;
            outline: none;

            transition: 0.2s;
        }

        .form-control:focus {
            border-color: #C8102E;
            box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.10);
        }

        .error {
            margin-top: 6px;
            font-size: 13px;
            color: #C8102E;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;

            margin-bottom: 20px;

            font-size: 14px;
            color: #6B6260;
        }

        .btn-login {
            width: 100%;

            border: none;
            border-radius: 9px;

            padding: 14px;

            background: #C8102E;
            color: white;

            font-family: inherit;
            font-size: 15px;
            font-weight: 600;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-login:hover {
            background: #96001F;
        }

        .footer {
            text-align: center;
            margin-top: 22px;

            font-size: 12px;
            color: #8A7E7C;
        }

    </style>
</head>

<body>

<div class="login-container">

    <div class="login-card">

        <div class="logo">

            <div class="logo-icon">
                <img src="{{ asset('img/icon.png') }}" alt="logo">
            </div>

            <h1>Postres María José</h1>
            <p>Sistema de gestión de ventas e inventario</p>

        </div>


        <form
            method="POST"
            action="{{ route('login.procesar') }}"
        >

            @csrf


            <div class="form-group">

                <label for="usuario">
                    Usuario
                </label>

                <input
                    type="text"
                    id="usuario"
                    name="usuario"
                    class="form-control"
                    value="{{ old('usuario') }}"
                    placeholder="Ingrese su usuario"
                    autocomplete="username"
                    required
                    autofocus
                >

                @error('usuario')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="password">
                    Contraseña
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Ingrese su contraseña"
                    autocomplete="current-password"
                    required
                >

                @error('password')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <label class="remember">

                <input
                    type="checkbox"
                    name="recordar"
                    value="1"
                >

                Recordar sesión

            </label>


            <button
                type="submit"
                class="btn-login"
            >
                Iniciar sesión
            </button>

        </form>


        <div class="footer">
            Postres María José · Sistema interno
        </div>

    </div>

</div>

</body>
</html>
