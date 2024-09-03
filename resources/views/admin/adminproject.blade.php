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
                        <div class="card-header">{{ __('โครงการ') }}
                            <a href="#" onclick="addproject()" class="btn btn-light text-success pull-right"><samp><i
                                        class="fa fa-plus-circle" aria-hidden="true"></i></samp></a>
                        </div>


                        <div class="card-body" style="overflow-x: auto;">
                            <span id="addproject" class="customhidden">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">{{ __('รายละเอียดโครงการ') }}
                                        </div>
                                        <div class="card-body">

                                            <form id="addprojectsss" action="{{ route('addproject.create') }}"
                                                method="POST" enctype="multipart/form-data">
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
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-hover"
                                    style="max-width: 100%; word-wrap: break-word;">
                                    <thead>
                                        <tr>
                                            <th>ลำดับที่</th>
                                            <th>หัวข้อ</th>
                                            <th>รายละเอียด</th>
                                            <th>ประเภท</th>
                                            <th>ปี</th>
                                            <th>ไฟล์</th>
                                            <th>เอกสารครูแนะแนว</th>
                                            <th>สถานะ</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $key => $project)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $project->Projectname }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $key }}">
                                                        View Details
                                                    </button>
                                                    {{-- <pre>{!! $project->Projectdetail !!}</pre> --}}
                                                </td>
                                                <td>
                                                    {{ $project->tcas }}
                                                </td>
                                                <td>
                                                    {{ $project->year }}
                                                </td>
                                                <td>

                                                    @if (!empty($project->Projectfile))
                                                        <a class="btn btn-outline-success"
                                                            href="{{ url('getfile/Projectfile/' . $project->Projectfile) }}"><i
                                                                class="bi bi-download"></i></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input btn btn-outline-secondary"
                                                                onchange="Pr_teacher({{ $project->id }})" type="checkbox"
                                                                role="switch"
                                                                @if ($project->teacher == 1) checked @endif
                                                                id="tstatus{{ $project->id }}">

                                                        </div>
                                                    </div>
                                                </td>
                                                <td>

                                                    <div class="btn-group">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input btn btn-outline-secondary"
                                                                onchange="Pr_upstatus({{ $project->id }})"
                                                                type="checkbox" role="switch"
                                                                @if ($project->status == 1) checked @endif
                                                                id="estatus{{ $project->id }}">

                                                        </div>


                                                        <button type="button" class="btn btn-outline-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $key }}">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </button>
                                                        <form action="{{ route('Projectfile.destroy', $project->id) }}"
                                                            method="POST" id="delete-form">
                                                            @method('DELETE')
                                                            @csrf

                                                            <!-- Add your delete button or link here -->
                                                            <button type="submit" class="btn btn-outline-danger"
                                                                onclick="confirmDelete(event)"><i
                                                                    class="bi bi-trash3-fill"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Modal detail-->
                                            <div class="modal fade" id="detailModal{{ $key }}" tabindex="-1"
                                                aria-labelledby="detailModalLabel{{ $key }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="detailModalLabel{{ $key }}">รายละเอียด
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div id="summernote{{ $key }}"
                                                                class="summernote-content">{!! $project->Projectdetail !!}</div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal for Editing -->
                                            <div class="modal fade" id="editModal{{ $key }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $key }}" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editModalLabel{{ $key }}">แก้ไขข้อมูลโครงการ
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('projects.update', $project->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT') <!-- Use PUT or PATCH for updating -->

                                                                <div class="form-group">
                                                                    <label
                                                                        for="Projectname{{ $key }}">ชื่อโครงการ</label>
                                                                    <input type="text" class="form-control"
                                                                        id="Projectname{{ $key }}"
                                                                        name="Projectname"
                                                                        value="{{ $project->Projectname }}" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label
                                                                        for="Projectdetail{{ $key }}">รายละเอียด</label>
                                                                    <textarea class="form-control summernote" id="Projectdetail{{ $key }}" name="Projectdetail"
                                                                        rows="3">{{ $project->Projectdetail }}</textarea>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="tcas{{ $key }}">ประเภท</label>
                                                                    <input type="text" class="form-control"
                                                                        id="tcas{{ $key }}" name="tcas"
                                                                        value="{{ $project->tcas }}" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="year{{ $key }}">ปี</label>
                                                                    <input type="text" class="form-control"
                                                                        id="year{{ $key }}" name="year"
                                                                        value="{{ $project->year }}" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label
                                                                        for="Projectfile{{ $key }}">เอกสารแนบ</label>
                                                                    <div class="input-group">
                                                                        <input type="file" name="Projectfile"
                                                                            class="form-control" accept=".pdf">
                                                                        <span class="input-group-text"
                                                                            id="basic-addon2"><i
                                                                                class="bi bi-filetype-pdf"></i></span>
                                                                    </div>
                                                                    @if (!empty($project->Projectfile))
                                                                        <a href="{{ url('getfile/Projectfile/' . $project->Projectfile) }}"
                                                                            class="btn btn-outline-info mt-2">Download
                                                                            Current File</a>
                                                                    @endif
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        Changes</button>
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#Projectdetail').summernote({
                height: 450,
            });
        });

     


        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.summernote').summernote({
                height: 450, // Set the height of the editor
                focus: true // Set focus to the editable area after initializing summernote
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
