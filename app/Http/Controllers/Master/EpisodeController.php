<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Redirect;
use App\Models\Master\Category;
use App\Models\Master\Episode;
use Session,File;
class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $episodes = Episode::with('category')->where('type',1)->paginate();
        return view('videos.episode.index',compact('episodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::get();
        return view('master.episode.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'category_id'=>'required',
            'picture' => 'nullable|mimes:jpeg,jpg,png|max:2048'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput($request->all());
        try{
                if ($request->hasFile('picture')) 
                {
                    $filenameWithExt = $request->file('picture')->getClientOriginalName ();
                    // Get Filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just Extension
                    $extension = $request->file('picture')->getClientOriginalExtension();
                    // Filename To store
                    $fileNameToStore = $filename.'-'. time().'.'.$extension;
                    $path = public_path('images/'.date('d-m-Y'));
                    if(!File::isDirectory($path)){
                        File::makeDirectory($path, 0777, true, true);
                    }
                    $path = $request->file('picture')->storeAs('public/images/'.date('d-m-Y'), $fileNameToStore);
                    $full_path = env("APP_URL")."/"."public/storage/images/".date('d-m-Y')."/".$fileNameToStore;
                }
                // Else add a dummy image
                else {
                    $full_path  = env("APP_URL")."/public/images/noimage.jpg";
                }
               $data['category_id'] = $request->category_id;
               $data['name'] = $request->name;
               $data['picture'] = $full_path;
               $data['cast'] = $request->cast;
               $data['details'] = $request->details;
               $data['release_date'] = $request->release_date;
               Episode::create($data);
               Session::flash('success','Episode added successfully');
               return Redirect::back();
        }
        catch(\Exception $e){
            dd($e->getMessage());
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
