<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{

    public function create()
    {
        return view('backend.gallery.create');
    }

    public function store(Request $request)
    {
        if(!empty($request->input('gallery')) && !empty($request->type)){
            if($this->verifyType($request->type) != true){
                $gallery = new Gallery;
                $gallery->name = $this->formatText($request->input('gallery'));
                $gallery->type = $request->type;
                $gallery->save();
                return redirect('panel/gallery')->with('message', 'Create Gallery Success');
            } else {
                return redirect('panel/gallery')->with(
                    'error', 'La categoria de galleria ya esta en uso para poder asiganar esta categoria por favor cambie
                    la categoria en la galeria que estas asiganada');
            }
        }
    }

    public function edit($id)
    {

    }
    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

    private function formatText($text){
        $format = strtolower($text);
        return $format;
    }
}
