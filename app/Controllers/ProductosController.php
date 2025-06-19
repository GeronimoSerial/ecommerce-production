<?php

namespace App\Controllers;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Controllers\BaseController;

class ProductosController extends BaseController
{
    private $productosPorPagina = 6; // Productos por página

    public function porCategoria($slug)
    {
        $categoriaModel = new CategoriaModel();
        $productoModel = new ProductoModel();

        // Obtener parámetros de filtrado y paginado
        $filtros = [
            'busqueda' => $this->request->getGet('busqueda'),
            'precio_min' => $this->request->getGet('precio_min'),
            'precio_max' => $this->request->getGet('precio_max'),
            'orden' => $this->request->getGet('orden') ?? 'nombre',
            'direccion' => $this->request->getGet('direccion') ?? 'ASC'
        ];

        $paginacion = [
            'pagina' => $this->request->getGet('page') ?? 1,
            'limite' => $this->productosPorPagina
        ];

        // Buscar la categoria por slug
        $categoria = $categoriaModel->where("LOWER(nombre)", strtolower($slug))->first();

        // Si no se encuentra la categoría, mostrar error 404
        if (!$categoria) {
            return view("errors/html/error_404", [
                "title" => "Categoría no encontrada",
                "message" => "La categoría que buscas no existe."
            ]);
        }

        // Obtener productos filtrados y total
        $resultado = $productoModel->getProductosFiltrados(
            $categoria['id_categoria'],
            $filtros,
            $paginacion
        );

        // Obtener estadísticas de precios
        $precios = $productoModel->getEstadisticasPrecios($categoria['id_categoria']);

        // Calcular información de paginación
        $totalPaginas = ceil($resultado['total'] / $this->productosPorPagina);
        $paginaActual = max(1, min($paginacion['pagina'], $totalPaginas));

        // Preparar datos para la vista
        $data = [
            "title" => $categoria["nombre"] . " - Suplementos Fitness",
            "categoria" => $categoria,
            "productos" => $resultado['productos'],
            "totalProductos" => $resultado['total'],
            "precioMinimo" => $precios['minimo'],
            "precioMaximo" => $precios['maximo'],
            "paginacion" => [
                "paginaActual" => $paginaActual,
                "totalPaginas" => $totalPaginas,
                "productosPorPagina" => $this->productosPorPagina,
                "totalProductos" => $resultado['total']
            ],
            "filtros" => $filtros,
            "content" => view("pages/productos/categoria", [
                "categoria" => $categoria,
                "productos" => $resultado['productos'],
                "totalProductos" => $resultado['total'],
                "precioMinimo" => $precios['minimo'],
                "precioMaximo" => $precios['maximo'],
                "paginacion" => [
                    "paginaActual" => $paginaActual,
                    "totalPaginas" => $totalPaginas,
                    "productosPorPagina" => $this->productosPorPagina,
                    "totalProductos" => $resultado['total']
                ],
                "filtros" => $filtros
            ]),
        ];
        return view("templates/main_layout", $data);
    }

    public function detalle($id)
    {
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();

        // Buscar el producto
        $producto = $productoModel->find($id);

        if (!$producto || $producto['activo'] != 1) {
            return view("errors/html/error_404", [
                "title" => "Producto no encontrado",
                "message" => "El producto que buscas no existe o no está disponible."
            ]);
        }

        // Obtener la categoría del producto
        $categoria = $categoriaModel->find($producto['id_categoria']);

        // Obtener productos relacionados
        $productosRelacionados = $productoModel->getProductosRelacionados(
            $producto['id_producto'],
            $producto['id_categoria']
        );

        $data = [
            "title" => $producto["nombre"] . " - " . $categoria["nombre"],
            "producto" => $producto,
            "categoria" => $categoria,
            "productosRelacionados" => $productosRelacionados,
            "content" => view("pages/productos/detalle", [
                "producto" => $producto,
                "categoria" => $categoria,
                "productosRelacionados" => $productosRelacionados,
            ]),
        ];
        return view("templates/main_layout", $data);
    }

    public function buscar()
    {
        $productoModel = new ProductoModel();
        $categoriaModel = new CategoriaModel();

        // Obtener parámetros de búsqueda y filtrado
        $filtros = [
            'busqueda' => $this->request->getGet('q'),
            'precio_min' => $this->request->getGet('precio_min'),
            'precio_max' => $this->request->getGet('precio_max'),
            'orden' => $this->request->getGet('orden') ?? 'nombre',
            'direccion' => $this->request->getGet('direccion') ?? 'ASC'
        ];

        $paginacion = [
            'pagina' => $this->request->getGet('page') ?? 1,
            'limite' => $this->productosPorPagina
        ];

        // Obtener productos filtrados
        $categoriaId = $this->request->getGet('categoria');
        $resultado = $productoModel->getProductosFiltrados($categoriaId, $filtros, $paginacion);

        // Obtener estadísticas de precios
        $precios = $productoModel->getEstadisticasPrecios($categoriaId);

        // Calcular información de paginación
        $totalPaginas = ceil($resultado['total'] / $this->productosPorPagina);
        $paginaActual = max(1, min($paginacion['pagina'], $totalPaginas));

        // Obtener categorías para filtros
        $categorias = $categoriaModel->findAll();

        $data = [
            "title" => "Resultados de búsqueda",
            "productos" => $resultado['productos'],
            "categorias" => $categorias,
            "busqueda" => $filtros['busqueda'],
            "totalProductos" => $resultado['total'],
            "precioMinimo" => $precios['minimo'],
            "precioMaximo" => $precios['maximo'],
            "paginacion" => [
                "paginaActual" => $paginaActual,
                "totalPaginas" => $totalPaginas,
                "productosPorPagina" => $this->productosPorPagina,
                "totalProductos" => $resultado['total']
            ],
            "filtros" => array_merge($filtros, ['categoriaId' => $categoriaId]),
            "content" => view("pages/productos/busqueda", [
                "productos" => $resultado['productos'],
                "categorias" => $categorias,
                "busqueda" => $filtros['busqueda'],
                "totalProductos" => $resultado['total'],
                "precioMinimo" => $precios['minimo'],
                "precioMaximo" => $precios['maximo'],
                "paginacion" => [
                    "paginaActual" => $paginaActual,
                    "totalPaginas" => $totalPaginas,
                    "productosPorPagina" => $this->productosPorPagina,
                    "totalProductos" => $resultado['total']
                ],
                "filtros" => array_merge($filtros, ['categoriaId' => $categoriaId])
            ]),
        ];
        return view("templates/main_layout", $data);
    }
}
