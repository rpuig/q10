<?php 

namespace App\Controllers;

class UtilityController extends BaseController
{
    public function go_back()
    {
        return redirect()->back();
    }
}
