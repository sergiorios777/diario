<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    // Reglas productos
    public array $createProducts = [
        'code' => [
            'rules'  => 'required|is_unique[products.code]|max_length[50]',
            'errors' => [
                'required' => 'El código del producto es obligatorio.',
                'is_unique' => 'Este código de producto ya existe.',
                'max_length' => 'El código no puede exceder los 50 caracteres.'
            ]
        ],
        'name' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required' => 'El nombre del producto es obligatorio.',
                'max_length' => 'El nombre no puede exceder los 255 caracteres.'
            ]
        ],
        'unit_of_measure' => [
            'rules'  => 'required|max_length[50]',
            'errors' => [
                'required' => 'La unidad de medida es obligatoria.'
            ]
        ],
        'sale_price' => [
            'rules'  => 'required|decimal|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'El precio de venta es obligatorio.',
                'decimal'  => 'El precio de venta debe ser un número decimal válido.',
                'greater_than_equal_to' => 'El precio de venta no puede ser negativo.'
            ]
        ],
        'cost_price' => [
            'rules'  => 'required|decimal|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'El costo unitario es obligatorio.',
                'decimal'  => 'El costo unitario debe ser un número decimal válido.',
                'greater_than_equal_to' => 'El costo unitario no puede ser negativo.'
            ]
        ],
        'category_name' => [
            'rules'  => 'permit_empty|max_length[100]',
            'errors' => [
                'max_length' => 'La categoría no puede exceder los 100 caracteres.'
            ]
        ],
    ];

    public array $updateProducts = [
        'id'   => [ // Regla para el ID que se añade programáticamente para la validación
            'rules'  => 'permit_empty|is_natural_no_zero',
            'errors' => [
                'is_natural_no_zero' => 'El ID interno para la validación no es válido.'
            ]
        ],
        'code' => [
            'rules'  => 'required|is_unique[products.code,id,{id}]|max_length[50]',
            'errors' => [
                'required' => 'El código del producto es obligatorio.',
                'is_unique' => 'Este código de producto ya existe en otro registro.',
                'max_length' => 'El código no puede exceder los 50 caracteres.'
            ]
        ],
        'name' => [ // Se repiten las reglas, pero puedes definir plantillas si son muchas
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required' => 'El nombre del producto es obligatorio.',
                'max_length' => 'El nombre no puede exceder los 255 caracteres.'
            ]
        ],
        'unit_of_measure' => [
            'rules'  => 'required|max_length[50]',
            'errors' => [
                'required' => 'La unidad de medida es obligatoria.'
            ]
        ],
        'sale_price' => [
            'rules'  => 'required|decimal|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'El precio de venta es obligatorio.',
                'decimal'  => 'El precio de venta debe ser un número decimal válido.',
                'greater_than_equal_to' => 'El precio de venta no puede ser negativo.'
            ]
        ],
        'cost_price' => [
            'rules'  => 'required|decimal|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'El costo unitario es obligatorio.',
                'decimal'  => 'El costo unitario debe ser un número decimal válido.',
                'greater_than_equal_to' => 'El costo unitario no puede ser negativo.'
            ]
        ],
        'category_name' => [
            'rules'  => 'permit_empty|max_length[100]',
            'errors' => [
                'max_length' => 'La categoría no puede exceder los 100 caracteres.'
            ]
        ],
    ];

    // --- INICIO: REGLAS PARA CLIENTES (BIZDAILY) ---
    public array $createCustomer = [
        'name' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required' => 'El nombre o razón social es obligatorio.',
                'max_length' => 'El nombre no puede exceder los 255 caracteres.'
            ]
        ],
        'document_number' => [
            // Si el DNI/RUC es opcional pero único si se proporciona:
            'rules'  => 'permit_empty|alpha_numeric|max_length[20]|is_unique[customers.document_number]',
            // Si solo es un texto simple sin unicidad forzosa (más simple para MVP):
            // 'rules'  => 'permit_empty|alpha_numeric_space|max_length[20]',
            'errors' => [
                'alpha_numeric' => 'El DNI/RUC solo puede contener letras y números.',
                'max_length' => 'El DNI/RUC no puede exceder los 20 caracteres.',
                'is_unique'  => 'Este DNI/RUC ya está registrado.'
            ]
        ],
        'email' => [
            'rules'  => 'permit_empty|valid_email|max_length[255]',
            'errors' => [
                'valid_email' => 'Por favor, ingrese un correo electrónico válido.',
                'max_length' => 'El correo no puede exceder los 255 caracteres.'
            ]
        ],
        'phone' => [
            'rules'  => 'permit_empty|max_length[20]', // Puedes añadir 'alpha_numeric_punct' si permites (+,-,etc)
            'errors' => [
                'max_length' => 'El teléfono no puede exceder los 20 caracteres.'
            ]
        ],
        'address' => [
            'rules'  => 'permit_empty|max_length[65535]', // TEXT
        ]
    ];

    public array $updateCustomer = [
        'id'   => [ // Regla para el ID que se añade programáticamente para la validación
            'rules'  => 'required|is_natural_no_zero', // 'permit_empty' no es necesario si siempre se añade
            'errors' => [
                'is_natural_no_zero' => 'El ID interno para la validación no es válido.'
            ]
        ],
        'name' => [
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required' => 'El nombre o razón social es obligatorio.',
                'max_length' => 'El nombre no puede exceder los 255 caracteres.'
            ]
        ],
        'document_number' => [
            // Si el DNI/RUC es opcional pero único si se proporciona:
            'rules'  => 'permit_empty|alpha_numeric|max_length[20]|is_unique[customers.document_number,id,{id}]',
            // Si solo es un texto simple sin unicidad forzosa:
            // 'rules'  => 'permit_empty|alpha_numeric_space|max_length[20]',
            'errors' => [
                'alpha_numeric' => 'El DNI/RUC solo puede contener letras y números.',
                'max_length' => 'El DNI/RUC no puede exceder los 20 caracteres.',
                'is_unique'  => 'Este DNI/RUC ya está registrado en otro cliente.'
            ]
        ],
        'email' => [
            'rules'  => 'permit_empty|valid_email|max_length[255]',
            'errors' => [
                'valid_email' => 'Por favor, ingrese un correo electrónico válido.',
                'max_length' => 'El correo no puede exceder los 255 caracteres.'
            ]
        ],
        'phone' => [
            'rules'  => 'permit_empty|max_length[20]',
            'errors' => [
                'max_length' => 'El teléfono no puede exceder los 20 caracteres.'
            ]
        ],
        'address' => [
            'rules'  => 'permit_empty|max_length[65535]',
        ]
    ];
    // --- FIN: REGLAS PARA CLIENTES ---
}
