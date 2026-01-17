<x-app-layout>
    <div style="max-width: 1000px; margin: 0 auto;">
        <h1 class="card-title mb-3" style="font-size: 28px;">Solicitudes de Adopción</h1>

        @if($notifications->isEmpty())
            <div class="info-box text-center">
                <p style="margin: 0; font-size: 16px;">Aún no tienes solicitudes de adopción para tus anuncios.</p>
            </div>
        @else
            @foreach($notifications as $notification)
                <div class="card mb-3">
                    <div class="flex-between mb-2">
                        <div style="flex: 1;">
                            <h2 class="card-title" style="margin-bottom: 8px;">
                                <a href="{{ $notification->data['animal_url'] ?? '#' }}" style="color: var(--primary); text-decoration: none;">
                                    {{ $notification->data['animal_name'] ?? 'Animal' }}
                                </a>
                            </h2>
                            <p class="text-muted" style="margin: 0; font-size: 14px;">
                                <strong>Solicitante:</strong> {{ $notification->data['requester_name'] ?? 'Usuario' }}
                            </p>
                        </div>
                        <div style="text-align: right;">
                            @if($notification->read_at)
                                <span class="badge badge-info">Leída</span>
                            @else
                                <span class="badge badge-warning">Nueva</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-box">
                        <p style="margin: 0; line-height: 1.6; color: #64748b;">
                            {{ $notification->data['message'] ?? 'Sin mensaje' }}
                        </p>
                    </div>

                    <div class="flex gap-2" style="justify-content: flex-end;">
                        <a href="{{ $notification->data['animal_url'] ?? '#' }}" class="btn btn-sm">Ver Animal</a>
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    Marcar como leída
                                </button>
                            </form>
                        @endif
                    </div>

                    <p class="text-muted mt-2" style="font-size: 12px; margin-bottom: 0;">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
            @endforeach

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
