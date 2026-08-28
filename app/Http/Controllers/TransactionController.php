<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $transactions = Transaction::where('user_id',$userId)->orderBy('thoi_gian','desc')->paginate(20);
        return view('user.transaction-history', compact('transactions'));
    }
}