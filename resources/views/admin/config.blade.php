@extends('layouts.admin')
@section('title')
    {{ 'Admin' }} @parent
@endsection
@push('style')
@endpush
@section('content')
    <section class="vh-10 gradient-custom">
        <div class="container py-5 h-10">
            <div class="row justify-content-center align-items-center h-10">
                <div class="col-12 col-lg-12 col-xl-12">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">

                        <div class="card-body p-4 p-md-5">
                            <form action="{{ route('admin.configdb') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-5 mb-4">
                                        <label class="form-label">หลักสูตร <span class="required">*</span></label>
                                        <select class="form-control" name="couse_id">
                                            <option value="">เลือกหลักสูตร</option>
                                            @foreach ($courses as $key => $course)
                                                <option
                                                    value="{{ $course->id }}"@if (old('link') == $course->id) selected @endif>
                                                    {{ $course->Cosename }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-5 mb-4">
                                        <label class="form-label">อาจารย์ <span class="required">*</span></label>
                                        <select class="form-control" name="user_id">
                                            <option value="">เลือกอาจารย์</option>
                                            @foreach ($users as $key => $user)
                                                <option
                                                    value="{{ $user->id }}"@if (old('link') == $user->id) selected @endif>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2 mb-4 pt-4">
                                        <div class="col" align="center">
                                            <input class="btn btn-primary btn-lg" type="submit" value="บันทึก" />
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>




                </div>
            </div>




            {{-- @foreach ($users_courses as $user)
                <div class="row justify-content-center align-items-center h-10">
                    <div class="col-12 col-lg-12 col-xl-12">
                        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">

                            <div class="card-body p-4 p-md-5">

                                <h3>{{ $user->name }}</h3>
                                <p>Email: {{ $user->email }}</p>
                                <p>Courses:</p>
                                <ul>
                                    @foreach ($user->courses as $course)
                                        <li>{{ $course->Cosename }} ({{ $course->datestart }} - {{ $course->dateend }})
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach --}}
        </div>

    </section>
    <section class="vh-10 gradient-custom">
        <div class="container py-5 h-10">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-hover">
                    <thead>
                        <td>#</td>
                        <th>ชื่อ-สกุล</th>
                        <th>หลักสูตร</th>
                    </thead>
                    <tbody>
                        {{-- @dd($users_courses) --}}
                        @foreach ($users_courses as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                {{-- <td>{{ $user->responsibles->courses }}
                                    <ul>
                                        @foreach ($user->responsibles->course as $course)
                                            <li>{{ $course->Cosename }} ({{ $course->datestart }} -
                                                {{ $course->dateend }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </td> --}}
                                <td>
                                    <ul>
                                        {{-- @dd($user) --}}
                                        @foreach ($user->responsibles as $responsible)
                                            <li>
                                               
                                                {{ $responsible->course->Cosename ?? 'No Course Name' }}
                                                ({{ $responsible->course->datestart }} -
                                                {{ $responsible->course->dateend }})
                                                <form action="{{ route('responsibles.destroy', $responsible->id) }}"
                                                    class="d-inline delete-form" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger delete-button">Delete</button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                const deleteButton = form.querySelector('.delete-button');

                deleteButton.addEventListener('click', function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
