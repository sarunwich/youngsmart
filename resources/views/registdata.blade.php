@extends('layouts.home')
@push('style')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"> --}}
@endpush
@section('content')
    <div class="container-fluid">
        <form method="GET" action="{{ route('registdata') }}">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search" value="{{ $search }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form>

        <table class="table">
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
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->p }}{{ $item->name }}</td>
                        <td>{{ $item->Projectname }}</td>
                        <td>{{ $item->Cosename }}</td>
                        <td>
                            {{-- {{ $item->std_status }} --}}
                            @if ($item->std_status == null)
                                รอเอกสารชำระเงิน
                            @elseif($item->std_status == 1)
                                ชำระเงินรอตรวจสอบ
                            @elseif($item->std_status == 2)
                                ยื่นเอกสารชำระเงินอีกครั้ง
                            @elseif($item->std_status == 3)
                                ชำระเงินเรียบร้อยรอผลการสมัคร
                            @elseif($item->std_status == 4)
                                ผ่าน
                            @endif
                        </td>
                        <!-- Add more columns as needed -->
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex">
            {!! $data->links() !!}
        </div>

    </div>
@endsection
