@extends(apply_filters('frontend-account_layout_view', 'layouts.main'))

@section('content')
    <div class="{{ $form_class }}">
        <p class="{{ $title_class }}">{{ $title }}</p>
        <p class="{{ $description_class }}">{{ $description }}</p>
        {!! $form->render() !!}
        @if($forgot_password)
            <a href="{{ route('frontend-account.forgot-password') }}" class="{{ $forgot_password_class }}">{{ $forgot_password_title }}</a>
        @endif
        <div>
            @isset($errors)
                @foreach($errors->all() as $error)
                    <div class="{{ $errors_class }}" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endisset
        </div>
    </div>

@endsection