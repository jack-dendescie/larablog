<<x-guest-layout class="w-[900px]">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $article->title }}
        </h2>

        @auth
        <a href="{{ route('article.like', $article->id) }}" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.719,17.073l-6.562-6.51c-0.27-0.268-0.504-0.567-0.696-0.888C1.385,7.89,1.67,5.613,3.155,4.14c0.864-0.856,2.012-1.329,3.233-1.329c1.924,0,3.115,1.12,3.612,1.752c0.499-0.634,1.689-1.752,3.612-1.752c1.221,0,2.369,0.472,3.233,1.329c1.484,1.473,1.771,3.75,0.693,5.537c-0.19,0.32-0.425,0.618-0.695,0.887l-6.562,6.51C10.125,17.229,9.875,17.229,9.719,17.073 M6.388,3.61C5.379,3.61,4.431,4,3.717,4.707C2.495,5.92,2.259,7.794,3.145,9.265c0.158,0.265,0.351,0.51,0.574,0.731L10,16.228l6.281-6.232c0.224-0.221,0.416-0.466,0.573-0.729c0.887-1.472,0.651-3.346-0.571-4.56C15.57,4,14.621,3.61,13.612,3.61c-1.43,0-2.639,0.786-3.268,1.863c-0.154,0.264-0.536,0.264-0.69,0C9.029,4.397,7.82,3.61,6.388,3.61" clip-rule="evenodd" />
            </svg>
            <span>{{ $article->likes }}</span>
        </a>
        @endauth
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