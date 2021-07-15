@extends('layouts.app')

@section('content')
<div class="pcoded-content">
<!-- Page-header start -->
<div class="page-header">
<div class="page-block">
<div class="row align-items-center">
<div class="col-md-8">
    <div class="page-header-title">
        <h5 class="m-b-10">Episodes</h5>
        
    </div>
</div>
<div class="col-md-4">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
        </li>
        <li class="breadcrumb-item"><a href="#!">Episodes</a>
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
                    <h5>List of Episode</h5>
                    <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                </div>
                <div class="card-block">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Release Date</th>
                            <th>Total Videos</th>
                            <th>Trailer</th>\
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($episodes as $key=>$episode)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$episode->name}}</td>
                            <td>{{$episode->category->name??'N/A'}}</td>
                            <td>{{$episode->release_date}}</td>
                            <td>NA</td>
                            <td>NA</td>
                            <td>
                            <div class="dropdown-primary dropdown open">
                             <button class="btn btn-primary dropdown-toggle waves-effect waves-light btn-sm " type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item waves-light waves-effect" href="{{route('videos.episode.create',$episode->uuid)}}">Add Videos</a>
                                </div>
                            </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">No record found</td>
                        </tr>    
                        @endforelse
                    </tbody>
                </table>
                {{$episodes->links()}}
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
