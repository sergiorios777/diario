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
        $this->validator = \Config\Services::validation(); // Instanciar el servicio aquí
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
        // 1. Obtener los datos del formulario
        $postData = $this->request->getPost();

        // 2. Ejecutar la validación y manejar los errores
        if (!$this->validator->run($postData, 'createProducts')) {
            session()->setFlashdata('error', 'Por favor, corrige los errores del formulario.');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Lógica para generar código si es autogenerado y no viene en $postData['code']
        // ...

        // 3. Guardar el producto
        if ($this->productModel->save($postData)) {
            session()->setFlashdata('success', 'Producto registrado exitosamente.');
            return redirect()->to('/products');
        } else {
            session()->setFlashdata('error', 'No se pudo registrar el producto.');
            return redirect()->back()->withInput()->with('errors', $this->productModel->errors());
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
        // 1. Validar que $id de la URL sea un número entero positivo.
        if (!ctype_digit((string)$id) || (int)$id <= 0) {
            session()->setFlashdata('error', 'El ID del producto es inválido.');
            return redirect()->to('/products');
        }
        
        $product = $this->productModel->find($id);
        if (!$product) {
            session()->setFlashdata('error', 'Producto no encontrado.');
            return redirect()->to('/products');
        }

        $postData = $this->request->getPost();
        
        // === PREPARACIÓN DE DATOS PARA VALIDACIÓN ===
        // Creamos un array con los datos del POST y añadimos el 'id' del producto actual.
        // Este 'id' será usado por la regla 'is_unique' para el campo 'code' (el placeholder {id})
        // y también será validado por su propia regla 'permit_empty|is_natural_no_zero' definida en el modelo.
        $dataForValidation = $postData;
        $dataForValidation['id'] = $id; 

        // Ejecutar la validación y manejar los errores
        if (!$this->validator->run($dataForValidation, 'updateProducts')) {
            session()->setFlashdata('error', 'Por favor, corrige los errores del formulario.');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Si la validación pasa, procedemos a actualizar usando solo los datos del POST.
        // El modelo se encargará de los $allowedFields.
        if ($this->productModel->update($id, $postData)) {
            session()->setFlashdata('success', 'Producto actualizado exitosamente.');
            return redirect()->to('/products');
        } else {
            session()->setFlashdata('error', 'No se pudo actualizar el producto.');
            return redirect()->back()->withInput()->with('errors', $this->productModel->errors());
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
