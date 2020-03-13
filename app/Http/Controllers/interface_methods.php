<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface interface_methods
{
    public function add();

    public function add1(Request $request);

    public function update();

    public function update1(Request $request);

    public function delete();

    public function delete1(Request $request);

    public function show();

    public function show1(Request $request);
}
