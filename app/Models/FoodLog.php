<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodLog extends Model
{
    protected $table = 'food_logs';

    protected $fillable = ['user_id', 'food_id', 'log_date', 'log_time', 'amount', 'note'];

    protected $casts = ['log_date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    /** Faktor porsi: jumlah dimakan / porsi standar */
    public function factor(): float
    {
        return $this->food->serving_size > 0
            ? $this->amount / $this->food->serving_size
            : 0;
    }

    public function calories(): float
    {
        return round($this->food->calories * $this->factor(), 1);
    }

    public function protein(): float
    {
        return round($this->food->protein * $this->factor(), 1);
    }

    public function carbs(): float
    {
        return round($this->food->carbs * $this->factor(), 1);
    }

    public function fat(): float
    {
        return round($this->food->fat * $this->factor(), 1);
    }
}