<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_attachment extends Model
{
    use HasFactory;

    public $fillable = [
        'file_name',
        'invoice_number',
        'user',
        'invoice_id',
    ];
}
