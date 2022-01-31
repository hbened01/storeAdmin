<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermittionsController extends Controller
{
    public function getListPermissions(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $idPermit = $request->idPermit !== NULL ? $request->idPermit : 0;
        $name = $request->name !== NULL ? $request->name : '';
        $slug = $request->slug !== NULL ? $request->slug : '';

        $data_query = DB::select(
            '
                call sp_permit_get_list_permissions (?, ?, ?)
            ',
            [$idPermit, $name, $slug]
        );

        return $data_query;
    }
}
