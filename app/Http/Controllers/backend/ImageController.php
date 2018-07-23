<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Image;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function index($id)
    {
        $images = Image::where('id_generic', $id)->get();
        return view('panel.image.index', compact('images', $images));
    }

    public function store(Request $request)
    {
        if(!empty($request->input('key')) && !empty($request->file('image'))){
            $image = new Image;
            $image->id_generic = $request->input('key');
            $file = $request->file('image');
            $name = Carbon::now()->timestamp.$file->getClientOriginalName();
            \Storage::disk('imagestore')->put($name, \File::get($file));
            $image->path_image = $name;
            $image->save();
            return redirect('panel/gallery/'.$request->input('key').'/images')->with('message', 'Image Success Create');
        }
    }

    public function destroy($id)
    {
        if(!empty($id) && is_integer($id)){
            $image = Image::where('id', $id)->first();
            if($image){
                $key = $image->id_generic;
                $this->deleteImage($image->path_image);
                $image->delete();
                return redirect('panel/gallery/'.$key.'/images')->with('message', 'Image Success Destroy');
            }
        }
    }

    private function deleteImage($image){
        if(\File::exists(public_path('images/gallery/'.$image))){
            \File::delete(public_path('images/gallery/'.$image));
        }
    }
}
