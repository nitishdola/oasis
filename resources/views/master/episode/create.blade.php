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
@endsection
@section('content')
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Episode</h5>
                        
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Episode</a>
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
                                        <form class="form-material" action="{{route('master.episode.store')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group form-default">
                                                <input type="text" name="name" class="form-control" required >
                                                <span class="form-bar"></span>
                                                <label class="float-label">Name <span class="req">*</span></label>
                                            </div>
                                            <div class="form-group form-default">
                                                <select class="form-control" name="category_id" required>
                                                    <option value=""></option>
                                                    @foreach($categories as $key=>$category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="form-bar"></span>
                                                <label class="float-label">Category <span class="req">*</span></label>
                                            </div>

                                            <div class="form-group form-default">
                                                <label>Banner</label>
                                                <input type="file" name="picture" id="picture" class="form-control" >
                                                <span class="form-bar"></span>
                                                
                                            </div>

                                            <div class="form-group form-default">
                                                <label>Release Date</label>
                                                <input type="text" name="release_date" class="form-control datepicker" >
                                                <span class="form-bar"></span>
                                                
                                            </div>

                                            <div class="form-group form-default">
                                            <label>Cast & Director</label>
                                            <textarea  name="cast" id="cast" class="form-control" ></textarea>
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
<script src="{{asset('public/assets/js/zebra_datepicker.min.js')}}"></script>
<script>
      tinymce.init({
        selector: '#details'
      });

      tinymce.init({
        selector: '#cast'
      });
      
</script>
<script>
       $('.datepicker').Zebra_DatePicker();
    </script>
@endsection