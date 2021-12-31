<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getListUsers(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id !== NULL ? $request->id : 0;
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
                call sp_user_get_list_users (?, ?, ?, ?, ?)
            ',
            [$id, $name, $user, $email, $state]
        );

        return $data_query;
    }

    public function setRegisterUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $firstname = $request->firstname !== NULL ? $request->firstname : '';
        $secondname = $request->secondname !== NULL ? $request->secondname : '';
        $lastname = $request->lastname !== NULL ? $request->lastname : '';
        $user = $request->user !== NULL ? $request->user : '';
        $email = $request->email !== NULL ? $request->email : '';
        $password = $request->password !== NULL ? Hash::make($request->password) : '';
        $photography = $request->photography !== NULL ? $request->photography : 0;

        $data_query = DB::select(
            '
                call sp_set_register_user (?, ?, ?, ?, ?, ?, ?)
            ',
            [$firstname, $secondname, $lastname, $user, $email, $password, $photography]
        );

        return true;
    }

    public function setEditUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id !== NULL ? $request->id : 0;
        $firstname = $request->firstname !== NULL ? $request->firstname : '';
        $secondname = $request->secondname !== NULL ? $request->secondname : '';
        $lastname = $request->lastname !== NULL ? $request->lastname : '';
        $user = $request->user !== NULL ? $request->user : '';
        $email = $request->email !== NULL ? $request->email : '';
        if($request->password !== NULL) {
            $password = Hash::make($request->password);
        } else {
            $password = '';
        };
        $photography = $request->photography !== NULL ? $request->photography : 0;

        // dump($id, $firstname, $secondname, $lastname, $user, $email, $password, $photography);
        // dd($id, $firstname, $secondname, $lastname, $user, $email, $password, $photography);
        // var_dump($id, $firstname, $secondname, $lastname, $user, $email, $password, $photography);
        // die();

        $data_query = DB::select(
            '
                call sp_set_edit_user (?, ?, ?, ?, ?, ?, ?, ?)
            ',
            [$id, $firstname, $secondname, $lastname, $user, $email, $password, $photography]
        );

        return true;
    }

    public function setChangeStatusUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id !== NULL ? $request->id : 0;
        $state = $request->state !== NULL ? $request->state : '';

        $data_query = DB::select(
            '
                call sp_set_change_state_user (?, ?)
            ',
            [$id, $state]
        );

        return true;

    }
}
