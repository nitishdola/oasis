@extends('layouts.default')

@section('content')
<link href="https://releases.transloadit.com/uppy/v1.30.0/uppy.min.css" rel="stylesheet">
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


         <div class="UppyForm">
  <form action='{{route("save.video")}}' method="POST">
    <h5>Uppy was not loaded — slow connection, unsupported browser, weird JS error on a page — but the upload still works, because HTML is cool like that</h5>
    <input type="file" name="files[]" multiple="">
    <button type="submit">Fallback Form Upload</button>
  </form>
</div>

<div class="UppyProgressBar"></div>

<!-- Uploaded files list -->
<div class="uploaded-files">
  <h5>Uploaded files:</h5>
  <ol></ol>
</div>
         </div>
      </div>
   </div>
</div>


<script src="https://releases.transloadit.com/uppy/v1.30.0/uppy.min.js"></script>
<script src="https://releases.transloadit.com/uppy/locales/v1.21.0/ru_RU.min.js"></script>
<script>   
require('es6-promise/auto')
require('whatwg-fetch')
const Uppy = require('@uppy/core')
const FileInput = require('@uppy/file-input')
const XHRUpload = require('@uppy/xhr-upload')
const ProgressBar = require('@uppy/progress-bar')

const uppy = new Uppy({ debug: true, autoProceed: true })
uppy.use(FileInput, {
  target: '.UppyForm',
  replaceTargetContent: true
})
uppy.use(ProgressBar, {
  target: '.UppyProgressBar',
  hideAfterFinish: false
})
uppy.use(XHRUpload, {
  endpoint: '{{route("save.video")}}',
  formData: true,
  fieldName: 'files[]'
})

// And display uploaded files
uppy.on('upload-success', (file, response) => {
  const url = response.uploadURL
  const fileName = file.name

  const li = document.createElement('li')
  const a = document.createElement('a')
  a.href = url
  a.target = '_blank'
  a.appendChild(document.createTextNode(fileName))
  li.appendChild(a)

  document.querySelector('.uploaded-files ol').appendChild(li)
})
   </script>
@endsection


