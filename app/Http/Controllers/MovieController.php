<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Genre;
use App\Image;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

//use ImageIntervention;
use Intervention\Image\ImageManagerStatic as ImageIntervention;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::with('images')->with('genre')->get();
        return view('movies.list',compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('movies.add_movie',compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:movies',
            'release_date' => 'required|max:255',
            'genre_id' => 'required|max:255',
            'images' => 'required'
        ]);
        $movie = new Movie();
        $movie->name = $request->name;
        $movie->release_date = $request->release_date;
        $movie->genre_id = $request->genre_id;
        $movie->save();
        $movie_id = $movie->id;

        //Code for multiple image uploading start
        $images=array();
        if($files=$request->file('images')){
            foreach($files as $file){
                $name=time().$file->getClientOriginalName();
                $file->move('images',$name);
                /*Insert your data*/
                Image::create(array('image_name'=>$name,'movie_id'=>$movie_id));
                /*Insert your data*/
                //ImageIntervention::make($file->getRealPath())->resize(320, 240)->insert('images/thumbnail/'.$file->getClientOriginalName());
                //ImageIntervention::make('images/1566984657Screen Shot 2019-08-03 at 4.03.55 PM')->resize(320, 240)->insert('images/thumbnail/1566984657Screen Shot 2019-08-03 at 4.03.55 PM');
                //ImageIntervention::make('public/images/'.$name)->resize(320, 240)->insert('public/images/thumbnail/'.$name);
            }
        }

        if ($movie_id) {
            session()->flash('success','Movie Added Successfully');
            return redirect()->back();
        }else{
            session()->flash('danger','Something went wrong');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        if (isset($movie->id)) {
            $movie = Movie::with('images')->with('genre')->whereId($movie->id)->first();
            return view('movies.single_view',compact('movie'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        $selected_movie = Movie::whereId($movie->id)->first();
        return view('movies',compact('selected_movie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        if (isset($movie->id)) {
            $delete = Movie::whereId($movie->id)->delete();
            if ($delete) {
                session()->flash('success','Country Deleted Successfully');
                return redirect()->back();
            }else{
                session()->flash('danger','Something went wrong');
                return redirect()->back();
            }
        }
    }
}
