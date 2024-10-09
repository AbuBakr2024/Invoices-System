<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $table="products";
    protected $fileable=['product_name','description','section_id'];

    public function section()
    {
        return $this->belongsTo('app\Models\sections');
    }
}
