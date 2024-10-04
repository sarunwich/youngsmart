@extends('layouts.admin')

@section('content')
    <h1>หลักสูตรในโปรเจ็ค</h1>

    <form action="{{ route('course_project.store') }}" method="POST">
        @csrf
        <div>
            <label>Select Project:</label>
            <select name="project_id" class="form-control">
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->Projectname }}</option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label>Select Courses:</label>
            <select name="courses[]" class="form-control" multiple>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->Cosename }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="form-control mt-5">Save</button>
    </form>
@endsection
