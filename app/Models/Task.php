<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = ['end_task','project_id','priority','status'];
    public function project(){
        return $this->belongsTo(Project::class);
    }
}
