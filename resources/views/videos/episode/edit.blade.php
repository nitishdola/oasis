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
               <h5 class="m-b-10">Update Episode Information</h5>
            </div>
         </div>
         <div class="col-md-4">
            <ul class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
               </li>
               <li class="breadcrumb-item"><a href="#!">Update Episode Information</a>
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
                        <h5>Update Episode Information</h5>
                        <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                     </div>
                     <div class="card-block">
                        @include('layouts.include.alert')
                        <span class="error"></span>
                        <form class="form-material" id="uploadForm" action="{{route('videos.episode.update')}}" method="POST" enctype="multipart/form-data">
                           @csrf
                           <div class="form-group form-default">
                           <label>Name <span class="req">*</span></label>
                              <input type="text" name="name" class="form-control" required value="{{$video->name}}">
                              <span class="form-bar"></span>
                              
                           </div>
                           <input type="hidden" name="id" value="{{$video->id}}">
                           <div class="form-group form-default">
                           <label >Price <span class="req">*</span></label>
                              <input type="number" name="price" id="price" class="form-control" value="{{$video->price}}" required>
                              <span class="form-bar"></span>
                              
                           </div>
                           <div class="form-group form-default">
                              <label>Thumbnail</label>
                              <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                              <span class="form-bar"></span>
                           </div>
                           <div class="form-group form-default">
                              <label>Details</label>
                              <textarea  name="details" id="details" class="form-control">{{$video->details}}</textarea>
                              <span class="form-bar"></span>
                           </div>
                           <div class="form-group form-default">
                              <button type="submit" name="submit" class="btn btn-primary">
                              Update
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
@endsection