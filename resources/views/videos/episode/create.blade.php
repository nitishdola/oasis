@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('public/assets/css/css/bootstrap/zebra_datepicker.min.css')}}" />
<style>
   #details {
   height: 500px;
   }
   .req{
   color:#FF0000;
   font-size:11px;
   }
</style>
<style>
   .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
   .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
   .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
</style>
@endsection
@section('content')
<div class="pcoded-content">
<!-- Page-header start -->
<div class="page-header">
   <div class="page-block">
      <div class="row align-items-center">
         <div class="col-md-8">
            <div class="page-header-title">
               <h5 class="m-b-10">Add Episode</h5>
            </div>
         </div>
         <div class="col-md-4">
            <ul class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
               </li>
               <li class="breadcrumb-item"><a href="#!">Add Episode</a>
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
               <div class="col-md-8">
                  <div class="card">
                     <div class="card-header">
                        <h5>Add Episode</h5>
                        <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                     </div>
                     <div class="card-block">
                        @include('layouts.include.alert')
                        <span class="error"></span>
                        <form class="form-material" id="uploadForm" action="{{route('videos.episode.info.store')}}" method="POST" enctype="multipart/form-data">
                           @csrf
                           <div class="form-group form-default">
                              <label>Video file</label>
                              <input type="file" name="video" id="video" class="form-control" required>
                              <span class="form-bar"></span>
                           </div>

                           <div class="progress" style="display:none" id="progress">
                              <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                 aria-valuenow="40" aria-valuemin="0" id="progressbar" aria-valuemax="100" style="width:1%">
                                 1% Complete
                              </div>
                           </div>
                         
                        </form>
                     </div>
                  </div>
               </div>
               <!-- column start    -->
            </div>
         </div>
         <!-- Page-body end -->
      </div>
      <div id="styleSelector"> </div>
   </div>
</div>
<!-- Modal -->

@endsection
@section('js')
<script src="https://cdn.tiny.cloud/1/8rv67b2gsl0g5fuzuzn80svphe25c16btq4p236c5xd5ruzi/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/assets/js/additional-methods.js')}}"></script>
<script src="{{asset('public/assets/js/jquery.blockUI.min.js')}}"></script>
<script src="{{asset('public/assets/js/toastr.min.js')}}"></script>
<script src="{{asset('node_modules/vimeo-upload/vimeo-upload.js')}}"></script>
<script>
   tinymce.init({
     selector: '#details'
   });
   
   tinymce.init({
     selector: '#cast'
   });
   
</script>
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
     var accessToken = 'XXXXXXXXXXXXXXXXXXXXXXXXXXX';
     updateProgress(0);
     var uploader = new VimeoUpload({
         file: files[0],
         token: "{{env('VIMEO_ACCESS')}}",
         beforeSend: function (req) {
            req.setRequestHeader('Accept', 'application/vnd.vimeo.*+json;version=3.2');
            $.blockUI({
                                css: {
                                    backgroundColor: 'transparent',
                                    border: 'none'
                                },
                                message: '<i class="fa fa-refresh fa-spin" style="font-size:92px"></i> <p><strong>We are processing your request.  Please be patient. </strong></p> ',
                                baseZ: 1500,
                                overlayCSS: {
                                    backgroundColor: '#FFFFFF',
                                    opacity: 0.7,
                                    cursor: 'wait'
                                }
                                });
        },

         onError: function(data) {
            $.unblockUI();
             data = JSON.parse(data)
             $('.error').text(data.developer_message);
         },
         onProgress: function(e) {
            $.unblockUI();
            if (e.lengthComputable) {
               $('#progress').show();
                updateProgress((e.loaded / e.total* 100).toFixed(2));
                if(e.loaded == 100){
                  $.blockUI({
                                css: {
                                    backgroundColor: 'transparent',
                                    border: 'none'
                                },
                                message: '<i class="fa fa-refresh fa-spin" style="font-size:92px"></i> <p><strong>We are processing your request.  Please be patient. </strong></p> ',
                                baseZ: 1500,
                                overlayCSS: {
                                    backgroundColor: '#FFFFFF',
                                    opacity: 0.7,
                                    cursor: 'wait'
                                }
                                });
                }
            }
         },
         onComplete: function(e) {
           // $.unblockUI();
            console.log(e);
            if(!jQuery.isEmptyObject(e)) {
                $('.error').html(e.developer_message);
            } 
            $('#progress').hide();
            $.ajax({
                        type: 'GET',
                        url: '{{route("videos.episode.store")}}',
                        data: {video_id:e,episode_id:{{$episode->id}}},
                        dataType:'json',
                        beforeSend: function(){
                            $.blockUI({
                                css: {
                                    backgroundColor: 'transparent',
                                    border: 'none'
                                },
                                message: '<i class="fa fa-refresh fa-spin" style="font-size:92px"></i> <p><strong>We are processing your request.  Please be patient. </strong></p> ',
                                baseZ: 1500,
                                overlayCSS: {
                                    backgroundColor: '#FFFFFF',
                                    opacity: 0.7,
                                    cursor: 'wait'
                                }
                                });
                        },
                        error:function(resp){
                           console.log(resp);
                           $.unblockUI();
                        },
                        success: function(resp){
                            console.log(resp);
                            $.unblockUI();
                            if(resp.success == true){
                               //
                               window.location = '{{url("/videos/info/")}}/'+resp.id
                            }
                            //console.log('hiii');
                        }
                     });
         }
        })
        uploader.upload();

})
</script>
@endsection