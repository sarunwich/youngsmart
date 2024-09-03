@extends('layouts.frontendlayout')
@push('style')
    <style>
        .required {
            color: red;
        }
    </style>
@endpush
@section('content')
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div> --}}
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-12 col-xl-12">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">สมัครเรียน</h3>
                            <form action="{{ route('user.registdb') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-6 mb-4">
                                        <label class="form-label">โครงการ <span class="required">*</span></label>
                                        <select class="form-control" onchange="checkteacher(this.value)" name="project">
                                            <option value="">เลือกโครงการ</option>
                                            @foreach ($projects as $key => $project)
                                                <option value="{{ $project->id }}"
                                                    @if (old('link') == $project->id) selected @endif>
                                                    {{ $project->Projectname }}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                    <div class="col-6 mb-4">
                                        <label class="form-label">หลักสูตร <span class="required">*</span></label>
                                        <select class="form-control" name="courses">
                                            <option value="">เลือกหลักสูตร</option>
                                            @foreach ($courses as $key => $course)
                                                <option
                                                    value="{{ $course->id }}"@if (old('link') == $course->id) selected @endif>
                                                    {{ $course->Cosename }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="input_tel" class="form-label">Link
                                            ผลงาน(ถ้ามี)</label>

                                        <input type="text" class="form-control" name="link" id="link"
                                            autocomplete="off" value="{{ old('link') }}">
                                        @error('link')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="input_tel" class="form-label">ข้อมูลติดต่อ
                                            Facebook <span class="required">*</span>
                                        </label>

                                        <input type="text" class="form-control" name="facebook" id="facebook"
                                            autocomplete="facebook" value="{{ old('facebook') }}" required>
                                        <div class="invalid-feedback">ข้อมูลติดต่อ Facebook </div>
                                        @error('facebook')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="input_tel" class="form-label">ข้อมูลติดต่อ ID
                                            Line <span class="required">*</span>
                                        </label>

                                        <input type="text" class="form-control" name="line" id="line"
                                            autocomplete="line" value="{{ old('line') }}" required>
                                        <div class="invalid-feedback">ข้อมูลติดต่อ ID Line </div>
                                        @error('line')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-4">
                                        <label class="form-label">อัพโหลดรูปถ่ายที่เห็นหน้าชัดเจน</label>

                                        <div class="input-group">
                                            {{-- <input type="file" class="custom-file-input" required name="picFile" id="picFile"
                                                accept="image/*">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <input type="text" id="_picFile" class="form-control d-none" value="">
                                            <div class="invalid-feedback"> กรุณาเลือกไฟล์ </div> --}}

                                            <input type="file"  accept="image/*" name="picFile"
                                                placeholder="กรุณาเลือกไฟล์" class="form-control" />
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="bi bi-file-earmark-image"></i></span>
                                        </div>
                                        <small class="text-muted required"><span
                                                class="required">สามารถอัปโหลดได้ภายหลัง</span></small>
                                    </div>

                                    <div class="col-6 mb-4">
                                        <label class="form-label">อัปโหลดผลการเรียน</label>

                                        <div class="input-group">
                                            <input type="file" name="customFile" id="customFile"
                                                placeholder="กรุณาเลือกไฟล์" class="form-control" accept=".pdf">
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="bi bi-filetype-pdf"></i></span>

                                        </div>
                                        <small class="text-muted ">ชนิดไฟล์ เป็น PDF. <span class="required">
                                                สามารถอัปโหลดได้ภายหลัง </span></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-4">
                                        <label class="form-label">ไฟล์ผลงาน</label>

                                        <div class="input-group">
                                            <input type="file" placeholder="กรุณาเลือกไฟล์" class="form-control"
                                                name="portfolio_file" id="portfolio_file" accept=".pdf">
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="bi bi-filetype-pdf"></i></span>

                                        </div>
                                        <small class="text-muted ">ชนิดไฟล์ เป็น PDF. <span
                                                class="required">สามารถอัปโหลดได้ภายหลัง</span></small>
                                    </div>
                                    <div class="col-6 mb-4 " id="teacher" style="display: none">
                                        <label class="form-label">เอกสารรับรองครูแนะแนว</label>

                                        <div class="input-group">
                                            <input type="file" placeholder="กรุณาเลือกไฟล์" class="form-control"
                                                name="guidance_teacher" disabled id="guidance_teacher" accept=".pdf">
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="bi bi-filetype-pdf"></i></span>

                                        </div>
                                        <small class="text-muted ">ชนิดไฟล์ เป็น PDF. <span
                                                class="required">สามารถอัปโหลดได้ภายหลัง</span></small>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12 mb-4">

                                        <div class="col" align="center">
                                            <div>
                                                <font color="#FF0000">*** การสมัครจะสมบูรณ์ก็ต่อเมื่อ
                                                    ส่งหลักฐานการสมัครและชำระเงินแล้วเท่านั้น
                                                    หลักฐานการชำระเงินให้อัพโหลดอีกครั้งแยกจากหลักฐานการสมัคร</font>
                                            </div>
                                            <div align="center" class="indent2">ชำระเงินได้ที่ ธนาคารไทยพาณิชย์ </div>
                                            <div align="center" class="indent2">ขื่อบัญชี มหาวิทยาลัยทักษิณ
                                                (คณะวิทยาศาสตร์)</div>
                                            <div align="center" class="indent2">เลขที่บัญชี 425-076285-4 </div>

                                            <div class="form-check">
                                                <input class="form-check-input required" type="checkbox"
                                                    name="checkbox_hobby2" id="hobby2" value="1" required>
                                                <label class="form-check-label" for="hobby2">
                                                    ข้าพเจ้ารับรองว่าข้อมูลข้างต้นเป็นความจริงทุกประการและได้ตรวจสอบความถูกต้องเรียบร้อยแล้ว
                                                </label>
                                                <div class="invalid-feedback"> รับรองว่าข้อมูลข้างต้นเป็นความจริงทุกประการ
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 pt-2">
                                    <div class="col" align="center">
                                        <input class="btn btn-primary btn-lg" type="submit" value="บันทึก" />
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
    <script>
        function checkteacher(id) {
            // alert(id);
            $.ajax({
                url: '{{ route('user.checkteacher') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                },
                type: "post",

                success: function(response) {
                    console.log(response);
                    //  $('#viewregistsdetail').html(response).show();
                    //    displayMessage("Event updated");
                    //window.location.reload();
                    if (response == 1) {

                        document.getElementById("teacher").style.display = "block";
                        document.getElementById("guidance_teacher").disabled = false;
                    } else {
                        document.getElementById("teacher").style.display = 'none';
                        document.getElementById("guidance_teacher").disabled = true;
                    }
                },
                // error: function (data) {
                // alert('error; ' + eval(data));
                //console.log(data.status + ':' + data.statusText,data.responseText);
            });
        }
    </script>
@endpush
