<?php

namespace App\Models;

use App\Traits\WithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use WithUuid;

    protected $guarded = [];
    protected $table = 'questions';

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
