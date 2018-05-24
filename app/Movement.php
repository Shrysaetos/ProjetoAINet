<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\MovementCategory;

class Movement extends Model
{
    public function getFormattedCategoryAttribute()
    {

        $movement_categories = MovementCategory::all();

        foreach ($movement_categories as $category) {
            if($this->movement_category_id == $category->id){
                return $category->name;
            }
        }
        
        return 'Unknown';
    }
}
