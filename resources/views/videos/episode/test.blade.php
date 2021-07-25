@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="https://releases.transloadit.com/uppy/v1.30.0/uppy.min.css">
@endsection
@section('content')
<div class="pcoded-content">
<!-- Page-header start -->
<div class="page-header">
<div class="page-block">
<div class="row align-items-center">
<div class="col-md-8">
    <div class="page-header-title">
        <h5 class="m-b-10">List of Series</h5>
        
    </div>
</div>
<div class="col-md-4">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">List of Series</a>
        </li>
    </ul>
</div>
</div>
</div>
</div>


<div class="pcoded-inner-content">
<!-- Main-body start -->
<div class="main-body">
<div class="page-wrapper">
<!-- Page-body start -->
<div class="page-body">
    <div class="row">
        <!-- column start    -->
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>List of Series</h5>
                    <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                </div>
                <div class="card-block">
                    <span class="error alert alert-danger"></span>
                <div class="UppyForm mt-2">
  <form action="{{route('save.video')}}" enctype="multipart/form-data">
    <input type="file" name="video" id="video">
    <button type="submit">Upload</button>
  </form>
</div>

<div class="progress">
  <div class="progress-bar" role="progressbar" id="progressbar" aria-valuenow="0"
  aria-valuemin="0" aria-valuemax="100" style="width:1%">
    1%
  </div>
</div>

<!-- Uploaded files list -->
<div class="uploaded-files">
  <h5>Uploaded files:</h5>
  <ol></ol>
</div>


                </div>
            </div>
        </div>
        <!-- Column end -->
    </div>
    </div>

</div>
<!-- Page-body end -->
</div>
<div id="styleSelector"> </div>
</div>
</div>
@endsection
@section('js')
<!-- Load Uppy JS bundle. -->
<script src="{{asset('node_modules/vimeo-upload/vimeo-upload.js')}}"></script>
<script>

    
    function updateProgress(percentage){
        if(percentage > 100) percentage = 100;
        $('#progressbar').css('width', percentage+'%');
        $('#progressbar').html(percentage+'%');
    }
    $('#video').change(function(evt){
        evt.stopPropagation();
     evt.preventDefault();
     var files = evt.target.files; // FileList object.

     console.log('Lets uplaod')
     var accessToken = 'XXXXXXXXXXXXXXXXXXXXXXXXXXX';
     updateProgress(0);

     var uploader = new VimeoUpload({
         file: files[0],
         token: "{{env('VIMEO_ACCESS')}}",
         beforeSend: function (req) {
            req.setRequestHeader('Accept', 'application/vnd.vimeo.*+json;version=3.2');
        },

         onError: function(data) {
             data = JSON.parse(data)
             $('.error').text(data.developer_message);
         },
         onProgress: function(e) {

            //updateProgress(e.loaded / e.total);
            //console.log(e);
            if (e.lengthComputable) {
                updateProgress((e.loaded / e.total* 100).toFixed(2));
            //    var percentage = (e.bytesUploaded / e.bytesTotal * 100).toFixed(2);
            //     console.log(bytesUploaded, bytesTotal, percentage + '%');
            }
         },
         onComplete: function(e) {
            console.log('yahoo !')
            if(!jQuery.isEmptyObject(e)) {
                $('.error').html(e.developer_message);
            } 
            
         }
        })
        x = uploader.upload();


        console.log('response => '+x)

        

})
</script>
@endsection
