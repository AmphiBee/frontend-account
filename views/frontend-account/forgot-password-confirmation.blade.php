@extends(apply_filters('frontend-account_layout_view', 'layouts.main'))

@section('content')
    <div class="{{ $container_class }}">
        {!! $message !!}
    </div>
@endsection