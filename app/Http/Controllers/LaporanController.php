<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    function invoice(){
        $invoice = Invoice::get();
        $invoiceGet = new Invoice;
        return view('admin.laporan.invoice',compact('invoice','invoiceGet'));
    }
    function pendapatan(){
        return view('admin.laporan.pendapatan');
    }
}
