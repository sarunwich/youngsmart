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
            $strMonthCut = [
                '',
                'ม.ค.',
                'ก.พ.',
                'มี.ค.',
                'เม.ย.',
                'พ.ค.',
                'มิ.ย.',
                'ก.ค.',
                'ส.ค.',
                'ก.ย.',
                'ต.ค.',
                'พ.ย.',
                'ธ.ค.',
            ];
            $strMonthThai = $strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear";
            //return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
        }
    @endphp
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: '{{ session('success') }}',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        </script>
                    @endif

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

                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-hover"
                                style="max-width: 100%; word-wrap: break-word;">
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


                                                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editCourseModal"
                                                        onclick="populateEditForm({{ $cose->id }}, '{{ $cose->Cosename }}', '{{ $cose->datestart }}', '{{ $cose->dateend }}', '{{ $cose->Cosefile }}')">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <form action="{{ route('courses.destroy', $cose->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger">
                                                            <i class="bi bi-trash3-fill"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                <!-- Edit Button -->

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
    </div>

    <!-- Edit Course Modal -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourseModalLabel">Edit หลักสูตรที่เปิดรับ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCourseForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="editCosename">หลักสูตร</label>
                            <input type="text" class="form-control" id="editCosename" required name="Cosename">
                        </div>
                        <div class="form-group">
                            <label for="editDatestart">วันที่เริ่ม</label>
                            <input type="text" class="form-control" id="editDatestart" required name="datestart">
                        </div>
                        <div class="form-group">
                            <label for="editDateend">วันที่สิ้นสุด</label>
                            <input type="text" class="form-control" id="editDateend" required name="dateend">
                        </div>
                        <div class="form-group">
                            <label for="editCosefile">เอกสารแนบ</label>
                            <div class="input-group">
                                <input type="file" name="Cosefile" accept=".pdf" class="form-control" />
                                <span class="input-group-text"><i class="bi bi-filetype-pdf"></i></span>
                            </div>
                            <p id="currentFile"></p>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        function populateEditForm(id, cosename, datestart, dateend, cosefile) {
            // Set the form action URL dynamically
            document.getElementById('editCourseForm').action = '{{ url('updatecose') }}/' + id;

            // Populate the form fields with data
            document.getElementById('editCosename').value = cosename;
            document.getElementById('editDatestart').value = datestart;
            document.getElementById('editDateend').value = dateend;
            document.getElementById('currentFile').textContent = 'Current File: ' + cosefile;
        }

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
                url: "{{ url('/admin/CouseUpstatus') }}",
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

        // Initialize Flatpickr after the modal is shown
        $('#editCourseModal').on('shown.bs.modal', function() {
            flatpickr("#editDatestart", {
                dateFormat: "Y-m-d",
                defaultDate: document.getElementById('editDatestart').value,
            });
            flatpickr("#editDateend", {
                dateFormat: "Y-m-d",
                defaultDate: document.getElementById('editDateend').value,
            });
        });
    </script>
@endpush
