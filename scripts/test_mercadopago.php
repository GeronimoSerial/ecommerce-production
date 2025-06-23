<?php

/**
 * Script de prueba para verificar la integración de MercadoPago
 * 
 * Uso: php scripts/test_mercadopago.php
 */

// Cargar el framework de CodeIgniter
require_once __DIR__ . '/../system/bootstrap.php';

use App\Models\PagoModel;
use App\Models\CartModel;
use App\Models\ProductoModel;
use App\Models\FacturaModel;
use App\Models\DetallesFacturaModel;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

class MercadoPagoTest
{
    private $pagoModel;
    private $cartModel;
    private $productoModel;
    private $facturaModel;
    private $detallesFacturaModel;
    private $preferenceClient;
    private $paymentClient;

    public function __construct()
    {
        // Inicializar modelos
        $this->pagoModel = new PagoModel();
        $this->cartModel = new CartModel();
        $this->productoModel = new ProductoModel();
        $this->facturaModel = new FacturaModel();
        $this->detallesFacturaModel = new DetallesFacturaModel();

        // Configurar MercadoPago
        $this->configureMercadoPago();
    }

    private function configureMercadoPago()
    {
        // Usar credenciales de prueba
        MercadoPagoConfig::setAccessToken('TEST-1234567890123456789012345678901234567890');
        
        // Configurar el entorno de runtime
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::SERVER);
        
