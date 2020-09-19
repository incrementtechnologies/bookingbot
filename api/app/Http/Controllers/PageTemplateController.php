<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PageTemplate as Bot;

class PageTemplateController extends APIController
{
    function __construct(){
        $this->model = new Bot();
    }
}
