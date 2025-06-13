<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;



class PublicController extends Controller
{
    public function index(User $user)
    {
        // On récupère les articles publiés de l'utilisateur
        $articles = Article::where('user_id', $user->id)->where('draft', 0)->get();
    
        // On retourne la vue
        return view('public.index', [
            'articles' => $articles,
            'user' => $user
        ]);
    }

    public function show(User $user, Article $article)
    {

        // $articles = Article::where('user_id', $user->id)->where('draft', 0)->get();

        // $user est l'utilisateur de l'article
        // $article est l'article à afficher

        // Je vous laisse faire le code
        // N'oubliez pas de vérifier que l'article est publié (draft == 0)
         // On retourne la vue
         return view('public.show',compact('article')
        //   [
        //     'article' => $articles,
        //     'user' => $user
        // ]
    );
    }
}
