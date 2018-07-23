<?php

namespace App\Http\Controllers\backend;


use Illuminate\Http\Request;
use App\Tour;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class TourController extends Controller
{

    public function index()
    {
        $tours = Tour::get();
        return view('backend.tour.index', compact('tours', $tours));
    }


    public function create()
    {
        return view('backend.tour.create');
    }

    public function store(Request $request)
    {
        if( !empty($request->category) && !empty($request->input('name'))){
            $tour = new Tour;
            $tour->category_id = $request->category;
            $tour->name = $this->formatText($request->input('name'));
            $tour->price = $request->input('price');
            $tour->description = $request->input('description');
            if(!empty($request->file('image'))){
                $file = $request->file('image');
                $name = Carbon::now()->timestamp.$file->getClientOriginalName();
                \Storage::disk('tourstore')->put($name, \File::get($file));
                $tour->path_image = $name;
            }
            $tour->save();
            return redirect()->route('panel.tour.index')->with('message', 'Tour Saved');
        }
    }

    public function show($id)
    {
        $tour = Tour::find($id);
        return view('backend.tour.show', compact('tour', $tour));
    }

    public function edit($id)
    {
        return view('backend.tour.edit');
    }

    public function update(Request $request, $id)
    {
        $tour = Tour::find;
        $tour->category_id = $request->category;
        $tour->name = $request->input('name');
        $tour->price = $request->input('price');
        $tour->description = $request->input('description');
        if(!empty($request->file('image'))){
            if($tour->path_image != 'demoTour.png'){
                $this->deleteImage($tour->path_image);
            }
            $file = $request->file('image');
            $name = Carbon::now()->timestamp.$file->getClientOriginalName();
            \Storage::disk('tourstore')->put($name, \File::get($file));
            $tour->path_image = $name;
        }
        $tour->save();
        return redirect()->route('panel.tour.index')->with('message', 'Tour Updated');
    }

    public function destroy($id)
    {

    }

    private function deleteImage($image)
    {
        if(\File::exists(public_path('images/tour/'.$image))){
            \File::delete(public_path('images/tour/'.$image));
        }
    }
    private function formatText($text){
        $format = strtolower($text);
        return $format;
    }
}
