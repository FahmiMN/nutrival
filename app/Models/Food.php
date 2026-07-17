<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = [
        'name', 'category_id', 'description', 'image_path',
        'serving_size', 'serving_unit', 'serving_text',
        'calories', 'protein', 'carbs', 'fat',
        'fiber', 'sugar', 'sodium', 'cholesterol', 'saturated_fat',
        'is_custom', 'status', 'created_by', 'admin_note',
    ];

    protected $casts = ['is_custom' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: makanan yang boleh dilihat/dipakai user tertentu.
     * = semua approved + custom food milik user itu sendiri (apapun statusnya).
     */
    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        return $query->where(function ($q) use ($user) {
            $q->where('status', 'approved')
              ->orWhere('created_by', $user->id);
        });
    }

    /** Label porsi, mis. "100 gram" atau "1 potong (1 potong sedang)" */
    public function servingLabel(): string
    {
        $label = rtrim(rtrim(number_format($this->serving_size, 1), '0'), '.') . ' ' . $this->serving_unit;
        return $this->serving_text ? "$label ({$this->serving_text})" : $label;
    }
}