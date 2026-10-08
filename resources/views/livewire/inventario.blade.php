<div class="inventario-page">

    <!-- INDICADORES -->
    <div class="inventario-stats">

        <div class="inventario-stat">

            <span class="material-symbols-rounded">
                inventory_2
            </span>

            <div>
                <strong>20</strong>
                <span>Total de productos</span>
            </div>

        </div>


        <div class="inventario-stat warning">

            <span class="material-symbols-rounded">
                warning
            </span>

            <div>
                <strong>4</strong>
                <span>En bajo stock</span>
            </div>

        </div>


        <div class="inventario-stat danger">

            <span class="material-symbols-rounded">
                remove_shopping_cart
            </span>

            <div>
                <strong>3</strong>
                <span>Agotados</span>
            </div>

        </div>

    </div>


    <!-- TABS -->
    <div class="inventario-tabs">

        <button
            class="{{ $vista === 'existencias' ? 'active' : '' }}"
            wire:click="$set('vista', 'existencias')"
        >
            <span class="material-symbols-rounded">
                inventory_2
            </span>

            Existencias
        </button>

        <button
            class="{{ $vista === 'movimientos' ? 'active' : '' }}"
            wire:click="$set('vista', 'movimientos')"
        >
            <span class="material-symbols-rounded">
                swap_vert
            </span>

            Movimientos
        </button>

    </div>


    @if($vista === 'existencias')

        <!-- FILTROS -->
        <div class="inventario-filters">

            <div class="inventario-search">

                <span class="material-symbols-rounded">
                    search
                </span>

                <input
                    type="text"
                    wire:model.live="busqueda"
                    placeholder="Buscar en el inventario..."
                >

            </div>


            <select wire:model.live="categoria">

                <option>Todas las categorías</option>
                <option>Postres</option>
                <option>Tortas</option>
                <option>Bebidas</option>

            </select>


            <select wire:model.live="estado">

                <option>Todos los estados</option>
                <option>Disponible</option>
                <option>Bajo stock</option>
                <option>Agotado</option>

            </select>

        </div>


        <!-- TABLA -->
        <div class="inventario-table-wrapper">

            <table class="inventario-table">

                <thead>

                    <tr>

                        <th>PRODUCTO</th>
                        <th>CATEGORÍA</th>
                        <th>PRECIO</th>
                        <th>STOCK</th>
                        <th>MÍNIMO</th>
                        <th>ESTADO</th>
                        <th>ACCIONES</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($this->productosFiltrados as $producto)

                        <tr>

                            <td>

                                <div class="inventory-product">

                                    <div class="inventory-product-image">
                                        foto
                                    </div>

                                    <div>

                                        <strong>
                                            {{ $producto['nombre'] }}
                                        </strong>

                                        <span>
                                            {{ $producto['sku'] }}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>
                                {{ $producto['categoria'] }}
                            </td>


                            <td>

                                <strong>
                                    ${{ number_format($producto['precio'], 0, ',', '.') }}
                                </strong>

                            </td>


                            <td>

                                <strong class="
                                    inventory-stock
                                    {{ $producto['estado'] === 'Bajo stock' ? 'low' : '' }}
                                    {{ $producto['estado'] === 'Agotado' ? 'empty' : '' }}
                                ">
                                    {{ $producto['stock'] }}
                                </strong>

                            </td>


                            <td>
                                {{ $producto['minimo'] }}
                            </td>


                            <td>

                                <span class="
                                    inventory-status
                                    {{ $producto['estado'] === 'Disponible' ? 'available' : '' }}
                                    {{ $producto['estado'] === 'Bajo stock' ? 'low' : '' }}
                                    {{ $producto['estado'] === 'Agotado' ? 'empty' : '' }}
                                ">

                                    <span></span>

                                    {{ $producto['estado'] }}

                                </span>

                            </td>


                            <td>

                                <div class="inventory-actions">

                                    <button>
                                        <span class="material-symbols-rounded">
                                            tune
                                        </span>
                                    </button>

                                    <button>
                                        <span class="material-symbols-rounded">
                                            swap_vert
                                        </span>
                                    </button>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <!-- MOVIMIENTOS -->
        <div class="movimientos-panel">

            <div class="movimientos-heading">

                <div>
                    <h2>Movimientos de inventario</h2>

                    <p>
                        Entradas y salidas registradas
                    </p>
                </div>

                <button class="new-product-button">
                    <span class="material-symbols-rounded">
                        add
                    </span>

                    Nuevo movimiento
                </button>

            </div>


            <div class="movimiento-row">

                <span class="material-symbols-rounded entrada">
                    arrow_downward
                </span>

                <div>
                    <strong>Producción registrada</strong>
                    <span>Merengón clásico · +120 unidades</span>
                </div>

                <small>
                    Hoy · 11:20 a.m.
                </small>

            </div>


            <div class="movimiento-row">

                <span class="material-symbols-rounded salida">
                    arrow_upward
                </span>

                <div>
                    <strong>Venta #000142</strong>
                    <span>9 unidades descontadas</span>
                </div>

                <small>
                    Hoy · 11:42 a.m.
                </small>

            </div>

        </div>

    @endif

</div>