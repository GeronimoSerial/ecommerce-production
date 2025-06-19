<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\ProductoModel;
use App\Models\CategoriaModel;
use App\Models\PersonaModel;

class AdminController extends BaseController
{
    protected $usuarioModel;
    protected $productoModel;
    protected $categoriaModel;
    protected $personaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->productoModel = new ProductoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->personaModel = new PersonaModel();
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
        $session = session();
        if (!$session->get('logueado') || $session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $request = \Config\Services::request();
        $page = (int) $request->getGet('page') ?: 1;
        $orden = $request->getGet('orden') ?: 'nombre';
        $direccion = $request->getGet('direccion') ?: 'ASC';
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $productos = $this->productoModel->getAllProductsWithCategories($orden, $direccion, $limit, $offset);
        $totalProductos = $this->productoModel->countAllProductsWithCategories();
        $totalPaginas = (int) ceil($totalProductos / $limit);
        $stockBajo = count($this->productoModel->getLowCantidadProducts());
        $cantActivos = $this->productoModel->countActiveProducts();


        // Calcular el valor total de todos los productos (precio * cantidad)

        $valorTotal = $this->productoModel->getAllProductsValue();

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
                'cantActivos' => $cantActivos
            ])
        ]);
    }

    public function crearProducto()
    {
        $session = session();
        if (!$session->get('logueado') || $session->get('id_rol') != 1) {
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
                    $session->setFlashdata('msg', 'Producto creado exitosamente');
                    return redirect()->to('/admin/inventario');
                } else {
                    $session->setFlashdata('error', 'Error al crear el producto');
                }
            } else {
                $session->setFlashdata('error', 'Por favor corrige los errores en el formulario');
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
        $session = session();
        if (!$session->get('logueado') || $session->get('id_rol') != 1) {
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
                'id_categoria' => 'required|integer'
            ];

            if ($this->validate($rules)) {
                $data = [
                    'nombre' => $this->request->getPost('nombre'),
                    'descripcion' => $this->request->getPost('descripcion'),
                    'precio' => $this->request->getPost('precio'),
                    'cantidad' => $this->request->getPost('cantidad'),
                    'id_categoria' => $this->request->getPost('id_categoria')
                ];

                // if ($this->request->getPost('imagen')) {
                //     $data['url_imagen'] = $this->request->getPost('imagen');
                // }

                $imagen = $this->request->getPost('imagen');
                if (!empty($imagen)) {
                    $data['url_imagen'] = $imagen;
                } else {
                    // Mantener la imagen actual si no se proporciona una nueva
                    $data['url_imagen'] = $producto['url_imagen'];
                }

                if ($this->productoModel->update($id, $data)) {
                    $session->setFlashdata('msg', 'Producto actualizado exitosamente');
                    return redirect()->to('/admin/inventario');
                } else {
                    $session->setFlashdata('error', 'Error al actualizar el producto');
                }
            } else {
                $session->setFlashdata('error', 'Por favor corrige los errores en el formulario');
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
        $session = session();
        if (!$session->get('logueado') || $session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        if ($this->productoModel->delete($id)) {
            $session->setFlashdata('msg', 'Producto eliminado exitosamente');
        } else {
            $session->setFlashdata('error', 'Error al eliminar el producto');
        }

        return redirect()->to('/admin/inventario');
    }

    // ==================== REPORTES Y ESTADÍSTICAS ====================
    public function reportes()
    {
        $session = session();
        if (!$session->get('logueado') || $session->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        $stats = $this->getDashboardStats();
        $productosPorCategoria = $this->getProductosPorCategoria();
        $usuariosPorMes = $this->getUsuariosPorMes();

        return view('templates/main_layout', [
            'title' => 'Reportes y Estadísticas',
            'content' => view('back/admin/reportes/index', [
                'stats' => $stats,
                'productosPorCategoria' => $productosPorCategoria,
                'usuariosPorMes' => $usuariosPorMes
            ])
        ]);
    }

    // ==================== MÉTODOS PRIVADOS ====================
    private function getDashboardStats()
    {
        $db = \Config\Database::connect();

        // Total de usuarios
        $totalUsuarios = $db->table('usuarios')->countAllResults();

        // Total de productos
        $totalProductos = $db->table('productos')->countAllResults();

        // Productos con cantidad bajo (menos de 10)
        $cantidadBajo = $db->table('productos')->where('cantidad <', 10)->countAllResults();

        // Usuarios registrados este mes (si no hay fecha_creacion, mostrar 0)
        $usuariosEsteMes = 0;

        return [
            'totalUsuarios' => $totalUsuarios,
            'totalProductos' => $totalProductos,
            'cantidadBajo' => $cantidadBajo,
            'usuariosEsteMes' => $usuariosEsteMes
        ];
    }

    private function getProductosPorCategoria()
    {
        $db = \Config\Database::connect();

        return $db->table('productos p')
            ->select('c.nombre as categoria, COUNT(*) as total')
            ->join('categorias c', 'c.id_categoria = p.id_categoria')
            ->groupBy('p.id_categoria')
            ->get()
            ->getResultArray();
    }

    private function getUsuariosPorMes()
    {
        // Como no hay fecha_creacion, retornamos array vacío
        return [];
    }
}