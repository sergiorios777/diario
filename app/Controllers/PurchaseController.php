<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PurchaseModel;
use App\Models\PurchaseItemModel;
use App\Models\ProductModel;
// use App\Models\SupplierModel;

class PurchaseController extends AppBaseController
{
    protected $purchaseModel;
    protected $purchaseItemModel;
    protected $productModel;
    protected $supplierModel;
    protected $db; // Para transacciones

    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel();
        $this->purchaseItemModel = new PurchaseItemModel();
        $this->productModel = new ProductModel();
        //$this->supplierModel = new SupplierModel(); // Asumiendo que existe
        $this->db = \Config\Database::connect(); // Conexión a la BD para transacciones
        helper(['form', 'url', 'number']); // Helper number para formato de moneda
    }

    /**
     * RF-MVP-COMP.2: Listar compras
     */
    public function index()
    {
        $data = [
            // Usar el método del modelo que hace join con suppliers si existe
            'purchases' => $this->purchaseModel->getPurchasesWithSupplier() ?? $this->purchaseModel->orderBy('purchase_date', 'DESC')->findAll(),
        ];
        return view('purchases/index', $data);
    }

    /**
     * Mostrar formulario para registrar nueva compra
     */
    public function new()
    {
        $data = [
            'products' => $this->productModel->where('deleted_at IS NULL')->orderBy('name', 'ASC')->findAll(),
            //'suppliers' => $this->supplierModel->orderBy('name', 'ASC')->findAll(), // Asumiendo que existe
            'validation' => \Config\Services::validation()
        ];
        return view('purchases/form', $data);
    }

    /**
     * RF-MVP-COMP.1: Procesar el registro de nueva compra
     */
    public function create()
    {
        // Validación básica para la cabecera de la compra
        $rules = [
            'purchase_date' => 'required|valid_date',
            // 'supplier_id' => 'permit_empty|is_natural_no_zero', // Si usas dropdown de proveedores
            'supplier_name_text' => 'required_without[supplier_id]|permit_empty|max_length[255]', // Si permites texto manual
            'items'          => 'required', // Asegurar que se envíen items
        ];

        // Validación para los items (se hace dentro del bucle por ahora para MVP)
        // En una implementación más robusta, se pueden crear reglas de validación para arrays

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->db->transStart(); // Iniciar transacción

        try {
            $purchaseData = [
                'purchase_date'      => $this->request->getPost('purchase_date'),
                'supplier_id'        => $this->request->getPost('supplier_id') ?: null,
                'supplier_name_text' => $this->request->getPost('supplier_name_text'),
                'reference_no'       => $this->request->getPost('reference_no'),
                'notes'              => $this->request->getPost('notes'),
                'total_amount'       => 0, // Se calculará después
            ];

            $purchaseId = $this->purchaseModel->insert($purchaseData);
            if (!$purchaseId) {
                throw new \Exception('Error al guardar la cabecera de la compra.');
            }

            $items = $this->request->getPost('items'); // Espera un array de items
            $grandTotal = 0;

            if (empty($items)) {
                 throw new \Exception('No se han añadido productos a la compra.');
            }

            foreach ($items as $item) {
                if (empty($item['product_id']) || !isset($item['quantity']) || !isset($item['unit_cost'])) {
                    continue; // Saltar item inválido, o manejar error más estrictamente
                }
                $quantity = (float) $item['quantity'];
                $unitCost = (float) $item['unit_cost'];

                if ($quantity <= 0 || $unitCost < 0) {
                     throw new \Exception('Cantidad o costo unitario inválido para un producto.');
                }


                $subtotal = $quantity * $unitCost;
                $itemData = [
                    'purchase_id' => $purchaseId,
                    'product_id'  => $item['product_id'],
                    'quantity'    => $quantity,
                    'unit_cost'   => $unitCost,
                    'subtotal'    => $subtotal,
                ];
                $this->purchaseItemModel->insert($itemData);
                $grandTotal += $subtotal;

                // Actualizar stock del producto
                $product = $this->productModel->find($item['product_id']);
                if ($product) {
                    $newStock = $product['stock_quantity'] + $quantity;
                    $this->productModel->update($item['product_id'], ['stock_quantity' => $newStock]);
                } else {
                    throw new \Exception('Producto no encontrado para actualizar stock: ID ' . $item['product_id']);
                }
            }
            
            // Actualizar el monto total de la compra
            $this->purchaseModel->update($purchaseId, ['total_amount' => $grandTotal]);

            $this->db->transComplete(); // Completar transacción

            if ($this->db->transStatus() === false) {
                session()->setFlashdata('error', 'Error en la transacción al registrar la compra.');
                return redirect()->back()->withInput();
            }

            session()->setFlashdata('success', 'Compra registrada exitosamente.');
            return redirect()->to('/purchases');

        } catch (\Exception $e) {
            $this->db->transRollback(); // Revertir en caso de error
            session()->setFlashdata('error', 'Error al registrar la compra: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * RF-MVP-COMP.3: Ver detalle de compra
     */
    public function show($id = null)
    {
        $purchase = $this->purchaseModel->getPurchasesWithSupplier($id) ?? $this->purchaseModel->find($id);
        
        if (!$purchase) {
            session()->setFlashdata('error', 'Compra no encontrada.');
            return redirect()->to('/purchases');
        }

        $items = $this->purchaseItemModel->getItemsByPurchaseId($id);

        $data = [
            'purchase' => $purchase,
            'items'    => $items,
        ];
        return view('purchases/show', $data);
    }
}
