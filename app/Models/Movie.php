<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'release_date',
        'genre_id',
        'rating',
        'poster_url',
        'trailer_url'
    ];

    /**
     * Define the relationship with the Genre model.
     * A movie belongs to a genre.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Scope a query to only include movies of a given genre.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $genreId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfGenre($query, $genreId)
    {
        return $query->where('genre_id', $genreId);
    }

    /**
     * Scope a query to only include movies with a minimum rating.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  float  $rating
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithMinimumRating($query, $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    /**
     * Accessor to get the formatted release date.
     *
     * @return string
     */
    public function getFormattedReleaseDateAttribute()
    {
        return \Carbon\Carbon::parse($this->release_date)->format('F d, Y');
    }
}
