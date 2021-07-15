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
                        <h5 class="m-b-10">Add Video</h5>
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Add Video</a>
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
                                        <h5>Add Video</h5>
                                        <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                    </div>
                                    <div class="card-block">
                                    @include('layouts.include.alert')
                                    <div class="progress">
                                        <div class="bar"></div >
                                        <div class="percent">0%</div >
                                    </div>
                                        <form class="form-material" action="{{route('videos.episode.store')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div id="phppot-message"></div>
                                            <div class="form-group form-default">
                                                <input type="text" name="name" class="form-control" required >
                                                <span class="form-bar"></span>
                                                <label class="float-label">Name <span class="req">*</span></label>
                                            </div>
                                            <div class="form-group form-default">
                                                <select class="form-control" name="episode_id" required>
                                                    <option value="{{$episode->id}}">{{$episode->name}}</option>
                                                   
                                                </select>
                                                <span class="form-bar"></span>
                                                
                                            </div>

                                            <div class="form-group form-default">
                                                <label>Thumbnail</label>
                                                <input type="file" name="thumbnail" id="thumbnail" class="form-control" required>
                                                <span class="form-bar"></span>
                                                
                                            </div>

                                            <div class="form-group form-default">
                                                <label>Video file</label>
                                                <input type="file" name="video" id="thumbnail" class="form-control" required>
                                                <span class="form-bar"></span>
                                                
                                            </div>


                                            <div class="form-group form-default">
                                            <label>Details</label>
                                                <textarea  name="details" id="details" class="form-control" ></textarea>
                                                <span class="form-bar"></span>
                                                
                                            </div>

                                            
                                            <div class="form-group form-default">
                                                <button type="submit" name="submit" class="btn btn-primary">
                                                Submit
                                                </button>
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
@endsection
@section('js')
<script src="https://cdn.tiny.cloud/1/8rv67b2gsl0g5fuzuzn80svphe25c16btq4p236c5xd5ruzi/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://malsup.github.io/jquery.form.js"></script>
<script>
      tinymce.init({
        selector: '#details'
      });

      tinymce.init({
        selector: '#cast'
      });
      
</script>
<script type="text/javascript">
 
    function validate(formData, jqForm, options) {
        var form = jqForm[0];
        if (!form.file.value) {
            alert('File not found');
            return false;
        }
    }
 
    (function() {
 
    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');
 
    $('form').ajaxForm({
        beforeSend: function() {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=file]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function() {
            var percentVal = 'Wait, Saving';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        complete: function(xhr) {
            status.html(xhr.responseText);
            alert('Uploaded Successfully');
            window.location.href = "/file-upload";
        }
    });
     
    })();
</script>
@endsection