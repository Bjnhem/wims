<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
  use HasFactory;

  protected $fillable = [
    'quantity',
  ];

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function location()
  {
    return $this->belongsTo(Location::class);
  }

  public function warehouse()
  {
    return $this->belongsTo(Warehouse::class);
  }
}
