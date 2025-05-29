<?php

namespace App\Controllers;

use App\Controllers\AppBaseController;
use App\Models\CustomerModel;

class CustomerController extends AppBaseController
{
    protected $customerModel;
    protected $validator;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->validator = \Config\Services::validation(); // Instanciar el servicio de validación
        helper(['form', 'url']);
    }

    /**
     * RF-MVP-CP.2: Listar clientes
     */
    public function index()
    {
        $data = [
            'customers' => $this->customerModel->where('deleted_at IS NULL')->orderBy('name', 'ASC')->findAll(),
        ];
        return view('customers/index', $data);
    }

    /**
     * Mostrar formulario para registrar nuevo cliente
     */
    public function new()
    {
        $data = [
            // No se necesitan datos adicionales para el formulario de cliente básico
        ];
        return view('customers/form', $data);
    }

    /**
     * RF-MVP-CP.1: Procesar el registro de nuevo cliente
     */
    public function create()
    {
        $postData = $this->request->getPost();

        if (!$this->validator->run($postData, 'createCustomer')) {
            session()->setFlashdata('error', 'Por favor, corrige los errores del formulario.');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($this->customerModel->save($postData)) {
            session()->setFlashdata('success', 'Cliente registrado exitosamente.');
            return redirect()->to('/customers');
        } else {
            session()->setFlashdata('error', 'No se pudo registrar el cliente.');
            // Los errores del modelo (ej. falla de BD) se pueden pasar si $skipValidation = false en el modelo
            return redirect()->back()->withInput()->with('errors', $this->customerModel->errors());
        }
    }

    /**
     * RF-MVP-CP.2: Mostrar formulario para editar cliente existente
     */
    public function edit($id = null)
    {
        if (!ctype_digit((string)$id) || (int)$id <= 0) {
             session()->setFlashdata('error', 'ID de cliente inválido.');
            return redirect()->to('/customers');
        }

        $customer = $this->customerModel->find($id);
        if (!$customer) {
            session()->setFlashdata('error', 'Cliente no encontrado.');
            return redirect()->to('/customers');
        }

        $data = [
            'customer' => $customer,
        ];
        return view('customers/form', $data);
    }

    /**
     * RF-MVP-CP.2: Procesar la actualización de un cliente
     */
    public function update($id = null)
    {
        if (!ctype_digit((string)$id) || (int)$id <= 0) {
            session()->setFlashdata('error', 'ID de cliente inválido.');
            return redirect()->to('/customers');
        }

        $customer = $this->customerModel->find($id); // Para verificar existencia
        if (!$customer) {
            session()->setFlashdata('error', 'Cliente no encontrado.');
            return redirect()->to('/customers');
        }

        $postData = $this->request->getPost();

        $dataForValidation = $postData;
        $dataForValidation['id'] = $id; // Para el placeholder {id} en la regla is_unique

        if (!$this->validator->run($dataForValidation, 'updateCustomer')) {
            session()->setFlashdata('error', 'Por favor, corrige los errores del formulario.');
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($this->customerModel->update($id, $postData)) {
            session()->setFlashdata('success', 'Cliente actualizado exitosamente.');
            return redirect()->to('/customers');
        } else {
            session()->setFlashdata('error', 'No se pudo actualizar el cliente.');
            return redirect()->back()->withInput()->with('errors', $this->customerModel->errors());
        }
    }

    /**
     * RF-MVP-CP.2: Eliminar (soft delete) un cliente
     */
    public function delete($id = null)
    {
         if (!ctype_digit((string)$id) || (int)$id <= 0) {
            session()->setFlashdata('error', 'ID de cliente inválido.');
            return redirect()->to('/customers');
        }

        // Podrías verificar si el cliente tiene transacciones asociadas antes de borrar
        // pero para el MVP, un borrado suave simple es suficiente.

        if ($this->customerModel->delete($id)) { // Esto usa soft delete
            session()->setFlashdata('success', 'Cliente eliminado (movido a la papelera) exitosamente.');
        } else {
            session()->setFlashdata('error', 'No se pudo eliminar el cliente.');
        }
        return redirect()->to('/customers');
    }

    /**
     * RF-MVP-CP.2: Restaurar un cliente eliminado
     */
    public function restore($id = null)
    {
        if (!ctype_digit((string)$id) || (int)$id <= 0) {
            session()->setFlashdata('error', 'ID de cliente inválido.');
            return redirect()->to('/customers');
        }

        $customer = $this->customerModel->onlyDeleted()->find($id);
        if (!$customer) {
            session()->setFlashdata('error', 'Cliente no encontrado o no eliminado.');
            return redirect()->to('/customers');
        }

        if ($this->customerModel->update($id, ['deleted_at' => null])) { // Restaurar borrado suave
            session()->setFlashdata('success', 'Cliente restaurado exitosamente.');
        } else {
            session()->setFlashdata('error', 'No se pudo restaurar el cliente.');
        }
        return redirect()->to('/customers');
    }
    
}
