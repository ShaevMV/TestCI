<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function __construct()
    {
        // todo: Задать права админа
        //$this->middleware('auth:api');
    }

    public function index()
    {
        return view('admin/index');
    }
}
