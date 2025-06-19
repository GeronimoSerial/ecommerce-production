<?php

namespace System\Commands\Database;

use System\CLI\BaseCommand;
use System\Database\BaseConnection;

class SeedDatabase extends BaseCommand
{
    protected $group = 'Database';
    protected $name = 'db:seed';
    protected $description = 'Poblar la base de datos con datos de ejemplo';

    public function run(array $params)
    {
        $this->cli->write('🌱 Poblando base de datos con datos de ejemplo...', 'green');
        
        try {
            $db = \Config\Database::connect();
            
            // Insertar categorías
            $this->insertCategorias($db);
            
            // Insertar productos
            $this->insertProductos($db);
            
            // Insertar roles
            $this->insertRoles($db);
            
            // Insertar usuario admin
            $this->insertUsuarioAdmin($db);
            
            $this->cli->write('✅ Base de datos poblada exitosamente!', 'green');
            $this->cli->write('📧 Usuario admin: admin@fitsyn.com', 'yellow');
            $this->cli->write('🔑 Contraseña: admin123', 'yellow');
            
        } catch (\Exception $e) {
            $this->cli->write('❌ Error: ' . $e->getMessage(), 'red');
        }
    }

    private function insertCategorias($db)
    {
        $this->cli->write('📂 Insertando categorías...', 'blue');
        
        $categorias = [
            ['nombre' => 'Proteinas', 'descripcion' => 'Suplementos de proteína para el desarrollo muscular y recuperación', 'activo' => 1],
            ['nombre' => 'Creatinas', 'descripcion' => 'Suplementos de creatina para mejorar el rendimiento y fuerza', 'activo' => 1],
            ['nombre' => 'Colagenos', 'descripcion' => 'Suplementos de colágeno para la salud de articulaciones y piel', 'activo' => 1],
            ['nombre' => 'Accesorios', 'descripcion' => 'Accesorios y equipamiento para entrenamiento', 'activo' => 1]
        ];

        foreach ($categorias as $categoria) {
            $db->table('categorias')->insert($categoria);
        }
        
        $this->cli->write('✅ Categorías insertadas', 'green');
    }

