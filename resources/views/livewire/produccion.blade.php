<div class="produccion-page">

    <!-- ENCABEZADO -->

    <div class="produccion-heading">

        <div class="production-date">

            <span class="material-symbols-rounded">
                event
            </span>

            <div>

                <small>
                    Fecha de producción
                </small>

                <strong>
                    Hoy · jueves 3 de septiembre
                </strong>

            </div>

            <button>
                ‹
            </button>

            <button>
                ›
            </button>

        </div>

    </div>


    <!-- CONTENIDO -->
    <div class="produccion-layout">


        <!-- PRODUCCIÓN -->
        <section class="produccion-card">

            <div class="produccion-card-heading">

                <h2>
                    Producción del día
                </h2>

                <span>
                    {{ count($producciones) }} productos
                </span>

            </div>


            @foreach($producciones as $index => $produccion)

                <div class="production-item">

                    <div class="production-image">
                        foto
                    </div>


                    <div class="production-product">

                        <select>

                            <option>
                                {{ $produccion['producto'] }}
                            </option>

                        </select>

                        <span>
                            En inventario:
                            {{ $produccion['stock'] }}
                            ·
                            ${{ number_format($produccion['precio'], 0, ',', '.') }} c/u
                        </span>

                    </div>


                    <div class="production-quantity">

                        <button
                            wire:click="disminuir({{ $index }})"
                        >
                            −
                        </button>

                        <strong>
                            {{ $produccion['cantidad'] }}
                        </strong>

                        <button
                            wire:click="aumentar({{ $index }})"
                        >
                            +
                        </button>

                    </div>


                    <button
                        class="production-delete"
                        wire:click="eliminar({{ $index }})"
                    >

                        <span class="material-symbols-rounded">
                            delete
                        </span>

                    </button>

                </div>

            @endforeach


            <div class="production-buttons">

                <button
                    class="production-add"
                    wire:click="agregarProducto"
                >

                    <span class="material-symbols-rounded">
                        add
                    </span>

                    Agregar producto

                </button>


                <button
                    class="production-clear"
                    wire:click="limpiar"
                >

                    <span class="material-symbols-rounded">
                        delete_sweep
                    </span>

                    Limpiar todo

                </button>

            </div>

        </section>


        <!-- IMPACTO -->
        <aside class="production-impact">

            <h2>
                Impacto en inventario
            </h2>

            <p>
                Así queda el stock si guardas ahora
            </p>


            <div class="production-total">

                <strong>
                    {{ $this->totalUnidades }} unidades
                </strong>

                <span>
                    {{ count($producciones) }}
                    productos entrarán al inventario
                </span>

            </div>


            @foreach($producciones as $produccion)

                <div class="production-impact-row">

                    <div>

                        <strong>
                            {{ $produccion['producto'] }}
                        </strong>

                        <span>
                            +{{ $produccion['cantidad'] }} unidades
                        </span>

                    </div>

                    <strong>
                        {{ $produccion['stock'] }}
                        →
                        {{ $produccion['stock'] + $produccion['cantidad'] }}
                    </strong>

                </div>

            @endforeach


            <div class="production-note">

                <span class="material-symbols-rounded">
                    info
                </span>

                <span>
                    Al guardar se generan entradas de inventario con fecha de producción.
                </span>

            </div>


            <button class="production-save">

                <span class="material-symbols-rounded">
                    save
                </span>

                Guardar producción

            </button>

        </aside>

    </div>

</div>