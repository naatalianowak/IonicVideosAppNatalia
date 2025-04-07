<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * App\Models\Video
 *
 * @property string|null $title
 * @property string|null $description
 * @property string|null $url
 * @property Carbon|null $published_at
 * @property string|null $previous
 * @property string|null $next
 * @property int|null $series_id
 * @method static findOrFail(int $id)
 * @method where(mixed $param, mixed $value)
 * @method static count()
 */
class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'url', 'published_at', 'previous', 'next', 'series_id', 'user_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'description' => 'string',
    ];

    protected $dates = ['published_at'];

    /**
     * Obtiene la fecha de publicación formateada.
     *
     * @return string|null
     */
    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->format('d \d\e F \d\e Y') : null;
    }

    /**
     * Obtiene la fecha de publicación en formato humano.
     *
     * @return string|null
     */
    public function getFormattedForHumansPublishedAtAttribute(): ?string
    {
        return $this->published_at ? $this->published_at->diffForHumans() : null;
    }

    /**
     * Obtiene el timestamp de la fecha de publicación.
     *
     * @return int|null
     */
    public function getPublishedAtTimestampAttribute(): ?int
    {
        return $this->published_at ? $this->published_at->timestamp : null;
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->firstOrFail();
    }
    public function getYoutubeId(): ?string
    {
        preg_match('/v=([^&]+)/', $this->url, $matches);
        return $matches[1] ?? null;
    }

    public function getThumbnailUrl(): ?string
    {
        $videoId = $this->getYoutubeId();
        return $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : null;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
