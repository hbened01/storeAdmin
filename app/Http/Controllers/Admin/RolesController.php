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

        $idRole = $request->idRole !== NULL ? $request->idRole : 0;
        $name = $request->name !== NULL ? $request->name : '';
        $slug = $request->slug !== NULL ? $request->slug : '';

        $data_query = DB::select(
            '
                call sp_role_get_list_roles (?, ?, ?)
            ',
            [$idRole, $name, $slug]
        );

        return $data_query;
    }

    public function getListPermissionsByRole(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $idRole = $request->idRole !== NULL ? $request->idRole : 0;
        $data_query = DB::select('call sp_role_get_list_permissions_by_role (?)', [$idRole]);

        return $data_query;
    }

    public function setRegisterRolePermit(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $name = $request->name !== NULL ? $request->name : '';
        $slug = $request->slug !== NULL ? $request->slug : '';

        try {
            DB::beginTransaction();

            $data_query = DB::select(
                '
                    call sp_role_set_register_role (?, ?)
                ',
                [$name, $slug]
            );
            $nIdRol = $data_query[0]->nIdRol;
            $listPermissions = $request->listPermissionsFilter;
            if (sizeof($listPermissions) > 0) {
                foreach ($listPermissions as $key => $value) {
                    if ($value['checked'] === true) {
                        $data_query = DB::select(
                            '
                                call sp_role_set_register_role_permit (?, ?)
                            ',
                            [$nIdRol, $value['id']]
                        );
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return $nIdRol;
    }


    public function setRegisterEditRolePermit(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $idRole = $request->idRole !== NULL ? $request->idRole : 0;
        $name = $request->name !== NULL ? $request->name : '';
        $slug = $request->slug !== NULL ? $request->slug : '';

        try {
            DB::beginTransaction();

            DB::select(
                '
                    call sp_role_set_register_edit_role (?, ?, ?)
                ',
                [$idRole, $name, $slug]
            );

            $listPermissions = $request->listPermissionsFilter;
            if (sizeof($listPermissions) > 0) {
                foreach ($listPermissions as $key => $value) {
                    if ($value['checked'] === true) {
                        $data_query = DB::select(
                            '
                                call sp_role_set_register_role_permit (?, ?)
                            ',
                            [$idRole, $value['id']]
                        );
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        return $idRole;
    }
}
