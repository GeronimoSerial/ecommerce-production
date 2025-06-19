# Solución para Problemas de Concatenación de URLs

## Problemas Identificados

### 1. Función `generate_sort_links`

- **Problema**: La función estaba usando `site_url()` sobre URLs que ya podían contener parámetros, causando concatenación incorrecta.
- **Ejemplo**: `site_url('productos/buscar?q=test')` resultaba en URLs malformadas.

### 2. Navbar Search

- **Problema**: La lógica para determinar la URL base del buscador podía causar problemas de concatenación.
- **Ejemplo**: Diferentes rutas base según la página actual.
- **Problema Específico**: Cuando se estaba en `/categoria/productos`, `site_url('productos/buscar')` generaba `/categoria/productos/productos/buscar`.

### 3. Vista de búsqueda

- **Problema**: Usaba `site_url(uri_string())` que podía causar concatenación.

## Soluciones Implementadas

### 1. Nueva Función Helper: `clean_url_for_params()`

```php
function clean_url_for_params($url)
{
    // Si la URL está vacía, usar la URL actual
    if (empty($url)) {
        $url = current_url();
    }

    // Si la URL ya tiene parámetros, extraer solo la ruta
    if (strpos($url, '?') !== false) {
        $url = explode('?', $url)[0];
    }

    // Si la URL no es válida, usar la URL actual
    if (!filter_var($url, FILTER_VALIDATE_URL) && !str_starts_with($url, '/')) {
        $url = current_url();
        if (strpos($url, '?') !== false) {
            $url = explode('?', $url)[0];
        }
    }

    return $url;
}
```

### 2. Función `generate_sort_links` Mejorada

```php
// Antes
$url = site_url($cleanUrl) . '?' . http_build_query($params);

// Después
$cleanUrl = clean_url_for_params($baseUrl);
$url = $cleanUrl . '?' . http_build_query($params);
```

### 3. Función `generate_pagination` Mejorada

```php
// Al inicio de la función
$baseUrl = clean_url_for_params($baseUrl);
```

### 4. Navbar Search Corregido (SOLUCIÓN FINAL)

```php
// Antes (problemático)
if (strpos($currentPath, 'productos') !== false) {
    $buscarBase = site_url('productos/buscar');
} else {
    $buscarBase = site_url('productos/buscar');
}

// Después (solución final)
$buscarBase = site_url('/productos/buscar');
```

**Explicación**: El slash inicial `/` en `site_url('/productos/buscar')` asegura que la URL se construya desde la raíz del sitio, evitando la concatenación con la ruta actual.

### 5. Búsquedas Populares Mejoradas (NUEVA SOLUCIÓN)

```php
// Antes (problemático - enlaces que causaban concatenación)
<a href="<?= $buscarBase . '?q=whey' ?>" class="badge">Whey Protein</a>

// Después (solución con JavaScript)
<button type="button" onclick="setSearchTerm('whey')" class="badge">Whey Protein</button>
```

**Explicación**: Reemplazamos los enlaces con botones JavaScript que colocan el término de búsqueda en el campo de entrada automáticamente, evitando completamente los problemas de concatenación de URLs.

#### Funciones JavaScript Implementadas:

```javascript
// Función para establecer el término de búsqueda
function setSearchTerm(term) {
    const searchInput = document.getElementById('searchInput');
    searchInput.value = term;
    searchInput.focus();
    mostrarNotificacion(`Búsqueda configurada: "${term}"`, 'info');
}

// Función para manejar la búsqueda con Enter
function handleSearchSubmit(event) {
    const searchInput = document.getElementById('searchInput');
    const searchTerm = searchInput.value.trim();

    if (searchTerm) {
        const searchUrl = '<?= site_url('/productos/buscar') ?>?q=' + encodeURIComponent(searchTerm);
        window.location.href = searchUrl;
    }
}
```

**Beneficios de esta solución:**

- ✅ No hay concatenación de URLs
- ✅ Mejor experiencia de usuario (focus automático)
- ✅ Notificaciones informativas
- ✅ Soporte para Enter para buscar
- ✅ URLs construidas de manera segura con `encodeURIComponent()`

### 6. Vista de búsqueda corregida

```php
// Antes
<?= generate_sort_links($filtros, site_url(uri_string())) ?>

// Después
<?= generate_sort_links($filtros, current_url()) ?>
```

## Archivos Modificados

1. **`app/Helpers/pagination_helper.php`**

   - Agregada función `clean_url_for_params()`
   - Mejorada función `generate_sort_links()`
   - Mejorada función `generate_pagination()`

2. **`app/Views/front/navbar_view.php`**

   - **SOLUCIÓN FINAL**: Usar `site_url('/productos/buscar')` con slash inicial

3. **`app/Views/pages/productos/busqueda.php`**

   - Cambiado `site_url(uri_string())` por `current_url()`

4. **`scripts/test_urls.php`**
   - Script de prueba para verificar URLs

## Beneficios

1. **URLs Consistentes**: Todas las URLs generadas son consistentes y válidas
2. **Sin Concatenación Incorrecta**: Se evita la duplicación de parámetros
3. **Mantenibilidad**: Código más limpio y fácil de mantener
4. **Robustez**: Manejo de casos edge como URLs vacías o inválidas
5. **Solución Definitiva**: El slash inicial en `site_url('/ruta')` resuelve el problema de concatenación

## Regla Importante

**Siempre usar `site_url('/ruta')` con slash inicial para rutas absolutas desde la raíz del sitio.**

- ✅ `site_url('/productos/buscar')` - Correcto
- ❌ `site_url('productos/buscar')` - Puede causar concatenación

## Testing

Para verificar que las correcciones funcionan:

1. Navegar a una página de categoría (ej: `/categoria/productos`)
2. Usar el buscador del navbar
3. Verificar que la URL sea: `http://localhost/ecommerce/productos/buscar?q=busqueda`
4. NO debe ser: `http://localhost/ecommerce/categoria/productos/productos/buscar?q=busqueda`

## Casos de Prueba

- ✅ Desde `/` → `/productos/buscar`
- ✅ Desde `/categoria/proteinas` → `/productos/buscar`
- ✅ Desde `/categoria/productos` → `/productos/buscar`
- ✅ Desde `/productos/buscar` → `/productos/buscar`
- ✅ Desde `/admin/inventario` → `/productos/buscar`
