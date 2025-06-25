<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class MercadoPago extends BaseConfig
{
    /**
     * Access Token de MercadoPago
     * Para pruebas usa: TEST-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
     * Para producción usa: APP-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
     */
    public $accessToken = 'APP_USR-3556562727757957-062120-0ecd065f4164bd93e7bc6df5b93f4db5-2512558186';

    /**
     * Public Key de MercadoPago
     * Para pruebas usa: TEST-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
     * Para producción usa: APP-xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
     */
    public $publicKey = 'APP_USR-511d71fb-05d5-4965-b215-07f40ce0a7de';

    /**
     * Moneda por defecto
     */
    public $currency = 'ARS';

    /**
     * URLs de retorno
     */
    public $backUrls = [
        'success' => 'mercadopago/success',
        'failure' => 'mercadopago/failure',
        'pending' => 'mercadopago/pending'
    ];

    /**
     * URL del webhook
     */
    public $webhookUrl = 'mercadopago/webhook';

    /**
     * Tiempo de expiración de la preferencia (en horas)
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
     */
    public $installments = [
        'enabled' => true,
        'max' => 12
    ];

    /**
     * Configuración de métodos de pago excluidos
     */
    public $excludedPaymentMethods = [];

    /**
     * Configuración de tipos de pago excluidos
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
     */
    public $binaries = [
        'enabled' => false,
        'card_number' => ''
    ];

    /**
     * Configuración de expiración automática
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