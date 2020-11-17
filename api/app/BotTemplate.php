<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BotTemplate extends APIModel
{
    use SoftDeletes;
    protected $table = "bot_templates";
    protected $fillable = ['account_id', 'code', 'title', 'settings', 'description', 'demo_url', 'content'];
}
