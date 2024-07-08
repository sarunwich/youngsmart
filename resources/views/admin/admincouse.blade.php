@extends('layouts.admin')
@section('title')
    {{ 'Admin' }} @parent
@endsection
@push('style')
    <style>
        .customhidden {
            display: none;
        }

        .customshow {
            /* display: block; */
            width: auto;
            /* height: 100px; */
            /* border: 1px solid #c3c3c3; */
            display: flex;
            justify-content: center;
        }
    </style>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endpush
@section('content')
@php
  function DateThai($strDate)
        {
            $strYear = date('Y', strtotime($strDate)) + 543;
            $strMonth = date('n', strtotime($strDate));
            $strDay = date('j', strtotime($strDate));
            $strHour = date('H', strtotime($strDate));
            $strMinute = date('i', strtotime($strDate));
            $strSeconds = date('s', strtotime($strDate));
            $strMonthCut = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
            $strMonthThai = $strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
            //return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
        }    
@endphp
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('หลักสูตรที่เปิดรับ') }}
                            <a href="#" onclick="addcose()" class="btn btn-light text-success pull-right"><samp><i
                                        class="fa fa-plus-circle" aria-hidden="true"></i></samp></a>
                        </div>
                    </div>

                    <div class="card-body">
                        <span id="addcose" class="customhidden">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">{{ __('หลักสูตรที่เปิดรับ') }}
                                    </div>
                                    <div class="card-body">

                                        <form id="addcosesss" action="{{ route('addcose.create') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label for="formGroupExampleInput">หลักสูตร</label>
                                                <input type="text" class="form-control" id="Cosename" required
                                                    name="Cosename" placeholder="หลักสูตร">
                                            </div>
                                            <div class="form-group">
                                                <label for="formGroupExampleInput">วันที่เริ่ม</label>
                                                <input type="text" class="form-control" id="datestart" required
                                                    name="datestart" placeholder="วันที่เริ่ม">
                                            </div>
                                            <div class="form-group">
                                                <label for="formGroupExampleInput">วันที่สิ้นสุด</label>
                                                <input type="text" class="form-control" id="dateend" required
                                                    name="dateend" placeholder="วันที่สิ้นสุด">
                                            </div>
                                            <div class="form-group">
                                                <label for="formGroupExampleInput2">เอกสารแนบ</label>
                                                <div class="input-group">
                                                    <input type="file" autofocus name="Cosefile" accept=".pdf"
                                                        placeholder="Enter เอกสารแนบ" class="form-control" />
                                                    <span class="input-group-text" id="basic-addon2"><i
                                                            class="bi bi-filetype-pdf"></i></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" onclick="showWaitAlert()"
                                                    class="btn btn-primary">บันทึก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </span>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>หลักสูตร</th>
                                    <th>วันที่รับสมัคร</th>

                                    <th>ไฟล์</th>
                                    <th>สถานะ</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coses as $key => $cose)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $cose->Cosename }}</td>
                                        <td>{{ DateThai($cose->datestart) }} ถึง {{ DateThai($cose->dateend) }}</td>

                                        <td>
                                            {{-- {{ $cose->pr_file }} --}}
                                            @if (!empty($cose->Cosefile))
                                                <a class="btn btn-outline-success"
                                                    href="{{ url('getfile/Cosefile/' . $cose->Cosefile) }}"><i
                                                        class="bi bi-download"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- {{ $cose->pr_staus }} --}}
                                            <div class="btn-group">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input btn btn-outline-secondary"
                                                        onchange="Pr_upstatus({{ $cose->id }})" type="checkbox"
                                                        role="switch" @if ($cose->status == 1) checked @endif
                                                        id="estatus{{ $cose->id }}">

                                                </div>

                                                {{-- <form action="{{ route('data.destroy', $cose->id) }}" method="POST"
                                                id="delete-form">
                                                @method('DELETE')
                                                @csrf

                                                <!-- Add your delete button or link here -->
                                                <button type="submit" class="btn btn-outline-danger"
                                                    onclick="confirmDelete(event)"><i
                                                        class="bi bi-trash3-fill"></i></button>
                                            </form> --}}

                                            </div>
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
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        function addcose() {
            // document.getElementById("addcose").style.display = 'block';
            var addclass = document.getElementById("addcose");
            addclass.classList.remove("customhidden");
            addclass.classList.add("customshow");
        }

        function showWaitAlert() {
            // Display the wait alert
            let timerInterval
            Swal.fire({
                title: '**กำลังอัปโหลดไฟล์** <br/>กรุณารอสักครู่!!',
                html: 'I will close in <b></b> milliseconds.',
                timer: 20000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })
        }


        function Pr_upstatus(id) {

            var checkBox = document.getElementById("estatus" + id);
            var status = 0;
            if (checkBox.checked == true) {

                status = 1;
            } else {

                status = 0;
            }
            $.ajax({
                url: "{{ url('/admin/PrUpstatus') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                    status: parseInt(status),
                },
                success: function(result) {
                    console.log(result);

                }
            });

        }

        function confirmDelete(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    document.getElementById('delete-form').submit();
                }
            });
        }


var input = document.getElementById("datestart");
        var flatpickrInstance = flatpickr(input);
        flatpickrInstance.setDate(new Date(input.value));
        var inputend = document.getElementById("dateend");
        var flatpickrInstanceend = flatpickr(inputend);
        flatpickrInstanceend.setDate(new Date(inputend.value));

    </script>
  
@endpush
