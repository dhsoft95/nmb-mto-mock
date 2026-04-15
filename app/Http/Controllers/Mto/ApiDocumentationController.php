<?php

namespace App\Http\Controllers\Mto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiDocumentationController extends Controller
{
    public function index()
    {
        return view('mto.docs');
    }
}
