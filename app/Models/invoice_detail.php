<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_detail extends Model
{
    use HasFactory;

    protected $fillable =[
        'invoice_number',
        'invoice_id',
        'status',
        'value_status',
        'product',
        'section',
        'note',
        'user',
        'payment_date',
    ];


}
