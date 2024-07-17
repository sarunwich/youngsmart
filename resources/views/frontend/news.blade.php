@extends('layouts.frontendlayout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('ข่าวประกาศ') }}</div>

                    <div class="card-body">
                        @foreach ($news as $key => $new)
                            @if ($new->pr_staus == 1)
                                <!--Section: News of the day-->
                                <div class="row gx-5">

                                    <div class="col-md-12 mb-8">

                                        <h4><strong>{{ $new->pr_title }}</strong></h4>
                                        <p class="text-muted">
                                            {!! $new->pr_detail !!}
                                        </p>
                                        @if ($new->pr_file)
                                            <a class="btn btn-outline-success"
                                                href="{{ url('viewfile/pr_file/' . $new->pr_file) }}"><i
                                                    class="bi bi-download"></i></a>
                                        @endif
                                    </div>
                                </div>

                                <!--Section: News of the day-->
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
