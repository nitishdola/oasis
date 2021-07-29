<?php

namespace App\Http\Controllers\REST;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Master\Category;
use App\Models\Master\Episode;
use App\Models\Videos;


class ApiController extends Controller
{
    public function getAllCategories(Request $request) {
        $where = [];
        if($request->category_id) {
            $where['id'] = $request->category_id;
        }
        $data = Category::where('deleted_at', NULL);
        if ($data->where($where)->count()) {
            return response()->json(['success'=>true, 'data' => $data->select('name', 'uuid')->get() ]);
        }
        else{
            return response()->json(['success'=>false]);
        }
    }


    public function getAllSeries(Request $request) {
        $where = [];
        if($request->category_id) {
            $where['category_id'] = $request->category_id;
        }
        $data = Episode::where('deleted_at', NULL);
        if ($data->where($where)->count()) {

            $res = $data->with('category:id,categories.name as category_name')->select(
                                    'name as series_name', 
                                    'category_id',
                                    'picture', 
                                    'cast', 
                                    'details', 
                                    'release_date', 
                                    'uuid', 
                                )->get();
            return response()->json(
                    [
                        'success'=>true, 
                        'data' => $res,
                    ]);
        }else{
            return response()->json(['success'=>false]);
        }
    }

    public function getAllVideos(Request $request) {
        $where = [];
        if($request->episode_id) {
            $where['episode_id'] = $request->episode_id;
        }
        $data = Videos::where('deleted_at', NULL);
        if ($data->where($where)->count()) {

            $res = $data->with('episode:id,name as episode_name')->select(
                                    'name as video_name', 
                                    'episode_id', 
                                    'thumbnail', 
                                    'video_url', 
                                    'trailer_url', 
                                    'video_id', 
                                    'details', 
                                    'price', 
                                    'order_list'
                                )
                                ->orderBy('order_list', 'ASC')
                                ->get();
            return response()->json(
                    [
                        'success'=>true, 
                        'data' => $res,
                    ]);
        }else{
            return response()->json(['success'=>false]);
        }
    }
}
