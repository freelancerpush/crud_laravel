<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_image(Request $request)
    {
        $image_id = $request->id;
        if (isset($image_id)) {
            $image = Image::whereId($image_id)->first();
            $image_path = public_path() ."/images/".$image->image_name;
            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $delete = Image::whereId($image_id)->delete();
            if ($delete) {
                return json_encode(array('result'=>'success'));
            }else{
                return json_encode(array('result'=>'failed'));
            }
        }
    }
}
