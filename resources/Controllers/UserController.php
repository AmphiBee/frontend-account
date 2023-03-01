<?php

namespace Amphibee\Plugin\FrontendAccount\Controllers;

use Amphibee\Plugin\FrontendAccount\Forms\AccountForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Themosis\Support\Facades\Filter;
use Themosis\Support\Facades\User;

class UserController extends Controller
{
    public function index()
    {
        Filter::add('document_title_parts', static function ($parts) {
            $parts['title'] = get_option('frontend_account_title') ?? __('My Account', 'frontend-account');

            return $parts;
        });

        $args = apply_filters('frontend_account_form_args', [
            'form' => $this->form(new AccountForm()),
            'user' => User::current(),
            'container_class' => 'container',
            'form_class' => 'frontend-account-form',
            'title_class' => '',
            'subtitle' => get_option('frontend_account_account_dashboard_subtitle'),
            'subtitle_class' => '',
        ]);

        return view(apply_filters('frontend-account/views/account', 'frontend-account.account'), $args);
    }

    public function update(Request $request)
    {
        $user = collect(get_userdata(User::current()->ID)->to_array());
        $user_id = $user->get('ID');
        $user = $user->merge($request->all());
        $user->forget(['_token', 'submit']);
        if ($password = $user->get('password')) {
            if (! wp_check_password($password, User::current()->user_pass, $user_id)) {
                wp_set_password($password, $user_id);
            }
        }
        $user->map(static function ($value, $key) use ($user_id) {
            if (str_contains($key, 'th_')) {
                $key = str_replace('th_', '', $key);
            }
            update_user_meta($user_id, $key, $value);
        });

        return redirect()->route('frontend-account.dashboard');
    }
}
