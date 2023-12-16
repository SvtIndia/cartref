<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function getColorAttribute(): string
    {
        if ($this->priority === 'high') {
//            return '#FA3E18';
            return 'danger';
        } else if ($this->priority === 'regular') {
//            return '#37AFF1';
            return 'primary';
        } else {
//            return '#42D07E';
            return 'success';
        }
    }
}
