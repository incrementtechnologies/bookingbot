<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageTemplate extends Model
{
    protected $table = "page_templates";
    protected $fillable = ['account_id', 'payload', 'payload_value', 'page', 'token', 'template_id', 'content'];
}
