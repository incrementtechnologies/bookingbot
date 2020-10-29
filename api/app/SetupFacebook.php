<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SetupFacebook extends APIModel
{
    use SoftDeletes;
    protected $table = 'setup_pages';
    protected $fillable = ['fb', 'access_token', 'name', 'category'];
}
