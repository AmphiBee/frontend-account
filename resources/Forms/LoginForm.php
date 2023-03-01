<?php

namespace Amphibee\Plugin\FrontendAccount\Forms;

use Themosis\Field\Contracts\FieldFactoryInterface;
use Themosis\Forms\Contracts\FormFactoryInterface;
use Themosis\Forms\Contracts\Formidable;
use Themosis\Forms\Contracts\FormInterface;

class LoginForm implements Formidable
{
    private static \Themosis\Forms\Contracts\FormBuilderInterface $form;

    private FieldFactoryInterface $allFields;

    /**
     * @var void|null
     */
    public $fields;

    /**
     * Build your form.
     *
     * @param  FormFactoryInterface  $factory
     * @param  FieldFactoryInterface  $fields
     * @return FormInterface
     */
    public function __construct()
    {
        $this->fields = $this->getBasicFields();
    }

    public function build(FormFactoryInterface $factory, FieldFactoryInterface $fields): FormInterface
    {
        $this->allFields = $fields;
        self::$form = $factory->make(null, [
            'attributes' => [
                'method' => 'POST',
                'class' => 'frontend-account-form frontend-account-login_form',
            ],

        ]);

        foreach ($this->fields as $field) {
            $this->addField($field);
        }

        return self::$form->get();
    }

    public function addField($field)
    {
        $name = $field['name'] ?? false;
        $type = $field['type'] ?? false;
        $options = [
            'label' => $field['label'] ?? '',
            'rules' => $field['rules'] ?? '',
            'placeholder' => $field['placeholder'] ?? '',
            'attributes' => $field['attributes'] ?? [],
            'label_attr' => $field['label_attr'] ?? [],
        ];
        self::$form->add(call_user_func_array([$this->allFields, $type], [$name, $options]));
    }

    public function getBasicFields()
    {
        $args = [
            'email' => [
                'type' => 'email',
                'name' => 'email',
                'attributes' => [
                    'class' => 'field frontend-account-username_field',
                    'placeholder' => __('Email', 'frontend-account'),
                ],
                'options' => [
                    'label' => __('Email', 'frontend-account'),
                    'rules' => 'required',
                ],
            ],
            'password' => [
                'type' => 'password',
                'name' => 'password',
                'attributes' => [
                    'placeholder' => __('Password', 'frontend-account'),
                    'class' => 'field frontend-account-password_field',
                ],
                'options' => [
                    'label' => __('Password', 'frontend-account'),
                    'rules' => 'required',
                ],
            ],
            'submit' => [
                'type' => 'submit',
                'name' => 'submit',
                'options' => [
                    'attributes' => [
                        'class' => 'frontend-account-submit_button',
                    ],
                    'data' => 'Login',
                ],
            ],
        ];

        return apply_filters('frontend_account_login_fields', $args);
    }
}
