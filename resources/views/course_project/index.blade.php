@extends('layouts.admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <h1>โครงการ และหลักสูตร</h1>

                        <a href="{{ route('course_project.create') }}"><button type="button"
                                class="btn btn-primary">เพิ่มหลักสูตรในโครงการ</button></a>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-hover"
                                style="max-width: 100%; word-wrap: break-word;">
                                <thead>
                                    <tr>
                                        <th>โครงการ</th>
                                        <th>หลักสูตร</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>
                                                <strong>{{ $project->Projectname }}:</strong>
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach ($project->courses as $course)
                                                        <li>{{ $course->Cosename }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <a href="{{ route('course_project.edit', $project->id) }}">Edit</a>
                                                <form action="{{ route('course_project.destroy', $project->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">Detach All Courses</button>
                                                </form>
                                            </td>
                                        
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
