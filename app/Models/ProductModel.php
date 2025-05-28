<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'code', 'name', 'description', 'unit_of_measure',
        'sale_price', 'cost_price', 'initial_lot',
        'category_name', // o 'category_id' si usas la Opción B
        'stock_quantity' // Aunque el stock se manejará por transacciones, podría haber un ajuste inicial
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Si usas category_id y quieres obtener el nombre de la categoría fácilmente:
    // public function findProductsWithCategory($id = null)
    // {
    //     $builder = $this->select('products.*, pc.name as category_name_from_table')
    //                     ->join('product_categories pc', 'pc.id = products.category_id', 'left');
    //     if ($id) {
    //         return $builder->find($id);
    //     }
    //     return $builder->findAll();
    // }
    
}
