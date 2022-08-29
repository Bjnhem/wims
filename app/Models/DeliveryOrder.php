<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
  use HasFactory;

  protected $fillable = [
    'doNo',
    'outNo',
    'deliveryDate',
    'reference'
  ];

  public function client()
  {
    return $this->belongsTo(Warehouse::class);
  }

  public function origin()
  {
    return $this->belongsTo(Warehouse::class);
  }

  public function destination()
  {
    return $this->belongsTo(Customer::class, 'dest_id', 'id');
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
