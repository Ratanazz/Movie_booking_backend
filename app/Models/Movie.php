<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use CrudTrait;
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
        'poster_image',
        'image_banner',
        'trailer_url',
        'run_time', 
    ];

    /**
     * The attributes that should be appended to the model's array and JSON form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_run_time',
    ];

    public function shows()
    {
        return $this->hasMany(Show::class);
    }

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

    public function getFormattedRunTimeAttribute()
    {
        if (!$this->run_time) {
            return null;
        }

        $hours = intdiv($this->run_time, 60);
        $minutes = $this->run_time % 60;

        return sprintf('%dh %02dmin', $hours, $minutes);
    }
}
