@extends('layouts.frontendlayout')

@section('content')
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> --}}
    <div class="container-fluid">
        <h1 class="h3 mb-0 text-gray-800">ข้อมูการสมัคร</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        @if (session('status'))
            <h6 class="alert alert-success">{{ session('status') }}</h6>
        @endif
        <table id="example" class="table table-striped table-hover">
            <thead>
                <td>#</td>
                <td>เลขที่</td>
                <td>โครงการ</td>
                <td>หลักสูตร</td>
                <td>เอกสาร</td>
                <td>สถานะ</td>
            </thead>
            <tbody>
                @foreach ($regists as $key => $regist)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $regist->id }}
                            <button class='btn btn-outline-info viewregists' data-id='{{ $regist->id ?? '' }}'
                                title="ดูรายละเอียด"><samp><i class="bi bi-eye-fill"></i>
                                </samp></button>
                        </td>
                        <td>{{ $regist->Projectname }}</td>
                        <td> {{ $regist->Cosename }}</td>
                        <td>
                            <ul>
                                <li>เอกสารการชำระเงิน<br>
                                  
                                    @if ($regist->std_status == null || $regist->std_status == 2)
                                        <form id="reg{{ $regist->id }}" action="{{ route('user.uppayment') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group">
                                                <input name="idreg" id="idreg" type="hidden"
                                                    value="{{ $regist->id }}">
                                                <input type="file" required name="payment" onchange="this.form.submit()"
                                                    placeholder="กรุณาเลือกไฟล์" class="form-control" />
                                                <span class="input-group-text" id="basic-addon2"><i
                                                        class="bi bi-cash-stack"></i></span>
                                            </div>

                                        </form>
                                    @else
                                        <a class="btn btn-outline-success"
                                            href="{{ url('viewfile/payment/' . $regist->payment) }}"><i
                                                class="bi bi-cash-stack"></i></a>
                                        {{ $regist->dateup_p }}
                                    @endif
                                </li>

                                @if ($regist->stdpic == null)
                                    <li>รูปถ่าย
                                       
                                        <form id="formpicfile{{ $regist->id }}" action="{{ route('uploadpicFile') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input name="idreg" id="idreg" type="hidden"
                                                    value="{{ $regist->id }}">
                                                    <div class="input-group">
                                                        <input type="file" onchange="this.form.submit()"  accept="image/*" name="picFile"
                                                            placeholder="กรุณาเลือกไฟล์" class="form-control" />
                                                        <span class="input-group-text" id="basic-addon2"><i
                                                                class="bi bi-file-earmark-image"></i></span>
                                                    </div>
                                        </form>

                                    </li>
                                @endif
                                @if ($regist->school_record == null)
                                    <li>ผลการเรียน
                                        <form id="formcustomFile{{ $regist->id }}" action="{{ route('uploadcustomFile') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input name="idreg" id="idreg" type="hidden"
                                                    value="{{ $regist->id }}">
                                                    <div class="input-group">
                                                        <input type="file" onchange="this.form.submit()" name="customFile" id="customFile"
                                                            placeholder="กรุณาเลือกไฟล์" class="form-control" accept=".pdf">
                                                        <span class="input-group-text" id="basic-addon2"><i
                                                                class="bi bi-filetype-pdf"></i></span>
            
                                                    </div>
                                        </form>
                                    </li>
                                @endif
                                @if ($regist->portfolio_file == null)
                                    <li>ไฟล์ผลงาน
                                        <form id="formportfolio_file{{ $regist->id }}" action="{{ route('uploadportfolio_file') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input name="idreg" id="idreg" type="hidden"
                                                    value="{{ $regist->id }}">
                                                    <div class="input-group">
                                                        <input type="file" placeholder="กรุณาเลือกไฟล์" class="form-control"
                                                            name="portfolio_file" onchange="this.form.submit()" id="portfolio_file" accept=".pdf">
                                                        <span class="input-group-text" id="basic-addon2"><i
                                                                class="bi bi-filetype-pdf"></i></span>
            
                                                    </div>
                                        </form>
                                    </li>
                                @endif
                                @if ($regist->guidance_teacher == null && $regist->teacher ==1)
                                    <li>เอกสารรับรองครูแนะแนว
                                        <form id="formguidance_teacher{{ $regist->id }}" action="{{ route('uploadguidance_teacher') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input name="idreg" id="idreg" type="hidden"
                                                    value="{{ $regist->id }}">
                                                    <div class="input-group">
                                                        <input type="file" placeholder="กรุณาเลือกไฟล์" class="form-control"
                                                            name="guidance_teacher" onchange="this.form.submit()"  id="guidance_teacher" accept=".pdf">
                                                        <span class="input-group-text" id="basic-addon2"><i
                                                                class="bi bi-filetype-pdf"></i></span>
            
                                                    </div>
                                        </form>
                                    </li>
                                @endif
                            </ul>

                        </td>
                        <td>
                            {{-- {{ $regist->std_status }} --}}
                            @if ($regist->std_status == null)
                                รอเอกสารชำระเงิน
                            @elseif($regist->std_status == 1)
                                ชำระเงินรอตรวจสอบ
                            @elseif($regist->std_status == 2)
                                ยื่นเอกสารชำระเงินอีกครั้ง
                            @elseif($regist->std_status == 3)
                                ชำระเงินเรียบร้อยรอผลการสมัคร
                            @elseif($regist->std_status == 4)
                                ผ่าน
                            @endif

                            <button class='btn btn-outline-info viewregists' data-id='{{ $regist->id ?? '' }}'
                                title="ดูรายละเอียด"><samp><i class="bi bi-eye-fill"></i>
                                </samp></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
    <div class="modal fade" id="viewregists" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ข้อมูการสมัคร</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewregistsdetail">
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // $(document).ready(function() {
            // show the alert
            setTimeout(function() {
                $(".alert").alert('close');
            }, 5000);
            // });

            $('#example').on('click', '.viewregists', function() {
                var id = $(this).attr('data-id');

                //  alert(idip);
                // $('#id_ip').val($(this).attr('data-id'));
                // $('#id_statusupdate').val($(this).data('st'));
                $('#viewregists').modal('show');
                $.ajax({
                    url: '{{ route('user.viewregistsdetail') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    type: "post",

                    success: function(response) {
                        console.log(response);
                        $('#viewregistsdetail').html(response).show();
                        //    displayMessage("Event updated");
                        //window.location.reload();

                    },
                    // error: function (data) {
                    // alert('error; ' + eval(data));
                    //console.log(data.status + ':' + data.statusText,data.responseText);
                });

            });
        });
    </script>
@endpush
