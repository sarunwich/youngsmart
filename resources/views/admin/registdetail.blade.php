@extends('layouts.admin')
@push('style')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"> --}}
@endpush
@section('content')
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> --}}
    <div class="container-fluid">
        <h1 class="h3 mb-0 text-gray-800">ข้อมูการสมัคร</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        @if (session('status'))
            <h6 class="alert alert-success">{{ session('status') }}</h6>
        @endif
        <form method="GET" action="{{ route('admin.regist') }}">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search" value="{{ $search }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form>
        <table id="example" class="table table-striped table-hover">
            <thead>
                <td>#</td>
                <td>เลขที่</td>
                <th>ชื่อ-สกุล</th>
                <td>โครงการ</td>
                <td>หลักสูตร</td>
                <td>เอกสารชำระเงิน</td>
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
                        <td>{{ $regist->p }}{{ $regist->name }}</td>
                        <td>{{ $regist->Projectname }}</td>
                        <td> {{ $regist->Cosename }}</td>
                        <td>
                            @if ($regist->payment)
                                <a class="btn btn-outline-success"
                                    href="{{ url('viewfile/payment/' . $regist->payment) }}"><i
                                        class="bi bi-cash-stack"></i></a>
                                {{ $regist->dateup_p }}
                            @endif

                        </td>
                        <td>{{ $regist->std_status }}
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
                            <form action="{{ route('admin.upstatus') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input name="idreg" id="idreg" type="hidden" value="{{ $regist->id }}">
                                <select class="form-select" name="updstatus" onchange="this.form.submit()" aria-label="Default select example">
                                    <option selected>เลือกสถานะ</option>
                                    <option value="2">ยื่นเอกสารชำระเงินอีกครั้ง</option>
                                    <option value="3">ชำระเงินเรียบร้อย</option>
                                    <option value="4">ผ่าน</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {{ $regists->links() }}
        </div>

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
                    url: '{{ route('admin.viewregistsdetail') }}',
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
