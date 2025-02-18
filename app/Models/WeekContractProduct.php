<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeekContractProduct extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'week_contract_products';

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
        'week_contract_id',
        'quantity',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function week_contract()
    {
        return $this->belongsTo(WeekContract::class, 'week_contract_id');
    }

    public function year_con_prods()
    {
        return $this->belongsToMany(YearContractProduct::class);
    }
}