    private function insertProductos($db)
    {
        $this->cli->write('📦 Insertando productos...', 'blue');
        
        $productos = [
            // Proteínas
            ['id_categoria' => 1, 'nombre' => 'Whey Protein Isolate', 'descripcion' => 'Proteína de suero aislada de alta pureza, ideal para recuperación muscular post-entrenamiento', 'precio' => 49999, 'cantidad' => 25, 'url_imagen' => 'isolated.webp', 'activo' => 1],
            ['id_categoria' => 1, 'nombre' => 'Whey Protein Concentrate', 'descripcion' => 'Proteína concentrada de suero con excelente perfil de aminoácidos', 'precio' => 39999, 'cantidad' => 30, 'url_imagen' => 'micronizada.webp', 'activo' => 1],
            ['id_categoria' => 1, 'nombre' => 'Caseína Micelar', 'descripcion' => 'Proteína de liberación lenta perfecta para tomar antes de dormir', 'precio' => 44999, 'cantidad' => 15, 'url_imagen' => 'caseina.webp', 'activo' => 1],
            ['id_categoria' => 1, 'nombre' => 'Plant Protein Ultra', 'descripcion' => 'Blend de proteínas vegetales premium para deportistas veganos', 'precio' => 45999, 'cantidad' => 20, 'url_imagen' => 'vegan.webp', 'activo' => 1],
            ['id_categoria' => 1, 'nombre' => 'Mass Gainer Ultra', 'descripcion' => 'Ganador de masa muscular con extra calorías y carbohidratos', 'precio' => 54999, 'cantidad' => 12, 'url_imagen' => 'mass_gainer.webp', 'activo' => 1],
            
            // Creatinas
            ['id_categoria' => 2, 'nombre' => 'Creatina Monohidrato', 'descripcion' => 'Creatina monohidrato pura para aumentar fuerza y masa muscular', 'precio' => 29999, 'cantidad' => 40, 'url_imagen' => 'creatina_monohidrato.webp', 'activo' => 1],
            ['id_categoria' => 2, 'nombre' => 'Creatina HCL', 'descripcion' => 'Creatina hidrocloruro de rápida absorción y sin retención de agua', 'precio' => 34999, 'cantidad' => 35, 'url_imagen' => 'creatina_hcl.webp', 'activo' => 1],
            ['id_categoria' => 2, 'nombre' => 'Creatina Micronizada', 'descripcion' => 'Creatina micronizada para mejor solubilidad y absorción', 'precio' => 27999, 'cantidad' => 28, 'url_imagen' => 'creatina_micronizada.webp', 'activo' => 1],
            ['id_categoria' => 2, 'nombre' => 'Creatina Kre-Alkalyn', 'descripcion' => 'Creatina con pH optimizado para máxima efectividad', 'precio' => 38999, 'cantidad' => 22, 'url_imagen' => 'creatina_kre_alkalyn.webp', 'activo' => 1],
            
            // Colágenos
            ['id_categoria' => 3, 'nombre' => 'Colágeno Hidrolizado', 'descripcion' => 'Colágeno hidrolizado para la salud de articulaciones y piel', 'precio' => 35999, 'cantidad' => 45, 'url_imagen' => 'colageno_hidrolizado.webp', 'activo' => 1],
            ['id_categoria' => 3, 'nombre' => 'Colágeno con Vitamina C', 'descripcion' => 'Colágeno enriquecido con vitamina C para mejor absorción', 'precio' => 39999, 'cantidad' => 38, 'url_imagen' => 'colageno_vitamina_c.webp', 'activo' => 1],
            ['id_categoria' => 3, 'nombre' => 'Colágeno Marino', 'descripcion' => 'Colágeno de pescado de alta biodisponibilidad', 'precio' => 42999, 'cantidad' => 25, 'url_imagen' => 'colageno_marino.webp', 'activo' => 1],
            ['id_categoria' => 3, 'nombre' => 'Colágeno Tipo I y III', 'descripcion' => 'Blend de colágenos para salud articular y cutánea', 'precio' => 37999, 'cantidad' => 32, 'url_imagen' => 'colageno_tipo_1_3.webp', 'activo' => 1],
            
            // Accesorios
            ['id_categoria' => 4, 'nombre' => 'Shaker Pro 600ml', 'descripcion' => 'Shaker profesional de 600ml con bola mezcladora', 'precio' => 15999, 'cantidad' => 60, 'url_imagen' => 'shaker_pro.webp', 'activo' => 1],
            ['id_categoria' => 4, 'nombre' => 'Cinturón de Levantamiento', 'descripcion' => 'Cinturón de cuero para levantamiento de pesas', 'precio' => 29999, 'cantidad' => 18, 'url_imagen' => 'cinturon_levantamiento.webp', 'activo' => 1],
            ['id_categoria' => 4, 'nombre' => 'Guantes de Gimnasio', 'descripcion' => 'Guantes con protección para palmas y muñecas', 'precio' => 12999, 'cantidad' => 45, 'url_imagen' => 'guantes_gimnasio.webp', 'activo' => 1],
            ['id_categoria' => 4, 'nombre' => 'Botella Deportiva 1L', 'descripcion' => 'Botella de agua deportiva con filtro integrado', 'precio' => 8999, 'cantidad' => 80, 'url_imagen' => 'botella_deportiva.webp', 'activo' => 1],
            ['id_categoria' => 4, 'nombre' => 'Bandas de Resistencia', 'descripcion' => 'Set de bandas elásticas para entrenamiento funcional', 'precio' => 19999, 'cantidad' => 35, 'url_imagen' => 'bandas_resistencia.webp', 'activo' => 1]
        ];

        foreach ($productos as $producto) {
            $db->table('productos')->insert($producto);
        }
        
        $this->cli->write('✅ Productos insertados', 'green');
    }

    private function insertRoles($db)
    {
        $this->cli->write('👥 Insertando roles...', 'blue');
        
        $roles = [
            ['nombre' => 'Administrador', 'descripcion' => 'Acceso completo al sistema', 'activo' => 1],
            ['nombre' => 'Cliente', 'descripcion' => 'Usuario regular del ecommerce', 'activo' => 1]
        ];

        foreach ($roles as $rol) {
            $db->table('roles')->insert($rol);
        }
        
        $this->cli->write('✅ Roles insertados', 'green');
    }

    private function insertUsuarioAdmin($db)
    {
        $this->cli->write('👤 Insertando usuario administrador...', 'blue');
        
        // Insertar domicilio
        $domicilioId = $db->table('domicilios')->insert([
            'calle' => 'Av. Principal',
            'numero' => '123',
            'codigo_postal' => '5000',
            'localidad' => 'Córdoba',
            'provincia' => 'Córdoba',
            'pais' => 'Argentina',
            'activo' => 1
        ]);

        // Insertar persona
        $personaId = $db->table('personas')->insert([
            'dni' => '12345678',
            'nombre' => 'Admin',
            'apellido' => 'Sistema',
            'id_domicilio' => $domicilioId,
            'telefono' => '3511234567'
        ]);

        // Insertar usuario
        $db->table('usuarios')->insert([
            'id_persona' => $personaId,
            'id_rol' => 1,
            'email' => 'admin@fitsyn.com',
            'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
            'activo' => 1
        ]);
        
        $this->cli->write('✅ Usuario administrador insertado', 'green');
    }
} 