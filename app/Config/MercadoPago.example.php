<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Archivo de ejemplo para configuración de MercadoPago
 * 
 * Copia este archivo como MercadoPago.php y actualiza las credenciales
 */

class MercadoPago extends BaseConfig
{
    /**
     * Access Token de MercadoPago
     * 
     * Para obtener tus credenciales:
     * 1. Ve a https://www.mercadopago.com.ar/developers
     * 2. Inicia sesión en tu cuenta
     * 3. Ve a "Tus integraciones" > "Credenciales"
     * 4. Copia el Access Token
     * 
     * Para pruebas usa: TEST-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
     * Para producción usa: APP-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
     */
    public $accessToken = 'TEST-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

    /**
     * Public Key de MercadoPago
     * 
     * Para pruebas usa: TEST-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
     * Para producción usa: APP-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
     */
    public $publicKey = 'TEST-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';

    /**
     * Moneda por defecto
     * 
     * Opciones disponibles:
     * - ARS (Pesos Argentinos)
     * - USD (Dólares Estadounidenses)
     * - BRL (Reales Brasileños)
     * - CLP (Pesos Chilenos)
     * - COP (Pesos Colombianos)
     * - MXN (Pesos Mexicanos)
     * - PEN (Soles Peruanos)
     * - UYU (Pesos Uruguayos)
     */
    public $currency = 'ARS';

    /**
     * URLs de retorno
     * 
     * Estas URLs se usan para redirigir al usuario después del pago
     */
    public $backUrls = [
        'success' => 'mercadopago/success',
        'failure' => 'mercadopago/failure',
        'pending' => 'mercadopago/pending'
    ];

    /**
     * URL del webhook
     * 
     * Esta URL debe ser accesible desde internet para recibir notificaciones
     * Configúrala en tu panel de MercadoPago
     */
    public $webhookUrl = 'mercadopago/webhook';

    /**
     * Tiempo de expiración de la preferencia (en horas)
     * 
     * Después de este tiempo, la preferencia expirará y el usuario
     * no podrá completar el pago
     */
    public $expirationHours = 1;

    /**
     * Configuración de notificaciones
     */
    public $notifications = [
        'enabled' => true,
        'email' => 'admin@tudominio.com'
    ];

    /**
     * Configuración de descuentos
     */
    public $discounts = [
        'enabled' => false,
        'percentage' => 0.0
    ];

    /**
     * Configuración de envío
     */
    public $shipping = [
        'enabled' => false,
        'cost' => 0.0
    ];

    /**
     * Configuración de cuotas
     * 
     * Si habilitas las cuotas, los usuarios podrán pagar en cuotas
     */
    public $installments = [
        'enabled' => true,
        'max' => 12
    ];

    /**
     * Configuración de métodos de pago excluidos
     * 
     * Lista de métodos de pago que no quieres aceptar
     * Ejemplo: ['visa', 'mastercard']
     */
    public $excludedPaymentMethods = [];

    /**
     * Configuración de tipos de pago excluidos
     * 
     * Lista de tipos de pago que no quieres aceptar
     * Ejemplo: ['credit_card', 'debit_card']
     */
    public $excludedPaymentTypes = [];

    /**
     * Configuración de financiación
     */
    public $financing = [
        'enabled' => true,
        'max_installments' => 12
    ];

    /**
     * Configuración de binarios
     * 
     * Para validaciones específicas de tarjetas
     */
    public $binaries = [
        'enabled' => false,
        'card_number' => ''
    ];

    /**
     * Configuración de expiración automática
     * 
     * 'approved': Retorna automáticamente cuando el pago es aprobado
     * 'all': Retorna automáticamente para cualquier estado
     */
    public $autoReturn = 'approved';

    /**
     * Configuración de expiración
     */
    public $expires = true;

    /**
     * Configuración de fecha de expiración
     */
    public function getExpirationDate()
    {
        return date('Y-m-d\TH:i:s.000-03:00', strtotime('+' . $this->expirationHours . ' hour'));
    }

    /**
     * Obtiene la URL completa para una ruta
     */
    public function getFullUrl($route)
    {
        return base_url($route);
    }

    /**
     * Obtiene las URLs de retorno completas
     */
    public function getBackUrls()
    {
        $urls = [];
        foreach ($this->backUrls as $key => $route) {
            $urls[$key] = $this->getFullUrl($route);
        }
        return $urls;
    }

    /**
     * Obtiene la URL del webhook completa
     */
    public function getWebhookUrl()
    {
        return $this->getFullUrl($this->webhookUrl);
    }
} 