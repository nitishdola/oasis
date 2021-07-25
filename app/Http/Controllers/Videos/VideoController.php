<?php

namespace App\Http\Controllers\Videos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect;
use App\Models\Master\Category;
use App\Models\Master\Episode;
use App\Models\Videos;
use Session,File;
use Vimeo\Laravel\VimeoManager;
class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($uuid)
    {
        //
        $episode = Episode::uuid($uuid);
        return view('videos.episode.create',compact('episode'));
    }

    public function info(Request $request,$id)
    {
        //
        $video = Videos::where('id',$id)->first();
        return view('videos.episode.info',compact('video'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return response()->json(['success'=>true,'id'=>$request->all()]);
        try{
            $data['video_id'] = $request->video_id;
            $data['episode_id'] = $request->episode_id;
            $video = Videos::create($data);
            return response()->json(['success'=>true,'id'=>$video->id]);
        }
        catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>$e->getMessage()]);
        }

    }

    public function infoStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required',
            'thumbnail' => 'required|mimes:jpeg,jpg,png|max:2048'
        ]);
        if($validator->fails()) 
        return response()->json(['success'=>false,'message'=>$validator]);
        //return Redirect::back()->withErrors($validator)->withInput($request->all());

        try{
                $video = Videos::where('id',$request->id)->first();
                if(!$video){
                    Session::flash('error','Video id mistmatched');
                    return Redirect::back();
                }
                if ($request->hasFile('thumbnail')) 
                {
                    $filenameWithExt = $request->file('thumbnail')->getClientOriginalName ();
                    // Get Filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just Extension
                    $extension = $request->file('thumbnail')->getClientOriginalExtension();
                    // Filename To store
                    $fileNameToStore = $filename.'-'. time().'.'.$extension;
                    $path = public_path('images/'.date('d-m-Y'));
                    if(!File::isDirectory($path)){
                        File::makeDirectory($path, 0777, true, true);
                    }
                    $path = $request->file('thumbnail')->storeAs(date('d-m-Y'), $fileNameToStore);
                    $full_path = "public/images/".date('d-m-Y')."/".$fileNameToStore;
                }
                $data['name'] = $request->name;
                $data['thumbnail'] = $full_path;
                $data['details'] = $request->details;
                $data['price'] = $request->price;
                $data['status'] = 1;
                $data['thumbnail'] = $full_path;
                $data['video_url'] = env("API_URL")."/videos/".$video->video_id;
                Videos::where('id',$request->id)->update($data);
                Session::flash('success','Updated successfully');
                return Redirect::back();
           
            }
            catch(\Exception $e){
                Session::flash('error',$e->getMessage());
                return Redirect::back();
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function list($uuid)
    {
        //
        
        $series = Episode::uuid($uuid);
        $videos = Videos::where('episode_id',$series->id)->get();
        return view('videos.episode.list',compact('videos'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        //
        $video = Videos::uuid($uuid);
        return view('videos.episode.edit',compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required',
            'thumbnail' => 'nullable|mimes:jpeg,jpg,png|max:2048'
        ]);
        if($validator->fails()) 
        return response()->json(['success'=>false,'message'=>$validator]);
        //return Redirect::back()->withErrors($validator)->withInput($request->all());

        try{
                $video = Videos::where('id',$request->id)->first();
                if(!$video){
                    Session::flash('error','Video id mistmatched');
                    return Redirect::back();
                }
                if ($request->hasFile('thumbnail')) 
                {
                    $filenameWithExt = $request->file('thumbnail')->getClientOriginalName ();
                    // Get Filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just Extension
                    $extension = $request->file('thumbnail')->getClientOriginalExtension();
                    // Filename To store
                    $fileNameToStore = $filename.'-'. time().'.'.$extension;
                    $path = public_path('images/'.date('d-m-Y'));
                    if(!File::isDirectory($path)){
                        File::makeDirectory($path, 0777, true, true);
                    }
                    $path = $request->file('thumbnail')->storeAs(date('d-m-Y'), $fileNameToStore);
                    $full_path = "public/images/".date('d-m-Y')."/".$fileNameToStore;
                }
                else{
                    $full_path = $video->thumbnail;
                }
                $data['name'] = $request->name;
                $data['thumbnail'] = $full_path;
                $data['details'] = $request->details;
                $data['price'] = $request->price;
                $data['status'] = 1;
                $data['thumbnail'] = $full_path;
                Videos::where('id',$request->id)->update($data);
                Session::flash('success','Updated successfully');
                return Redirect::back();
           
            }
            catch(\Exception $e){
                Session::flash('error',$e->getMessage());
                return Redirect::back();
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, VimeoManager $vimeo)
    {
        //
        $video = Videos::find($request->id);
        $uri = '/videos/'.$video->video_id; // example: `/videos/1234`
        $v = $vimeo->request($uri, [], 'DELETE');
        if($v){
            $video->delete();
            Session::flash('success','Video deleted successfull');
            return Redirect::back();
        }
       
    }
}
