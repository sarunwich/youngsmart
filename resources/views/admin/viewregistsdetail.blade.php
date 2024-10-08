<div class="shadow p-3 mb-5 bg-body-tertiary rounded">
    <div class="row">
        <div class="col-6 mb-4">
            <label class="form-label">เลขที่สมัคร</label>
            <div>
                {{ $regists->id }}
            </div>

        </div>
        <div class="col-6 mb-4">

            <label class="form-label">เลขบัตรประชาชน</label>
            <div>
                {{ $regists->idcard }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mb-4">
            <label class="form-label">ชื่อ-สกุล</label>
            {{ $regists->p }}{{ $regists->name }}
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">เบอร์มือถือ</label>
            {{ $regists->tel }}
        </div>
    </div>
    <div class="row">
        <div class="col-6 mb-4">

            <label class="form-label">โรงเรียน</label>
            <div>
                {{ $regists->belong }}
            </div>
        </div>
        <div class="col-6 mb-4">

            <label class="form-label">จังหวัด</label>
            <div>
                {{ $regists->province }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mb-4">

            <label class="form-label">ที่อยู่</label>
            <div>
                {{ $regists->address }}
            </div>
        </div>
        <div class="col-6 mb-4">

            <label class="form-label">เกรดเฉลี่ย</label>
            <div>
                {{ $regists->gread }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6 mb-4">
            <label class="form-label">โครงการ</label>
            <div>
                {{ $regists->Projectname }}
            </div>
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">หลักสูตร</label>
            <div>
                {{ $regists->Cosename }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mb-4">
            <label class="form-label">ชื่อผู้ปกครง</label>
            <div>
                {{ $regists->parent_name }}
            </div>
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">เบอร์โทรผู้ปกครอง</label>
            <div>
                {{ $regists->parent_tel }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mb-4">
            <label for="input_tel" class="form-label">ระดับการศึกษา</label>
            <div>
                {{-- {{ $regists->level }} --}}
                @if ($regists->level == 1)
                    ปวส
                @elseif($regists->level == 2)
                    ม.6
                @endif
            </div>

        </div>
        @if (isset($regists->link))
            <div class="col-6 mb-4">
                <label for="input_tel" class="form-label">Link
                    ผลงาน</label>
                <div>
                    {{ $regists->link }}
                </div>

            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <label for="input_tel" class="form-label">ข้อมูลติดต่อ
                Facebook
            </label>
            <div>
                {{ $regists->facebook }}
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label for="input_tel" class="form-label">ข้อมูลติดต่อ ID
                Line
            </label>
            <div>
                {{ $regists->line }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mb-4">
            <label class="form-label">รูปถ่าย</label>
            {{-- {{$regists->stdpic}} --}}
            @if (isset($regists->stdpic))
            <div>
                <img alt="Product Image" class="w-100" src="{{ asset('storage/' . $regists->stdpic) }}" />
            </div>
            @else
            N/A
            @endif
        </div>
        <div class="col-6 mb-4">
            <label class="form-label">ผลการเรียน</label>
            @if (isset($regists->school_record))
            <iframe src="{{ asset('storage/customFile/' . $regists->school_record) }}" style="width:100%; height:90%;"
                frameborder="0"></iframe>
            <div>
                <a class="btn btn-outline-success" href="{{ url('getfile/customFile/' . $regists->school_record) }}">
                    {{ $regists->school_record }}
                    <i class="fa fa-download" aria-hidden="true"></i>
                </a>
            </div>
            @else
                N/A
            @endif
           
        </div>
    </div>
    <div class="row">
        <div class="col-6 mb-4">
            <label class="form-label">ไฟล์ผลงาน</label>
            @if (isset($regists->portfolio_file))
                <iframe src="{{ asset('storage/portfolio_file/' . $regists->portfolio_file) }}"
                    style="width:100%; height:600px;" frameborder="0"></iframe>
                <div>
                    <a class="btn btn-outline-success"
                        href="{{ url('getfile/portfolio_file/' . $regists->portfolio_file) }}">
                        {{ $regists->portfolio_file }}
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>
                </div>
            @endif
        </div>
        @if (isset($regists->guidance_teacher))
            <div class="col-6 mb-4">
                <label class="form-label">เอกสารรับรองครูแนะแนว</label>
                <iframe src="{{ asset('storage/guidance_teacher/' . $regists->guidance_teacher) }}"
                    style="width:100%; height:600px;" frameborder="0"></iframe>
                <div>
                    <a class="btn btn-outline-success"
                        href="{{ url('getfile/guidance_teacher/' . $regists->guidance_teacher) }}">{{ $regists->guidance_teacher }}</a>

                </div>

            </div>
        @endif
    </div>
    @if (isset($regists->payment))
        <div class="row">
            <div class="col-6 mb-4">
                <label class="form-label">เอกสารชำระเงิน</label>

                <div>
                    <img alt="Product Image" class="w-100"
                        src="{{ asset('storage/payment/' . $regists->payment) }}" />
                    <a class="btn btn-outline-success" href="{{ url('getfile/payment/' . $regists->payment) }}"><i
                            class="bi bi-cash-stack"></i></a>
                    {{ $regists->dateup_p }}
                </div>

            </div>
        </div>
    @endif
</div>
