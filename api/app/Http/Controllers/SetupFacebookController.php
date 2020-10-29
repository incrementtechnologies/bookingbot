<?php

namespace App\Http\Controllers;
use App\SetupFacebook;
use Illuminate\Http\Request;

class SetupFacebookController extends APIController
{
    function __construct(){
        $this->model = new SetupFacebook();
    }
}
