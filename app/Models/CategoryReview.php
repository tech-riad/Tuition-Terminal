<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryReview extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function parent()
    {
        return $this->belongsTo(Parents::class,'parent_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'emp_id');
    }
}
