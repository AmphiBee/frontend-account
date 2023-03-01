<?php

namespace Amphibee\Plugin\FrontendAccount\Forms;

use Themosis\Field\Contracts\FieldFactoryInterface;
use Themosis\Forms\Contracts\FormFactoryInterface;
use Themosis\Forms\Contracts\Formidable;
use Themosis\Forms\Contracts\FormInterface;
use Themosis\Support\Facades\User;

class AccountForm implements Formidable
{
    private static \Themosis\Forms\Contracts\FormBuilderInterface $form;

    private $allFields;

    /**
     * Build your form.
     *
     * @param  FormFactoryInterface  $factory
     * @param  FieldFactoryInterface  $fields
     * @return FormInterface
     */
    public function __construct()
    {
        $this->user = User::current()->data;
        $this->fields = $this->getBasicFields();
    }

    public function build(FormFactoryInterface $factory, FieldFactoryInterface $fields): FormInterface
    {
        $this->allFields = $fields;
        self::$form = $factory->make(null, [
            'attributes' => [
                'method' => 'POST',
                'class' => 'frontend-account-form frontend-account-form',
            ],
        ]);

        foreach ($this->fields as $field) {
            $this->addField($field);
        }

        return self::$form->get()->setPrefix('');
    }

    public function addField($field)
    {
        $name = $field['name'] ?? false;
        $type = $field['type'] ?? false;
        $options = $field['options'] ?? [];
        self::$form->add(call_user_func_array([$this->allFields, $type], [$name, $options]));
    }

    public function getBasicFields()
    {
        $args = [
            'first_name' => [
                'name' => 'first_name',
                'type' => 'text',
                'options' => [
                    'label' => __('First name', 'frontend-account'),
                    'rules' => 'required',
                    'attributes' => [
                        'class' => 'form-control',
                        'placeholder' => __('First name', 'frontend-account'),
                    ],
                    'label_attr' => [
                        'class' => 'form-label',
                    ],
                    'data' => get_user_meta($this->user->ID, 'first_name', true),
                ],
            ],
            'last_name' => [
                'name' => 'last_name',
                'type' => 'text',
                'options' => [
                    'label' => __('Last name', 'frontend-account'),
                    'rules' => 'required',
                    'attributes' => [
                        'class' => 'form-control',
                        'placeholder' => __('Last name', 'frontend-account'),
                    ],
                    'label_attr' => [
                        'class' => 'form-label',
                    ],
                    'data' => get_user_meta($this->user->ID, 'last_name', true),
                ],
            ],
            'email' => [
                'name' => 'email',
                'type' => 'email',
                'options' => [
                    'label' => __('Email', 'frontend-account'),
                    'rules' => 'required',
                    'attributes' => [
                        'class' => 'form-control',
                        'placeholder' => __('Email', 'frontend-account'),
                    ],
                    'label_attr' => [
                        'class' => 'form-label',
                    ],
                    'data' => $this->user->user_email,
                ],
            ],
            'password' => [
                'name' => 'password',
                'type' => 'password',
                'options' => [
                    'label' => __('Password', 'frontend-account'),
                    'rules' => 'required',
                    'attributes' => [
                        'class' => 'form-control',
                        'placeholder' => __('Password', 'frontend-account'),
                    ],
                    'label_attr' => [
                        'class' => 'form-label',
                    ],
                ],
            ],
            'submit' => [
                'name' => 'submit',
                'type' => 'submit',
                'options' => [
                    'label' => __('Envoyer', 'frontend-account'),
                    'attributes' => [
                        'class' => 'form-submit',
                        'placeholder' => __('Envoyer', 'frontend-account'),
                    ],
                    'label_attr' => [
                        'class' => 'form-label',
                    ],
                ],
            ],

        ];

        /**
         * Field arguments can be found here: https://framework.themosis.com/docs/3.0/field
         */

        return apply_filters('frontend_account_account_fields', $args);
    }
}
