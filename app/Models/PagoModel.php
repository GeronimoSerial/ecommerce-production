<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['payment_id', 'status', 'detail'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = false;
    protected $deletedField = false;

    // Validation
    protected $validationRules = [
        'payment_id' => 'required|numeric',
        'status' => 'required|max_length[50]',
        'detail' => 'required'
    ];

    protected $validationMessages = [
        'payment_id' => [
            'required' => 'El ID de pago es requerido',
            'numeric' => 'El ID de pago debe ser numérico'
        ],
        'status' => [
            'required' => 'El estado del pago es requerido',
            'max_length' => 'El estado no puede exceder 50 caracteres'
        ],
        'detail' => [
            'required' => 'Los detalles del pago son requeridos'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Guarda un nuevo pago
     */
    public function savePayment($paymentId, $status, $detail)
    {
        $data = [
            'payment_id' => $paymentId,
            'status' => $status,
            'detail' => json_encode($detail)
        ];

        return $this->insert($data);
    }

    /**
     * Actualiza el estado de un pago
     */
    public function updatePaymentStatus($paymentId, $status, $detail = null)
    {
        $data = ['status' => $status];
        
        if ($detail !== null) {
            $data['detail'] = json_encode($detail);
        }

        return $this->where('payment_id', $paymentId)->set($data)->update();
    }

    /**
     * Obtiene un pago por payment_id
     */
    public function getByPaymentId($paymentId)
    {
        return $this->where('payment_id', $paymentId)->first();
    }

    /**
     * Obtiene todos los pagos de un usuario
     */
    public function getPaymentsByUser($userId)
    {
        return $this->select('pagos.*, facturas.importe_total, facturas.id as factura_id')
                    ->join('facturas', 'facturas.id = JSON_EXTRACT(pagos.detail, "$.external_reference")')
                    ->where('facturas.id_usuario', $userId)
                    ->orderBy('pagos.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Obtiene pagos por estado
     */
    public function getPaymentsByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }
} 