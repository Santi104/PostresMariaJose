<div>

    <style>
        .create-user-panel {
            max-width: 640px;

            background: #fff;

            border: 1px solid #EFEDEC;
            border-radius: 18px;

            padding: 36px;

            box-shadow: 0 12px 35px rgba(36, 28, 27, 0.06);
        }

        .create-user-panel .panel-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;

            color: #241C1B;

            margin-bottom: 6px;
        }

        .create-user-panel .panel-subtitle {
            font-size: 14.5px;
            font-weight: 500;

            color: #8A7E7C;

            margin-bottom: 28px;
        }

        .user-fields {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .double-row {
            display: flex;
            gap: 16px;
        }

        .double-row > div {
            flex: 1;
            min-width: 0;
        }

        .field-label {
            font-size: 12.5px;
            font-weight: 700;

            color: #6B6260;

            margin-bottom: 7px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;

            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            font-size: 20px;

            color: #B0A6A4;

            pointer-events: none;

            font-family: 'Material Symbols Rounded';
        }

        .user-input {
            width: 100%;

            height: 46px;

            padding: 0 14px 0 44px;

            border: 1px solid #E3DEDB;
            border-radius: 12px;

            background: #fff;

            font-family: inherit;
            font-size: 14.5px;
            font-weight: 500;

            color: #241C1B;

            outline: none;

            transition: 0.2s;
        }

        .user-input:focus {
            border-color: #C8102E;

            box-shadow: 0 0 0 3px rgba(200, 16, 46, 0.10);
        }

        .field-error {
            margin-top: 6px;

            font-size: 12.5px;
            font-weight: 600;

            color: #C8102E;
        }

        .active-toggle {
            display: flex;
            align-items: center;
            gap: 10px;

            font-size: 14px;
            font-weight: 600;

            color: #4A3F3D;
        }

        .active-toggle input {
            width: 19px;
            height: 19px;

            accent-color: #C8102E;

            cursor: pointer;
        }

        .save-user-btn {
            margin-top: 6px;

            border: none;
            border-radius: 12px;

            padding: 14px;

            background: #C8102E;

            color: #fff;

            font-family: inherit;
            font-size: 15px;
            font-weight: 700;

            cursor: pointer;

            transition: 0.2s;
        }

        .save-user-btn:hover {
            background: #96001F;
        }

        .success-alert {
            display: flex;
            align-items: center;
            gap: 10px;

            background: #EAF7EE;
            border: 1px solid rgba(34, 139, 74, .28);
            border-radius: 14px;

            padding: 13px 16px;

            margin-bottom: 22px;

            font-size: 14px;
            font-weight: 600;

            color: #1F6B3D;
        }

        .success-alert .icon {
            font-family: 'Material Symbols Rounded';
            font-size: 20px;
        }
    </style>

    <div class="create-user-panel">

        <div class="panel-title">
            Crear nuevo usuario
        </div>

        <div class="panel-subtitle">
            Registra al personal que tendrá acceso al sistema
        </div>

        @if ($exito)
            <div class="success-alert">
                <span class="icon">check_circle</span>
                Usuario creado correctamente.
            </div>
        @endif

        <form wire:submit="guardar">

            <div class="user-fields">

                <div>
                    <div class="field-label">Nombre completo</div>

                    <div class="input-wrapper">
                        <span class="input-icon">person</span>
                        <input type="text" wire:model="nombre" class="user-input"
                            placeholder="Ej. María Fernanda Ríos">
                    </div>

                    @error('nombre')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="double-row">

                    <div>
                        <div class="field-label">Usuario</div>

                        <div class="input-wrapper">
                            <span class="input-icon">badge</span>
                            <input type="text" wire:model="usuario" class="user-input" placeholder="Ej. mfrios">
                        </div>

                        @error('usuario')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <div class="field-label">Correo</div>

                        <div class="input-wrapper">
                            <span class="input-icon">mail</span>
                            <input type="email" wire:model="correo" class="user-input"
                                placeholder="correo@ejemplo.com">
                        </div>

                        @error('correo')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="double-row">

                    <div>
                        <div class="field-label">Contraseña</div>

                        <div class="input-wrapper">
                            <span class="input-icon">lock</span>
                            <input type="password" wire:model="password" class="user-input"
                                placeholder="Mínimo 6 caracteres">
                        </div>

                        @error('password')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <div class="field-label">Confirmar contraseña</div>

                        <div class="input-wrapper">
                            <span class="input-icon">lock</span>
                            <input type="password" wire:model="password_confirmation" class="user-input"
                                placeholder="Repite la contraseña">
                        </div>
                    </div>

                </div>

                <label class="active-toggle">
                    <input type="checkbox" wire:model="activo">
                    Usuario activo (puede iniciar sesión)
                </label>

                <button type="submit" class="save-user-btn">
                    Crear usuario
                </button>

            </div>

        </form>

    </div>

</div>