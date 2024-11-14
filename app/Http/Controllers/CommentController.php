<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCommentRequest;
class CommentController extends Controller
{
    public function index(Post $post)
    {
        $comments = Comment::where('post_id', $post->id)->latest()->get();
        return view('comments.postComment', compact('post', 'comments'));
    }

    public function store(StoreCommentRequest $request, Post $post)
    {
        // Crear un nuevo comentario con los datos del request
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->id(); // Asegura que el usuario esté autenticado
        $comment->post_id = $post->id;
        $comment->save();

        // Redirige de vuelta a la página del post con un mensaje de éxito
        return redirect()->route('posts.show', $post)->with('success', 'Comentario agregado exitosamente.');
    }
}
