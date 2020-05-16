<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;
use App\User;


class MyDatatablesController extends Controller
{

    public function index(){
	   	return view('datatables');
    }

    public function getData(){
        return Datatables::of(User::query())->make(true);
    }
}