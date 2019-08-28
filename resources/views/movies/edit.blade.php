@extends('template.layout')
@section('content')

<div id="contact" class="container-fluid bg-grey">
  @include('template.flash')
  <h2 class="text-center">Edit movie</h2>
  <div class="row">
    <div class="col-sm-12 slideanim">
      <?php $submit_url = url("movie")."/".$movie->id ?>
      <form method="post" action="{{ $submit_url }}" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
       @csrf
        <div class="row">
          <div class="col-sm-6 form-group">
            <input class="form-control" id="name" name="name" placeholder="Name" type="text" value="{{old('name',$movie->name)}}">
          </div>
          <div class="col-sm-6 form-group">
            <input class="form-control" id="releaseDate " name="release_date" placeholder="Release Date" type="date" value="{{ old('release_date',$movie->release_date)}}">
          </div>
        </div>
         <div class="row">
          <div class="col-sm-6 form-group">
            <input class="form-control" id="image" name="images[]" placeholder="Image" type="file" multiple>
          </div>
          <div class="col-sm-6 form-group">
            <select class="form-control" id="genre" name="genre_id">
              @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" <?php if(old('genre_id',$movie->genre_id) == $genre->id){ echo "selected"; } ?> >{{ $genre->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 form-group">
            <button class="btn btn-default pull-right" type="submit">Update</button>
          </div>
        </div>
      </form>

    </div>
  </div>

  <h2>Images</h2>
    <div class="images-for-delete">
      
      <div class="item ">
        <?php $j = 0; ?>
        @foreach(@$movie->images as $image)
          <div  class="image-div" id="{{ $image->id }}">
            <span class="glyphicon glyphicon-trash" onclick="delete_image('{{ $image->id }}')" aria-hidden="true"></span>
            <img src="{{ url('images').'/'.$image->image_name }}">
          </div>
          <?php $j++; ?>
        @endforeach
      </div>
    </div>
    
</div>
      
        
@endsection
<style type="text/css">
.images-for-delete .image-div span{
       position: absolute;
    right: 3px;
    /* background: #fff; */
    color: #f4511d;
    top: 6px;
    font-size: 16px;
}
.images-for-delete {
    text-align: center;
  }
.images-for-delete .image-div {
   
    display: inline-block;
    position: relative;
    
}
.images-for-delete .image-div img{
  width: 100px;
  height: 100px;
  }
  .img-wrap {
    position: relative;
    display: inline-block;
    border: 1px red solid;
    font-size: 0;
}
}
.img-wrap .close {
    position: absolute;
    top: 2px;
    right: 2px;
    z-index: 100;
    background-color: #FFF;
    padding: 5px 2px 2px;
    color: #f4511e;
    font-weight: bold;
    cursor: pointer;
    opacity: .2;
    text-align: center;
    font-size: 22px;
    line-height: 10px;
    border-radius: 50%;
}
.img-wrap:hover .close {
    opacity: 1;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
  function delete_image(id){
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this lorem ipsum!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
      }).then(result => {
        console.log(result.value);
         if (result.value) {
          var hitUrl = '{{ url("movie/delete_image") }}';
          $.ajax({
              type: "POST",
              url: hitUrl,
              data:{id:id},
              success: function (data) {
                  console.log(data.result);
                  $("#"+id).hide();
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
         }
      });

  }
  
</script>