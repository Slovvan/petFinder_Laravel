<x-app-layout>
    <div style="max-width: 1000px; margin: 0 auto;">
        <h1 class="card-title mb-3">Demandes d'Adoption</h1>

        @if($notifications->isEmpty())
            <div class="info-box text-center">
                <p style="margin: 0;">Vous n'avez pas encore de demandes d'adoption pour vos annonces.</p>
            </div>
        @else
            @foreach($notifications as $notification)
                <div class="card mb-3">
                    <div class="flex-between mb-2">
                        <div style="flex: 1;">
                            <h2 class="card-title" style="margin-bottom: 8px;">
                                <a href="{{ $notification->data['animal_url'] ?? '#' }}">
                                    {{ $notification->data['animal_name'] ?? 'Animal' }}
                                </a>
                            </h2>
                            <p class="text-muted" style="margin: 0;">
                                <strong>Demandeur :</strong> {{ $notification->data['requester_name'] ?? 'Utilisateur' }}
                            </p>
                        </div>
                        <div class="text-right">
                            @if($notification->read_at)
                                <span class="badge badge-info">Lue</span>
                            @else
                                <span class="badge badge-warning">Nouvelle</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-box">
                        <p style="margin: 0;">
                            {{ $notification->data['message'] ?? 'Sans message' }}
                        </p>
                    </div>

                    <div class="flex gap-2" style="justify-content: flex-end;">
                        <a href="{{ $notification->data['animal_url'] ?? '#' }}" class="btn btn-sm">Voir l'animal</a>
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    Marquer comme lue
                                </button>
                            </form>
                        @endif
                    </div>

                    <p class="text-muted text-small mt-2" style="margin-bottom: 0;">
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
