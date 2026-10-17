<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class Productos extends Component
{
    use WithFileUploads;

    // Filtros del listado.
    public string $busqueda = '';
    public string $categoria = '';

    // Estado de los modales.
    public bool $mostrarFormulario = false;
    public bool $modoEdicion = false;
    public bool $mostrarConfirmacionEliminar = false;
    public bool $mostrarBloqueoEliminacion = false;
    public ?int $producto_id = null;
    public ?int $productoEliminarId = null;
    public string $productoEliminarNombre = '';

    // Únicamente los campos visibles en el prototipo.
    public string $nombre = '';
    public string $categoria_id = '';
    public string $precio_venta = '';
    public string $stock_actual = '0';
    public string $stock_minimo = '5';
    public bool $activo = true;

    // Archivo temporal de Livewire y ruta de la imagen guardada.
    public $imagenNueva = null;
    public ?string $imagenActual = null;

    #[Computed]
    public function productosFiltrados()
    {
        return Producto::with('categoria')
            ->when(trim($this->busqueda) !== '', function ($query) {
                $busqueda = trim($this->busqueda);
                $query->where(function ($q) use ($busqueda) {
                    $q->where('nombre', 'like', "%{$busqueda}%")
                        ->orWhere('codigo', 'like', "%{$busqueda}%");
                });
            })
            ->when($this->categoria !== '', function ($query) {
                $query->where('categoria_id', $this->categoria);
            })
            ->orderBy('nombre')
            ->get()
            ->map(function (Producto $producto) {
                if (!$producto->activo) {
                    $estado = 'Inactivo';
                } elseif ($producto->stock_actual <= 0) {
                    $estado = 'Agotado';
                } elseif ($producto->stock_actual <= $producto->stock_minimo) {
                    $estado = 'Bajo stock';
                } else {
                    $estado = 'Disponible';
                }

                return [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'sku' => $producto->codigo,
                    'categoria' => $producto->categoria?->nombre ?? 'Sin categoría',
                    'precio' => $producto->precio_venta,
                    'stock' => $producto->stock_actual,
                    'minimo' => $producto->stock_minimo,
                    'estado' => $estado,
                    'activo' => (bool) $producto->activo,
                    'imagen' => $producto->imagen,
                ];
            });
    }

    #[Computed]
    public function categorias()
    {
        return Categoria::where('activo', true)->orderBy('nombre')->get();
    }

    public function abrirFormulario(): void
    {
        $this->resetFormulario();
        $this->resetValidation();
        $this->modoEdicion = false;

        // El prototipo abre el formulario con «Postres» y stock mínimo 5.
        // Si no existe esa categoría, tomar la primera disponible.
        $categoria = $this->categorias->first(
            fn ($item) => mb_strtolower($item->nombre) === 'postres'
        ) ?? $this->categorias->first();
        $this->categoria_id = $categoria ? (string) $categoria->id : '';

        $this->mostrarFormulario = true;
    }

    public function editarProducto(int $id): void
    {
        $producto = Producto::findOrFail($id);
        $this->resetFormulario();
        $this->resetValidation();

        $this->producto_id = $producto->id;
        $this->nombre = $producto->nombre;
        $this->categoria_id = (string) $producto->categoria_id;
        // En el prototipo el precio se visualiza como moneda colombiana.
        $this->precio_venta = '$' . number_format((float) $producto->precio_venta, 0, ',', '.');
        $this->stock_actual = (string) $producto->stock_actual;
        $this->stock_minimo = (string) $producto->stock_minimo;
        $this->activo = (bool) $producto->activo;
        $this->imagenActual = $producto->imagen;

        $this->modoEdicion = true;
        $this->mostrarFormulario = true;
    }

    public function ajustarStock(int $paso): void
    {
        // Los botones +/- siempre mantienen el valor >= 0.
        $this->stock_actual = (string) max(0, (int) $this->stock_actual + $paso);
    }

    public function ajustarStockMinimo(int $paso): void
    {
        $this->stock_minimo = (string) max(0, (int) $this->stock_minimo + $paso);
    }

    public function alternarActivoFormulario(): void
    {
        $this->activo = !$this->activo;
    }

    public function updatedImagenNueva(): void
    {
        $this->validateOnly('imagenNueva', [
            'imagenNueva' => 'nullable|image|mimes:jpg,jpeg,png|max:3072|dimensions:min_width=600,min_height=600',
        ], [
            'imagenNueva.dimensions' => 'La imagen debe tener al menos 600 × 600 píxeles.',
        ]);
    }

    public function guardarProducto(): void
    {
        // El prototipo trabaja con precios en pesos enteros: «$25.000» -> 25000.
        // Si escriben caracteres inesperados, la validación rechaza el valor.
        $precioOriginal = trim($this->precio_venta);
        if ($precioOriginal !== '' && preg_match('/^\$?\s*[\d., ]+$/u', $precioOriginal)) {
            $this->precio_venta = preg_replace('/\D/', '', $precioOriginal);
        }

        $datos = $this->validate([
            'nombre' => 'required|string|max:150',
            'categoria_id' => 'required|exists:categorias,id',
            'precio_venta' => 'required|integer|min:0|max:9999999',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'activo' => 'required|boolean',
            'imagenNueva' => 'nullable|image|mimes:jpg,jpeg,png|max:3072|dimensions:min_width=600,min_height=600',
        ], [
            'imagenNueva.dimensions' => 'La imagen debe tener al menos 600 × 600 píxeles.',
        ]);

        unset($datos['imagenNueva']);
        $rutaNueva = null;
        $rutaAnterior = null;

        if ($this->imagenNueva) {
            $rutaNueva = $this->imagenNueva->store('productos', 'public');
            if (!$rutaNueva) {
                throw new \RuntimeException('No fue posible guardar la imagen del producto.');
            }
            $datos['imagen'] = $rutaNueva;
        }

        try {
            if ($this->modoEdicion) {
                // Conserva SKU, costo unitario y descripción existentes.
                $producto = Producto::findOrFail($this->producto_id);
                $rutaAnterior = $producto->imagen;
                $producto->update($datos);
                $mensaje = 'Producto actualizado correctamente.';
            } else {
                // Campos que exige la base de datos, sin mostrarlos en el modal:
                // SKU generado automáticamente y costo inicial 0.
                $datos['codigo'] = 'PRD-' . Str::ulid();
                $datos['costo_unitario'] = 0;
                Producto::create($datos);
                $mensaje = 'Producto creado correctamente.';
            }
        } catch (Throwable $e) {
            if ($rutaNueva) {
                Storage::disk('public')->delete($rutaNueva);
            }
            throw $e;
        }

        if ($rutaNueva && $rutaAnterior && $rutaAnterior !== $rutaNueva) {
            Storage::disk('public')->delete($rutaAnterior);
        }

        $this->cerrarFormulario();
        session()->flash('mensaje', $mensaje);
    }

    public function cambiarEstado(int $id): void
    {
        $producto = Producto::findOrFail($id);
        $producto->activo = !$producto->activo;
        $producto->save();

        session()->flash(
            'mensaje',
            $producto->activo
                ? 'Producto activado correctamente.'
                : 'Producto desactivado correctamente.'
        );
    }

    public function confirmarEliminacion(int $id): void
    {
        $producto = Producto::findOrFail($id);
        $this->productoEliminarId = $producto->id;
        $this->productoEliminarNombre = $producto->nombre;
        $this->mostrarBloqueoEliminacion = false;
        $this->mostrarConfirmacionEliminar = true;
    }

    public function eliminarProducto(): void
    {
        if ($this->productoEliminarId === null) {
            return;
        }

        $producto = Producto::findOrFail($this->productoEliminarId);
        $rutaImagen = $producto->imagen;

        try {
            $producto->delete();
            $this->cerrarModalEliminacion();
            if ($rutaImagen) {
                Storage::disk('public')->delete($rutaImagen);
            }
            session()->flash('mensaje', 'Producto eliminado correctamente.');
        } catch (QueryException $e) {
            // Solo mostrar el modal de protección cuando hay vínculos en la base de datos.
            if (!in_array((string) $e->getCode(), ['23000', '23503'], true)) {
                throw $e;
            }

            $this->mostrarConfirmacionEliminar = false;
            $this->mostrarBloqueoEliminacion = true;
        }
    }

    public function desactivarProductoBloqueado(): void
    {
        if ($this->productoEliminarId === null) {
            return;
        }

        $producto = Producto::findOrFail($this->productoEliminarId);
        $producto->update(['activo' => false]);
        $this->cerrarModalEliminacion();
        session()->flash('mensaje', 'Producto desactivado; se conserva su historial.');
    }

    public function cerrarModalEliminacion(): void
    {
        $this->mostrarConfirmacionEliminar = false;
        $this->mostrarBloqueoEliminacion = false;
        $this->productoEliminarId = null;
        $this->productoEliminarNombre = '';
    }

    public function cerrarFormulario(): void
    {
        $this->mostrarFormulario = false;
        $this->resetFormulario();
        $this->resetValidation();
    }

    private function resetFormulario(): void
    {
        $this->reset([
            'producto_id', 'nombre', 'categoria_id',
            'precio_venta', 'stock_actual', 'stock_minimo',
            'activo', 'imagenNueva', 'imagenActual',
        ]);

        $this->stock_actual = '0';
        $this->stock_minimo = '5';
        $this->activo = true;
        $this->modoEdicion = false;
    }

    public function render()
    {
        return view('livewire.productos');
    }
}
