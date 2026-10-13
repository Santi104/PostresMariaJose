<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Livewire\Component;

class Productos extends Component
{
    public string $busqueda = '';
    public string $categoria = '';

    public bool $mostrarFormulario = false;
    public bool $modoEdicion = false;
    public ?int $producto_id = null;

    public string $nombre = '';
    public string $codigo = '';
    public string $categoria_id = '';
    public string $descripcion = '';
    public string $precio_venta = '';
    public string $costo_unitario = '';
    public string $stock_minimo = '0';

    public function getProductosFiltradosProperty()
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
            ->map(function ($producto) {
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
                ];
            });
    }

    public function getCategoriasProperty()
    {
        return Categoria::where('activo', true)
            ->orderBy('nombre')
            ->get();
    }

    public function abrirFormulario()
    {
        $this->resetFormulario();
        $this->resetValidation();

        $this->modoEdicion = false;
        $this->mostrarFormulario = true;
    }

    public function editarProducto(int $id)
    {
        $producto = Producto::findOrFail($id);

        $this->producto_id = $producto->id;
        $this->nombre = $producto->nombre;
        $this->codigo = $producto->codigo;
        $this->categoria_id = (string) $producto->categoria_id;
        $this->descripcion = $producto->descripcion ?? '';
        $this->precio_venta = (string) $producto->precio_venta;
        $this->costo_unitario = (string) $producto->costo_unitario;
        $this->stock_minimo = (string) $producto->stock_minimo;

        $this->modoEdicion = true;
        $this->mostrarFormulario = true;

        $this->resetValidation();
    }

    public function guardarProducto()
    {
        $datos = $this->validate([
            'nombre' => 'required|string|max:150',
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('productos', 'codigo')
                    ->ignore($this->producto_id),
            ],
            'categoria_id' => 'required|exists:categorias,id',
            'descripcion' => 'nullable|string|max:1000',
            'precio_venta' => 'required|numeric|min:0',
            'costo_unitario' => 'required|numeric|min:0',
            'stock_minimo' => 'required|integer|min:0',
        ]);

        if ($this->modoEdicion) {
            $producto = Producto::findOrFail($this->producto_id);
            $producto->update($datos);

            $mensaje = 'Producto actualizado correctamente.';
        } else {
            Producto::create([
                ...$datos,
                'stock_actual' => 0,
                'activo' => true,
            ]);

            $mensaje = 'Producto creado correctamente.';
        }

        $this->cerrarFormulario();

        session()->flash('mensaje', $mensaje);
    }

    public function cambiarEstado(int $id)
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

    public function eliminarProducto(int $id)
    {
        $producto = Producto::findOrFail($id);

        try {
            $producto->delete();

            session()->flash('mensaje', 'Producto eliminado correctamente.');
        } catch (QueryException $e) {
            session()->flash(
                'mensaje',
                'No se puede eliminar este producto porque puede tener ventas o movimientos relacionados. Puedes desactivarlo.'
            );
        }
    }

    public function cerrarFormulario()
    {
        $this->mostrarFormulario = false;
        $this->resetFormulario();
        $this->resetValidation();
    }

    private function resetFormulario()
    {
        $this->reset([
            'producto_id',
            'nombre',
            'codigo',
            'categoria_id',
            'descripcion',
            'precio_venta',
            'costo_unitario',
            'stock_minimo',
        ]);

        $this->stock_minimo = '0';
    }

    public function render()
    {
        return view('livewire.productos');
    }
}
