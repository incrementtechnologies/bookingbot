<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BotConfiguration extends APIModel
{
    use SoftDeletes;
    protected $table = "bot_configurations";
    protected $fillable = ['account_id', 'payload', 'payload_value', 'page', 'token'];
}
