<x-app-layout>
    <div style="max-width: 1000px; margin: 0 auto;">
        <div class="card">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @if($animal->image)
                    <img src="{{ asset('storage/'.$animal->image) }}" alt="{{ $animal->name }}" class="image-preview">
                @else
                    <div style="background: #f1f5f9; height: 420px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                        <span class="text-muted">Sin imagen</span>
                    </div>
                @endif

                <div>
                    <div class="flex-between mb-3">
                        <h1 style="font-size: 28px; font-weight: bold; margin: 0;">{{ $animal->name }}</h1>
                        <span class="badge badge-{{ $animal->status == 'Lost' ? 'danger' : 'success' }}" style="font-size: 0.875rem; padding: 6px 12px;">
                            {{ $animal->status == 'Lost' ? 'Perdido' : 'En Adopción' }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-muted"><strong>Especie:</strong> {{ $animal->species }}</p>
                        <p class="text-muted"><strong>Ciudad:</strong> {{ $animal->city }}</p>
                        @if($animal->description)
                            <p class="mt-2" style="line-height: 1.6;">{{ $animal->description }}</p>
                        @endif
                    </div>

                    <div class="info-box">
                        <h3 style="margin-top: 0; font-weight: 600;">Contacto del Propietario</h3>
                        <p class="text-muted">
                            <strong>Nombre:</strong> {{ $animal->user->name ?? 'No disponible' }}
                        </p>
                        <p class="text-muted">
                            <strong>Email:</strong> {{ $animal->user->email ?? 'No disponible' }}
                        </p>
                        @if($animal->city)
                            <p class="text-muted">
                                <strong>Ubicación:</strong> {{ $animal->city }}
                            </p>
                        @endif
                    </div>

                    @auth
                        @if(auth()->id() === $animal->user_id)
                            <div class="alert alert-success mt-3">
                                Este es tu anuncio. <a href="{{ route('animals.edit', $animal) }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Editar</a>
                            </div>
                        @else
                            <div class="mt-3">
                                <h3 style="font-weight: 600; margin-bottom: 12px;">Enviar Solicitud de Adopción</h3>
                                <form action="{{ route('adopt.store', $animal) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="message" rows="3" required placeholder="Cuéntale al dueño por qué quieres adoptar a {{ $animal->name }}..."></textarea>
                                    </div>
                                    <button type="submit" class="btn" style="width: 100%;">Enviar Solicitud</button>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-success mt-3">
                            <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Inicia sesión</a> para enviar una solicitud de adopción
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
