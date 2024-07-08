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
@endpush
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('จัดการผลการคัดเลือก') }}
                        <a href="#" onclick="addnew()" class="btn btn-light text-success pull-right"><samp><i
                                    class="fa fa-plus-circle" aria-hidden="true"></i></samp></a>
                    </div>
                </div>

                <div class="card-body">
                    <span id="addnew" class="customhidden">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">{{ __('ผลการคัดเลือก') }}
                                </div>
                                <div class="card-body">

                                    <form id="addnewsss" action="{{ route('results.create') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6 mb-4">
                                                <label class="form-label">โครงการ</label>
                                                <select class="form-control" name="project">
                                                    <option value="">เลือกโครงการ</option>
                                                    @foreach ($projects as $key => $project)
                                                        <option value="{{ $project->id }}"
                                                            @if (old('link') == $project->id) selected @endif>
                                                            {{ $project->Projectname }}</option>
                                                    @endforeach
        
        
                                                </select>
                                            </div>
                                            <div class="col-6 mb-4">
                                                <label class="form-label">หลักสูตร</label>
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
                                        <div class="form-group">
                                            <label for="formGroupExampleInput">หัวข้อ</label>
                                            <input type="text" class="form-control" id="announcements" required
                                                name="announcements" placeholder="หัวข้อ">
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="formGroupExampleInput2">รายละเอียด</label>

                                            <textarea class="form-control" id="pr_detail" name="pr_detail" placeholder="รายละเอียดของข่าว/ประชาสัมพันธ์"
                                                rows="3"></textarea>
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="formGroupExampleInput2">เอกสารแนบ</label>
                                            <div class="input-group">
                                                <input type="file" autofocus name="announcementsfile"
                                                    placeholder="Enter update_file" class="form-control" />
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
                                <th>หัวข้อ</th>
                                <th>โครงการ</th>
                                <th>หลักสูตร</th>
                                <th>วันที่ประกาศ</th>
                                <th>ไฟล์</th>
                                <th>สถานะ</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($announcements as $key => $announcement)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $announcement->announcements }}</td>
                                    <td>
                                    {{ $announcement->Projectname }}
                                    </td>
                                    <td>{{ $announcement->Cosename }}</td>
                                    <td>{{ $announcement->created_at }}</td>
                                    <td>
                                        
                                        @if (!empty($announcement->announcementsfile))
                                            <a class="btn btn-outline-success"
                                                href="{{ url('getfile/announcementsfile/' . $announcement->announcementsfile) }}"><i
                                                    class="bi bi-download"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                       
                                        <div class="btn-group">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input btn btn-outline-secondary"
                                                    onchange="Exam_upstatus({{ $announcement->id }})" type="checkbox"
                                                    role="switch" @if ($announcement->status == 1) checked @endif
                                                    id="estatus{{ $announcement->id }}">

                                            </div>

                                            <form action="{{ route('data.destroy', $announcement->id) }}" method="POST"
                                                id="delete-form">
                                                @method('DELETE')
                                                @csrf

                                               
                                                <button type="submit" class="btn btn-outline-danger"
                                                    onclick="confirmDelete(event)"><i
                                                        class="bi bi-trash3-fill"></i></button>
                                            </form>

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
    <script>
        function addnew() {
            // document.getElementById("addnew").style.display = 'block';
            var addclass = document.getElementById("addnew");
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


        function Exam_upstatus(id) {

            var checkBox = document.getElementById("estatus" + id);
            var status = 0;
            if (checkBox.checked == true) {

                status = 1;
            } else {

                status = 0;
            }
            $.ajax({
                url: "{{ url('/admin/Exam_upstatus') }}",
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
