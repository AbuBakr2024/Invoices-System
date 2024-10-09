<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{

    use HasFactory;
    use SoftDeletes;
    
     protected $table="invoices";
     protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'section_id',
        'product',
        'amount_collection',
        'amount_commission',
        'discount',
        'value_vat',
        'rate_vat',
        'total',
        'status',
        'value_status',
        'note',
        'payment_date',
    ];

    public function section()
    {
        return $this->belongsTo('app\Models\sections');
    }

}
