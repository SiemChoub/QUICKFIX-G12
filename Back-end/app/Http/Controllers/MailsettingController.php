<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailsettingController extends Controller
{
    public function index(){
        return view('admin.mail.index');
    }
}
