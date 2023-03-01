<?php

namespace Amphibee\Plugin\FrontendAccount\Providers;

class ForgottenPasswordProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        \Action::add('login_form_lostpassword', [$this, 'redirectToLostPassword']);
    }

    public function redirectToLostPassword()
    {
        if (request()->isMethod('post')) {
            $errors = retrieve_password();

            if (is_wp_error($errors)) {
                wp_redirect(route('frontend-account.forgot-password', [
                    'errors' => $errors->get_error_message(),
                ]));
                exit;
            }

            wp_redirect(route('frontend-account.forgot-password-confirmation'));
            exit;
        }
    }
}
