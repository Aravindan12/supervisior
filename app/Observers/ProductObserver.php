<?php

namespace App\Observers;
use App\Models\Product;


class ProductObserver
{
   public function __construct(Product $product)
    {
        $this->product = $product;
    }
   
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */


   public function creating(Product $product)
    {
        $product->slug_name = \Str::slug($product->product_name);
    }


    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $product->unique_id = 'Pr'.$product->id;
        $product->save();
    }
  
    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        $product->slug_name=$product->product_name;
        $product->slug_name = \Str::slug($product->slug_name);
        $product->unique_id = 'Pr+'.$product->id;
        $product->save();
    }
  
    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
          
    }
  
    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
          
    }
  
    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
          
    }
}






