<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model

{

    //protected $fillable = ['name','slug','price','description'];  //ekleme yapılabilecek kısımlar

    //protected $guarded = ['name'];  //eklemesi engellenen kısımlar
    
    //protected $table = 'products'; 

    //protected $hidden = ['slug'];  //slug kolonu apide gizlenir

    public function categories() {
        return $this->belongsToMany('App\Models\Category','product_categories'); //model sınıfı
    }  
    use HasFactory;
}
