<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    use HasEvents;

    public function website(): belongsTo
    {
        return $this->belongsTo(Website::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->BelongsToMany(Subscriber::class)->withTimestamps();
    }
}
