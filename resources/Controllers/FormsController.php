<?php

namespace Amphibee\Plugin\FrontendAccount\Controllers;

use Amphibee\Plugin\FrontendAccount\Forms\ForgottenPasswordForm;
use Amphibee\Plugin\FrontendAccount\Forms\LoginForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function login()
    {
        if (is_user_logged_in()) {
            if (user_can(wp_get_current_user(), 'subscriber')) {
                return redirect()->route('frontend-account.dashboard');
            }

            return redirect('/wp-admin/');
        }

        $formArgs = apply_filters('frontend_account_login_form_args', [
            'form' => $this->form(new LoginForm()),
            'title' => get_option('frontend_account_login_title'),
            'title_class' => 'frontend-account-form-title',
            'description' => get_option('frontend_account_login_description'),
            'description_class' => 'frontend-account-form-description',
            'form_class' => 'frontend-account-form frontend-account-login_form',
            'show_forgot_password' => true,
            'forgot_password_class' => 'frontend-account-forgot-password',
            'forgot_password_title' => get_option('frontend_account_login_forgot_password_title'),
            'errors_class' => 'frontend-account-form-errors',
        ]);

        return view('frontend-account.forms.login', [
            'form' => $formArgs['form'],
            'title' => $formArgs['title'],
            'description' => $formArgs['description'],
            'title_class' => $formArgs['title_class'],
            'description_class' => $formArgs['description_class'],
            'form_class' => $formArgs['form_class'],
            'forgot_password' => $formArgs['show_forgot_password'] ?? false,
            'forgot_password_class' => $formArgs['forgot_password_class'] ?? '',
            'forgot_password_title' => $formArgs['forgot_password_title'] ?? '',
            'errors_class' => $formArgs['errors_class'] ?? '',
        ]);
    }

    public function loginCheck(Request $request)
    {
        $form = $this->form(new LoginForm());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $email = $form->repository()->getFieldByName('email')->getValue();
            $password = $form->repository()->getFieldByName('password')->getValue();

            $user = wp_signon(
                [
                    'user_login' => $email,
                    'user_password' => $password,
                ],
                false
            );

            if (is_wp_error($user)) {
                return redirect()->back()->withErrors($user->get_error_message());
            }

            return redirect()->route('frontend-account.dashboard');
        }
    }

    public function logout(): void
    {
        wp_logout();
        wp_redirect('/');
        exit;
    }

    public function forgotPassword(Request $request)
    {
        if ($request->get('errors')) {
            $errors = $request->get('errors');
        }

        $formArgs = apply_filters('frontend_account_forgot_password_form_args', [
            'form' => $this->form(new ForgottenPasswordForm()),
            'title' => get_option('frontend_account_forgot_password_title'),
            'title_class' => 'frontend-account-form-title',
            'description' => get_option('frontend_account_forgot_password_description'),
            'description_class' => 'frontend-account-form-description',
            'form_class' => 'frontend-account-form frontend-account-forgot_password-form',
            'errors_class' => 'frontend-account-forgot-password-error',
            'errors' => $errors ?? null,
        ]);

        if ($request->get('errors')) {
            $errors = $request->get('errors');
        }

        return view('frontend-account.forms.forgot-password', [
            'form' => $formArgs['form'],
            'title' => $formArgs['title'],
            'description' => $formArgs['description'],
            'title_class' => $formArgs['title_class'],
            'description_class' => $formArgs['description_class'],
            'form_class' => $formArgs['form_class'],
            'forgotErrors' => $formArgs['errors'] ?? null,
            'error_class' => $formArgs['errors_class'],
        ]);
    }
}
