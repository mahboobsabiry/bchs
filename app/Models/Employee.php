<?php

namespace App\Models;

use App\Traits\HasPhoto;
use App\Traits\HasTazkira;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Employee extends Model
{
    use HasFactory, HasPhoto, HasTazkira;

    protected $fillable = [
        'position_id', 'name', 'last_name', 'father_name', 'grand_f_name',
        'p2number', 'emp_number', 'dob', 'phone', 'phone2', 'email',
        'province', 'info', 'on_duty', 'main_position', 'is_responsible', 'status'
    ];

    // Morph Photo
    public function photo(): MorphOne
    {
        return $this->morphOne(Photo::class, 'transaction');
    }

    // Morph Photo
    public function tazkira(): MorphOne
    {
        return $this->morphOne(Tazkira::class, 'transaction');
    }

    // Position
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
