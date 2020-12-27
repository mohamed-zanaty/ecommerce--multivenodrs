<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(PAGINATION_COUNT);
        return view('dashboard.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('dashboard.roles.create');
    }


    public function store(RoleRequest $request)
    {


        DB::beginTransaction();

        //validation
        $role = $this->process(new Role, $request);

        if (!$role)
            return redirect()->route('admin.roles')->with(['success' => 'هناك خطأ']);

        DB::commit();
        return redirect()->route('admin.roles')->with(['success' => 'تم ألاضافة بنجاح']);


    }


    public function edit($id)
    {

        $role = role::findORFail($id);

        if (!$role)
            return redirect()->route('admin.roles')->with(['error' => 'هذا الصالحيه غير موجود ']);

        return view('dashboard.roles.edit', compact('role'));

    }


    public function update($id, RoleRequest $request)
    {
        try {
            //validation

            $role = role::findOrFail($id);

            if (!$role)
                return redirect()->route('admin.roles')->with(['error' => 'هذا الصالحيه غير موجود']);


            DB::beginTransaction();


            $role = $this->process($role, $request);

            if (!$role)
                return redirect()->route('admin.roles')->with(['error' => 'هناك خطأ']);


            DB::commit();
            return redirect()->route('admin.roles')->with(['success' => 'تم ألتحديث بنجاح']);

        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.roles')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {
        try {
            $roles = role::find($id);

            if (!$roles)
                return redirect()->route('admin.roles')->with(['error' => 'هذا الصالحيه غير موجود ']);

            $roles->delete();

            return redirect()->route('admin.roles')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.roles')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

    public function process(Role $role, Request $r)
    {
        $role->name = $r->name;
        $role->permissions = json_encode($r->permissions);
        $role->save();
        return $role;

    }

}
