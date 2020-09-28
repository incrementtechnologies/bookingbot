<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageTemplate extends APIModel
{
    protected $table = "page_templates";
    protected $fillable = ['account_id', 'payload', 'payload_value', 'page', 'token', 'template_id', 'content'];
}
