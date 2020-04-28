<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectionChecklist extends Model
{
    # Define MANY-TO-MANY relationship between InspectionChecklists and InspectionItems
    # Ref: Week 12 CSCI E-15 notes/video 12.1
    public function inspection_items()
    {
        return $this->belongsToMany('App\InspectionItem')
            ->withTimestamps();
    }
}
