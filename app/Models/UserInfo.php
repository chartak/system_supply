<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'user_infos';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'customer' => 'Customer',
        'supplier' => 'Supplier',
    ];

    protected $fillable = [
        'userid_id',
        'company',
        'company_email',
        'phone',
        'address',
        'bank_name',
        'bank_account_number',
        'type',
        'tax_code',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function userid()
    {
        return $this->belongsTo(User::class, 'userid_id');
    }
}