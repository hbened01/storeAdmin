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

        try {

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

        } catch (\Throwable $th) {
            return false;
        }

        return $data_query[0]->idUser;
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

        // die(var_dump($id, $state));

        $data_query = DB::select(
            '
                call sp_set_change_state_user (?, ?)
            ',
            [$id, $state]
        );

        return true;

    }

    public function setEditRolByUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $idUser = $request->idUser !== NULL ? $request->idUser : '';
        $idRole = $request->idRole !== NULL ? $request->idRole : '';

        $data_query = DB::select(
            '
                call sp_set_edit_rol_by_user (?, ?)
            ',
            [$idUser, $idRole]
        );

        // die(var_dump($data_query));

        return true;
    }

    public function getRoleByUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $idUser = $request->idUser !== NULL ? $request->idUser : 0;

        $data_query = DB::select(
            '
                call sp_get_rol_by_user (?)
            ',
            [$idUser]
        );

        // die(var_dump($data_query));

        return $data_query;
    }

    public function getListPermitByRolAsign(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $idUser = $request->idUser !== NULL ? $request->idUser : 0;

        $data_query = DB::select(
            '
                call sp_get_list_permit_by_rol_asign (?)
            ',
            [$idUser]
        );

        // die(var_dump($data_query));

        return $data_query;
    }

    public function getListPermissionsByUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $idUser = $request->idUser !== NULL ? $request->idUser : 0;

        $data_query = DB::select(
            '
                call sp_get_list_permit_by_user (?)
            ',
            [$idUser]
        );

        // die(var_dump($data_query));

        return $data_query;
    }

    public function setRegisterRolePermitByUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $idUser = $request->idUser !== NULL ? $request->idUser : 0;

        try {
            DB::beginTransaction();

            DB::select(
                '
                    call sp_set_delete_role_by_user (?)
                ',
                [$idUser]
            );

            $listPermissions = $request->listPermissionsFilter;
            if (sizeof($listPermissions) > 0) {
                foreach ($listPermissions as $key => $value) {
                    if ($value['checked'] == true) {
                        DB::select(
                            '
                                call sp_set_register_permit_by_user (?, ?)
                            ',
                            [$idUser, $value['id']]
                        );
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            // echo "Error: " . $th;
            // die();
            return false;
        }

        // die(var_dump($data_query));

        return true;
    }
}
