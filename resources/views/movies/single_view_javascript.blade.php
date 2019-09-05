@extends('template.layout')
@section('content')
<!-- Container (Contact Section) -->
<div id="contact" class="container-fluid bg-grey">
<div class="row">
  <div class="col-sm-6">
    <h1 class="view-page-title">{{ @$movie->name }}</h1>
  </div>
  <div class="col-sm-6">
    <ul class="view-page-list">
          <li>Genre : {{ @$movie->genre->name }} </li>
          <li>Release Date : {{ @$movie->release_date }}</li>
    </ul>
  </div>
</div>
<div class="movie-image-slider">
  <div class="row main_image_container">
    <?php $i = 0; ?>
      @foreach(@$movie->images as $image)
      <div id="main_{{ $image->id }}" class="main_image @if ($i === 0) active @endif <?php $i++; ?>">
        <img style="width: 100%;height: auto;" src="{{ url('images').'/'.$image->image_name }}">
      </div>
      @endforeach
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <ul class="thumb_show">
    <?php $i = 0; ?>
      @foreach(@$movie->images as $image)
      <li onclick="set_default('{{ $image->id }}')">
        <div id="thumb_{{ $image->id }}" class="@if ($i === 0) active @endif <?php $i++; ?>">
          <img class="thumb_image" src="{{ url('images/thumbnail').'/thumb_'.$image->image_name }}">
        </div>
      </li>
      @endforeach
    </ul>
  </div>
</div>
</div>
@endsection
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">
  async function set_default(id) {
    $('.main_image').removeClass('active');
    $('#main_'+id).addClass('active');
    const url = '{{ url("images/set-default") }}';
    await axios.post(url, {
      image_id:id,
      movie_id:'{{ @$movie->id }}',
    })
    .then(function (response) {
      console.log(response);
    })
    .catch(function (error) {
      console.log(error);
    });
  }
</script>
<style type="text/css">
  .thumb_show { 
    list-style-type: none;
    text-align: center;
    margin: 20 5 0;
    padding: 0;
  }
  .thumb_show li {
    display: inline-block;
    font-size: 20px;
    padding: 20px;
    border: 2px solid gray;
    margin: 4px;
    cursor: pointer;
  }
  .thumb_show li:hover {border: 4px solid gray}

  .thumb_show li:active {
    background-color: gray;
    box-shadow: 0 5px #666;
    transform: translateY(4px);
  }
  .thumb_image{
    width: 128px;
    height: 128px;
  }
  .main_image{
    display: none;
  }
  .main_image_container .active{
    display: block;
  }
</style>