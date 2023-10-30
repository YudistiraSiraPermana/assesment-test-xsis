<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $limit  = $request->query('limit', 100);
        $offset = $request->query('offset', 0);
        $sort   = $request->query('sort', 'DESC');
        $search = $request->query('search');

        $movie = Movie::search($search)
            ->limit($limit)
            ->offset($offset)
            ->orderBy('created_at', $sort)
            ->get();

        $filtered_total = Movie::search($search)
            ->orderBy('created_at', $sort)
            ->count();

        return $this->responseJson([
            'data' => $movie,
            'meta' => [
                'limit'          => $limit,
                'offset'         => $offset,
                'filtered_total' => $filtered_total,
                'total'          => Movie::count()
            ],
        ]);
    }

    public function detail($id)
    {
        $movie = Movie::firstWhere('id', $id)->get();

        return $this->responseJson([
            'data' => $movie,
        ]);
    }

    public function store(MovieRequest $request)
    {
        try {

            $data = $request->all();
            if($request->file('image') != null){
                $data['image'] = $request->file('image')->store('images');
            }
            $movie = Movie::create($data);

            return $this->responseJson([
                'message'   => 'Movie successfully added',
                'data'      => $movie
            ], 201);
        } catch (\Exception $th) {
            throw $th;
            return $this->responseJson([], 500, $th);
        }
    }

    public function update(MovieRequest $request, $id)
    {
        try {
            $movie = Movie::findOrFail($id);

            if ($request->file('image') != null){
                // Delete Old image
                $pathFoto =  $movie->image;
                if ($pathFoto != null || $pathFoto != '') {
                    Storage::delete($pathFoto);
                }

                // Update image
                $movie->image = $request->file('image')->store('images');      
            }

            $movie->title       = $request->title       ?? $movie->title;
            $movie->description = $request->description ?? $movie->description;
            $movie->rating      = $request->rating      ?? $movie->rating;
            $movie->save();

            return $this->responseJson([
                'message'   => 'Movie updated successfully',
                'data'      => $movie
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return $this->responseJson([], 500, $th);
        }
    }

    public function destroy($id)
    {
        try {
            $movie = Movie::findOrFail($id);
            // Delete Old image
            $pathFoto =  $movie->image;
            if ($pathFoto != null || $pathFoto != '') {
                Storage::delete($pathFoto);
            }
            $movie->delete();

            return $this->responseJson([
                'message' => 'Movie successfully deleted'
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return $this->responseJson([], 500, $th);
        }
    }
}
