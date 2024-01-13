<?php

namespace App\Traits;

use App\Observers\UniqueSoftDeleteObserver;

trait UniqueSoftDelete
{    
     public static function bootUniqueSoftDelete()         
     {          
         static::observe(app(UniqueSoftDeleteObserver::class));    
     }     
     public function getDuplicateAvoidColumns() : array 
     {        
         return [];    
     }
}