<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Reminder;
use App\Models\Checklist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Card extends Model
{
     use HasFactory, SoftDeletes;

    protected $fillable = [
        'board_id',
        'title',
        'description',
        'due_date',
        'position'
    ];

    protected $casts = [
        'due_date' => 'date',
        'position' => 'integer'
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

     public function labels()
    {
        return $this->belongsToMany(Label::class, 'card_label')
            ->withTimestamps(); // Relasi many-to-many, Card -> Label melalui pivot
    }

     public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'card_user')
            ->withTimestamps()
            ->withPivot('assigned_at');
    }

    public function checklists() : hasMany
    {
        return $this->hasMany(Checklist::class)->orderBy('position');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
