<x-guest-layout class="w-[900px]">
    <div class="text-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $article->title }}
        </h2>
    </div>

    <div class="text-gray-500 text-sm">
        Publié le {{ $article->created_at->format('d/m/Y') }} par <a href="{{ route('public.index', $article->user->id) }}">{{ $article->user->name }}</a>
    </div>

    <div>
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <p class="text-gray-700 dark:text-gray-300">{{ $article->content }}</p>
        </div>
    </div>


    <!-- Categorie -->
        <div class="mt-2 mb-4">
            @foreach ($article->categories as $category)
                <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs mr-2">
                    {{ $category->name }}
                </span>
            @endforeach
        </div>
            <!-- Liste des commentaires -->
            <h2 class="text-2xl font-bold mb-6">Commentaires ({{ $article->comments->count() }})</h2>

            @forelse ($article->comments as $comment)
                <div class="mb-6 border border-gray-200 p-4 rounded-lg bg-gray-50">
                    <div class="flex justify-between items-center mb-2">
                        <div class="font-semibold text-gray-800">
                            {{ $comment->user->name ?? 'Utilisateur anonyme' }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $comment->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <p class="text-gray-700">{{ $comment->content }}</p>
                </div>
            @empty
                <p class="text-gray-600">Aucun commentaire pour cet article.</p>
            @endforelse

    <!-- Ajout d'un commentaire -->

  
    <!-- Le code affiché si la personne est connecté -->

    <section class="mt-10">

        @auth
        <h2 class="text-2xl font-bold mb-4">Laisser un commentaire</h2>

        <form action="{{ route('comments.store') }}" method="POST" class=" p-6 rounded-lg  space-y-4">
            @csrf
            <input type="hidden" name="articleId" value="{{ $article->id }}">

            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Commentaire -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">Commentaire</label>
                <textarea name="content" id="content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
            </div>

            <!-- Bouton envoyer -->
            <div class="text-right">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Envoyer</button>
            </div>
        </form>
        @else
    <div>connecter-vous pour laisser un commentaire.</div>
    </section>

    @endauth

    

</x-guest-layout>