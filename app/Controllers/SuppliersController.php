<?php

namespace App\Controllers;

use App\Controllers\AppBaseController;
use App\Models\SupplierModel;
use App\Entities\Supplier;
use CodeIgniter\Exceptions\PageNotFoundException;


class SuppliersController extends AppBaseController
{
    protected $supplierModel;
    protected $helpers = ['form', 'url']; // Cargar helpers

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
        // Aquí podrías verificar permisos con Shield si es necesario
        // Ejemplo: if (!auth()->user()->can('suppliers.access')) { throw PageNotFoundException::forPageNotFound(); }
    }
    
    /**
     * RF-MVP-CP.4: Listar proveedores
     * Muestra la lista de proveedores.
     */
    public function index()
    {
        $data = [
            'suppliers' => $this->supplierModel->findAll(), // Para DataTables del lado del cliente sin paginación del servidor
            //'suppliers' => $this->supplierModel->paginate(10), // Para paginación del servidor
            //'pager'     => $this->supplierModel->pager,      // Necesario para los enlaces de paginación
            'title'     => 'Gestión de Proveedores',
        ];
        return view('suppliers/index', $data);
    }

     /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function new()
    {
        $data = [
            'title'      => 'Registrar Nuevo Proveedor',
            'validation' => \Config\Services::validation(),
            'supplier'   => new Supplier(), // Entidad vacía para el formulario
        ];
        return view('suppliers/form', $data);
    }

    /**
     * RF-MVP-CP.3: Registrar proveedores
     * Procesa el formulario de creación y guarda el nuevo proveedor.
     */

    public function create()
    {
        $rules = [
            'name' => 'required|string|max_length[255]',
            'ruc'  => 'permit_empty|string|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            $data = [
                'title'      => 'Registrar Nuevo Proveedor',
                'validation' => $this->validator,
                'supplier'   => new Supplier($this->request->getPost()), // Repoblar con datos enviados
            ];
            return view('suppliers/form', $data);
        }

        $supplier = new Supplier($this->request->getPost());

        if ($this->supplierModel->save($supplier)) {
            return redirect()->to('/suppliers')->with('message', 'Proveedor registrado exitosamente.');
        }

        return redirect()->back()->withInput()->with('error', 'No se pudo registrar el proveedor. Por favor, intente de nuevo.');
    }
 
    /**
     * Muestra el formulario para editar un proveedor existente.
     * RF-MVP-CP.4: Editar proveedores
     */
    public function edit($id = null)
    {
        $supplier = $this->supplierModel->find($id);
        if (!$supplier) {
            throw PageNotFoundException::forPageNotFound('Proveedor no encontrado.');
        }

        $data = [
            'title'    => 'Editar Proveedor',
            'supplier' => $supplier,
            'validation' => \Config\Services::validation(),
        ];
        return view('suppliers/form', $data);
    }

    /**
     * Procesa el formulario de edición y actualiza el proveedor.
     * RF-MVP-CP.4: Editar proveedores
     */
    public function update($id = null)
    {
        $supplier = $this->supplierModel->find($id);
        if (!$supplier) {
            throw PageNotFoundException::forPageNotFound('Proveedor no encontrado para actualizar.');
        }

        $rules = [
            'name' => 'required|string|max_length[255]',
            'ruc'  => 'permit_empty|string|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            $data = [
                'title'      => 'Editar Proveedor',
                'validation' => $this->validator,
                // Crear una nueva entidad con los datos del post y el ID original para repoblar el form
                'supplier'   => new Supplier(array_merge($this->request->getPost(), ['id' => $id])),
            ];
            return view('suppliers/form', $data);
        }

        if ($this->supplierModel->update($id, $this->request->getPost())) {
            return redirect()->to('/suppliers')->with('message', 'Proveedor actualizado exitosamente.');
        }

        return redirect()->back()->withInput()->with('error', 'No se pudo actualizar el proveedor. Por favor, intente de nuevo.');
    }

    /**
     * Elimina (soft delete) un proveedor.
     * RF-MVP-CP.4: Eliminar proveedores
     */
    public function delete($id = null)
    {
        if (!$this->supplierModel->find($id)) {
             return redirect()->to('/suppliers')->with('error', 'Proveedor no encontrado para eliminar.');
        }

        if ($this->supplierModel->delete($id)) { // Esto hará un soft delete
            return redirect()->to('/suppliers')->with('message', 'Proveedor eliminado exitosamente.');
        }
        return redirect()->to('/suppliers')->with('error', 'No se pudo eliminar el proveedor.');
    }
}