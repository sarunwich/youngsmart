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
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('โครงการ') }}
                            <a href="#" onclick="addproject()" class="btn btn-light text-success pull-right"><samp><i
                                        class="fa fa-plus-circle" aria-hidden="true"></i></samp></a>
                        </div>
                    </div>

                    <div class="card-body">
                        <span id="addproject" >
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">{{ __('รายละเอียดโครงการ') }}
                                    </div>
                                    <div class="card-body">

                                        <form id="addprojectsss" action="{{ route('addproject.create') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label for="formGroupExampleInput">ชื่อโครงการ</label>
                                                <input type="text" class="form-control" id="Projectname" required
                                                    name="Projectname" value="{{ old('Projectname') }}"
                                                    placeholder="โครงการ">
                                                @error('Projectname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="formGroupExampleInput2">รายละเอียด</label>

                                                <textarea class="form-control" id="Projectdetail" name="Projectdetail" value="{{ old('Projectdetail') }}"
                                                    placeholder="รายละเอียด" rows="3"></textarea>
                                                @error('Projectdetail')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="formGroupExampleInput">ประเภท</label>
                                                <input type="text" class="form-control" id="tcas" required
                                                    value="{{ old('tcas') }}" name="tcas" placeholder="TCAS 1/66">
                                                @error('tcas')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="formGroupExampleInput">ปี</label>
                                                <input type="text" class="form-control" id="year" required
                                                    name="year" placeholder="ปี" value="{{ date('Y') + 543 }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="formGroupExampleInput2">เอกสารแนบ</label>
                                                <div class="input-group">
                                                    <input type="file" autofocus name="Projectfile" accept=".pdf"
                                                        placeholder="Enter Projectfile" class="form-control" />
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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#Projectdetail').summernote({
            height: 450,
        });
    });
</script>
    <script>
        function addproject() {
            // document.getElementById("addproject").style.display = 'block';
            var addclass = document.getElementById("addproject");
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
                url: "{{ url('/admin/PUpstatus') }}",
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

        function Pr_teacher(id) {

            var checkBox = document.getElementById("tstatus" + id);
            var status = 0;
            if (checkBox.checked == true) {

                status = 1;
            } else {

                status = 0;
            }
            $.ajax({
                url: "{{ url('/admin/Prteacher') }}",
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
    </script>
@endpush
