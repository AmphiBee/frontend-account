<?php

namespace Amphibee\Plugin\FrontendAccount\Forms;

use Themosis\Field\Contracts\FieldFactoryInterface;
use Themosis\Forms\Contracts\FormFactoryInterface;
use Themosis\Forms\Contracts\Formidable;
use Themosis\Forms\Contracts\FormInterface;

class ForgottenPasswordForm implements Formidable
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
                'class' => 'frontend-account-form frontend-account-forgot_password_form',
                'action' => wp_lostpassword_url(),
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
            'email' => [
                'type' => 'email',
                'name' => 'user_login',
                'options' => [
                    'label' => 'Email',
                    'rules' => 'required',
                    'attributes' => [
                        'class' => 'field frontend-account-username_field',
                        'placeholder' => 'Email',
                    ],
                ],
            ],
            'submit' => [
                'type' => 'submit',
                'name' => 'submit',
                'options' => [
                    'label' => 'Login',
                    'rules' => '',
                    'attributes' => [
                        'class' => 'frontend-account-submit_button',
                    ],
                ],
            ],
        ];

        return apply_filters('frontend_account_forgot_password_fields', $args);
    }
}
