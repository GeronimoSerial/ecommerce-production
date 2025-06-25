<?php

if (!function_exists('calculate_subtotal')) {
    /**
     * Calcula el subtotal de un array de productos
     * @param array $items Array de productos con cantidad y precio
     * @return float
     */
    function calculate_subtotal($items)
    {
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += ($item['cantidad'] * $item['precio_unitario']);
        }
        return round($subtotal, 2);
    }
}

if (!function_exists('format_currency')) {
    /**
     * Formatea un número como moneda
     * @param float $amount Cantidad a formatear
     * @param string $currency Símbolo de moneda (por defecto $)
     * @return string
     */
    function format_currency($amount, $currency = '$')
    {
        // Formatear con separador de miles (.) y decimales (,)
        return $currency . number_format((float)$amount, 2, ',', '.');
    }
}

if (!function_exists('get_session_cart')) {
    /**
     * Obtiene el carrito de la sesión
     * @return array
     */
    function get_session_cart()
    {
        $session = session();
        return $session->get('cart') ?? [];
    }
}

if (!function_exists('add_to_session_cart')) {
    /**
     * Agrega un producto al carrito de sesión
     * @param int $productoId ID del producto
     * @param int $cantidad Cantidad a agregar
     * @param float $precio Precio unitario
     * @param string $nombre Nombre del producto
     * @param string $imagen URL de la imagen
     * @return bool
     */
    function add_to_session_cart($productoId, $cantidad, $precio, $nombre, $imagen = '')
    {
        $session = session();
        $cart = get_session_cart();

        if (isset($cart[$productoId])) {
            $cart[$productoId]['cantidad'] += $cantidad;
        } else {
            $cart[$productoId] = [
                'cantidad' => $cantidad,
                'precio' => $precio,
                'nombre' => $nombre,
                'imagen' => $imagen
            ];
        }

        $session->set('cart', $cart);
        return true;
    }
}

if (!function_exists('update_session_cart_quantity')) {
    /**
     * Actualiza la cantidad de un producto en el carrito de sesión
     * @param int $productoId ID del producto
     * @param int $cantidad Nueva cantidad
     * @return bool
     */
    function update_session_cart_quantity($productoId, $cantidad)
    {
        $session = session();
        $cart = get_session_cart();

        if (isset($cart[$productoId])) {
            if ($cantidad <= 0) {
                unset($cart[$productoId]);
            } else {
                $cart[$productoId]['cantidad'] = $cantidad;
            }
            $session->set('cart', $cart);
            return true;
        }

        return false;
    }
}

if (!function_exists('remove_from_session_cart')) {
    /**
     * Elimina un producto del carrito de sesión
     * @param int $productoId ID del producto
     * @return bool
     */
    function remove_from_session_cart($productoId)
    {
        $session = session();
        $cart = get_session_cart();

        if (isset($cart[$productoId])) {
            unset($cart[$productoId]);
            $session->set('cart', $cart);
            return true;
        }

        return false;
    }
}

if (!function_exists('clear_session_cart')) {
    /**
     * Vacía el carrito de sesión
     * @return bool
     */
    function clear_session_cart()
    {
        $session = session();
        $session->remove('cart');
        return true;
    }
}

if (!function_exists('get_session_cart_count')) {
    /**
     * Obtiene el número total de items en el carrito de sesión
     * @return int
     */
    function get_session_cart_count()
    {
        $cart = get_session_cart();
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['cantidad'];
        }
        return $count;
    }
}

if (!function_exists('get_session_cart_subtotal')) {
    /**
     * Calcula el subtotal del carrito de sesión
     * @return float
     */
    function get_session_cart_subtotal()
    {
        $cart = get_session_cart();
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['cantidad'] * $item['precio']);
        }
        return round($subtotal, 2);
    }
}

if (!function_exists('validate_cart_item')) {
    /**
     * Valida un item del carrito
     * @param array $item Item del carrito
     * @param int $stockDisponible Stock disponible del producto
     * @return array Array con errores si los hay
     */
    function validate_cart_item($item, $stockDisponible)
    {
        $errors = [];

        if ($item['cantidad'] <= 0) {
            $errors[] = 'La cantidad debe ser mayor a 0';
        }

        if ($item['precio_unitario'] < 0) {
            $errors[] = 'El precio no puede ser negativo';
        }

        if ($item['cantidad'] > $stockDisponible) {
            $errors[] = "Stock insuficiente. Disponible: {$stockDisponible}";
        }

        return $errors;
    }
}