        $this->preferenceClient = new PreferenceClient();
        $this->paymentClient = new PaymentClient();
    }

    /**
     * Prueba la conexión con MercadoPago
     */
    public function testConnection()
    {
        echo "🔍 Probando conexión con MercadoPago...\n";
        
        try {
            // Intentar crear una preferencia de prueba usando arrays (SDK v3.x)
            $preference = [
                'items' => [
                    [
                        'title' => 'Producto de Prueba',
                        'quantity' => 1,
                        'unit_price' => 100.0,
                        'currency_id' => 'ARS'
                    ]
                ],
                'external_reference' => 'TEST-' . time(),
                'expires' => false
            ];

            $response = $this->preferenceClient->create($preference);
            
            if (isset($response->id)) {
                echo "✅ Conexión exitosa. Preferencia creada con ID: {$response->id}\n";
                return true;
            } else {
                echo "❌ Error: No se pudo crear la preferencia\n";
                return false;
            }
        } catch (\Exception $e) {
            echo "❌ Error de conexión: " . $e->getMessage() . "\n";
            return false;
        }
    }

    /**
     * Prueba la tabla de pagos
     */
    public function testPagosTable()
    {
        echo "\n🔍 Probando tabla de pagos...\n";
        
        try {
            // Verificar si la tabla existe
            $db = \Config\Database::connect();
            $tables = $db->listTables();
            
            if (in_array('pagos', $tables)) {
                echo "✅ Tabla 'pagos' existe\n";
                
                // Probar inserción
                $testData = [
                    'payment_id' => 123456789,
                    'status' => 'test',
                    'detail' => json_encode(['test' => true])
                ];
                
                $result = $this->pagoModel->insert($testData);
                
                if ($result) {
                    echo "✅ Inserción en tabla 'pagos' exitosa\n";
                    
                    // Limpiar datos de prueba
                    $this->pagoModel->where('payment_id', 123456789)->delete();
                    echo "✅ Datos de prueba limpiados\n";
                    
                    return true;
                } else {
                    echo "❌ Error al insertar en tabla 'pagos'\n";
                    return false;
                }
            } else {
                echo "❌ Tabla 'pagos' no existe. Ejecuta la migración primero.\n";
                return false;
            }
        } catch (\Exception $e) {
            echo "❌ Error en tabla de pagos: " . $e->getMessage() . "\n";
            return false;
        }
    }

    /**
     * Prueba la creación de una preferencia completa
     */
    public function testPreferenceCreation()
    {
        echo "\n🔍 Probando creación de preferencia completa...\n";
        
        try {
            // Simular datos de carrito
            $cartItems = [
                [
                    'nombre' => 'Producto 1',
                    'cantidad' => 2,
                    'precio_unitario' => 150.0
                ],
                [
                    'nombre' => 'Producto 2',
                    'cantidad' => 1,
                    'precio_unitario' => 200.0
                ]
            ];

            // Crear items para MercadoPago
            $items = [];
            foreach ($cartItems as $item) {
                $items[] = [
                    'title' => $item['nombre'],
                    'quantity' => $item['cantidad'],
                    'unit_price' => (float) $item['precio_unitario'],
                    'currency_id' => 'ARS'
                ];
            }

            // Crear preferencia usando arrays (SDK v3.x)
            $preference = [
                'items' => $items,
                'external_reference' => 'TEST-' . time(),
                'notification_url' => 'https://tudominio.com/mercadopago/webhook',
                'back_urls' => [
                    'success' => 'https://tudominio.com/mercadopago/success',
                    'failure' => 'https://tudominio.com/mercadopago/failure',
                    'pending' => 'https://tudominio.com/mercadopago/pending'
                ],
                'auto_return' => 'approved',
                'expires' => true,
                'expiration_date_to' => date('Y-m-d\TH:i:s.000-03:00', strtotime('+1 hour'))
            ];

            $response = $this->preferenceClient->create($preference);

            if (isset($response->id)) {
                echo "✅ Preferencia creada exitosamente\n";
                echo "   ID: {$response->id}\n";
                echo "   Total: ARS " . array_sum(array_column($items, 'unit_price')) . "\n";
                echo "   Items: " . count($items) . "\n";
                echo "   URL de pago: {$response->init_point}\n";
                
                return true;
            } else {
                echo "❌ Error al crear preferencia\n";
                return false;
            }
        } catch (\Exception $e) {
            echo "❌ Error en creación de preferencia: " . $e->getMessage() . "\n";
            return false;
        }
    }

    /**
     * Prueba el modelo de pagos
     */
    public function testPagoModel()
    {
        echo "\n🔍 Probando modelo de pagos...\n";
        
        try {
            // Probar guardar pago
            $paymentId = 987654321;
            $status = 'pending';
            $detail = [
                'preference_id' => 'test-pref-123',
                'external_reference' => 'test-ref-456',
                'total_amount' => 500.0,
                'items_count' => 3,
                'currency' => 'ARS'
            ];

            $result = $this->pagoModel->savePayment($paymentId, $status, $detail);
            
            if ($result) {
                echo "✅ Pago guardado exitosamente\n";
                
                // Probar obtener pago
                $pago = $this->pagoModel->getByPaymentId($paymentId);
                if ($pago) {
                    echo "✅ Pago recuperado exitosamente\n";
                    echo "   Status: {$pago['status']}\n";
                    echo "   Detail: " . json_encode(json_decode($pago['detail'])) . "\n";
                }
                
                // Probar actualizar pago
                $updateResult = $this->pagoModel->updatePaymentStatus($paymentId, 'approved');
                if ($updateResult) {
                    echo "✅ Pago actualizado exitosamente\n";
                }
                
                // Limpiar datos de prueba
                $this->pagoModel->where('payment_id', $paymentId)->delete();
                echo "✅ Datos de prueba limpiados\n";
                
                return true;
            } else {
                echo "❌ Error al guardar pago\n";
                return false;
            }
        } catch (\Exception $e) {
            echo "❌ Error en modelo de pagos: " . $e->getMessage() . "\n";
            return false;
        }
    }

    /**
     * Ejecuta todas las pruebas
     */
    public function runAllTests()
    {
        echo "🚀 Iniciando pruebas de integración de MercadoPago\n";
        echo "================================================\n\n";

        $tests = [
            'Conexión con MercadoPago' => [$this, 'testConnection'],
            'Tabla de pagos' => [$this, 'testPagosTable'],
            'Creación de preferencia' => [$this, 'testPreferenceCreation'],
            'Modelo de pagos' => [$this, 'testPagoModel']
        ];

        $results = [];
        
        foreach ($tests as $testName => $testMethod) {
            echo "📋 Ejecutando: {$testName}\n";
            $results[$testName] = call_user_func($testMethod);
            echo "\n";
        }

        // Resumen de resultados
        echo "📊 RESUMEN DE PRUEBAS\n";
        echo "=====================\n";
        
        $passed = 0;
        $total = count($results);
        
        foreach ($results as $testName => $result) {
            $status = $result ? "✅ PASÓ" : "❌ FALLÓ";
            echo "{$status} - {$testName}\n";
            if ($result) $passed++;
        }
        
        echo "\n";
        echo "Resultado final: {$passed}/{$total} pruebas pasaron\n";
        
        if ($passed === $total) {
            echo "🎉 ¡Todas las pruebas pasaron! La integración está funcionando correctamente.\n";
        } else {
            echo "⚠️  Algunas pruebas fallaron. Revisa los errores arriba.\n";
        }
    }
}

// Ejecutar pruebas
if (php_sapi_name() === 'cli') {
    $test = new MercadoPagoTest();
    $test->runAllTests();
} else {
    echo "Este script debe ejecutarse desde la línea de comandos.\n";
    echo "Uso: php scripts/test_mercadopago.php\n";
} 