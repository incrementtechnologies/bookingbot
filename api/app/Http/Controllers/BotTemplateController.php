<?php

namespace App\Http\Controllers;

use App\BotTemplate as Template;
use Illuminate\Http\Request;

class BotTemplateController extends APIController
{
    function __construct(){
        $this->model = new Template();
    }
}
