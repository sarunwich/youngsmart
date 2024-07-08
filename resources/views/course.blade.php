@extends('layouts.home')

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
    <div class="container-fluid">
        <h1 class="h3 mb-0 text-gray-800">หลักสูตรที่เปิดรับ</h1>
        

        <table class="table table-striped table-hover">
            <tbody>
                @foreach ($courses as $key => $course)
                    @if ($course->status == 1)
                        <tr>
                            <td>{{ $course->Cosename }}</td>
                            <td>รับสมัครวันที่ {{ DateThai($course->datestart) }} ถึง {{ DateThai($course->dateend) }}</td>
                            <td> <a class="btn btn-outline-success"
                                    href="{{ url('viewfile/Cosefile/' . $course->Cosefile) }}"><i
                                        class="bi bi-download"></i></a></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>


    </div>
@endsection
