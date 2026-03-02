<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Invitation;


class Colocation extends Model
{
    protected $fillable = ['name', 'status', 'owner_id'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): BelongsToMany 
    {
        return $this->belongsToMany(User::class)->withPivot(['role', 'joined_at', 'left_at'])->withTimestamps();
    }


    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }


    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }
}
