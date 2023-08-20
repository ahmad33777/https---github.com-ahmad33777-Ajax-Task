<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'image',
        'status'
    ];

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'description' => [
                'required',
                'string',
                'min:5'
            ],
            'image' => [
                'nullable',
                'image',
                'max:1048576',
            ],
            'status' => 'required|in:active,archived'
        ];
    }


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}