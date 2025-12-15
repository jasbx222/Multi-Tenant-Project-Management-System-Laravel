<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
   
    
    protected $fillable =['description','user_id','company_id','name'];
    public function tasks(){
        return $this->hasMany(Task::class);
    }


    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('role', 'joined_at')
                    ->withTimestamps();
    }


    public function company(){

        return $this->belongsTo(Company::class);
    }
}
