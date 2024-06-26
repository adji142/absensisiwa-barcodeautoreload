<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DB;
use Log;

use App\Models\User;

class LoginController extends Controller
{
    public function __construct()
    {

    }
    public function login() {
        return view("auth.login");
    }
    public function action_login(Request $request)
    {
        try {
            $this->validate($request, [
                'email'=>'required',
                'password'=>'required',
            ]);

            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            // GetRecordOwnerID

            $RecordOwnerID = "";

            $user = User::where('email', '=', $request->input('email'))->first();

            if ($user) {
                if ($user->active == 'N') {
                    throw new \Exception('User tidak aktif !');
                    goto jump;
                }

                if (Auth::Attempt($data)) {
                    return redirect('dashboard');
                } else{
                    throw new \Exception('Email atau Password Salah');
                }
            } else{
                throw new \Exception('Email tidak ditemukan');
            }

            jump:

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->info('Info',$e->getMessage());
            return redirect()->back();
        }
    }

    public function API_login(Request $request)
    {
        $data = array('success' => false, 'message' => '', 'data' => array(), 'token' => "");

        try {
            $this->validate($request, [
                'email'=>'required',
                'password'=>'required',
            ]);

            $userdata = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            $user = User::selectRaw("users.*, userrole.roleid, roles.RoleName")
                    ->leftJoin('userrole','users.id','userrole.userid')
                    ->leftJoin('roles','userrole.roleid','roles.id')
                    ->where('email', '=', $request->input('email'))->first();

            if ($user) {
                if ($user->active == 'N') {
                    // throw new \Exception('User tidak aktif !');
                    $data['message'] = "User tidak aktif !";
                    goto jump;
                }

                if (Auth::Attempt($userdata)) {
                    // $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
                    $data['success'] = true;
                    $data['data'] = $user;
                    // $data['token'] = $token;
                    // return redirect('dashboard');
                } else{
                    $data['message'] = "Email atau Password Salah";
                    // throw new \Exception('Email atau Password Salah');
                }
            } else{
                $data['message'] = "Email tidak ditemukan";
                // throw new \Exception('Email tidak ditemukan');
            }

            jump:

        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            // alert()->info('Info',$e->getMessage());
            // return redirect()->back();
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        Auth::logout();
        return redirect('/');
    }
}
