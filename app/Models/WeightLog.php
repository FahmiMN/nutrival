<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightLog extends Model
{
    protected $fillable = ['user_id', 'log_date', 'weight_kg', 'note'];

    protected $casts = ['log_date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
