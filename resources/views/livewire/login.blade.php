<div>


    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;

            font-family: 'Outfit', system-ui, sans-serif;

            background: #F6F5F4;
            color: #241C1B;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 24px;
        }

        .icon {
            font-family: 'Material Symbols Rounded';

            font-weight: 400;
            font-style: normal;
            line-height: 1;

            -webkit-font-feature-settings: 'liga';

            user-select: none;
        }

        .container {
            width: 100%;
            max-width: 420px;
        }

        .layaout {
            width: 100%;

            background: white;

            border: 1px solid #EFEDEC;
            border-radius: 18px;

            overflow: hidden;

            box-shadow:
                0 12px 35px rgba(36, 28, 27, 0.08);
        }

        .side {
            display: none;
        }

        .side::before {
            content: "";

            position: absolute;
            inset: 0;

            pointer-events: none;

            background-image:
                radial-gradient(34% 26% at 18% 12%,
                    rgba(255, 255, 255, .075) 0 60%,
                    transparent 61%),
                radial-gradient(26% 20% at 82% 26%,
                    rgba(255, 255, 255, .06) 0 60%,
                    transparent 61%),
                radial-gradient(30% 22% at 32% 62%,
                    rgba(255, 255, 255, .055) 0 60%,
                    transparent 61%),
                radial-gradient(22% 17% at 88% 78%,
                    rgba(255, 255, 255, .06) 0 60%,
                    transparent 61%),
                radial-gradient(18% 14% at 8% 88%,
                    rgba(255, 255, 255, .05) 0 60%,
                    transparent 61%);
        }

        .content-side {
            position: relative;

            display: flex;
            flex-direction: column;

            gap: 30px;
        }

        .icon-grande {
            width: 132px;
            height: 132px;

            border-radius: 42px;

            background: #fff;

            overflow: hidden;

            box-shadow:
                0 16px 40px rgba(0, 0, 0, .18);
        }

        .icon-grande img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;
        }

        .title-side {
            line-height: 1.02;
        }

        .title-side .text1 {
            font-size: 52px;
            font-weight: 800;

            letter-spacing: -2.2px;

            color: #fff;
        }

        .title-side .text2 {
            font-size: 52px;
            font-weight: 800;

            letter-spacing: -2.2px;

            color: #FBD3D9;
        }

        .text-side {
            font-size: 17.5px;
            font-weight: 500;

            color: rgba(255, 255, 255, .82);

            line-height: 1.45;

            max-width: 300px;
        }

        .footer-side {
            position: relative;

            margin-top: auto;

            padding-top: 40px;

            font-size: 13px;
            font-weight: 600;

            color: rgba(255, 255, 255, .6);
        }

        .form {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 35px;
        }

        .content-form {
            width: 100%;
            max-width: 392px;

            display: flex;
            flex-direction: column;

            gap: 24px;
        }

        .icon {
            text-align: center;

            margin-bottom: 0;
        }

        .icon-icon img {
            width: 70px;
            height: 60px;

            margin: 0 auto 15px;

            border-radius: 16px;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;
        }

        .icon h1 {
            font-size: 24px;
            font-weight: 600;

            margin-bottom: 6px;
        }

        .icon p {
            color: #8A7E7C;

            font-size: 14px;
        }

        .title-desktop {
            display: none;
        }

        .grupo {
            margin-bottom: 18px;
        }

        .grupo label {
            display: block;

            margin-bottom: 7px;

            font-size: 14px;
            font-weight: 600;
        }

        .campos {
            display: flex;

            flex-direction: column;

            gap: 16px;
        }

        .text-label {
            font-size: 12.5px;
            font-weight: 700;

            color: #6B6260;

            margin-bottom: 7px;
        }

        .caja-input {
            position: relative;
        }

        .icon-input {
            position: absolute;

            left: 17px;
            top: 50%;

            transform: translateY(-50%);

            font-size: 22px;

            color: #B0A6A4;

            pointer-events: none;
        }

        .input {
            width: 100%;

            height: 48px;

            padding: 13px 14px;

            border: 1px solid #E3DEDB;

            border-radius: 9px;

            background: #fff;

            font-family: inherit;

            font-size: 15px;

            font-weight: 500;

            color: #241C1B;

            outline: none;

            transition: 0.2s;
        }

        .caja-input .input {
            padding-left: 50px;
        }

        .input.showPass {
            padding-right: 50px;
        }

        .input:focus {
            border-color: #C8102E;

            box-shadow:
                0 0 0 3px rgba(200, 16, 46, 0.10);
        }

        .btton-pass {
            position: absolute;

            right: 8px;
            top: 50%;

            transform: translateY(-50%);

            width: 42px;
            height: 42px;

            border-radius: 13px;

            border: none;

            background: transparent;

            color: #8A7E7C;

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;
        }

        .btton-pass:hover {
            background: #F6F5F4;

            color: #241C1B;
        }

        .btton-pass .icon {
            font-size: 23px;

            pointer-events: none;
        }

        /* ERRORES */

        .error {
            margin-top: 6px;

            font-size: 13px;

            color: #C8102E;
        }

        .text-error {
            margin-top: 6px;

            font-size: 12.5px;
            font-weight: 600;

            color: #C8102E;
        }

        .alert-error {
            display: flex;

            align-items: flex-start;

            gap: 11px;

            background: #FDECEF;

            border: 1px solid rgba(200, 16, 46, .28);

            border-radius: 18px;

            padding: 14px 16px;
        }

        .alert-error .icon {
            font-size: 22px;

            color: #C8102E;

            flex: none;
        }

        .alert-error .title-error {
            font-size: 15px;
            font-weight: 800;

            color: #96001F;
        }

        .alert-error .descripcion-error {
            font-size: 13.5px;
            font-weight: 500;

            color: #7A4048;

            margin-top: 3px;
        }


        .recordar {
            display: flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 20px;

            font-size: 14px;

            color: #6B6260;

            cursor: pointer;
        }

        .recordar input {
            width: 18px;
            height: 18px;

            accent-color: #C8102E;

            cursor: pointer;
        }

        .fila {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 14px;

            flex-wrap: wrap;
        }

        .btton {
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

        .btton:hover {
            background: #96001F;
        }

        .btton:active {
            transform: translateY(1px);
        }

        .footer {
            text-align: center;

            margin-top: 22px;

            font-size: 12px;

            color: #8A7E7C;
        }

        .text-footer {
            padding-top: 6px;

            border-top: 1px dashed rgba(36, 28, 27, .14);

            font-size: 13.5px;
            font-weight: 500;

            color: #8A7E7C;

            line-height: 1.5;
        }

        .text-footer a {
            color: #C8102E;

            font-weight: 700;

            text-decoration: none;
        }

        body {
            background: #EDEBEA;
            padding: 24px;
        }

        .container {
            max-width: 1180px;
        }

        .layaout {
            min-height: 620px;
            border-radius: 28px;
            display: flex;
            border: none;
            box-shadow:
                0 18px 44px rgba(36, 28, 27, .14);
        }

        .side {
            width: 470px;
            flex: none;
            background: #C8102E;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 56px 52px;
        }

        .form {
            flex: 1;
            min-width: 0;
            padding: 48px;
        }

        .content-form {
            max-width: 392px;
        }

        .icon-movil {
            display: none;
        }

        .title-desktop {
            display: block;
        }

        .title-form {
            font-size: 31px;
            font-weight: 800;
            letter-spacing: -1.1px;
        }

        .subtitulo-form {
            font-size: 15.5px;
            font-weight: 500;
            color: #8A7E7C;
            margin-top: 7px;
        }

        .input {
            height: 56px;
            border-radius: 17px;
            padding: 0 16px 0 50px;
            font-size: 16px;
        }

        .recordar {
            font-size: 14.5px;
            font-weight: 600;
            color: #4A3F3D;
            margin-bottom: 0;
        }

        .recordar input {
            width: 21px;
            height: 21px;
        }

        .btton {
            height: 60px;
            border-radius: 19px;
            font-size: 16.5px;
            font-weight: 800;
            letter-spacing: .09em;
            text-transform: uppercase;
            box-shadow:
                0 12px 28px rgba(200, 16, 46, .28);
        }

        .footer {
            display: none;
        }

        .text-footer {
            display: block;
        }

        @media (max-width: 980px) {

            html,
            body {
                width: 100%;
                min-height: 100%;
            }

            body {
                min-height: 100vh;
                padding: 0;
                background: #fff;
                align-items: flex-start;
                justify-content: center;
            }

            .container {
                width: 100%;
                max-width: 420px;
                min-height: 100vh;
                margin: 0 auto;
            }

            .layaout {
                width: 100%;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                border: none;
                border-radius: 0;
                background: #fff;
                box-shadow: none;
                overflow: hidden;
            }

            .side {
                width: 100%;
                height: 230px;
                min-height: 230px;
                flex: none;

                display: flex;
                align-items: center;
                justify-content: flex-start;

                padding: 34px 22px 27px;

                background: #D1082D;
                border-radius: 0 0 0 0;
            }

            .side::before {
                background-image:
                    radial-gradient(34% 26% at 13% 18%,
                        rgba(255, 255, 255, .075) 0 60%,
                        transparent 61%),
                    radial-gradient(26% 20% at 84% 31%,
                        rgba(255, 255, 255, .06) 0 60%,
                        transparent 61%),
                    radial-gradient(30% 22% at 42% 84%,
                        rgba(255, 255, 255, .055) 0 60%,
                        transparent 61%);
            }

            .content-side {
                width: 100%;
                height: 100%;
                gap: 15px;

                align-items: center;
                justify-content: flex-start;
                text-align: center;
            }

            .icon-grande {
                width: 88px;
                height: 88px;
                flex: none;
                border-radius: 27px;
                box-shadow: none;
            }

            .title-side {
                line-height: .98;
                text-align: center;
            }

            .title-side .text1,
            .title-side .text2 {
                font-size: 27px;
                line-height: .98;
                letter-spacing: -1px;
            }

            .text-side,
            .footer-side {
                display: none;
            }

            .form {
                width: 100%;
                flex: 1;
                min-width: 0;
                padding: 28px 22px 30px;
                align-items: flex-start;
                justify-content: flex-start;
            }

            .content-form {
                width: 100%;
                max-width: none;
                gap: 0;
            }

            .title-desktop {
                display: block;
                margin-bottom: 20px;
            }

            .title-form {
                font-size: 24px;
                line-height: 1.15;
                font-weight: 800;
                letter-spacing: -0.7px;
                color: #241C1B;
            }

            .subtitulo-form {
                margin-top: 6px;
                font-size: 15px;
                line-height: 1.35;
                font-weight: 500;
                color: #8A7E7C;
            }

            .icon-movil {
                display: none !important;
            }

            .alert-error {
                margin-bottom: 18px;
            }

            form {
                width: 100%;
            }

            .campos {
                width: 100%;
                gap: 20px;
            }

            .text-label {
                margin-bottom: 7px;
                font-size: 12.5px;
                font-weight: 700;
                color: #6B6260;
            }

            .caja-input {
                width: 100%;
            }

            .input {
                width: 100%;
                height: 56px;
                padding: 0 14px 0 50px;
                border: 1px solid #E1DDDB;
                border-radius: 17px;
                font-size: 15px;
                font-weight: 500;
                background: #fff;
            }

            .caja-input .input {
                padding-left: 50px;
            }

            .input.showPass {
                padding-right: 50px;
            }

            .icon-input {
                left: 17px;
                font-size: 21px;
                color: #A9A09E;
            }

            .btton-pass {
                right: 7px;
                width: 42px;
                height: 42px;
            }

            .recordar {
                gap: 10px;
                margin-top: 9px;
                margin-bottom: 4px;
                font-size: 14px;
                font-weight: 600;
                color: #4A3F3D;
            }

            .recordar input {
                width: 24px;
                height: 24px;
                border-radius: 7px;
            }

            .btton {
                width: 100%;
                height: 60px;
                margin-top: 4px;
                border-radius: 18px;
                padding: 0 14px;
                background: #D1082D;
                font-size: 16px;
                font-weight: 800;
                letter-spacing: .07em;
                text-transform: uppercase;
                box-shadow: 0 12px 28px rgba(200, 16, 46, .25);
            }

            .btton:hover {
                background: #D1082D;
            }

            .text-footer {
                display: block;
                padding-top: 0;
                border-top: none;
                margin-top: 25px;
                text-align: center;
                font-size: 15px;
                line-height: 1.4;
                font-weight: 700;
                color: #D1082D;
            }

            .text-footer {
                font-size: 0;
            }

            .text-footer a {
                font-size: 15px;
                color: #D1082D;
                font-weight: 700;
            }

            .text-footer a::before {
                content: "¿Olvidaste tu contraseña?";
            }

            .text-footer a {
                color: transparent;
            }

            .footer {
                display: none;
            }
        }

        @media (max-width: 360px) {

            .side {
                height: 215px;
                min-height: 215px;
                padding-top: 28px;
            }

            .icon-grande {
                width: 80px;
                height: 80px;
                border-radius: 24px;
            }

            .title-side .text1,
            .title-side .text2 {
                font-size: 25px;
            }

            .form {
                padding-left: 18px;
                padding-right: 18px;
            }

            .title-form {
                font-size: 22px;
            }
        }
    </style>


    <div class="container">

        <div class="layaout">

            <div class="side">

                <div class="content-side">

                    <div class="icon-grande">

                        <img src="{{ asset('img/icon.png') }}" alt="icon">

                    </div>

                    <div class="title-side">

                        <div class="text1">
                            Postres
                        </div>

                        <div class="text2">
                            María José
                        </div>

                    </div>

                    <div class="text-side">

                        Sistema de ventas e inventario.
                        Ingresa con tu usuario para abrir tu turno.

                    </div>

                </div>

                <div class="footer-side">
                    Sistema interno
                </div>

            </div>

            <div class="form">

                <div class="content-form">

                    <div class="icon icon-movil">

                        <div class="icon-icon">

                            <img src="{{ asset('img/icon.png') }}" alt="icon">

                        </div>

                        <h1>
                            Postres María José
                        </h1>

                        <p>
                            Sistema de gestión de ventas e inventario
                        </p>

                    </div>

                    <div class="title-desktop">

                        <div class="title-form">
                            Bienvenida de nuevo
                        </div>

                        <div class="subtitulo-form">
                            Entra a tu cuenta para registrar ventas
                        </div>

                    </div>

                    @if ($errors->any() && !$errors->has('usuario') && !$errors->has('password'))

                        <div class="alert-error">

                            <span class="icon">
                                error
                            </span>

                            <div>

                                <div class="title-error">
                                    No se pudo iniciar sesión
                                </div>

                                <div class="descripcion-error">
                                    {{ $errors->first() }}
                                </div>

                            </div>

                        </div>

                    @endif

                    @if ($errors->has('usuario'))

                        <div class="alert-error">

                            <span class="icon">
                                error
                            </span>

                            <div>

                                <div class="title-error">
                                    Usuario o contraseña incorrectos
                                </div>

                                <div class="descripcion-error">
                                    Revisa los datos e intenta otra vez.
                                </div>

                            </div>

                        </div>

                    @endif

                    <form wire:submit="login">

                        <div class="campos">

                            <div>

                                <div class="text-label">
                                    Usuario
                                </div>

                                <div class="caja-input">

                                    <span class="icon icon-input">
                                        person
                                    </span>

                                    <input type="text" id="usuario" wire:model="usuario" class="input"
                                        placeholder="Ingrese su usuario" autocomplete="username" autofocus>

                                </div>

                                @error('usuario')
                                    <div class="error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div>

                                <div class="text-label">
                                    Contraseña
                                </div>

                                <div class="caja-input">

                                    <span class="icon icon-input">
                                        lock
                                    </span>

                                    <input type="password" id="password" wire:model="password" class="input showPass"
                                        placeholder="Ingrese su contraseña" autocomplete="current-password">

                                    <button type="button" class="btton-pass" onclick="togglePassword()"
                                        aria-label="Mostrar u ocultar contraseña">

                                        <span class="icon" id="toggleIcon">
                                            visibility
                                        </span>

                                    </button>

                                </div>

                                @error('password')
                                    <div class="error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="fila">

                                <label class="recordar">

                                    <input type="checkbox" wire:model="recordar">

                                    Recordar sesión

                                </label>

                            </div>

                            <button type="submit" class="btton">
                                Ingresar
                            </button>

                        </div>

                    </form>

                    <div class="footer">

                        Postres María José · Sistema interno

                    </div>

                    <div class="text-footer">

                        ¿Problemas para entrar?
                        Escribe a
                        <a href="#">
                            soporte del negocio.
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>

        function togglePassword() {

            const input = document.getElementById('password');

            const icon = document.getElementById('toggleIcon');

            if (input.type === 'password') {

                input.type = 'text';

                icon.textContent = 'visibility_off';

            } else {

                input.type = 'password';

                icon.textContent = 'visibility';

            }

        }

    </script>
</div>