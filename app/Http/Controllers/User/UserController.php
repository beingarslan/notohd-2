<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function manage()
    {
        $roles = Role::all()->pluck('name');

        return view('users.manage', compact('roles'));
    }

    public function users(Request $request)
    {
        try {
            $totalData = User::count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');

            if (empty($request->input('search.value'))) {
                $users = User::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $users =  User::where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = User::where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->count();
            }

            $data = array();
            if (!empty($users)) {
                foreach ($users as $user) {
                    $show =  ('edituser/' . $user->id);
                    $edit =  ('edituser/' . $user->id);

                    $nestedData['id'] = $user->id;
                    $nestedData['name'] = $user->name;
                    $nestedData['role'] = $user->getRoleNames();
                    $nestedData['email'] = $user->email;
                    $nestedData['status'] = $user->status;
                    $nestedData['action'] =
                        '
                        <div class="btn-group">
                            <a href="button" class="btn btn-outline-primary waves-effect" ' . $user->id . '">Edit</a>
                        </div>
                        ';

                    $data[] = $nestedData;
                }
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    // save user information
    public function save(Request $request){
        // validate informtion
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
            'status' => 'required',
        ]);

        if($validated->fails()){
            Toastr::info('message', 'title', ['options']);
        }
    }
}
