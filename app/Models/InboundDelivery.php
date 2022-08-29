<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InboundDelivery extends Model
{
  use HasFactory;

  protected $fillable = [
    'inboundNo',
    'deliveryDate',
    'status',
  ];

  public function supplier()
  {
    return $this->belongsTo(Vendor::class, 'supplier_id', 'id');
  }

  public function client()
  {
    return $this->belongsTo(Customer::class, 'client_id', 'id');
  }

  public function products()
  {
    return $this->belongsToMany(Product::class)->withPivot([
      'name',
      'description',
      'baseUom',
      'quantity'
    ]);
  }
}
