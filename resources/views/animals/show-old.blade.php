<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-3/5 bg-black flex items-center">
                        <img src="{{ $animal->image ? asset('storage/'.$animal->image) : 'https://placehold.co/800x400?text=Sin+imagen' }}"
                             alt="{{ $animal->name }}"
                             style="width: 100%; max-height: 420px; object-fit: contain; background: #000;">
                    </div>

                    <div class="md:w-2/5 p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <h1 class="text-3xl font-extrabold text-gray-900">{{ $animal->name }}</h1>
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $animal->status == 'Lost' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $animal->status == 'Lost' ? 'Perdido' : 'En Adopción' }}
                                </span>
                            </div>
                            
                            <div class="mt-4 space-y-2 text-gray-600">
                                <p><strong>Especie:</strong> {{ $animal->species }}</p>
                                <p><strong>Ciudad:</strong> {{ $animal->city }}</p>
                                <p class="mt-4 leading-relaxed">{{ $animal->description }}</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t">
                            <!-- Información del propietario -->
                            <div style="background: #f0f9ff; border-left: 4px solid var(--primary); padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                                <h3 class="font-bold text-gray-800 mb-3" style="margin-top: 0; color: #1e293b;">Contacto del Propietario</h3>
                                <p style="margin: 8px 0; color: #64748b;">
                                    <strong>Nombre:</strong> {{ $animal->user->name ?? 'No disponible' }}
                                </p>
                                <p style="margin: 8px 0; color: #64748b;">
                                    <strong>Email:</strong> {{ $animal->user->email ?? 'No disponible' }}
                                </p>
                                @if($animal->city)
                                    <p style="margin: 8px 0; color: #64748b;">
                                        <strong>Ubicación:</strong> {{ $animal->city }}
                                    </p>
                                @endif
                            </div>

                            @auth
                                @if(auth()->id() === $animal->user_id)
                                    <div style="background: #f8fafc; padding: 12px; border-radius: 6px; border: 1px solid #e2e8f0; color: #64748b;">
                                        <p style="margin: 0;">Este es tu anuncio. <a href="{{ route('animals.edit', $animal) }}" style="color: var(--primary); font-weight: 600; text-decoration: none;">Editar</a></p>
                                    </div>
                                @else
                                    <h3 class="font-bold text-gray-800 mb-3">Enviar Solicitud de Adopción</h3>
                                    <form action="{{ route('adopt.store', $animal) }}" method="POST">
                                        @csrf
                                        <textarea name="message" rows="3" required placeholder="Cuéntale al dueño por qué quieres adoptar a {{ $animal->name }}..."
                                            style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; margin-bottom: 12px; font-family: inherit;"></textarea>
                                        <button type="submit" class="btn" style="width: 100%; padding: 12px;">Enviar Solicitud</button>
                                    </form>
                                @endif
                            @else
                                <div style="background: #dbeafe; border: 1px solid #93c5fd; border-radius: 6px; padding: 12px;">
                                    <p style="margin: 0; color: #2563eb;"><a href="{{ route('login') }}" style="font-weight: 600; text-decoration: none;">Inicia sesión</a> para enviar una solicitud de adopción</p>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>