<x-app-layout>
    <div style="max-width: 1000px; margin: 0 auto;">
        <div class="card">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @if($animal->image)
                    <img src="{{ asset('storage/'.$animal->image) }}" alt="{{ $animal->name }}" class="image-preview">
                @else
                    <div class="card text-center" style="height: 320px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-muted">Sans image</span>
                    </div>
                @endif

                <div>
                    <div class="flex-between mb-3">
                        <h1 class="card-title">{{ $animal->name }}</h1>
                        <span class="badge badge-{{ $animal->status == 'Lost' ? 'danger' : 'success' }}">
                            {{ $animal->status == 'Lost' ? 'Perdu' : 'En Adoption' }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-muted"><strong>Espèce :</strong> {{ $animal->species }}</p>
                        <p class="text-muted"><strong>Ville :</strong> {{ $animal->city }}</p>
                        @if($animal->description)
                            <p class="mt-2">{{ $animal->description }}</p>
                        @endif
                    </div>

                    <div class="info-box">
                        <strong>Contact du Propriétaire</strong>
                        <p class="text-muted">
                            <strong>Nom :</strong> {{ $animal->user->name ?? 'Non disponible' }}
                        </p>
                        <p class="text-muted">
                            <strong>E-mail :</strong> {{ $animal->user->email ?? 'Non disponible' }}
                        </p>
                        @if($animal->city)
                            <p class="text-muted">
                                <strong>Localisation :</strong> {{ $animal->city }}
                            </p>
                        @endif
                    </div>

                    @auth
                        @if(auth()->id() === $animal->user_id)
                            <div class="alert alert-success mt-3">
                                Ceci est votre annonce. <a href="{{ route('animals.edit', $animal) }}">Modifier</a>
                            </div>
                        @else
                            <div class="mt-3">
                                <h3 class="card-title mb-2">Envoyer une Demande d'Adoption</h3>
                                <form action="{{ route('adopt.store', $animal) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="message" rows="3" required placeholder="Dites au propriétaire pourquoi vous voulez adopter {{ $animal->name }}..."></textarea>
                                    </div>
                                    <button type="submit" class="btn" style="width: 100%;">Envoyer la Demande</button>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-success mt-3">
                            <a href="{{ route('login') }}">Connectez-vous</a> pour envoyer une demande d'adoption
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
