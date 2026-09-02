<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TentangKknController extends Controller
{
    public function index()
    {
        return view('admin.tentang-kkn.index');
    }
}