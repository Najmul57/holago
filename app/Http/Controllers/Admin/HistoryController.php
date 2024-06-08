<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLoginHistory;

class HistoryController extends Controller
{
    public function loginHistory()
    {
        $loginLogs = UserLoginHistory::orderBy('id','desc')->with('user')->paginate(50);
        return view('admin.history.logins', compact('loginLogs'));
    }
}
