<?php

namespace App\Controllers;

use App\Controllers\AppBaseController;
//use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;

class ProductController extends AppBaseController
{
    protected $productModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
        helper(['form', 'url']);    // Carga helpers
    }
    /**
     * RF-MVP-PROD.2: Listar productos
     */
    public function index()
    {
        $data = [
            // Si usas el join en el modelo:
            // 'products' => $this->productModel->findProductsWithCategory(),
            // Si no, o para DataTables server-side, puedes pasar solo el título
            // y DataTables hará la petición AJAX. Para MVP client-side:
            'products' => $this->productModel->findAll(), // Muestra también los eliminados (soft) si no se filtra
            // 'products' => $this->productModel->where('deleted_at IS NULL')->findAll(), // Solo activos
        ];
        return view('products/index', $data);
    }

    /**
     * RF-MVP-PROD.1: Mostrar formulario para registrar nuevo producto
     */
    public function new()
    {
        $data = [
            'validation' => \Config\Services::validation(),
            // 'categories' => $this->categoryModel->findAll() // Descomenta si usas tabla de categorías
        ];
        return view('products/form', $data);
    }

    /**
     * RF-MVP-PROD.1: Procesar el registro de nuevo producto
     */
    public function create()
    {
        $validationRules = $this->productModel->getValidationRules();
        // Para el código, si es manual, 'required' es suficiente.
        // Si es autogenerado simple, puedes quitar 'required' y generarlo aquí antes de insertar.
        // Ejemplo simple de código autogenerado (no robusto para alta concurrencia):
        // $lastProduct = $this->productModel->orderBy('id', 'DESC')->first();
        // $nextId = $lastProduct ? ((int) substr($lastProduct['code'], 4)) + 1 : 1;
        // $productCode = 'PROD' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $dataToSave = [
            'code'            => $this->request->getPost('code'), // o $productCode si es autogenerado
            'name'            => $this->request->getPost('name'),
            'description'     => $this->request->getPost('description'),
            'unit_of_measure' => $this->request->getPost('unit_of_measure'),
            'sale_price'      => $this->request->getPost('sale_price'),
            'cost_price'      => $this->request->getPost('cost_price'),
            'initial_lot'     => $this->request->getPost('initial_lot'),
            'category_name'   => $this->request->getPost('category_name'), // o 'category_id'
            // 'stock_quantity' => 0, // Se inicializa por defecto o con la primera compra
        ];
        
        if (!$this->validate($validationRules)) {
            session()->setFlashdata('error', 'Por favor, corrige los errores del formulario.');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($this->productModel->save($dataToSave)) {
            session()->setFlashdata('success', 'Producto registrado exitosamente.');
            return redirect()->to('/products');
        } else {
            session()->setFlashdata('error', 'No se pudo registrar el producto.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * RF-MVP-PROD.3: Mostrar formulario para editar producto existente
     */
    public function edit($id = null)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            session()->setFlashdata('error', 'Producto no encontrado.');
            return redirect()->to('/products');
        }

        $data = [
            'product'    => $product,
            'validation' => \Config\Services::validation(),
            // 'categories' => $this->categoryModel->findAll() // Descomenta
        ];
        return view('products/form', $data);
    }

    /**
     * RF-MVP-PROD.3: Procesar la actualización de un producto
     */
    public function update($id = null)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            session()->setFlashdata('error', 'Producto no encontrado.');
            return redirect()->to('/products');
        }

        // Ajusta las reglas de validación para 'is_unique' en la actualización
        $validationRules = $this->productModel->getValidationRules(['id' => $id]);
        
        $dataToUpdate = [
            'id'              => $id, // Necesario para la validación de is_unique
            'code'            => $this->request->getPost('code'),
            'name'            => $this->request->getPost('name'),
            'description'     => $this->request->getPost('description'),
            'unit_of_measure' => $this->request->getPost('unit_of_measure'),
            'sale_price'      => $this->request->getPost('sale_price'),
            'cost_price'      => $this->request->getPost('cost_price'),
            'initial_lot'     => $this->request->getPost('initial_lot'),
            'category_name'   => $this->request->getPost('category_name'), // o 'category_id'
        ];

        if (!$this->validate($validationRules)) {
            session()->setFlashdata('error', 'Por favor, corrige los errores del formulario.');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($this->productModel->save($dataToUpdate)) {
            session()->setFlashdata('success', 'Producto actualizado exitosamente.');
            return redirect()->to('/products');
        } else {
            session()->setFlashdata('error', 'No se pudo actualizar el producto.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * RF-MVP-PROD.4: Eliminar (soft delete) un producto
     */
    public function delete($id = null)
    {
        // Para MVP, validación simple. En fases futuras, verificar transacciones asociadas.
        if ($this->productModel->delete($id)) {
            session()->setFlashdata('success', 'Producto eliminado (movido a la papelera) exitosamente.');
        } else {
            session()->setFlashdata('error', 'No se pudo eliminar el producto.');
        }
        return redirect()->to('/products');
    }

    /**
     * RF-MVP-PROD.5: Restaurar un producto eliminado (soft delete)
     */
    public function restore($id = null)
    {
        if ($this->productModel->restore($id)) {
            session()->setFlashdata('success', 'Producto restaurado exitosamente.');
        } else {
            session()->setFlashdata('error', 'No se pudo restaurar el producto.');
        }
        return redirect()->to('/products');
    }

    // Para utilizar DataTables server-side, se requeire un método ajax
    public function ajaxList()
    {
        // Aquí puedes implementar la lógica para DataTables server-side
        // Por ejemplo, obtener los datos filtrados y paginados
        $products = $this->productModel->findProductsWithCategory();
        return $this->response->setJSON($products);
    }

}
