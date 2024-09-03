
@foreach ($news as $key => $new)

@if($new->pr_staus==1)
<!--Section: News of the day-->
<div class="row gx-5">
    {{-- <div class="col-md-6 mb-4">
      <div class="bg-image hover-overlay ripple shadow-2-strong rounded-5" data-mdb-ripple-color="light">
        <img src="https://mdbcdn.b-cdn.net/img/new/slides/080.webp" class="img-fluid" />
        <a href="#!">
          <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
        </a>
      </div>
    </div> --}}
  
    <div class="col-md-12 mb-8 ">
      {{-- <span class="badge bg-danger px-2 py-1 shadow-1-strong mb-3">News of the day</span> --}}
      <h4><strong>{{$new->pr_title}}</strong></h4>
      <div class="text-muted summernote-content ">
        {!!$new->pr_detail!!}
      </div>
      @if($new->pr_file)
      <a class="btn btn-outline-success"
      href="{{ url('viewfile/pr_file/' . $new->pr_file) }}"><i
          class="bi bi-download"></i></a>
      @endif
    </div>
  </div>
  
  <!--Section: News of the day-->
  @endif
@endforeach
