<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesController extends Controller
{
    public function getlistRoles(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $name = $request->name !== NULL ? $request->name : '';
        $slug = $request->slug !== NULL ? $request->slug : '';

        $data_query = DB::select(
            '
                call sp_role_get_list_roles (?, ?)
            ',
            [$name, $slug]
        );

        return $data_query;
    }
}
