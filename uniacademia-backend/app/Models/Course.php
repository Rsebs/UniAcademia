<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'credits',
        'elective',
        'knowledge_area_id',
    ];

    public function Knowledge_area() {
        return $this->belongsTo(Knowledge_area::class);
    }
}
