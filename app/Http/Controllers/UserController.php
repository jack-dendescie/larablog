<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Category;

class UserController extends Controller
{
    public function create()
    {

        $categories = Category::all();
        return view('articles.create', compact('categories'));
        // return view('articles.create');
    }

        public function store(Request $request)
    {
        // On récupère les données du formulaire
        $data = $request->only(['title', 'content', 'draft']);

        // Créateur de l'article (auteur)
        $data['user_id'] = Auth::user()->id;

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On crée l'article
        $article = Article::create($data); // $Article est l'objet article nouvellement créé

        // Exemple pour ajouter la catégorie 1 à l'article
        // $article->categories()->sync(1);

        // Exemple pour ajouter des catégories à l'article
        // $article->categories()->sync([1, 2, 3]);

        // Exemple pour ajouter des catégories à l'article en venant du formulaire
        // $article->categories()->sync($request->input('categories'));

        // On redirige l'utilisateur vers la liste des articles
        $article->categories()->sync($request->categories);

        return redirect()->route('dashboard')->with('success', 'Article créé avec succès');
        // return redirect()->route('dashboard');
    }

    public function index()
    {
        // On récupère l'utilisateur connecté.
        $user = Auth::user();
        $articles = Article::where('user_id', $user->id)->get();

        // On retourne la vue.
        return view('dashboard', [ 'articles' => $articles]);
    }

    public function edit(Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            abort(403);
        }

        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));

        // On retourne la vue avec l'article
        // return view('articles.edit', [
        //     'article' => $article
        // ]);
    }   

    public function update(Request $request, Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            abort(403);
        }

        // On récupère les données du formulaire
        $data = $request->only(['title', 'content', 'draft']);

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On met à jour l'article
        $article->update($data);

        // On redirige l'utilisateur vers la liste des articles (avec un flash)
        $article->categories()->sync($request->categories);
        return redirect()->route('dashboard')->with('success', 'Article modifié avec succès');
        // return redirect()->route('dashboard')->with('success', 'Article mis à jour !');
    }

    // public function remove($id)
    // {
    //     // On vérifie que l'utilisateur est bien le créateur de l'article


    //     $article = Article::find($id);
        
    //     if ($article->user_id !== Auth::user()->id) {
    //         abort(403);
    //     } 
    //     if (!$article) {
    //         return redirect()->back()->with('error', 'Article non trouvé.');
    //     } 
        
    //     $article->delete();

    //     // On redirige l'utilisateur vers la liste des articles (avec un flash)
    //     return redirect()->route('dashboard')->with('success', 'Article supprimé avec succès !');
    // }


    public function remove($id)
        {
            $article = Article::find($id);

            if (!$article) {
                return redirect()->back()->with('error', 'Article non trouvé.');
            }

            $article->delete();

            return redirect()->back()->with('success', 'Article supprimé avec succès.');
        }

        public function like($id)
        {
            $article = Article::findOrFail($id);
            $article->likes += 1;
            $article->save();

            return redirect()->back()->with('success', 'Merci pour le like !');
        }




}
