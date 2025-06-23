<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;



class CommentController extends Controller
{
    
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'articleId' => 'required|exists:articles,id',
            'content' => 'required|string|max:1000',
        ]);

        // Vérifie si l'utilisateur est connecté
        if (Auth::check()) {
            Comment::create([
                'content' => $request->content,
                'article_id' => $request->articleId,
                'user_id' => Auth::user()->id
            ]);

            return back()->with('success', 'Commentaire ajouté avec succès.');
        }

        // Sinon, on redirige vers la page de connexion
        return redirect()->route('login')->with('error', 'Vous devez être connecté pour commenter.');
    }
    
}
