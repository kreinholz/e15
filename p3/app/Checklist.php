<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    # Define MANY-TO-MANY relationship between Checklists and ChecklistItems
    # Ref: https://laravel.com/docs/7.x/eloquent-relationships#many-to-many
    public function checklist_items()
    {
        return $this->belongsToMany(ChecklistItem::class);
    }
}
