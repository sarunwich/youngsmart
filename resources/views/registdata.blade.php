@extends('layouts.home')
@push('style')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.1/css/responsive.bootstrap5.min.css">
    <style>
        .bd-callout {
            padding: 0.05rem;
            margin-top: 0.05rem;
            margin-bottom: 0.05rem;
            border: 1px solid #eee;
            border-left-width: 0.25rem;
            border-radius: 0.25rem;
        }

        .bd-callout-info {
            border-left-color: #5bc0de;
            background-color: #d9edf7;
        }

        .bd-callout-warning {
            border-left-color: #f0ad4e;
            background-color: #fcf8e3;
        }

        .bd-callout-danger {
            border-left-color: #d9534f;
            background-color: #f2dede;
        }

        .bd-callout-primary {
            border-left-color: #337ab7;
            background-color: #d9edf7;
        }

        .bd-callout-success {
            border-left-color: #5cb85c;
            background-color: #dff0d8;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        {{-- <form method="GET" action="{{ route('registdata') }}">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search"
                    value="{{ $search }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form> --}}
        <div class="table-responsive">
            <table id="myTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ชื่อ-สกุล</th>
                        <th>โครงการ</th>
                        <th>หลักสูตร</th>
                        <th>สถานะ</th>
                        <!-- Add more columns as needed -->
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = $data->count(); // Get the total count of the data
                    @endphp
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $total - $key }}</td>
                            <td>{{ $item->p }}{{ $item->name }}</td>
                            <td>{{ $item->Projectname }}</td>
                            <td>{{ $item->Cosename }}</td>
                            <td>
                                {{-- {{ $item->std_status }} --}}
                                @if ($item->std_status == null)
                                    <div class="bd-callout bd-callout-warning">
                                        รอเอกสารชำระเงิน
                                    </div>
                                @elseif($item->std_status == 1)
                                    <div class="bd-callout bd-callout-info">
                                        ชำระเงินรอตรวจสอบ
                                    </div>
                                @elseif($item->std_status == 2)
                                    <div class="bd-callout bd-callout-danger">
                                        ยื่นเอกสารชำระเงินอีกครั้ง
                                    </div>
                                @elseif($item->std_status == 3)
                                    <div class="bd-callout bd-callout-primary">
                                        ชำระเงินเรียบร้อยรอผลการสมัคร
                                    </div>
                                @elseif($item->std_status == 4)
                                    <div class="bd-callout bd-callout-success">
                                        ผ่านการคัดเลือก
                                    </div>
                                @endif
                            </td>
                            <!-- Add more columns as needed -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="d-flex">
            {!! $data->links() !!}
        </div> --}}

    </div>
@endsection
@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.1/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({

                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endpush
