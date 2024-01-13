<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class UniqueSoftDeleteObserver
{
    private const DELIMITER = '--';   
  
    public function restoring(Model $model) 
    {        
        if (!$model->trashed()) {
            return;
        }
        foreach ($model->getDuplicateAvoidColumns() as $column) {
           if ($value = (explode(self::DELIMITER, $model->{$column})[1] ?? null)) {                    
               $model->{$column} = $value;
           }        
        }    
    }
     
    public function deleted(Model $model) 
    {        
        foreach ($model->getDuplicateAvoidColumns() as $column) { 
           $newValue = time().self::DELIMITER.$model->{$column};              
           $model->{$column} = $newValue;       
        }         
        $model->save();    
   }
}
