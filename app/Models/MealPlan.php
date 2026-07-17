<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealPlan extends Model
{
    protected $fillable = ['user_id', 'food_id', 'plan_date', 'amount', 'note', 'is_completed'];

    protected $casts = ['plan_date' => 'date', 'is_completed' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function factor(): float
    {
        return $this->food->serving_size > 0 ? $this->amount / $this->food->serving_size : 0;
    }

    public function calories(): float
    {
        return round($this->food->calories * $this->factor(), 1);
    }
}
