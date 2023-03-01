@extends('layouts.main')

@section('content')
    <div class="my-account">
        <div class="section {{ $container_class }}">
            <h1 class="{{ $title_class }}">{{ sprintf(__('Hello %s', 'frontend-account'), $user->data->user_login) }}</h1>
            <div>
                <h2 class="{{ $subtitle_class }}">{{ $subtitle }}</h2>
                {!! $form->render() !!}
            </div>
        </div>

        @php do_action('frontend-account/views/account_extras') @endphp

        <div class="section {{ $container_class }} mt-8 frontend-account-form-logout">
            <div class="th-form-input py-6 text-center">
                <a href="{{ home_url('sign-out/') }}" class="form-submit frontend-account-logout" id="th_logout_field" >{{ __('Logout', 'frontend-account') }}</a>
            </div>
        </div>
    </div>
@endsection
