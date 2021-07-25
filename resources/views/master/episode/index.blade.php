@extends('layouts.app')

@section('content')
<div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10"></h5>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="{{route('home')}}"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!">Category</a>
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
                                        <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Add Category</h5>
                                                        <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                                    </div>
                                                    <div class="card-block">
                                                    @include('layouts.include.alert')
                                                        <form class="form-material" action="{{route('master.category.store')}}" method="POST">
                                                            @csrf
                                                            <div class="form-group form-default">
                                                                <input type="text" name="name" class="form-control" required >
                                                                <span class="form-bar"></span>
                                                                <label class="float-label">Name</label>
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
                                        <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>List of Category</h5>
                                                        <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                                    </div>
                                                    <div class="card-block">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($categories as $key=>$category)
                                                            <tr>
                                                                <td>{{$key+1}}</td>
                                                                <td>{{$category->name}}</td>
                                                                <td>
                                                                    <a href="#"><i class="fa fa-edit"></i></a>
                                                                   &nbsp;&nbsp;&nbsp; <a href="#"><i class="fa fa-trash"></i></a>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="3">No record found</td>
                                                            </tr>    
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                    
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
