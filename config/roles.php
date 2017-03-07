<?php

return [

    /**
     * Roles defined in the system
     */
    'labels' => [
        'admin' => 'Administrador',
        'company' => 'Empresa',
        'provider' => 'Prestador'
    ],

    /**
     * Access permissions
     */
    'canAccess' => [
        'admin' => ['admin'],
        'company' => ['admin', 'company'],
        'provider' => ['admin', 'company', 'provider']
    ],

];