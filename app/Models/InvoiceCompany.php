<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCompany extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
        'name',
        'company_name',
        'address',
        'post_code',
        'city',
        'phone',
        'siret',
        'rcs',
        'tva',
        'note',
    ];
}
