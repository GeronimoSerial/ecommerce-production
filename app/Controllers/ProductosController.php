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
        $pagina = $this->request->getGet('page') ?? 1;
        $orden = $this->request->getGet('orden') ?? 'nombre';
        $direccion = $this->request->getGet('direccion') ?? 'ASC';
        $precioMin = $this->request->getGet('precio_min');
        $precioMax = $this->request->getGet('precio_max');
        $busqueda = $this->request->getGet('busqueda');

        // Buscar la categoria por slug
        $categoria = $categoriaModel
            ->where("LOWER(nombre)", strtolower($slug))
            ->first();

        // Si no se encuentra la categoría, mostrar error 404
        if (!$categoria) {
            return view("errors/html/error_404", [
                "title" => "Categoría no encontrada",
                "message" => "La categoría que buscas no existe."
            ]);
        }

        // Builder para conteo
        $countBuilder = $productoModel->builder();
        $countBuilder->where("id_categoria", $categoria["id_categoria"]);
        $countBuilder->where("activo", 1);
        if ($busqueda) {
            $countBuilder->groupStart()
                ->like("nombre", $busqueda)
                ->orLike("descripcion", $busqueda)
                ->groupEnd();
        }
        if ($precioMin !== null && $precioMin !== '') {
            $countBuilder->where("precio >=", $precioMin);
        }
        if ($precioMax !== null && $precioMax !== '') {
            $countBuilder->where("precio <=", $precioMax);
        }
        $totalProductos = $countBuilder->countAllResults();

        // Builder puro para productos paginados
        $productosBuilder = $productoModel->builder();
        $productosBuilder->where("id_categoria", $categoria["id_categoria"]);
        $productosBuilder->where("activo", 1);
        if ($busqueda) {
            $productosBuilder->groupStart()
                ->like("nombre", $busqueda)
                ->orLike("descripcion", $busqueda)
                ->groupEnd();
        }
        if ($precioMin !== null && $precioMin !== '') {
            $productosBuilder->where("precio >=", $precioMin);
        }
        if ($precioMax !== null && $precioMax !== '') {
            $productosBuilder->where("precio <=", $precioMax);
        }
        $ordenesPermitidos = ['nombre', 'precio', 'cantidad'];
        $direccionesPermitidas = ['ASC', 'DESC'];
        if (in_array($orden, $ordenesPermitidos)) {
            $productosBuilder->orderBy($orden, in_array($direccion, $direccionesPermitidas) ? $direccion : 'ASC');
        } else {
            $productosBuilder->orderBy('nombre', 'ASC');
        }
        $offset = ($pagina - 1) * $this->productosPorPagina;
        $productosBuilder->limit($this->productosPorPagina, $offset);
        $query = $productosBuilder->get();
        $productos = $query->getResultArray();

        // Calcular información de paginación
        $totalPaginas = ceil($totalProductos / $this->productosPorPagina);
        $paginaActual = max(1, min($pagina, $totalPaginas));

        // Obtener estadísticas de la categoría (sin filtros)
        $statsQuery = $productoModel
            ->where("id_categoria", $categoria["id_categoria"])
            ->where("activo", 1);
        $precioMinimo = $statsQuery->selectMin("precio")->first();
        $precioMaximo = $statsQuery->selectMax("precio")->first();

        // Preparar datos para la vista
        $data = [
            "title" => $categoria["nombre"] . " - Suplementos Fitness",
            "categoria" => $categoria,
            "productos" => $productos,
            "totalProductos" => $totalProductos,
            "precioMinimo" => $precioMinimo ? $precioMinimo['precio'] : 0,
            "precioMaximo" => $precioMaximo ? $precioMaximo['precio'] : 0,
            "paginacion" => [
                "paginaActual" => $paginaActual,
                "totalPaginas" => $totalPaginas,
                "productosPorPagina" => $this->productosPorPagina,
                "totalProductos" => $totalProductos
            ],
            "filtros" => [
                "busqueda" => $busqueda,
                "precioMin" => $precioMin,
                "precioMax" => $precioMax,
                "orden" => $orden,
                "direccion" => $direccion
            ],
            "content" => view("pages/productos/categoria", [
                "categoria" => $categoria,
                "productos" => $productos,
                "totalProductos" => $totalProductos,
                "precioMinimo" => $precioMinimo ? $precioMinimo['precio'] : 0,
                "precioMaximo" => $precioMaximo ? $precioMaximo['precio'] : 0,
                "paginacion" => [
                    "paginaActual" => $paginaActual,
                    "totalPaginas" => $totalPaginas,
                    "productosPorPagina" => $this->productosPorPagina,
                    "totalProductos" => $totalProductos
                ],
                "filtros" => [
                    "busqueda" => $busqueda,
                    "precioMin" => $precioMin,
                    "precioMax" => $precioMax,
                    "orden" => $orden,
                    "direccion" => $direccion
                ]
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

        // Obtener productos relacionados de la misma categoría
        $productosRelacionados = $productoModel
            ->where("id_categoria", $producto['id_categoria'])
            ->where("id_producto !=", $producto['id_producto'])
            ->where("activo", 1)
            ->limit(3)
            ->findAll();

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
        $busqueda = $this->request->getGet('q');
        $categoriaId = $this->request->getGet('categoria');
        $precioMin = $this->request->getGet('precio_min');
        $precioMax = $this->request->getGet('precio_max');
        $orden = $this->request->getGet('orden') ?? 'nombre';
        $direccion = $this->request->getGet('direccion') ?? 'ASC';
        $pagina = $this->request->getGet('page') ?? 1;

        // Builder para conteo
        $countBuilder = $productoModel->builder();
        $countBuilder->where("activo", 1);
        if ($busqueda) {
            $countBuilder->groupStart()
                ->like("nombre", $busqueda)
                ->orLike("descripcion", $busqueda)
                ->groupEnd();
        }
        if ($categoriaId) {
            $countBuilder->where("id_categoria", $categoriaId);
        }
        if ($precioMin !== null && $precioMin !== '') {
            $countBuilder->where("precio >=", $precioMin);
        }
        if ($precioMax !== null && $precioMax !== '') {
            $countBuilder->where("precio <=", $precioMax);
        }
        $totalProductos = $countBuilder->countAllResults();

        // Builder puro para productos paginados
        $productosBuilder = $productoModel->builder();
        $productosBuilder->where("activo", 1);
        if ($busqueda) {
            $productosBuilder->groupStart()
                ->like("nombre", $busqueda)
                ->orLike("descripcion", $busqueda)
                ->groupEnd();
        }
        if ($categoriaId) {
            $productosBuilder->where("id_categoria", $categoriaId);
        }
        if ($precioMin !== null && $precioMin !== '') {
            $productosBuilder->where("precio >=", $precioMin);
        }
        if ($precioMax !== null && $precioMax !== '') {
            $productosBuilder->where("precio <=", $precioMax);
        }
        $ordenesPermitidos = ['nombre', 'precio', 'cantidad'];
        $direccionesPermitidas = ['ASC', 'DESC'];
        if (in_array($orden, $ordenesPermitidos)) {
            $productosBuilder->orderBy($orden, in_array($direccion, $direccionesPermitidas) ? $direccion : 'ASC');
        } else {
            $productosBuilder->orderBy('nombre', 'ASC');
        }
        $offset = ($pagina - 1) * $this->productosPorPagina;
        $productosBuilder->limit($this->productosPorPagina, $offset);
        $query = $productosBuilder->get();
        $productos = $query->getResultArray();

        // Calcular información de paginación
        $totalPaginas = ceil($totalProductos / $this->productosPorPagina);
        $paginaActual = max(1, min($pagina, $totalPaginas));

        // Obtener categorías para filtros
        $categorias = $categoriaModel->findAll();

        // Obtener estadísticas de precios (sin filtros de categoría)
        $statsQuery = $productoModel->where("activo", 1);
        $precioMinimo = $statsQuery->selectMin("precio")->first();
        $precioMaximo = $statsQuery->selectMax("precio")->first();

        $data = [
            "title" => "Resultados de búsqueda",
            "productos" => $productos,
            "categorias" => $categorias,
            "busqueda" => $busqueda,
            "totalProductos" => $totalProductos,
            "precioMinimo" => $precioMinimo ? $precioMinimo['precio'] : 0,
            "precioMaximo" => $precioMaximo ? $precioMaximo['precio'] : 0,
            "paginacion" => [
                "paginaActual" => $paginaActual,
                "totalPaginas" => $totalPaginas,
                "productosPorPagina" => $this->productosPorPagina,
                "totalProductos" => $totalProductos
            ],
            "filtros" => [
                "busqueda" => $busqueda,
                "categoriaId" => $categoriaId,
                "precioMin" => $precioMin,
                "precioMax" => $precioMax,
                "orden" => $orden,
                "direccion" => $direccion
            ],
            "content" => view("pages/productos/busqueda", [
                "productos" => $productos,
                "categorias" => $categorias,
                "busqueda" => $busqueda,
                "totalProductos" => $totalProductos,
                "precioMinimo" => $precioMinimo ? $precioMinimo['precio'] : 0,
                "precioMaximo" => $precioMaximo ? $precioMaximo['precio'] : 0,
                "paginacion" => [
                    "paginaActual" => $paginaActual,
                    "totalPaginas" => $totalPaginas,
                    "productosPorPagina" => $this->productosPorPagina,
                    "totalProductos" => $totalProductos
                ],
                "filtros" => [
                    "busqueda" => $busqueda,
                    "categoriaId" => $categoriaId,
                    "precioMin" => $precioMin,
                    "precioMax" => $precioMax,
                    "orden" => $orden,
                    "direccion" => $direccion
                ]
            ]),
        ];
        return view("templates/main_layout", $data);
    }
}
