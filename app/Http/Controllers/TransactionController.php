<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Transaction;
use DB;
use PDF;

class TransactionController extends Controller
{
    public function index()
    {
        $trans = Transaction::where('user_id', Auth::user()->id)->get();
        return view('frontend.transaction', compact('trans'));
    }
}
