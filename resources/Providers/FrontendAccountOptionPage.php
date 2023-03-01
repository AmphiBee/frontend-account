<?php

namespace Amphibee\Plugin\FrontendAccount\Providers;

use Themosis\Support\Section;

class FrontendAccountOptionPage extends \Illuminate\Support\ServiceProvider
{
    public static $page;

    public function register()
    {
        self::$page = \Page::make('frontend-account', __('FrontendAccount', 'frontend-account'))->set();
        $this->registerSections();
    }

    public function registerSections()
    {
        self::$page->addSections([
            new Section('login', __('Login', 'frontend-account')),
            new Section('forgot_password', __('Forgot password', 'frontend-account')),
            new Section('account_dashboard', __('Account dashboard', 'frontend-account')),
        ]);

        $this->registerFields();
    }

    public function registerFields()
    {
        self::$page->addSettings([
            'login' => [
                \Field::text('login_title', [
                    'label' => __('Title', 'frontend-account'),
                    'attributes' => [
                        'placeholder' => __('Login', 'frontend-account'),
                    ],
                ]),
                \Field::textarea('login_description', [
                    'label' => __('Description', 'frontend-account'),
                    'attributes' => [
                        'placeholder' => __('Description', 'frontend-account'),
                    ],
                ]),
                \Field::text('login_forgot_password_title', [
                    'label' => __('Forgot password title', 'frontend-account'),
                    'attributes' => [
                        'placeholder' => __('Forgot password title', 'frontend-account'),
                    ],
                ]),
            ],
            'forgot_password' => [
                \Field::text('forgot_password_title', [
                    'label' => __('Title', 'frontend-account'),
                    'attributes' => [
                        'placeholder' => __('Login', 'frontend-account'),
                    ],
                ]),
                \Field::textarea('forgot_password_description', [
                    'label' => __('Description', 'frontend-account'),
                    'attributes' => [
                        'placeholder' => __('Description', 'frontend-account'),
                    ],
                ]),
                \Field::editor('forgot_password_confirmation_message', [
                    'label' => __('Confirmation message', 'frontend-account'),
                    'attributes' => [
                        'placeholder' => __('Confirmation message', 'frontend-account'),
                    ],
                ]),
            ],
            'account_dashboard' => [
                \Field::text('account_dashboard_subtitle', [
                    'label' => __('Subtitle', 'frontend-account'),
                    'attributes' => [
                        'placeholder' => __('Subtitle', 'frontend-account'),
                    ],
                ]),

            ],
        ]);

        self::$page->setPrefix('frontend_account_');
    }
}
