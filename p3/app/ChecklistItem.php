<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    # Allow MANY Checklist Items to belong to a Checklist
    # Ref: https://www.itsolutionstuff.com/post/laravel-one-to-many-eloquent-relationship-tutorialexample.html
#    public function checklists()
#    {
#        return $this->belongsTo(Checklist::class);
#    }
}
