<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function index()
    {
        return view('dashboard.questionnaire.index');
    }

    public function create()
    {
        return view('dashboard.questionnaire.create');
    }
}
