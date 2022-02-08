<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'author',
        'vat',
        'total_tax',
        'received_date',
        'status',
        'creation_status',
    ];

    public function invoiceCompany()
    {
        return $this->hasOne(InvoiceCompany::class);
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
