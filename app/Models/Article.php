<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'category',
    ];

    /**
     * Save UUID when creating model.
     * 
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(fn($model) => $model->uuid = Str::uuid()->toString());
    }

    /**
     * An Article has many Comments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
