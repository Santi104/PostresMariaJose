<div class="productos-page">

    <!-- FILTROS -->
    <div class="productos-toolbar">

        <!-- BUSCADOR -->
        <div class="productos-search">

            <span class="material-symbols-rounded">
                search
            </span>

            <input
                type="text"
                placeholder="Buscar producto..."
                wire:model.live="busqueda"
            >

        </div>


        <!-- CATEGORÍA -->
        <div class="productos-category">

            <select wire:model.live="categoria">

                <option>
                    Todas las categorías
                </option>

                <option value="Postres">
                    Postres
                </option>

                <option value="Tortas">
                    Tortas
                </option>

                <option value="Bebidas">
                    Bebidas
                </option>

            </select>

            <span class="material-symbols-rounded">
                expand_more
            </span>

        </div>


        <!-- NUEVO PRODUCTO -->
        <button class="new-product-button">

            <span class="material-symbols-rounded">
                add
            </span>

            Nuevo producto

        </button>

    </div>


    <!-- TABLA -->
    <div class="productos-table-wrapper">

        <table class="productos-table">

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

                        <!-- PRODUCTO -->
                        <td>

                            <div class="product-information">

                                <div class="product-image">
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


                        <!-- CATEGORÍA -->
                        <td>
                            <span class="product-category">
                                {{ $producto['categoria'] }}
                            </span>
                        </td>


                        <!-- PRECIO -->
                        <td>

                            <strong class="product-price">
                                ${{ number_format($producto['precio'], 0, ',', '.') }}
                            </strong>

                        </td>


                        <!-- STOCK -->
                        <td>

                            <strong
                                class="product-stock
                                @if($producto['estado'] === 'Bajo stock')
                                    stock-low
                                @elseif($producto['estado'] === 'Agotado')
                                    stock-empty
                                @endif"
                            >
                                {{ $producto['stock'] }}
                            </strong>

                        </td>


                        <!-- MÍNIMO -->
                        <td>

                            <span class="product-minimum">
                                {{ $producto['minimo'] }}
                            </span>

                        </td>


                        <!-- ESTADO -->
                        <td>

                            <span
                                class="product-status
                                @if($producto['estado'] === 'Disponible')
                                    status-available
                                @elseif($producto['estado'] === 'Bajo stock')
                                    status-low
                                @elseif($producto['estado'] === 'Agotado')
                                    status-empty
                                @endif"
                            >

                                <span></span>

                                {{ $producto['estado'] }}

                            </span>

                        </td>


                        <!-- ACCIONES -->
                        <td>

                            <div class="product-actions">

                                <button title="Editar">

                                    <span class="material-symbols-rounded">
                                        edit
                                    </span>

                                </button>

                                <button title="Activar o desactivar">

                                    <span class="material-symbols-rounded">
                                        visibility_off
                                    </span>

                                </button>

                                <button title="Eliminar">

                                    <span class="material-symbols-rounded">
                                        delete
                                    </span>

                                </button>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>