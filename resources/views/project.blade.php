@extends('layouts.home')

@section('content')
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> --}}
    <div class="container-fluid">
        <h1 class="h3 mb-0 text-gray-800">รายละเอียดโครงการ</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}

        {{-- <table class="table table-striped table-hover">
            <tbody>
                @foreach ($projects as $key => $project)
                    @if ($project->status == 1)
                        <tr>
                            <td>{{ $project->Projectname }}</td>
                            <td class="summernote-content"> {!! $project->Projectdetail !!}</td>
                            <td>
                                @if ($project->Projectfile)
                                    <a class="btn btn-outline-success"
                                        href="{{ url('viewfile/Projectfile/' . $project->Projectfile) }}"><i
                                            class="bi bi-download"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table> --}}
        @foreach ($projects as $key => $project)
            @if ($project->status == 1)
                <div class="card mb-3 shadow-sm" >
                    <div class="card">
                        <div class="card-header">
                            {{ $project->Projectname }}
                        </div>
                        <div class="card-body summernote-content">
                            {!! $project->Projectdetail !!}
                            @if ($project->Projectfile)
                                <a class="btn btn-outline-success"
                                    href="{{ url('viewfile/Projectfile/' . $project->Projectfile) }}"><i
                                        class="bi bi-download"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

    </div>
@endsection
