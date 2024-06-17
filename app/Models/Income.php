<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'amount', 'date', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
