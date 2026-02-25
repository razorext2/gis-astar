<?php

namespace App\Http\Controllers;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('dashboard.invoice.index');
    }

    public function indexJkt()
    {
        return view('dashboard.invoice.index-jkt');
    }

    public function indexPku()
    {
        return view('dashboard.invoice.index-pku');
    }

    public function create()
    {
        return view('dashboard.invoice.create');
    }

    public function show($id)
    {
        return view('dashboard.invoice.show', compact('id'));
    }

    public function addDetails($id)
    {
        return view('dashboard.invoice.add-details', compact('id'));
    }
}
