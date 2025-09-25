<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('dashboard.invoice.index');
    }

    public function create()
    {
        return view('dashboard.invoice.create');
    }
}
