<?php

namespace App\Http\Controllers;

use App\Files;
use App\Http\Requests\FileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilesController extends Controller
{
    public function uploadPDF(FileRequest $request){
        $file = new Files;
        $file->visibility = $request->visibility === "public" ? 1 : 0;
        $file->user_id = $request->user_id;
        $file->file_name = $request->file('file')->store('files');
        $file->save();

        if($file){
            return response($file, 200);
        }

        return response('So9mething was wrong!', 403);

    }

    public function getFiles($id = null){
        if($id){
            $files = Files::where('user_id', $id)->get();
        }else{
            $files = Files::where('visibility', 1)->get();
        }

        return $files;
    }

    public function delete($id)
    {
        $file = Files::find($id)->delete();
        if($file){
            return ["File is successfully deleted"];
        }else{
            return ["Something was wrong!"];
        }


    }
}
