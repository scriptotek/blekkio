<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YoutubePlaylist extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['youtube_id', 'title'];

    /**
     * Get the videos for the playlist.
     */
    public function videos()
    {
        return $this->belongsToMany('App\Recording', 'youtube_playlist_videos')
            ->withPivot('playlist_position');
    }

    /**
     * Get the event for this YouTube playlist, if any.
     */
    public function event()
    {
        return $this->hasOne('App\Event');
    }

}
