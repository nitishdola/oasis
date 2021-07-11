@extends('layouts.default')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-10">
   @if(Session::has('message'))
   <div class="alert bg-success alert-success text-white" role="alert">
      {{Session::get('message')}}
   </div>
   @endif
   <div class="card">
      <div class="card-header">
         <h3>Add Video</h3>
      </div>
      <div class="card-body">
         <form class="forms-sample" action="{{route('save.video')}}" method="post" enctype="multipart/form-data">
            @csrf  
            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                     
                    <p>
                        <input type="text" name="title" class="form-control" placeholder="Title">
                    </p>

                    <p>
                        <input type="text" name="description" class="form-control" placeholder="Description">
                    </p>

                     {!! Form::label('Upload','',array('class'=>'')) !!}
                     
                     <input type="file" name="video" required="reuired">
                     {!! $errors->first('name','<span class="help-inline">:message</span>') !!}
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary mr-2">Submit</button>
                  </div>
               </div>
         </form>
         </div>
      </div>
   </div>
</div>
@endsection


