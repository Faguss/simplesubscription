<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Website;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
{
    use HasFactory;
    protected $fillable = ['email'];

    public function websites(): BelongsToMany
    {
        return $this->BelongsToMany(Website::class)->withTimestamps();
    }

    public function posts(): BelongsToMany
    {
        return $this->BelongsToMany(Post::class)->withTimestamps();
    }
}
