<div class="ventas-page">

    <div class="ventas-content">

        <!-- BUSCADOR -->
        <div class="ventas-search">

            <span class="material-symbols-rounded">
                search
            </span>

            <input
                type="text"
                wire:model.live="busqueda"
                placeholder="Buscar producto por nombre..."
            >

        </div>


        <!-- CATEGORÍAS -->
        <div class="ventas-categories">

            @foreach(['Todos', 'Postres', 'Tortas', 'Bebidas', 'Helados', 'Otros'] as $cat)

                <button
                    type="button"
                    wire:click="$set('categoria', '{{ $cat }}')"
                    class="{{ $categoria === $cat ? 'selected' : '' }}"
                >
                    {{ $cat }}
                </button>

            @endforeach

        </div>


        <div class="ventas-catalog-title">

            <strong>
                TODO EL CATÁLOGO
            </strong>

            <span>
                {{ count($this->productosFiltrados) }} productos
            </span>

        </div>


        <!-- PRODUCTOS -->
        <div class="ventas-product-grid">

            @foreach($this->productosFiltrados as $producto)

                <div class="venta-product-card">

                    <div class="venta-product-image">
                        {{ $producto['imagen'] }}
                    </div>

                    <strong>
                        {{ $producto['nombre'] }}
                    </strong>

                    <div class="venta-product-bottom">

                        <span class="venta-product-price">
                            ${{ number_format($producto['precio'], 0, ',', '.') }}
                        </span>

                        <span class="
                            venta-product-status
                            {{ $producto['estado'] === 'Bajo stock' ? 'bajo' : 'disponible' }}
                        ">

                            <span></span>

                            {{ $producto['estado'] }}

                        </span>

                    </div>

                    <button
                        type="button"
                        class="venta-add-product"
                        wire:click="agregarAlCarrito('{{ $producto['nombre'] }}')"
                    >
                        Agregar
                    </button>

                </div>

            @endforeach

        </div>

    </div>


    <!-- CARRITO -->
    <aside class="venta-cart">

        <div class="venta-cart-header">

            <div>

                <h2>Venta actual</h2>

                <p>
                    {{ count($carrito) }} productos · {{ $this->unidades }} unidades
                </p>

            </div>

            <button
                type="button"
                wire:click="vaciar"
            >
                <span class="material-symbols-rounded">
                    delete_sweep
                </span>

                Vaciar
            </button>

        </div>


        <div class="venta-cart-items">

            @forelse($carrito as $index => $item)

                <div class="venta-cart-item">

                    <div class="venta-cart-item-top">

                        <div>

                            <strong>
                                {{ $item['nombre'] }}
                            </strong>

                            <span>
                                ${{ number_format($item['precio'], 0, ',', '.') }} c/u
                            </span>

                        </div>

                        <button
                            type="button"
                            wire:click="quitar({{ $index }})"
                        >
                            ×
                        </button>

                    </div>


                    <div class="venta-cart-item-bottom">

                        <div class="venta-quantity">

                            <button
                                type="button"
                                wire:click="disminuir({{ $index }})"
                            >
                                −
                            </button>

                            <strong>
                                {{ $item['cantidad'] }}
                            </strong>

                            <button
                                type="button"
                                wire:click="aumentar({{ $index }})"
                            >
                                +
                            </button>

                        </div>


                        <strong class="venta-subtotal">

                            ${{ number_format(
                                $item['precio'] * $item['cantidad'],
                                0,
                                ',',
                                '.'
                            ) }}

                        </strong>

                    </div>

                </div>

            @empty

                <div class="venta-cart-empty">

                    <span class="material-symbols-rounded">
                        shopping_cart
                    </span>

                    <p>
                        No hay productos en la venta
                    </p>

                </div>

            @endforelse

        </div>


        <!-- TOTAL -->
        <div class="venta-cart-total">

            <div>

                <span>
                    Subtotal
                </span>

                <strong>
                    ${{ number_format($this->total, 0, ',', '.') }}
                </strong>

            </div>

            <div>

                <span>
                    Productos
                </span>

                <strong>
                    {{ $this->unidades }}
                </strong>

            </div>

            <hr>

            <div class="venta-total-final">

                <span>
                    TOTAL
                </span>

                <strong>
                    ${{ number_format($this->total, 0, ',', '.') }}
                </strong>

            </div>


            <button class="venta-cobrar">

                <span class="material-symbols-rounded">
                    payments
                </span>

                COBRAR

            </button>

        </div>

    </aside>

</div>