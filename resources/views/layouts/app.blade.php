<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Postres María José</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,400,0,0&family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @livewireStyles

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <div class="app-shell">

        <!-- =========================
         SIDEBAR
    ========================== -->
        <aside class="sidebar">

            <!-- LOGO -->
            <div class="sidebar-brand">

                <div class="brand-logo">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <div class="brand-name">
                    <strong>Postres</strong>
                    <strong>María José</strong>
                </div>

            </div>


            <!-- NAVEGACIÓN -->
            <nav class="sidebar-navigation">

                <div class="navigation-group">

                    <div class="navigation-title">
                        Operación
                    </div>

                    <a href="#" class="navigation-item active"
                        onclick="cambiarModulo('dashboard', this); return false;">
                        <span class="material-symbols-rounded">
                            cottage
                        </span>

                        <span>Inicio</span>
                    </a>

                    <a href="#" class="navigation-item" onclick="cambiarModulo('ventas', this); return false;">
                        <span class="material-symbols-rounded">
                            point_of_sale
                        </span>

                        <span>Ventas</span>
                    </a>

                    <a href="#" class="navigation-item"
                        onclick="cambiarModulo('inventario', this); return false;">
                        <span class="material-symbols-rounded">
                            inventory_2
                        </span>

                        <span>Inventario</span>
                    </a>
                    <a href="#" class="navigation-item"
                        onclick="cambiarModulo('produccion', this); return false;">
                        <span class="material-symbols-rounded">
                            bakery_dining
                        </span>

                        <span>Producción</span>
                    </a>

                    <a href="#" class="navigation-item" onclick="cambiarModulo('productos', this); return false;">
                        <span class="material-symbols-rounded">
                            storefront
                        </span>

                        <span>Productos</span>
                    </a>

                </div>


                <div class="navigation-group">

                    <div class="navigation-title">
                        Control
                    </div>

                    <a href="#" class="navigation-item">
                        <span class="material-symbols-rounded">
                            receipt_long
                        </span>

                        <span>Historial</span>
                    </a>

                    <a href="#" class="navigation-item">
                        <span class="material-symbols-rounded">
                            point_of_sale
                        </span>

                        <span>Caja</span>
                    </a>

                    <a href="#" class="navigation-item">
                        <span class="material-symbols-rounded">
                            bar_chart
                        </span>

                        <span>Reportes</span>
                    </a>

                    <a href="#" class="navigation-item">
                        <span class="material-symbols-rounded">
                            settings
                        </span>

                        <span>Ajustes</span>
                    </a>

                </div>

            </nav>

        </aside>


        <!-- =========================
         ÁREA PRINCIPAL
    ========================== -->
        <div class="main-area">

            <!-- HEADER -->
            <header class="top-header">

                <div class="header-left">

                    <div class="header-page">

                        <h2 id="header-title">
                            Resumen del día
                        </h2>

                        <span id="header-description">
                            Cómo va el negocio hoy, de un vistazo
                        </span>

                    </div>

                </div>


                <div class="header-right">

                    <div class="header-date">

                        <strong>
                            María Fernanda Ríos
                        </strong>

                        <span>
                            Jueves 3 de septiembre · 11:42 a.m.
                        </span>

                    </div>


                    <div class="header-avatar">
                        MF
                    </div>


                    <!-- CERRAR SESIÓN -->
                    <button type="button" class="logout-button" title="Cerrar sesión">
                        <span class="material-symbols-rounded">
                            logout
                        </span>
                    </button>

                </div>

            </header>


            <!-- CONTENIDO LIVEWIRE -->
            <main class="page-content">

                {{ $slot }}

            </main>

        </div>

    </div>

    @livewireScripts

    <script>
        const informacionModulos = {
            dashboard: {
                titulo: 'Resumen del día',
                descripcion: 'Cómo va el negocio hoy, de un vistazo'
            },

            ventas: {
                titulo: 'Punto de venta',
                descripcion: 'Registra la venta y cobra sin salir de esta pantalla.'
            },

            inventario: {
                titulo: 'Inventario',
                descripcion: 'Existencias al día y trazabilidad de cada movimiento.'
            },

            produccion: {
                titulo: 'Producción',
                descripcion: 'Lo de esta mañana, listo para vender.'
            },

            productos: {
                titulo: 'Productos',
                descripcion: 'El catálogo que ve el vendedor al cobrar'
            }
        };

        function actualizarHeader(modulo) {

            const informacion = informacionModulos[modulo];

            if (!informacion) {
                return;
            }

            document.getElementById('header-title').textContent = informacion.titulo;
            document.getElementById('header-description').textContent = informacion.descripcion;
        }

        function cambiarModulo(modulo, elemento) {

            document
                .querySelectorAll('.navigation-item')
                .forEach(item => {
                    item.classList.remove('active');
                });

            if (elemento) {
                elemento.classList.add('active');
            }

            actualizarHeader(modulo);

            Livewire.dispatch('cambiarModulo', {
                modulo: modulo
            });
        }
    </script>

</body>

</html>