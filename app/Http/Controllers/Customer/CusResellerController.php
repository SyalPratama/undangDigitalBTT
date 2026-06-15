<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CusResellerController extends Controller
{
    public function index()
    {
        return view('customer.reseller');
    }

    public function store(Request $request)
    {
        // Dummy logic untuk upgrade menjadi reseller
        return redirect()->back()->with('success', 'Permintaan Anda untuk menjadi Reseller telah dikirim dan sedang ditinjau.');
    }
}
