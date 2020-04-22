<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    # Define MANY-TO-MANY relationship between Checklists and ChecklistItems
    # Ref: Week 12 CSCI E-15 notes/video 12.1
    public function checklist_items()
    {
        return $this->belongsToMany('App\ChecklistItem')
            ->withTimestamps();
    }
}
