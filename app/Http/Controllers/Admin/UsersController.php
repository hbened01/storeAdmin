<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getListUsers(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $name = $request->name !== NULL ? $request->name : '';
        $user = $request->user !== NULL ? $request->user : '';
        $email = $request->email !== NULL ? $request->email : '';
        $state = $request->state !== NULL ? $request->state : '';

        // DB::select('
        //     SELECT
        //         *
        //     FROM
        //         users
        //     WHERE
        //         active = ?
        // ', [1]);

        $data_query = DB::select(
            '
                call sp_user_get_list_users (?, ?, ?, ?)
            ',
            [$name, $user, $email, $state]
        );

        return $data_query;

    }
}
