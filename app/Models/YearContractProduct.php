<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YearContractProduct extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'year_contract_products';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'main'     => 'main',
        'addition' => 'addition',
    ];

    protected $fillable = [
        'productid_id',
        'quantity',
        'year_contractid_id',
        'price',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function productid()
    {
        return $this->belongsTo(Product::class, 'productid_id');
    }

    public function year_contractid()
    {
        return $this->belongsTo(YearContract::class, 'year_contractid_id');
    }
}