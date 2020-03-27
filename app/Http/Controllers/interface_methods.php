<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

interface interface_methods
{
    public function add();

    public function add1(Request $request);

    public function update(Request $request);

    public function update1(Request $request);

    public function delete(Request $request);

    public function show();

}
