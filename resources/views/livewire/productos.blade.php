<div class="productos-page">

    <!-- FILTROS -->
    <div class="productos-toolbar">

        <!-- BUSCADOR -->
        <div class="productos-search">

            <span class="material-symbols-rounded">
                search
            </span>

            <input type="text" placeholder="Buscar producto..." wire:model.live="busqueda">

        </div>


        <!-- CATEGORÍA -->

        <div class="productos-category">

            <select wire:model.live="categoria">
                <option value="">Todas las categorías</option>

                @foreach($this->categorias as $categoriaItem)
                    <option value="{{ $categoriaItem->id }}">
                        {{ $categoriaItem->nombre }}
                    </option>
                @endforeach
            </select>

            <span class="material-symbols-rounded">
                expand_more
            </span>

        </div>



        <!-- NUEVO PRODUCTO -->

        <button class="btn-dashboard primary" type="button" wire:click="abrirFormulario">

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

                            <strong class="product-stock
                                                                                        @if($producto['estado'] === 'Bajo stock')
                                                                                            stock-low
                                                                                        @elseif($producto['estado'] === 'Agotado')
                                                                                            stock-empty
                                                                                        @endif">
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

                            <span class="product-status
                                    @if($producto['estado'] === 'Disponible')
                                        status-available
                                    @elseif($producto['estado'] === 'Bajo stock')
                                        status-low
                                    @elseif($producto['estado'] === 'Agotado')
                                        status-empty
                                    @endif">

                                <span></span>

                                {{ $producto['estado'] }}

                            </span>

                        </td>

                        <!-- ACCIONES -->
                        <td>
                            <div class="product-actions">

                                <button type="button" title="Editar" wire:click="editarProducto({{ $producto['id'] }})">
                                    <span class="material-symbols-rounded">edit</span>
                                </button>

                                <button type="button" title="{{ $producto['activo'] ? 'Desactivar' : 'Activar' }}"
                                    wire:click="cambiarEstado({{ $producto['id'] }})"
                                    wire:confirm="¿Quieres {{ $producto['activo'] ? 'desactivar' : 'activar' }} este producto?">
                                    <span class="material-symbols-rounded">
                                        {{ $producto['activo'] ? 'visibility_off' : 'visibility' }}
                                    </span>
                                </button>

                                <button type="button" title="Eliminar" wire:click="eliminarProducto({{ $producto['id'] }})"
                                    wire:confirm="¿Estás seguro de eliminar este producto? Esta acción no se puede deshacer.">
                                    <span class="material-symbols-rounded">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($mostrarFormulario)
        <div class="modal-producto">
            <div class="modal-contenido">
                <h2>{{ $modoEdicion ? 'Editar producto' : 'Crear producto' }}</h2>

                <form wire:submit="guardarProducto">
                    <label>Nombre</label>
                    <input type="text" wire:model="nombre">
                    @error('nombre')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <label>Código (SKU)</label>
                    <input type="text" wire:model="codigo">
                    @error('codigo')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <label>Categoría</label>
                    <select wire:model="categoria_id">
                        <option value="">Selecciona una categoría</option>

                        @foreach ($this->categorias as $categoriaItem)
                            <option value="{{ $categoriaItem->id }}">
                                {{ $categoriaItem->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <label>Descripción</label>
                    <textarea wire:model="descripcion"></textarea>
                    @error('descripcion')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <label>Precio de venta</label>
                    <input type="number" step="0.01" min="0" wire:model="precio_venta">
                    @error('precio_venta')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <label>Costo unitario</label>
                    <input type="number" step="0.01" min="0" wire:model="costo_unitario">
                    @error('costo_unitario')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <label>Stock mínimo</label>
                    <input type="number" min="0" step="1" wire:model="stock_minimo">
                    @error('stock_minimo')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <div class="acciones-formulario">
                        <button type="button" class="boton-cancelar" wire:click="cerrarFormulario">
                            Cancelar
                        </button>

                        <button type="submit" class="boton-guardar" wire:loading.attr="disabled">
                            {{ $modoEdicion ? 'Guardar cambios' : 'Guardar producto' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if (session()->has('mensaje'))
        <p class="mensaje-exito">{{ session('mensaje') }}</p>
    @endif

</div>