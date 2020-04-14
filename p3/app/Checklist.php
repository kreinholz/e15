<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    # Allow a Checklist to contain MANY Checklist Items
    # Ref: https://www.itsolutionstuff.com/post/laravel-one-to-many-eloquent-relationship-tutorialexample.html
    public function checklist_items()
    {
        return $this->hasMany(ChecklistItem::class);
    }
}
