<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'color',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'note_tags')
            ->using(NoteTag::class)
            ->withTimestamps();
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount('notes')
            ->orderBy('notes_count', 'desc')
            ->limit($limit);
    }

    public function getNotesCountAttribute()
    {
        return $this->notes()->count();
    }

    public static function findOrCreateByName(string $name, ?string $color = null): self
    {
        return static::firstOrCreate(
            ['name' => strtolower(trim($name))],
            ['color' => $color]
        );
    }
}
