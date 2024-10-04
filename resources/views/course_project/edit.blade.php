@extends('layouts.admin')

@section('content')
    <h1>Edit Project Courses</h1>

    <form action="{{ route('course_project.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label>โครงการ:</label>
            <strong>{{ $project->Projectname }}</strong>
        </div>
        
        <div>
            <label>หลักสูตร:</label>
            <select name="courses[]" class="form-control" multiple>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" 
                        @if ($project->courses->contains($course->id)) selected @endif>
                        {{ $course->Cosename }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <button class="form-control mt-5"  type="submit">Update</button>
    </form>
@endsection
