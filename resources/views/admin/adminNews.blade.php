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
                    <div class="card-header">{{ __('จัดการข้อมูลข่าวประชาสัมพันธ์') }}
                        <a href="#" onclick="addnew()" class="btn btn-light text-success pull-right"><samp><i
                                    class="fa fa-plus-circle" aria-hidden="true"></i></samp></a>
                    </div>
                </div>

                <div class="card-body">
                    <span id="addnew" class="customhidden">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">{{ __('ข่าวประชาสัมพันธ์') }}
                                </div>
                                <div class="card-body">

                                    <form id="addnewsss" action="{{ route('addnew.create') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label for="formGroupExampleInput">หัวข้อข่าว/ประชาสัมพันธ์</label>
                                            <input type="text" class="form-control" id="pr_title" required
                                                name="pr_title" placeholder="หัวข้อข่าว/ประชาสัมพันธ์">
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput2">รายละเอียดของข่าว/ประชาสัมพันธ์</label>

                                            <textarea class="form-control" id="pr_detail" name="pr_detail" placeholder="รายละเอียดของข่าว/ประชาสัมพันธ์"
                                                rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="formGroupExampleInput2">เอกสารแนบ(ถ้ามี)</label>
                                            <div class="input-group">
                                                <input type="file" autofocus name="pr_file"
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
                                <th>รายละเอียด</th>
                                <th>วันที่ประกาศ</th>
                                <th>ไฟล์</th>
                                <th>สถานะ</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($news as $key => $new)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $new->pr_title }}</td>
                                    <td>
                                        <pre>{{ $new->pr_detail }}</pre>
                                    </td>
                                    <td>{{ $new->pr_date }}</td>
                                    <td>
                                        {{-- {{ $new->pr_file }} --}}
                                        @if (!empty($new->pr_file))
                                            <a class="btn btn-outline-success"
                                                href="{{ url('getfile/pr_file/' . $new->pr_file) }}"><i
                                                    class="bi bi-download"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- {{ $new->pr_staus }} --}}
                                        <div class="btn-group">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input btn btn-outline-secondary"
                                                    onchange="Pr_upstatus({{ $new->id }})" type="checkbox"
                                                    role="switch" @if ($new->pr_staus == 1) checked @endif
                                                    id="estatus{{ $new->id }}">

                                            </div>

                                            <form action="{{ route('data.destroy', $new->id) }}" method="POST"
                                                id="delete-form">
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
    </script>
@endpush
