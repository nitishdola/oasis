<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vimeo\Laravel\VimeoManager;
use Validator;

class UploadsController extends Controller
{

    public function uploadVideo1() {
        return view('videos.episode.test');
    }

    public function uploadVideo() {
        return view('uploads.upload_video');
    }

    public function saveVideo(Request $request, VimeoManager $vimeo) {


        //dd($request);

        $request->validate([
            'video' => 'required|max:6000'
        ]);

        $uri = $vimeo->upload($request->video, [
            'name' => 'OASIS TEST VIDEO',
            'description' => 'Direct Upload',
        ]);
        return response()->json($uri);
    }
}
