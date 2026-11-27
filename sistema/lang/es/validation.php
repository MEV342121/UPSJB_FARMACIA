<?php

// Mensajes de validación en español.
// Laravel usa este archivo cuando APP_LOCALE=es en el .env.
// :attribute se reemplaza por el nombre del campo (ver 'attributes' al final).

return [
    'array'     => 'El campo :attribute debe ser una lista.',
    'boolean'   => 'El campo :attribute debe ser verdadero o falso.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'date'      => 'El campo :attribute debe ser una fecha válida.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha igual o posterior a :date.',
    'digits'    => 'El campo :attribute debe tener :digits dígitos.',
    'distinct'  => 'El campo :attribute tiene un valor repetido.',
    'email'     => 'El campo :attribute debe ser un correo válido.',
    'exists'    => 'El :attribute seleccionado no es válido.',
    'image'     => 'El campo :attribute debe ser una imagen.',
    'integer'   => 'El campo :attribute debe ser un número entero.',
    'max'       => [
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
        'file'    => 'El archivo :attribute no debe pesar más de :max KB.',
        'string'  => 'El campo :attribute no debe tener más de :max caracteres.',
        'array'   => 'El campo :attribute no debe tener más de :max elementos.',
    ],
    'mimes'     => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min'       => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'file'    => 'El archivo :attribute debe pesar al menos :min KB.',
        'string'  => 'El campo :attribute debe tener al menos :min caracteres.',
        'array'   => 'El campo :attribute debe tener al menos :min elementos.',
    ],
    'numeric'   => 'El campo :attribute debe ser un número.',
    'required'  => 'El campo :attribute es obligatorio.',
    'string'    => 'El campo :attribute debe ser texto.',
    'unique'    => 'El :attribute ya está registrado.',

    // Nombres "bonitos" de los campos del sistema
    'attributes' => [
        'name'                => 'nombre',
        'description'         => 'descripción',
        'dni'                 => 'DNI',
        'phone'               => 'teléfono',
        'age'                 => 'edad',
        'tuition'             => 'colegiatura',
        'email'               => 'correo electrónico',
        'password'            => 'contraseña',
        'role_id'             => 'rol',
        'category_id'         => 'categoría',
        'price'               => 'precio',
        'stock'               => 'stock',
        'image'               => 'imagen',
        'customer_id'         => 'cliente',
        'user_id'             => 'vendedor',
        'items'               => 'medicamentos',
        'items.*.medicine_id' => 'medicamento',
        'items.*.amount'      => 'cantidad',
        'from'                => 'fecha inicial',
        'to'                  => 'fecha final',
    ],
];
