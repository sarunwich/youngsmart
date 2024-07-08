@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="prefix"
                                class="col-md-4 col-form-label text-md-end">{{ __('คำนำหน้า') }}</label>


                            <div class="col-md-6">
                                {{-- {{old('prefix')}} --}}
                                <select name="prefix" id="prefix" class="form-control ">
                                    <option value="">เลือกคำนำหน้า</option>
                                    <option value="นาย" @if(old('prefix')=='นาย') selected @endif >นาย</option>
                                    <option value="นาง" @if(old('prefix')=='นาง') selected @endif >นาง</option>
                                    <option value="นางสาว" @if(old('prefix')=='นางสาว') selected @endif >นางสาว</option>

                                </select>
                                @error('prefix')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('ชื่อ-สกุล') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="idcard"
                                class="col-md-4 col-form-label text-md-end">{{ __('หมายเลขบัตรประชาชน') }}</label>

                            <div class="col-md-6">
                                <input id="idcard" type="text"
                                    class="form-control @error('idcard') is-invalid @enderror" name="idcard"
                                    value="{{ old('idcard') }}" maxlength="13" autocomplete="idcard" autofocus>

                                @error('idcard')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="input_tel" class="col-md-4 col-form-label text-md-end">เกรดเฉลี่ย</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control"  name="gread" id="gread" autocomplete="gread" value="{{ old('gread') }}" required>
                                <div class="invalid-feedback"> เป็นตัวเลข</div>
                                @error('gread')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="select_province" class="col-md-4 col-form-label text-md-end">ระดับการศึกษา</label>
                            <div class="col-md-6">
                                <select class="form-control" name="level" id="level" required>
                                    <option value="">เลือกระดับการศึกษา</option>
                                    <option value="1" @if(old('level')==1) selected @endif>ปวช.</option>
                                    <option value="2" @if(old('level')==2) selected @endif>ม.6</option>
                                </select>
                                <div class="invalid-feedback"> ระดับการศึกษา </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input_name" class="col-md-4 col-form-label text-md-end">โรงเรียน/สถานศึกษา</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="belong" id="belong" autocomplete ="belong" value="{{ old('belong') }}" required>
                                <div class="invalid-feedback"> โรงเรียน/สถานศึกษา</div>
                            </div>
                        </div>

                        
                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">ที่อยู่</label>
                            <div class="col-md-6">
                                <textarea class="form-control"  name="address" id="address"  rows="3" autocomplete ="address" required></textarea>
                                <div class="invalid-feedback"> กรุณากรอกที่อยู่ </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="select_province" class="col-md-4 col-form-label text-md-end">จังหวัด</label>
                            <div class="col-md-6">
                                <input id="province" type="text" class="form-control" @error('province') is-invalid @enderror name="province" value="{{ old('province') }}" required autocomplete="province" autofocus>

                                @error('province"')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input_tel" class="col-md-4 col-form-label text-md-end">เบอร์มือถือ</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="tel" id="tel" autocomplete="tel" value="{{ old('tel') }}" required>
                                <div class="invalid-feedback"> กรุณากรอกเบอร์มือถือตัวเลข 10 หลัก </div>
                                @error('tel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="parent_name" class="col-md-4 col-form-label text-md-end">{{ __('ชื่อ-สกุล ผู้ปกครอง') }}</label>

                            <div class="col-md-6">
                                <input id="parent_name" type="text" class="form-control @error('parent_name') is-invalid @enderror" name="parent_name" value="{{ old('parent_name') }}" required autocomplete="name" autofocus>

                                @error('parent_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input_parent_tel" class="col-md-4 col-form-label text-md-end">เบอร์มือถือผู่ปกครอง</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="parent_tel" id="parent_tel" autocomplete="parent_tel" value="{{ old('parent_tel') }}" required>
                                <div class="invalid-feedback"> กรุณากรอกเบอร์มือถือตัวเลข 10 หลัก </div>
                                @error('parent_tel')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
