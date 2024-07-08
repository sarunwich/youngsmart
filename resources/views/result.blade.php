@extends('layouts.home')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    @foreach ($announcements as $key => $announcement)
    <div class="card" style="width: 90%;">
        <div class="card-body">
          <h5 class="card-title">
            {{ $announcement->announcements }}</h5>
          {{-- {{ $announcement->announcementsfile }} --}}
          <object data="{{ asset('storage/announcementsfile/'.$announcement->announcementsfile) }}" type="application/pdf" width="100%" height="600px">
            <p>Unable to display PDF. Please <a href="{{ asset('storage/announcementsfile/'.$announcement->announcementsfile) }}">download it here</a>.</p>
        </object>
        </div>
      </div>
      @endforeach
</div>
@endsection