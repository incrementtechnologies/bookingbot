<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoogleSheet extends APIModel
{
    protected $table = "google_sheets";
    protected $fillable = ['account_id', 'file_name', 'file_id', 'sheet_page'];
}
