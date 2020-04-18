<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    # Define MANY-TO-MANY relationship between Checklists and ChecklistItems
    # Ref: https://laravel.com/docs/7.x/eloquent-relationships#many-to-many
    public function checklists()
    {
        return $this->belongsToMany('App\Checklist');
    }
}
