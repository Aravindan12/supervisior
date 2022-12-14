<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable =['user_id','product_name','price','slug_name','unique_id'];
public function getUniqueIdAttribute()
{
  return $this->unique_id = 'Pr+'.$this->id;
}

}
