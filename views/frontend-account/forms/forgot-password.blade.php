@extends(apply_filters('frontend-account_layout_view', 'layouts.main'))

@section('content')
    <div class="{{ $form_class }}">
        <p class="{{ $title_class }}">{{ $title }}</p>
        <p class="{{ $description_class }}">{{ $description }}</p>
        {!! $form->render() !!}
        <div>
            @isset($errors)
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endisset
        </div>
        @isset($forgotErrors)
            <p class="{{ $error_class }}">{!! $forgotErrors !!}</p>
        @endisset
    </div>
@endsection