<div class="productos-page">
    {{-- Filtros y nuevo producto --}}
    <div class="productos-toolbar">
        <div class="productos-search">
            <span class="material-symbols-rounded" aria-hidden="true">search</span>
            <input type="search" wire:model.live.debounce.300ms="busqueda" placeholder="Buscar producto…"
                aria-label="Buscar producto">
        </div>

        <div class="productos-category">
            <select wire:model.live="categoria" aria-label="Filtrar categoría">
                <option value="">Todas las categorías</option>
                @foreach ($this->categorias as $categoriaItem)
                    <option value="{{ $categoriaItem->id }}">{{ $categoriaItem->nombre }}</option>
                @endforeach
            </select>
            <span class="material-symbols-rounded" aria-hidden="true">expand_more</span>
        </div>

        <button type="button" class="productos-btn-primary" wire:click="abrirFormulario">
            <span class="material-symbols-rounded" aria-hidden="true">add</span>
            Nuevo producto
        </button>
    </div>

    {{-- Tabla del prototipo --}}
    <div class="productos-table-wrapper">
        <table class="productos-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th class="productos-text-right">Precio</th>
                    <th class="productos-text-right">Stock</th>
                    <th class="productos-text-right">Mínimo</th>
                    <th>Estado</th>
                    <th class="productos-text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->productosFiltrados as $producto)
                    <tr wire:key="producto-{{ $producto['id'] }}"
                        class="{{ !$producto['activo'] ? 'producto-desactivado' : '' }}">
                        <td>
                            <div class="product-information">

                                <div class="product-image">
                                    @if (!empty($producto['imagen']))
                                        <img src="{{ url('storage/' . ltrim($producto['imagen'], '/')) }}"
                                            alt="" loading="lazy" onerror="this.style.display='none'">
                                    @else
                                        <span class="material-symbols-rounded">image</span>
                                    @endif
                                </div>

                                <div class="product-info-text">
                                    <strong>{{ $producto['nombre'] }}</strong>
                                </div>
                            </div>
                        </td>
                        <td><span class="product-category">{{ $producto['categoria'] }}</span></td>
                        <td class="productos-text-right">
                            <strong
                                class="product-price">${{ number_format($producto['precio'], 0, ',', '.') }}</strong>
                        </td>
                        <td class="productos-text-right">
                            <strong
                                class="product-stock {{ $producto['estado'] === 'Bajo stock' ? 'stock-low' : ($producto['estado'] === 'Agotado' ? 'stock-empty' : '') }}">
                                {{ $producto['stock'] }}
                            </strong>
                        </td>
                        <td class="productos-text-right">
                            <span class="product-minimum">{{ $producto['minimo'] }}</span>
                        </td>
                        <td>
                            <span
                                class="product-status {{ match ($producto['estado']) {'Disponible' => 'status-available','Bajo stock' => 'status-low','Agotado' => 'status-empty',default => 'status-inactive'} }}">
                                <span class="product-status-dot"></span>
                                {{ $producto['estado'] }}
                            </span>
                        </td>
                        <td>
                            <div class="product-actions">
                                <button type="button" class="product-action-edit" title="Editar"
                                    aria-label="Editar {{ $producto['nombre'] }}"
                                    wire:click="editarProducto({{ $producto['id'] }})">
                                    <span class="material-symbols-rounded" aria-hidden="true">edit</span>
                                </button>
                                <button type="button" title="{{ $producto['activo'] ? 'Desactivar' : 'Activar' }}"
                                    aria-label="{{ $producto['activo'] ? 'Desactivar' : 'Activar' }} {{ $producto['nombre'] }}"
                                    wire:click="cambiarEstado({{ $producto['id'] }})">
                                    <span class="material-symbols-rounded"
                                        aria-hidden="true">{{ $producto['activo'] ? 'visibility_off' : 'visibility' }}</span>
                                </button>
                                <button type="button" class="product-action-delete" title="Eliminar"
                                    aria-label="Eliminar {{ $producto['nombre'] }}"
                                    wire:click="confirmarEliminacion({{ $producto['id'] }})">
                                    <span class="material-symbols-rounded" aria-hidden="true">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="productos-empty">
                            <span class="material-symbols-rounded" aria-hidden="true">inventory_2</span>
                            No se encontraron productos con estos filtros.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        {{ $this->productosFiltrados->count() }}
                        {{ $this->productosFiltrados->count() === 1 ? 'producto listado' : 'productos listados' }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Modal de creación/edición: estructura y estilo del prototipo --}}
    @if ($mostrarFormulario)
        <div class="modal-producto-overlay" wire:key="modal-formulario-{{ $modoEdicion ? 'editar' : 'crear' }}"
            wire:click.self="cerrarFormulario" x-on:keydown.escape.window="$wire.cerrarFormulario()">
            <div class="modal-producto" role="dialog" aria-modal="true" aria-labelledby="modal-producto-titulo">
                <div class="modal-producto-header">
                    <div>
                        <h2 id="modal-producto-titulo">{{ $modoEdicion ? 'Editar producto' : 'Nuevo producto' }}</h2>
                        <p>{{ $modoEdicion ? 'Los cambios se aplican de inmediato en el catálogo' : 'Quedará disponible en el punto de venta al guardarlo' }}
                        </p>
                    </div>
                    <button type="button" class="modal-producto-close" wire:click="cerrarFormulario"
                        aria-label="Cerrar modal">
                        <span class="material-symbols-rounded" aria-hidden="true">close</span>
                    </button>
                </div>

                <form wire:submit="guardarProducto" novalidate>
                    <div class="modal-producto-body">
                        <div class="modal-producto-imagen-col" x-data="{ arrastrando: false }">
                            {{-- Se puede hacer clic para elegir la foto o arrastrarla hasta el recuadro. --}}
                            <label for="imagen-producto" class="modal-producto-imagen-drop"
                                :class="{ 'arrastrando': arrastrando }" x-on:dragover.prevent="arrastrando = true"
                                x-on:dragleave.prevent="arrastrando = false"
                                x-on:drop.prevent="arrastrando = false; $refs.inputImagen.files = $event.dataTransfer.files; $refs.inputImagen.dispatchEvent(new Event('change', { bubbles: true }))">
                                @if ($imagenNueva && !$errors->has('imagenNueva'))
                                    <img class="modal-producto-imagen-preview" src="{{ $imagenNueva->temporaryUrl() }}"
                                        alt="Vista previa de la nueva imagen">
                                @elseif ($imagenActual)
                                    <img class="modal-producto-imagen-preview"
                                        src="{{ url('storage/' . ltrim($imagenActual, '/')) }}" alt="">
                                @else
                                    <span class="material-symbols-rounded modal-producto-upload-icon"
                                        aria-hidden="true">add_photo_alternate</span>
                                    <strong>Arrastra la foto<br>del producto</strong>
                                    <small>JPG o PNG · mín. 600×600</small>
                                @endif
                            </label>

                            <input id="imagen-producto" type="file" accept="image/jpeg,image/png"
                                wire:model="imagenNueva" x-ref="inputImagen" class="modal-producto-file-input">
                            <label for="imagen-producto" class="modal-producto-upload-button">
                                <span class="material-symbols-rounded" aria-hidden="true">upload</span> Subir imagen
                            </label>
                            <div class="modal-producto-imagen-nota">Se mostrará recortada en la card del punto de venta
                            </div>
                            <div wire:loading wire:target="imagenNueva" class="modal-producto-uploading">Subiendo
                                imagen...</div>
                            @error('imagenNueva')
                                <p class="modal-producto-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="modal-producto-campos">
                            <div class="modal-producto-field">
                                <label for="p-nombre">Nombre del producto</label>
                                <input id="p-nombre" type="text" wire:model="nombre"
                                    placeholder="Ej: Merengón de frutos rojos" maxlength="150"
                                    class="{{ $errors->has('nombre') ? 'input-error' : '' }}">
                                @error('nombre')
                                    <span class="modal-producto-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="modal-producto-grid-2">
                                <div class="modal-producto-field">
                                    <label for="p-categoria">Categoría</label>
                                    <select id="p-categoria" wire:model="categoria_id"
                                        class="{{ $errors->has('categoria_id') ? 'input-error' : '' }}">
                                        <option value="">Selecciona una categoría</option>
                                        @foreach ($this->categorias as $categoriaItem)
                                            <option value="{{ $categoriaItem->id }}">{{ $categoriaItem->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <span class="modal-producto-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="modal-producto-field">
                                    <label for="p-precio">Precio de venta</label>
                                    <input id="p-precio" type="text" inputmode="numeric"
                                        wire:model="precio_venta" placeholder="$0"
                                        class="modal-producto-precio {{ $errors->has('precio_venta') ? 'input-error' : '' }}">
                                    @error('precio_venta')
                                        <span class="modal-producto-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-producto-grid-2">
                                <div class="modal-producto-field">
                                    <label
                                        for="p-stock">{{ $modoEdicion ? 'Stock actual' : 'Stock inicial' }}</label>
                                    <div
                                        class="modal-producto-counter {{ $errors->has('stock_actual') ? 'input-error' : '' }}">
                                        <button type="button" wire:click="ajustarStock(-1)"
                                            aria-label="Disminuir stock">
                                            <span class="material-symbols-rounded" aria-hidden="true">remove</span>
                                        </button>
                                        <input id="p-stock" type="number" wire:model="stock_actual"
                                            min="0" step="1" aria-label="Stock">
                                        <button type="button" class="counter-plus" wire:click="ajustarStock(1)"
                                            aria-label="Aumentar stock">
                                            <span class="material-symbols-rounded" aria-hidden="true">add</span>
                                        </button>
                                    </div>
                                    @error('stock_actual')
                                        <span class="modal-producto-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="modal-producto-field">
                                    <label for="p-minimo">Stock mínimo</label>
                                    <div
                                        class="modal-producto-counter {{ $errors->has('stock_minimo') ? 'input-error' : '' }}">
                                        <button type="button" wire:click="ajustarStockMinimo(-1)"
                                            aria-label="Disminuir stock mínimo">
                                            <span class="material-symbols-rounded" aria-hidden="true">remove</span>
                                        </button>
                                        <input id="p-minimo" type="number" wire:model="stock_minimo"
                                            min="0" step="1" aria-label="Stock mínimo">
                                        <button type="button" class="counter-plus"
                                            wire:click="ajustarStockMinimo(1)" aria-label="Aumentar stock mínimo">
                                            <span class="material-symbols-rounded" aria-hidden="true">add</span>
                                        </button>
                                    </div>
                                    @error('stock_minimo')
                                        <span class="modal-producto-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="button"
                                class="modal-producto-activo {{ $activo ? 'esta-activo' : 'esta-inactivo' }}"
                                role="switch" aria-checked="{{ $activo ? 'true' : 'false' }}"
                                wire:click="alternarActivoFormulario">
                                <span class="modal-producto-switch"><span></span></span>
                                <span class="modal-producto-activo-texto">
                                    <strong>{{ $activo ? 'Producto activo' : 'Producto inactivo' }}</strong>
                                    <small>{{ $activo ? 'Se muestra en el punto de venta' : 'Oculto del punto de venta, conserva su historial' }}</small>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="modal-producto-footer">
                        <button type="button" class="modal-producto-btn-cancel"
                            wire:click="cerrarFormulario">Cancelar</button>
                        <button type="submit" class="modal-producto-btn-save" wire:loading.attr="disabled"
                            wire:target="guardarProducto,imagenNueva">
                            <span class="material-symbols-rounded" aria-hidden="true">check_circle</span>
                            {{ $modoEdicion ? 'Guardar cambios' : 'Crear producto' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Confirmación de borrado con el mismo lenguaje visual del prototipo. --}}
    @if ($mostrarConfirmacionEliminar)
        <div class="modal-producto-overlay modal-producto-overlay-warning" wire:click.self="cerrarModalEliminacion"
            x-on:keydown.escape.window="$wire.cerrarModalEliminacion()">
            <div class="modal-producto-alerta" role="alertdialog" aria-modal="true"
                aria-labelledby="alerta-eliminar-titulo">
                <div class="modal-producto-alerta-titulo">
                    <span class="modal-producto-alerta-icon warning"><span class="material-symbols-rounded"
                            aria-hidden="true">delete</span></span>
                    <div>
                        <h2 id="alerta-eliminar-titulo">Eliminar producto</h2>
                        <p>{{ $productoEliminarNombre }}</p>
                    </div>
                </div>
                <div class="modal-producto-alerta-box warning-box">
                    Esta acción eliminará el producto definitivamente si no existen ventas o movimientos relacionados.
                </div>
                <div class="modal-producto-alerta-actions">
                    <button type="button" class="modal-producto-btn-cancel"
                        wire:click="cerrarModalEliminacion">Cancelar</button>
                    <button type="button" class="modal-producto-btn-save" wire:click="eliminarProducto"
                        wire:loading.attr="disabled" wire:target="eliminarProducto">
                        <span class="material-symbols-rounded" aria-hidden="true">delete</span> Eliminar
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- El prototipo muestra este modal cuando no se puede borrar un producto con historial. --}}
    @if ($mostrarBloqueoEliminacion)
        <div class="modal-producto-overlay modal-producto-overlay-warning" wire:click.self="cerrarModalEliminacion"
            x-on:keydown.escape.window="$wire.cerrarModalEliminacion()">
            <div class="modal-producto-alerta" role="alertdialog" aria-modal="true"
                aria-labelledby="alerta-bloqueo-titulo">
                <div class="modal-producto-alerta-titulo">
                    <span class="modal-producto-alerta-icon warning"><span class="material-symbols-rounded"
                            aria-hidden="true">history_toggle_off</span></span>
                    <div>
                        <h2 id="alerta-bloqueo-titulo">No se puede eliminar</h2>
                        <p>{{ $productoEliminarNombre }}</p>
                    </div>
                </div>
                <div class="modal-producto-alerta-box warning-box">
                    Este producto tiene registros asociados. Eliminarlo afectaría la trazabilidad de ventas o
                    movimientos de inventario.
                </div>
                <div class="modal-producto-alerta-box secondary-box">
                    <span class="material-symbols-rounded" aria-hidden="true">visibility_off</span>
                    <span>Desactívalo en su lugar: dejará de estar disponible para nuevas ventas, pero conservará su
                        historial.</span>
                </div>
                <div class="modal-producto-alerta-actions">
                    <button type="button" class="modal-producto-btn-cancel"
                        wire:click="cerrarModalEliminacion">Entendido</button>
                    <button type="button" class="modal-producto-btn-save" wire:click="desactivarProductoBloqueado">
                        <span class="material-symbols-rounded" aria-hidden="true">visibility_off</span> Desactivar
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('mensaje'))
        <div class="productos-toast" role="status">
            <span class="material-symbols-rounded" aria-hidden="true">check_circle</span>
            {{ session('mensaje') }}
        </div>
    @endif
</div>