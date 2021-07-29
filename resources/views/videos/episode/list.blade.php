@extends('layouts.app')
@section('css')
@endsection
@section('content')
<div class="pcoded-content">
<!-- Page-header start -->
<div class="page-header">
   <div class="page-block">
      <div class="row align-items-center">
         <div class="col-md-8">
            <div class="page-header-title">
               <h5 class="m-b-10">List of Episode</h5>
            </div>
         </div>
         <div class="col-md-4">
            <ul class="breadcrumb">
               <li class="breadcrumb-item">
                  <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
               </li>
               <li class="breadcrumb-item"><a href="#!">List of Episode</a>
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
                        <div class="col-md-12">
                           @include('layouts.include.alert')
                        </div>
                        
                        @forelse($videos as $key=>$video)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{$video->name ?? "NA"}}</h5>
                                    <div class="card-block">
                                        @if($video->thumbnail != NULL)
                                        <img src="{{asset($video->thumbnail)}}" class="img-fluid">
                                        @else
                                        <img src="{{ env('APP_URL').'/public/images/episode.jpg'}}" class="img-fluid">
                                        @endif
                                       <div class="mt-3">
                                        <form action="{{route('videos.episode.delete')}}" method="POST">
                                          @csrf
                                          <input type="hidden" name="id" value="{{$video->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')"><i class="fa fa-trash"></i>
                                       </button>

                                       <a href="{{route('videos.episode.edit',$video->uuid)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                       </form>
</div>

                                       
                                    </div>
                                </div> 
                            </div> 
                        </div>      
                        @empty
                        No record found
                        @endforelse
                  
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
<script src="{{asset('node_modules/vimeo-upload/vimeo-upload.js')}}"></script>
<script>
$('.delete').click(function(e){
   evt.preventDefault();
   var conf = comfirm('Are you sure to delete?');
   if(conf){
      
   }
})
</script>
@endsection