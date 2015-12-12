<?php

namespace App;

use cebe\markdown\GithubMarkdown;
use Illuminate\Database\Eloquent\Model;

class YoutubeVideo extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['youtube_id', 'title', 'description', 'tags', 'thumbnail', 'published_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
        'is_public' => 'boolean',
    ];

    /**
     * Get the playlists the video are part of.
     */
    public function playlists()
    {
        return $this->belongsToMany('App\YoutubePlaylist', 'youtube_playlist_videos')
            ->withPivot('playlist_position');
    }

    /**
     * Get the presentation the video is from.
     */
    public function presentation()
    {
        return $this->belongsTo('App\Presentation');
    }

    public function descriptionAsHtml()
    {
        $parser = new GithubMarkdown();
        return $parser->parse($this->description);
    }

    public function link($method='watch')
    {
        $host = 'https://www.youtube.com';
        switch ($method) {
            case 'embed':
                return $host . '/embed/' . $this->youtube_id;

            case 'edit':
                return $host . '/edit?video_id=' . $this->youtube_id;

            default:
                return $host .'/watch?v=' . $this->youtube_id;
        }
    }

}
