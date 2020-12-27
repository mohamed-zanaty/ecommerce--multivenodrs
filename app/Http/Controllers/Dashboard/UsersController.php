<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::latest()->where('id', '<>', auth()->id())->get();
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::get();
        return view('dashboard.users.create', compact('roles'));
    }


    public function store(UserRequest $request)
    {


        DB::beginTransaction();

        //validation
        $user = new Admin;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();

        if (!$user)
            return redirect()->route('admin.users')->with(['success' => 'هناك خطأ']);

        DB::commit();
        return redirect()->route('admin.users')->with(['success' => 'تم ألاضافة بنجاح']);


    }


    public function edit($id)
    {

        $user = Admin::findORFail($id);

        if (!$user)
            return redirect()->route('admin.users')->with(['error' => 'هذا الصالحيه غير موجود ']);

        return view('dashboard.users.edit', compact('user'));

    }


    public function update($id, UserRequest $request)
    {
        try {
            //validation

            $user = Admin::findOrFail($id);

            if (!$user)
                return redirect()->route('admin.users')->with(['error' => 'هذا الصالحيه غير موجود']);


            DB::beginTransaction();


            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role_id = $request->role_id;
            $user->save();
            if (!$user)
                return redirect()->route('admin.users')->with(['error' => 'هناك خطأ']);


            DB::commit();
            return redirect()->route('admin.users')->with(['success' => 'تم ألتحديث بنجاح']);

        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.users')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }


    public function destroy($id)
    {
        try {
            $users = Admin::find($id);

            if (!$users)
                return redirect()->route('admin.users')->with(['error' => 'هذا الصالحيه غير موجود ']);

            $users->delete();

            return redirect()->route('admin.users')->with(['success' => 'تم  الحذف بنجاح']);

        } catch (\Exception $ex) {
            return redirect()->route('admin.users')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }

}
