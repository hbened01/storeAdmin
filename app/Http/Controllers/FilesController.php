<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function setRegisterFile(Request $request)
    {
        $file = $request->file;
        $flag = Str::random(10);
        $filename = $file->getClientOriginalName();
        $fileserver = $flag .'_'. $filename;
        Storage::putFileAs('public/users', $file, $fileserver);

        $data_query = DB::select(
            '
                call sp_file_register (?, ?)
            ',
            [asset('storage/users/'.$fileserver), $filename]
        );

        return $data_query;
    }
}
