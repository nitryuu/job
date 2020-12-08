<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $movie = Movie::GetMovie();

        foreach($movie as $value) {
            $id = $value['tconst'];
            $ids = substr($id,2);
        }
            return response()->json($movie);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'titleType' => 'required',
            'primaryTitle' => 'required',
            'originalTitle' => 'required',
            'isAdult' => 'required',
            'startYear' => 'required',
            'endYear' => 'required',
            'runtimeMinutes' => 'required',
            'genres' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if($request->endYear == 'null' || $request->endYear == null) {
            $endYear = 'N';
        } else {
            $endYear = $request->endYear;
        }

        if($request->runtimeMinutes == null || $request->runtimeMinutes == 'null') {
            $runtimeMinutes = 'N';
        } else {
            $runtimeMinutes = $request->runtimeMinutes;
        }

        if($request->isAdult == 'false') {
            $isAdult = 0;
        } else {
            $isAdult = 1;
        }

        $movie = Movie::create([
            'tconst' => "tt".$request->id,
            'titleType' => $request->titleType,
            'primaryTitle' => $request->primaryTitle,
            'originalTitle' => $request->originalTitle,
            'isAdult' => $isAdult,
            'startYear' => $request->startYear,
            'endYear' => $endYear,
            'runtimeMinutes' => $runtimeMinutes,
            'genres' => $request->genres
        ]);

        if($movie) {
            return response()->json([
                'success' => true,
                'message' => 'Movie berhasil ditambahkan',
                'data' => $movie
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $ids = 'tt'.$id;

        $movies = Movie::GetSpesificMovie($ids);

        return response()->json($movies);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'titleType' => 'required',
            'primaryTitle' => 'required',
            'originalTitle' => 'required',
            'isAdult' => 'required',
            'startYear' => 'required',
            'endYear' => 'required',
            'runtimeMinutes' => 'required',
            'genres' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $ids = 'tt'.$id;

        $movie = Movie::select('*')->where('tconst',$ids);

        if($request->endYear == 'null' || $request->endYear == null) {
            $endYear = 'N';
        } else {
            $endYear = $request->endYear;
        }

        if($request->runtimeMinutes == null || $request->runtimeMinutes == 'null') {
            $runtimeMinutes = 'N';
        } else {
            $runtimeMinutes = $request->runtimeMinutes;
        }

        if($request->isAdult == 'false') {
            $isAdult = 0;
        } else {
            $isAdult = 1;
        }

        if($movie) {
            $movie->update([
                'titleType' => $request->titleType,
                'primaryTitle' => $request->primaryTitle,
                'originalTitle' => $request->originalTitle,
                'isAdult' => $isAdult,
                'startYear' => $request->startYear,
                'endYear' => $endYear,
                'runtimeMinutes' => $runtimeMinutes,
                'genres' => $request->genres
            ]);

            return response()->json([
                'status' => 1
            ]);
        } else {
            return response()->json([
                'status' => 0
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $ids = 'tt'.$id;
        $movie = Movie::select('*')
            ->where('tconst',$ids);

        if($movie) {
            $movie->delete();

            return response()->json([
                'status' => 1
            ]);
        }

        return response()->json([
            'status' => 0
        ]);

    }
}
