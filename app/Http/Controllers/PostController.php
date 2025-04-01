<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Obtener todas las publicaciones con paginación y usuario relacionado
    public function index(Request $request)
    {
        $query = Post::with('user');

        // Filtrar por fecha de creación
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Ordenar por fecha descendente para mostrar la más reciente primero
        $posts = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($posts);
    }

    // Obtener un solo post por ID
    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return response()->json($post);
    }
}
