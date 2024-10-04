@extends('layouts.admin')
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
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> --}}
    <div class="container-fluid">
        <h1 class="h3 mb-0 text-gray-800">ข้อมูการสมัคร</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        @if (session('status'))
            <h6 class="alert alert-success">{{ session('status') }}</h6>
        @endif
        {{-- <form method="GET" action="{{ route('admin.regist') }}">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search..." name="search" value="{{ $search }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </div>
        </form> --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active position-relative" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane"
                    aria-selected="true">รอเอกสารชำระเงิน
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $regists->count() }}
                        <span class="visually-hidden">unread messages</span>
                </button>
            </li>
            <li class="nav-item position-relative" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane"
                    aria-selected="false">ชำระเงินรอตรวจสอบ
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $regists1->count() }}
                        <span class="visually-hidden">unread messages</span>
                </button>
            </li>
            <li class="nav-item position-relative" role="presentation">
                <button class="nav-link" id="profile1-tab" data-bs-toggle="tab" data-bs-target="#profile1-tab-pane"
                    type="button position-relative" role="tab" aria-controls="profile1-tab-pane"
                    aria-selected="false">ยื่นเอกสารชำระเงินอีกครั้ง
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $regists2->count() }}
                        <span class="visually-hidden">unread messages</span>
                </button>
            </li>
            <li class="nav-item position-relative" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                    type="button position-relative" role="tab" aria-controls="contact-tab-pane"
                    aria-selected="false">ชำระเงินเรียบร้อยรอผลการสมัคร
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $regists3->count() }}
                        <span class="visually-hidden">unread messages</span>
                </button>
            </li>
            <li class="nav-item position-relative" role="presentation">
                <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane"
                    type="button" role="tab" aria-controls="disabled-tab-pane"
                    aria-selected="false">ผ่านการคัดเลือก</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                tabindex="0">

                <div class="table-responsive">
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
                            @php
                                $total = $regists->count();
                            @endphp
                            @foreach ($regists as $key => $regist)
                                <tr>
                                    <td>{{ $total - $key }}</td>
                                    <td>{{ $regist->id }}
                                        <button class='btn btn-outline-info viewregists' data-id='{{ $regist->id ?? '' }}'
                                            title="ดูรายละเอียด"><samp><i class="bi bi-eye-fill"></i>
                                            </samp></button>
                                    </td>
                                    <td>{{ $regist->p }}{{ $regist->name }}
                                        {{-- {{ $regist->stdpic }}
                            <img alt="Product Image" class="w-100" src="{{ asset('storage/' . $regist->stdpic) }}" /> --}}
                                    </td>
                                    <td>{{ $regist->Projectname }}</td>
                                    <td> {{ $regist->Cosename }}</td>
                                    <td>
                                        @if ($regist->payment)
                                            <a class="btn btn-outline-success view-payment-btn" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $key }}">
                                                <i class="bi bi-cash-stack"></i>
                                            </a>

                                            <a class="btn btn-outline-success"
                                                href="{{ url('viewfile/payment/' . $regist->payment) }}"><i
                                                    class="fas fa-download"></i></a>
                                            {{ $regist->dateup_p }}
                                        @else
                                            N/A
                                        @endif

                                    </td>
                                    <td>
                                        {{-- {{ $regist->std_status }} --}}
                                        @if ($regist->std_status == null)
                                            <div class="bd-callout bd-callout-warning">
                                                รอเอกสารชำระเงิน
                                            </div>
                                        @elseif($regist->std_status == 1)
                                            <div class="bd-callout bd-callout-info">
                                                ชำระเงินรอตรวจสอบ
                                            </div>
                                        @elseif($regist->std_status == 2)
                                            <div class="bd-callout bd-callout-danger">
                                                ยื่นเอกสารชำระเงินอีกครั้ง
                                            </div>
                                        @elseif($regist->std_status == 3)
                                            <div class="bd-callout bd-callout-primary">
                                                ชำระเงินเรียบร้อยรอผลการสมัคร
                                            </div>
                                        @elseif($regist->std_status == 4)
                                            <div class="bd-callout bd-callout-success">
                                                ผ่านการคัดเลือก
                                            </div>
                                        @endif
                                        <form action="{{ route('admin.upstatus') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input name="idreg" id="idreg" type="hidden"
                                                value="{{ $regist->id }}">
                                            <select class="form-select" name="updstatus" onchange="this.form.submit()"
                                                aria-label="Default select example">
                                                <option selected>เลือกสถานะ</option>
                                                <option value="2">ยื่นเอกสารชำระเงินอีกครั้ง</option>
                                                <option value="3">ชำระเงินเรียบร้อย</option>
                                                <option value="4">ผ่านการคัดเลือก</option>
                                            </select>
                                        </form>
                                        <form action="{{ route('regist.destroy', $regist->id) }}"
                                            class="d-inline delete-form" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger delete-button">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal detail-->
                                <div class="modal fade" id="detailModal{{ $key }}" tabindex="-1"
                                    aria-labelledby="detailModalLabel{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $key }}">
                                                    รายละเอียด
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img alt="Product Image" class="w-100"
                                                    src="{{ asset('storage/payment/' . $regist->payment) }}" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                tabindex="0">
                <div class="table-responsive">
                    <table id="example1" class="table table-striped table-hover" style="width: 100%;">
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
                           
                            @php
                                $total = $regists1->count();
                            @endphp
                            @foreach ($regists1 as $key => $regist)
                                <tr>
                                    <td>{{ $total - $key }}</td>
                                    <td>{{ $regist->id }}
                                        <button class='btn btn-outline-info viewregists' data-id='{{ $regist->id ?? '' }}'
                                            title="ดูรายละเอียด"><samp><i class="bi bi-eye-fill"></i>
                                            </samp></button>
                                    </td>
                                    <td>{{ $regist->p }}{{ $regist->name }}
                                        {{-- {{ $regist->stdpic }}
                            <img alt="Product Image" class="w-100" src="{{ asset('storage/' . $regist->stdpic) }}" /> --}}
                                    </td>
                                    <td>{{ $regist->Projectname }}</td>
                                    <td> {{ $regist->Cosename }}</td>
                                    <td>
                                        @if ($regist->payment)
                                            <a class="btn btn-outline-success view-payment-btn" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $key }}">
                                                <i class="bi bi-cash-stack"></i>
                                            </a>

                                            <a class="btn btn-outline-success"
                                                href="{{ url('viewfile/payment/' . $regist->payment) }}"><i
                                                    class="fas fa-download"></i></a>
                                            {{ $regist->dateup_p }}
                                        @else
                                            N/A
                                        @endif

                                    </td>
                                    <td>
                                        {{-- {{ $regist->std_status }} --}}
                                        @if ($regist->std_status == null)
                                            <div class="bd-callout bd-callout-warning">
                                                รอเอกสารชำระเงิน
                                            </div>
                                        @elseif($regist->std_status == 1)
                                            <div class="bd-callout bd-callout-info">
                                                ชำระเงินรอตรวจสอบ
                                            </div>
                                        @elseif($regist->std_status == 2)
                                            <div class="bd-callout bd-callout-danger">
                                                ยื่นเอกสารชำระเงินอีกครั้ง
                                            </div>
                                        @elseif($regist->std_status == 3)
                                            <div class="bd-callout bd-callout-primary">
                                                ชำระเงินเรียบร้อยรอผลการสมัคร
                                            </div>
                                        @elseif($regist->std_status == 4)
                                            <div class="bd-callout bd-callout-success">
                                                ผ่านการคัดเลือก
                                            </div>
                                        @endif
                                        <form action="{{ route('admin.upstatus') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input name="idreg" id="idreg" type="hidden"
                                                value="{{ $regist->id }}">
                                            <select class="form-select" name="updstatus" onchange="this.form.submit()"
                                                aria-label="Default select example">
                                                <option selected>เลือกสถานะ</option>
                                                <option value="2">ยื่นเอกสารชำระเงินอีกครั้ง</option>
                                                <option value="3">ชำระเงินเรียบร้อย</option>
                                                <option value="4">ผ่านการคัดเลือก</option>
                                            </select>
                                        </form>
                                        <form action="{{ route('regist.destroy', $regist->id) }}"
                                            class="d-inline delete-form" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger delete-button">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal detail-->
                                <div class="modal fade" id="detailModal{{ $key }}" tabindex="-1"
                                    aria-labelledby="detailModalLabel{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $key }}">
                                                    รายละเอียด
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img alt="Product Image" class="w-100"
                                                    src="{{ asset('storage/payment/' . $regist->payment) }}" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            <div class="tab-pane fade" id="profile1-tab-pane" role="tabpanel" aria-labelledby="profile1-tab"
                tabindex="0">
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-hover" style="width: 100%;">
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
                            @php
                                $total = $regists2->count();
                            @endphp
                            @foreach ($regists2 as $key => $regist)
                                <tr>
                                    <td>{{ $total - $key }}</td>
                                    <td>{{ $regist->id }}
                                        <button class='btn btn-outline-info viewregists' data-id='{{ $regist->id ?? '' }}'
                                            title="ดูรายละเอียด"><samp><i class="bi bi-eye-fill"></i>
                                            </samp></button>
                                    </td>
                                    <td>{{ $regist->p }}{{ $regist->name }}
                                        {{-- {{ $regist->stdpic }}
                            <img alt="Product Image" class="w-100" src="{{ asset('storage/' . $regist->stdpic) }}" /> --}}
                                    </td>
                                    <td>{{ $regist->Projectname }}</td>
                                    <td> {{ $regist->Cosename }}</td>
                                    <td>
                                        @if ($regist->payment)
                                            <a class="btn btn-outline-success view-payment-btn" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $key }}">
                                                <i class="bi bi-cash-stack"></i>
                                            </a>

                                            <a class="btn btn-outline-success"
                                                href="{{ url('viewfile/payment/' . $regist->payment) }}"><i
                                                    class="fas fa-download"></i></a>
                                            {{ $regist->dateup_p }}
                                        @else
                                            N/A
                                        @endif

                                    </td>
                                    <td>
                                        {{-- {{ $regist->std_status }} --}}
                                        @if ($regist->std_status == null)
                                            <div class="bd-callout bd-callout-warning">
                                                รอเอกสารชำระเงิน
                                            </div>
                                        @elseif($regist->std_status == 1)
                                            <div class="bd-callout bd-callout-info">
                                                ชำระเงินรอตรวจสอบ
                                            </div>
                                        @elseif($regist->std_status == 2)
                                            <div class="bd-callout bd-callout-danger">
                                                ยื่นเอกสารชำระเงินอีกครั้ง
                                            </div>
                                        @elseif($regist->std_status == 3)
                                            <div class="bd-callout bd-callout-primary">
                                                ชำระเงินเรียบร้อยรอผลการสมัคร
                                            </div>
                                        @elseif($regist->std_status == 4)
                                            <div class="bd-callout bd-callout-success">
                                                ผ่านการคัดเลือก
                                            </div>
                                        @endif
                                        <form action="{{ route('admin.upstatus') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input name="idreg" id="idreg" type="hidden"
                                                value="{{ $regist->id }}">
                                            <select class="form-select" name="updstatus" onchange="this.form.submit()"
                                                aria-label="Default select example">
                                                <option selected>เลือกสถานะ</option>
                                                <option value="2">ยื่นเอกสารชำระเงินอีกครั้ง</option>
                                                <option value="3">ชำระเงินเรียบร้อย</option>
                                                <option value="4">ผ่านการคัดเลือก</option>
                                            </select>
                                        </form>
                                        <form action="{{ route('regist.destroy', $regist->id) }}"
                                            class="d-inline delete-form" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger delete-button">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal detail-->
                                <div class="modal fade" id="detailModal{{ $key }}" tabindex="-1"
                                    aria-labelledby="detailModalLabel{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $key }}">
                                                    รายละเอียด
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img alt="Product Image" class="w-100"
                                                    src="{{ asset('storage/payment/' . $regist->payment) }}" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>    
            </div>
            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                tabindex="0"><div class="table-responsive">
                    <table id="example3" class="table table-striped table-hover" style="width: 100%;">
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
                            @php
                                $total = $regists3->count();
                            @endphp
                            @foreach ($regists3 as $key => $regist)
                                <tr>
                                    <td>{{ $total - $key }}</td>
                                    <td>{{ $regist->id }}
                                        <button class='btn btn-outline-info viewregists' data-id='{{ $regist->id ?? '' }}'
                                            title="ดูรายละเอียด"><samp><i class="bi bi-eye-fill"></i>
                                            </samp></button>
                                    </td>
                                    <td>{{ $regist->p }}{{ $regist->name }}
                                        {{-- {{ $regist->stdpic }}
                            <img alt="Product Image" class="w-100" src="{{ asset('storage/' . $regist->stdpic) }}" /> --}}
                                    </td>
                                    <td>{{ $regist->Projectname }}</td>
                                    <td> {{ $regist->Cosename }}</td>
                                    <td>
                                        @if ($regist->payment)
                                            <a class="btn btn-outline-success view-payment-btn" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $key }}">
                                                <i class="bi bi-cash-stack"></i>
                                            </a>

                                            <a class="btn btn-outline-success"
                                                href="{{ url('viewfile/payment/' . $regist->payment) }}"><i
                                                    class="fas fa-download"></i></a>
                                            {{ $regist->dateup_p }}
                                        @else
                                            N/A
                                        @endif

                                    </td>
                                    <td>
                                        {{-- {{ $regist->std_status }} --}}
                                        @if ($regist->std_status == null)
                                            <div class="bd-callout bd-callout-warning">
                                                รอเอกสารชำระเงิน
                                            </div>
                                        @elseif($regist->std_status == 1)
                                            <div class="bd-callout bd-callout-info">
                                                ชำระเงินรอตรวจสอบ
                                            </div>
                                        @elseif($regist->std_status == 2)
                                            <div class="bd-callout bd-callout-danger">
                                                ยื่นเอกสารชำระเงินอีกครั้ง
                                            </div>
                                        @elseif($regist->std_status == 3)
                                            <div class="bd-callout bd-callout-primary">
                                                ชำระเงินเรียบร้อยรอผลการสมัคร
                                            </div>
                                        @elseif($regist->std_status == 4)
                                            <div class="bd-callout bd-callout-success">
                                                ผ่านการคัดเลือก
                                            </div>
                                        @endif
                                        <form action="{{ route('admin.upstatus') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input name="idreg" id="idreg" type="hidden"
                                                value="{{ $regist->id }}">
                                            <select class="form-select" name="updstatus" onchange="this.form.submit()"
                                                aria-label="Default select example">
                                                <option selected>เลือกสถานะ</option>
                                                <option value="2">ยื่นเอกสารชำระเงินอีกครั้ง</option>
                                                <option value="3">ชำระเงินเรียบร้อย</option>
                                                <option value="4">ผ่านการคัดเลือก</option>
                                            </select>
                                        </form>
                                        {{-- <form action="{{ route('regist.destroy', $regist->id) }}"
                                            class="d-inline delete-form" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger delete-button">Delete</button>
                                        </form> --}}
                                    </td>
                                </tr>

                                <!-- Modal detail-->
                                <div class="modal fade" id="detailModal{{ $key }}" tabindex="-1"
                                    aria-labelledby="detailModalLabel{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $key }}">
                                                    รายละเอียด
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img alt="Product Image" class="w-100"
                                                    src="{{ asset('storage/payment/' . $regist->payment) }}" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div></div>
            <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab"
                tabindex="0">
                <div class="table-responsive">
                    <table id="example4" class="table table-striped table-hover" style="width: 100%;">
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
                            @php
                                $total = $regists4->count();
                            @endphp
                            @foreach ($regists4 as $key => $regist)
                                <tr>
                                    <td>{{ $total - $key }}</td>
                                    <td>{{ $regist->id }}
                                        <button class='btn btn-outline-info viewregists' data-id='{{ $regist->id ?? '' }}'
                                            title="ดูรายละเอียด"><samp><i class="bi bi-eye-fill"></i>
                                            </samp></button>
                                    </td>
                                    <td>{{ $regist->p }}{{ $regist->name }}
                                        {{-- {{ $regist->stdpic }}
                            <img alt="Product Image" class="w-100" src="{{ asset('storage/' . $regist->stdpic) }}" /> --}}
                                    </td>
                                    <td>{{ $regist->Projectname }}</td>
                                    <td> {{ $regist->Cosename }}</td>
                                    <td>
                                        @if ($regist->payment)
                                            <a class="btn btn-outline-success view-payment-btn" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $key }}">
                                                <i class="bi bi-cash-stack"></i>
                                            </a>

                                            <a class="btn btn-outline-success"
                                                href="{{ url('viewfile/payment/' . $regist->payment) }}"><i
                                                    class="fas fa-download"></i></a>
                                            {{ $regist->dateup_p }}
                                        @else
                                            N/A
                                        @endif

                                    </td>
                                    <td>
                                        {{-- {{ $regist->std_status }} --}}
                                        @if ($regist->std_status == null)
                                            <div class="bd-callout bd-callout-warning">
                                                รอเอกสารชำระเงิน
                                            </div>
                                        @elseif($regist->std_status == 1)
                                            <div class="bd-callout bd-callout-info">
                                                ชำระเงินรอตรวจสอบ
                                            </div>
                                        @elseif($regist->std_status == 2)
                                            <div class="bd-callout bd-callout-danger">
                                                ยื่นเอกสารชำระเงินอีกครั้ง
                                            </div>
                                        @elseif($regist->std_status == 3)
                                            <div class="bd-callout bd-callout-primary">
                                                ชำระเงินเรียบร้อยรอผลการสมัคร
                                            </div>
                                        @elseif($regist->std_status == 4)
                                            <div class="bd-callout bd-callout-success">
                                                ผ่านการคัดเลือก
                                            </div>
                                        @endif
                                        {{-- <form action="{{ route('admin.upstatus') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input name="idreg" id="idreg" type="hidden"
                                                value="{{ $regist->id }}">
                                            <select class="form-select" name="updstatus" onchange="this.form.submit()"
                                                aria-label="Default select example">
                                                <option selected>เลือกสถานะ</option>
                                                <option value="2">ยื่นเอกสารชำระเงินอีกครั้ง</option>
                                                <option value="3">ชำระเงินเรียบร้อย</option>
                                                <option value="4">ผ่านการคัดเลือก</option>
                                            </select>
                                        </form>
                                        <form action="{{ route('regist.destroy', $regist->id) }}"
                                            class="d-inline delete-form" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger delete-button">Delete</button>
                                        </form> --}}
                                    </td>
                                </tr>

                                <!-- Modal detail-->
                                <div class="modal fade" id="detailModal{{ $key }}" tabindex="-1"
                                    aria-labelledby="detailModalLabel{{ $key }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel{{ $key }}">
                                                    รายละเอียด
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img alt="Product Image" class="w-100"
                                                    src="{{ asset('storage/payment/' . $regist->payment) }}" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="d-flex">
            {{ $regists->links() }}
        </div> --}}

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

        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Use modal-lg for a larger modal -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center"> <!-- Center the image -->
                        <img id="paymentImage" src="" alt="Payment Image" class="img-fluid">
                        <!-- img-fluid for responsive image -->
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
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
                // $(document).ready(function() {
                // show the alert
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 5000);
                // });
                $('#example').DataTable({
                    "columnDefs": [{
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    }],
                    "order": [
                        [1, 'desc']
                    ]
                });
                $('#example1').DataTable({
                    "columnDefs": [{
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    }],
                    "order": [
                        [1, 'desc']
                    ]
                });
                $('#example2').DataTable({
                    "columnDefs": [{
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    }],
                    "order": [
                        [1, 'desc']
                    ]
                });
                $('#example3').DataTable({
                    "columnDefs": [{
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    }],
                    "order": [
                        [1, 'desc']
                    ]
                });
                $('#example4').DataTable({
                    "columnDefs": [{
                        "searchable": false,
                        "orderable": false,
                        "targets": 0
                    }],
                    "order": [
                        [1, 'desc']
                    ]
                });
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
                $('#example1').on('click', '.viewregists', function() {
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
                $('#example2').on('click', '.viewregists', function() {
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
                $('#example3').on('click', '.viewregists', function() {
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
                $('#example4').on('click', '.viewregists', function() {
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
                /////
                document.addEventListener('DOMContentLoaded', function() {
                    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
                    const paymentImage = document.getElementById('paymentImage');

                    document.querySelectorAll('.view-payment-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const paymentUrl = this.getAttribute('data-payment-url');

                            // Set the image src and show the modal
                            paymentImage.src = paymentUrl;
                            paymentModal.show();
                        });
                    });
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteForms = document.querySelectorAll('.delete-form');

                deleteForms.forEach(form => {
                    const deleteButton = form.querySelector('.delete-button');

                    deleteButton.addEventListener('click', function(event) {
                        event.preventDefault();

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
