<?php

namespace App\Controllers;

use App\Models\DetallesFacturaModel;
use App\Models\UsuarioModel;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\PersonaModel;
use App\Models\FacturaModel;
use App\Models\ContactoModel;

class AdminController extends BaseController
{
    private $usuarioModel;
    private $productoModel;
    private $categoriaModel;
    private $personaModel;
    private $facturaModel;
    private $detallesFacturaModel;
    private $contactoModel;
    private $session;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->usuarioModel = new UsuarioModel();
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->personaModel = new PersonaModel();
        $this->facturaModel = new FacturaModel();
        $this->detallesFacturaModel = new DetallesFacturaModel();
        $this->contactoModel = new ContactoModel();
        $this->session = session();
    }

    public function index()
    {
        $session = session();

        // Verificar si está logueado y es administrador
        if (!$session->get('logueado') || $session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        // Obtener estadísticas generales
        $stats = $this->getDashboardStats();

        return view('templates/main_layout', [
            'title' => 'Panel de Administración',
            'content' => view('back/admin/dashboard', [
                'nombre' => $session->get('nombre'),
                'stats' => $stats
            ])
        ]);
    }

    // ==================== GESTIÓN DE USUARIOS (REDIRIGE AL USUARIO CONTROLLER) ====================

    /**
     * Redirige a la gestión de usuarios
     */
    public function usuarios()
    {
        return redirect()->to('/admin/usuarios');
    }

    /**
     * Redirige al formulario de crear usuario
     */
    public function crearUsuario()
    {
        return redirect()->to('/admin/usuarios/crear');
    }

    /**
     * Redirige al formulario de editar usuario
     */
    public function editarUsuario($id = null)
    {
        return redirect()->to('/admin/usuarios/editar/' . $id);
    }

    /**
     * Redirige a la acción de eliminar usuario
     */
    public function eliminarUsuario($id = null)
    {
        return redirect()->to('/admin/usuarios/eliminar/' . $id);
    }

    // ==================== CONTROL DE INVENTARIO ====================
    public function inventario()
    {
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $request = \Config\Services::request();
        $page = (int) $request->getGet('page') ?: 1;
        $orden = $request->getGet('orden') ?: 'nombre';
        $direccion = $request->getGet('direccion') ?: 'ASC';
        $limit = 20;
        $offset = ($page - 1) * $limit;

        // Obtener productos usando los métodos del modelo
        $productos = $this->productoModel->getAllProductsWithCategories($orden, $direccion, $limit, $offset);
        $totalProductos = $this->productoModel->countAllProductsWithCategories();
        $stockBajo = count($this->productoModel->getLowCantidadProducts());
        $cantActivos = $this->productoModel->countActiveProducts();
        $valorTotal = $this->productoModel->getAllProductsValue();
        $vendidosPorCategoria = $this->categoriaModel->getVendidosPorCategoria();

        $totalPaginas = (int) ceil($totalProductos / $limit);

        $filtros = [
            'orden' => $orden,
            'direccion' => $direccion,
            'page' => $page
        ];

        $paginacion = [
            'paginaActual' => $page,
            'totalPaginas' => $totalPaginas,
            'totalProductos' => $totalProductos
        ];

        return view('templates/main_layout', [
            'title' => 'Control de Inventario',
            'content' => view('back/admin/inventario/index', [
                'productos' => $productos,
                'filtros' => $filtros,
                'paginacion' => $paginacion,
                'baseUrl' => base_url('admin/inventario'),
                'valorTotal' => $valorTotal,
                'totalProductos' => $totalProductos,
                'stockBajo' => $stockBajo,
                'cantActivos' => $cantActivos,
                'vendidosPorCategoria' => $vendidosPorCategoria
            ])
        ]);
    }

    public function crearProducto()
    {
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $categorias = $this->categoriaModel->findAll();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nombre' => 'required|min_length[3]',
                'descripcion' => 'required',
                'precio' => 'required|numeric',
                'cantidad' => 'required|integer',
                'id_categoria' => 'required|integer'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'nombre' => $this->request->getPost('nombre'),
                    'descripcion' => $this->request->getPost('descripcion'),
                    'precio' => $this->request->getPost('precio'),
                    'cantidad' => $this->request->getPost('cantidad'),
                    'id_categoria' => $this->request->getPost('id_categoria'),
                    'url_imagen' => $this->request->getPost('imagen') ?: 'default-product.jpg',
                    'activo' => 1
                ];

                if ($this->productoModel->insert($data)) {
                    $this->session->setFlashdata('msg', 'Producto creado exitosamente');
                    return redirect()->to('/admin/inventario');
                } else {
                    $this->session->setFlashdata('error', 'Error al crear el producto');
                }
            } else {
                $this->session->setFlashdata('error', 'Por favor corrige los errores en el formulario');
            }
        }

        return view('templates/main_layout', [
            'title' => 'Crear Producto',
            'content' => view('back/admin/inventario/crear', [
                'categorias' => $categorias,
                'validation' => \Config\Services::validation()
            ])
        ]);
    }

    public function editarProducto($id = null)
    {
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $producto = $this->productoModel->find($id);
        $categorias = $this->categoriaModel->findAll();

        if (!$producto) {
            return redirect()->to('/admin/inventario');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nombre' => 'required|min_length[3]',
                'descripcion' => 'required',
                'precio' => 'required|numeric',
                'cantidad' => 'required|integer',
                'cantidad_vendidos' => 'required|integer',
                'id_categoria' => 'required|integer'

            ];

            if ($this->validate($rules)) {
                $data = [
                    'nombre' => $this->request->getPost('nombre'),
                    'descripcion' => $this->request->getPost('descripcion'),
                    'precio' => $this->request->getPost('precio'),
                    'cantidad' => $this->request->getPost('cantidad'),
                    'cantidad_vendidos' => $this->request->getPost('cantidad_vendidos'),
                    'id_categoria' => $this->request->getPost('id_categoria')
                ];

                $imagen = $this->request->getPost('imagen');
                if (!empty($imagen)) {
                    $data['url_imagen'] = $imagen;
                } else {
                    $data['url_imagen'] = $producto['url_imagen'];
                }

                if ($this->productoModel->update($id, $data)) {
                    $this->session->setFlashdata('msg', 'Producto actualizado exitosamente');
                    return redirect()->to('/admin/inventario');
                } else {
                    $this->session->setFlashdata('error', 'Error al actualizar el producto');
                }
            } else {
                $this->session->setFlashdata('error', 'Por favor corrige los errores en el formulario');
            }
        }

        return view('templates/main_layout', [
            'title' => 'Editar Producto',
            'content' => view('back/admin/inventario/editar', [
                'producto' => $producto,
                'categorias' => $categorias,
                'validation' => \Config\Services::validation()
            ])
        ]);
    }

    public function eliminarProducto($id = null)
    {
        if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        if ($this->productoModel->delete($id)) {
            $this->session->setFlashdata('msg', 'Producto eliminado exitosamente');
        } else {
            $this->session->setFlashdata('error', 'Error al eliminar el producto');
        }

        return redirect()->to('/admin/inventario');
    }

    // ==================== REPORTES Y ESTADÍSTICAS ====================
    // public function reportes()
    // {
    //     if (!$this->session->get('logueado') || $this->session->get('id_rol') != 1) {
    //         return redirect()->to('/login');
    //     }

    //     $stats = $this->getDashboardStats();
    //     $productosPorCategoria = $this->getProductosPorCategoria();

    //     return view('templates/main_layout', [
    //         'title' => 'Reportes y Estadísticas',
    //         'content' => view('back/admin/reportes/index', [
    //             'stats' => $stats,
    //             'productosPorCategoria' => $productosPorCategoria,
    //         ])
    //     ]);
    // }


    // ==================== MÉTODOS PRIVADOS ====================
    private function getDashboardStats()
    {
        // Total de usuarios
        $totalUsuarios = $this->usuarioModel->countAll();

        // Total de productos
        $totalProductos = $this->productoModel->countAll();

        // Productos con cantidad bajo (menos de 10)
        $cantidadBajo = count($this->productoModel->getLowCantidadProducts());

        // Productos sin stock
        $sinStock = count($this->productoModel->getProductosSinStock());

        // Estadísticas de ventas
        $estadisticasVentas = $this->facturaModel->getEstadisticasVentas();
        $totalVentas = $estadisticasVentas['totalVentas'];
        $ingresosTotales = $estadisticasVentas['ingresosTotales'];
        $ventasHoy = $estadisticasVentas['ventasHoy'];

        // Estadísticas de contactos
        $estadisticasContactos = $this->contactoModel->getEstadisticas();

        return [
            'totalUsuarios' => $totalUsuarios,
            'totalProductos' => $totalProductos,
            'cantidadBajo' => $cantidadBajo,
            'sinStock' => $sinStock,
            'totalVentas' => $totalVentas,
            'ingresosTotales' => $ingresosTotales,
            'ventasHoy' => $ventasHoy,
            'contactosNoLeidos' => $estadisticasContactos['no_leidos'],
            'contactosNoRespondidos' => $estadisticasContactos['no_respondidos'],
            'contactosHoy' => $estadisticasContactos['hoy']
        ];
    }

    private function getProductosPorCategoria()
    {
        return $this->categoriaModel->getProductosPorCategoria();
    }


}