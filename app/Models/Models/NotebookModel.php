<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotebookModel extends Model
{
    protected $table = "notebook";

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'company',
        'phone',
        'email',
        'date_of_birth',
        'photo'
    ];
}
