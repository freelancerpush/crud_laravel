<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use App\Services\ImageDeleteService;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ImageDeleteService $imagedeleteervices)
    {
        $this->imagedeleteervices = $imagedeleteervices;
    }
    public function deleteImage(Request $request)
    {
        $image_id = $request->id;
        if (isset($image_id)) {
            $image = Image::whereId($image_id)->first();
            //Service for delete image
            $this->imagedeleteervices->handleDeleteImage($image);

            $delete = Image::whereId($image_id)->delete();
            if ($delete) {
                return json_encode(array('result'=>'success'));
            }else{
                return json_encode(array('result'=>'failed'));
            }
        }
    }
    public function defaultImage(Request $request)
    {
        $image_id = $request->image_id;
        $movie_id = $request->movie_id;
        if($image_id!="" && $movie_id!="")
        {
            $image = Image::whereId($image_id)->update(array('is_primary'=>1));
            $image = Image::where('id','!=',$image_id)->where('movie_id',$movie_id)->update(array('is_primary'=>0));
        }
        
    }
}
