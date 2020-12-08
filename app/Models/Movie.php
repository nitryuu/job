<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    protected $table = 'title_basics';
    protected $guarded = [];
    public $timestamps = false;

    public function scopeGetMovie($query) {
        return $query->select(DB::raw('SUBSTR(tconst, 3) as id, titleType, primaryTitle,
        (CASE WHEN title_basics.runtimeMinutes = "N" THEN null ELSE CONVERT(title_basics.runtimeMinutes, INT) END) as runtimeMinutes,
         genres'))
            ->get();
    }

    public function scopeGetSpesificMovie($query, $ids) {
        return $query->select(DB::raw('SUBSTR(tconst, 3) as id, titleType, primaryTitle, originalTitle,
        (CASE WHEN title_basics.isAdult = 0 THEN "false" ELSE "true" END) as isAdult,
        CONVERT(title_basics.startYear, INT) as startYear,
        (CASE WHEN title_basics.endYear = "N" THEN null ELSE CONVERT(title_basics.endYear, INT) END) as endYear,
        (CASE WHEN title_basics.runtimeMinutes = "N" THEN null ELSE CONVERT(title_basics.runtimeMinutes, INT) END) as runtimeMinutes,
        genres
        '))
            ->where('tconst', $ids)
            ->get();
    }
}
