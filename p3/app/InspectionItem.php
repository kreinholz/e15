<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectionItem extends Model
{
    # Define MANY-TO-MANY relationship between InspectionChecklists and InspectionItems
    # Ref: https://laravel.com/docs/7.x/eloquent-relationships#many-to-many
    public function inspection_checklists()
    {
        return $this->belongsToMany('App\InspectionChecklist')
            ->withTimestamps();
    }
}
