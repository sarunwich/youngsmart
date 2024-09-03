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
        </div>
    </section>
@endsection
@push('scripts')
@endpush
