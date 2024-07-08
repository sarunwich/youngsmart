@extends('layouts.home')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('ข่าวประกาศ') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <span id="news"></span>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $.ajax({
            url: '{{ route('news') }}',
            method: 'GET',
            success: function(response) {
                console.log(response);
                $('#news').html(response).show();
            },
            error: function(xhr) {
                console.log(xhr);
                // Handle error response
            }
        });
    </script>
@endpush
