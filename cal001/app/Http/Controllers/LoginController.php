<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/index';  // ログイン後のリダイレクト先

    public function __construct(Request $request)
    {
        $this->middleware('guest:admin')->except('logout');;
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

}