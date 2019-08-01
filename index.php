<?php

require_once('config/config.php');
require_once('config/autoload.php');



$form = new Form;

$form->input('description');

$form->input('content', [
    'label' => 'Contenu',
]);

//$form->select('country');


$form->input('email', [
    'label' => 'Adresse e-mail',
    'type'  => 'email',
    'classList' => 'form-control',
    'placeholder' => 'Saisissez un email',
    'value' => 'john@doe.com',
]);

$form->select('country', [
                'label' => 'Pays',
                'classList' => 'form-control',
            ],
            [
                [
                    'value' => 'fr',
                    'html' => 'France',
                    'disabled' => true,
                    'selected' => true,
                ],
                [
                    'value' => 'gb',
                    'html' => 'Royaume-Uni',
                    'disabled' => false,
                    'selected' => false,
                ],
                [
                    'value' => 'it',
                    'html' => 'Italie',
                    'disabled' => false,
                    'selected' => false,
                ],
                [
                    'value' => 'es',
                    'html' => 'Espagne',
                    'disabled' => true,
                    'selected' => false,
                ],
            ]);

var_dump($form);





include('views/form.php');