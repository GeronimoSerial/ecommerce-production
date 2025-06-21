<?php
namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = "carrito_compras";
    protected $primaryKey = "id_carrito";
    protected $allowedFields = [
        "id_usuario",
        "id_producto",
        "cantidad",
        "precio_unitario",
        "fecha_agregado"
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';

    /**
     * Obtiene todos los productos del carrito de un usuario
     * @param int $usuarioId ID del usuario
     * @return array
     */
    public function getCartByUser($usuarioId)
    {
        $db = \Config\Database::connect();
        return $db->table($this->table . ' c')
                 ->select('c.*, p.nombre, p.descripcion, p.url_imagen, p.cantidad as stock_disponible')
                 ->join('productos p', 'p.id_producto = c.id_producto')
                 ->where('c.id_usuario', $usuarioId)
                 ->where('p.activo', 1)
                 ->get()
                 ->getResultArray();
    }

    /**
     * Verifica si un producto ya existe en el carrito del usuario
     * @param int $usuarioId ID del usuario
     * @param int $productoId ID del producto
     * @return array|null
     */
    public function getCartItem($usuarioId, $productoId)
    {
        return $this->where('id_usuario', $usuarioId)
                   ->where('id_producto', $productoId)
                   ->first();
    }

    /**
     * Agrega un producto al carrito o actualiza la cantidad si ya existe
     * @param int $usuarioId ID del usuario
     * @param int $productoId ID del producto
     * @param int $cantidad Cantidad a agregar
     * @param float $precioUnitario Precio unitario del producto
     * @return bool
     */
    public function addToCart($usuarioId, $productoId, $cantidad, $precioUnitario)
    {
        $item = $this->getCartItem($usuarioId, $productoId);
        
        if ($item) {
            // Producto ya existe, actualizar cantidad
            $nuevaCantidad = $item['cantidad'] + $cantidad;
            return $this->update($item['id_carrito'], [
                'cantidad' => $nuevaCantidad,
                'fecha_agregado' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Producto nuevo, insertar
            return $this->insert([
                'id_usuario' => $usuarioId,
                'id_producto' => $productoId,
                'cantidad' => $cantidad,
                'precio_unitario' => $precioUnitario,
                'fecha_agregado' => date('Y-m-d H:i:s')
            ]);
        }
    }

    /**
     * Actualiza la cantidad de un producto en el carrito
     * @param int $carritoId ID del item del carrito
     * @param int $cantidad Nueva cantidad
     * @return bool
     */
    public function updateQuantity($carritoId, $cantidad)
    {
        if ($cantidad <= 0) {
            return $this->delete($carritoId);
        }
        
        return $this->update($carritoId, [
            'cantidad' => $cantidad,
            'fecha_agregado' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Elimina un producto del carrito
     * @param int $carritoId ID del item del carrito
     * @return bool
     */
    public function removeFromCart($carritoId)
    {
        return $this->delete($carritoId);
    }

    /**
     * Vacía el carrito de un usuario
     * @param int $usuarioId ID del usuario
     * @return bool
     */
    public function clearCart($usuarioId)
    {
        return $this->where('id_usuario', $usuarioId)->delete();
    }

    /**
     * Obtiene el total de items en el carrito de un usuario
     * @param int $usuarioId ID del usuario
     * @return int
     */
    public function getCartItemCount($usuarioId)
    {
        return $this->where('id_usuario', $usuarioId)->countAllResults();
    }

    /**
     * Calcula el subtotal del carrito de un usuario
     * @param int $usuarioId ID del usuario
     * @return float
     */
    public function getCartSubtotal($usuarioId)
    {
        $db = \Config\Database::connect();
        $result = $db->table($this->table)
                    ->select('SUM(cantidad * precio_unitario) as subtotal')
                    ->where('id_usuario', $usuarioId)
                    ->get()
                    ->getRow();
        
        return $result ? (float)$result->subtotal : 0.0;
    }

    /**
     * Verifica si hay stock suficiente para todos los productos en el carrito
     * @param int $usuarioId ID del usuario
     * @return array Array con productos sin stock suficiente
     */
    public function checkStockAvailability($usuarioId)
    {
        $db = \Config\Database::connect();
        $items = $db->table($this->table . ' c')
                   ->select('c.*, p.nombre, p.cantidad as stock_disponible')
                   ->join('productos p', 'p.id_producto = c.id_producto')
                   ->where('c.id_usuario', $usuarioId)
                   ->get()
                   ->getResultArray();

        $sinStock = [];
        foreach ($items as $item) {
            if ($item['cantidad'] > $item['stock_disponible']) {
                $sinStock[] = [
                    'producto' => $item['nombre'],
                    'cantidad_solicitada' => $item['cantidad'],
                    'stock_disponible' => $item['stock_disponible']
                ];
            }
        }

        return $sinStock;
    }

    /**
     * Transfiere productos del carrito de sesión al carrito de base de datos
     * @param int $usuarioId ID del usuario
     * @param array $sessionCart Carrito de sesión
     * @return bool
     */
    public function transferFromSession($usuarioId, $sessionCart)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Primero, limpiar el carrito existente en base de datos
            $this->clearCart($usuarioId);
            
            // Luego, agregar todos los productos del carrito de sesión
            foreach ($sessionCart as $productoId => $item) {
                $this->addToCart($usuarioId, $productoId, $item['cantidad'], $item['precio']);
            }
            
            $db->transCommit();
            return true;
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error al transferir carrito de sesión: ' . $e->getMessage());
            return false;
        }
    }
} 