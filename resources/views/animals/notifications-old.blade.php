<x-app-layout>
    <div style="max-width: 900px; margin: 0 auto;">
        <h1 style="font-size: 28px; font-weight: bold; margin-bottom: 30px; color: #1e293b;">Solicitudes de Adopción</h1>

        @if($notifications->isEmpty())
            <div style="background: #f1f5f9; border-left: 4px solid #94a3b8; padding: 20px; border-radius: 6px; text-align: center;">
                <p style="color: #64748b; margin: 0; font-size: 16px;">Aún no tienes solicitudes de adopción para tus anuncios.</p>
            </div>
        @else
            @foreach($notifications as $notification)
                <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s ease;" onmouseover="this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)'" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <h2 style="font-size: 18px; font-weight: bold; margin: 0 0 8px 0; color: #1e293b;">
                                <a href="{{ $notification->data['animal_url'] ?? '#' }}" style="color: var(--primary); text-decoration: none;">
                                    {{ $notification->data['animal_name'] ?? 'Animal' }}
                                </a>
                            </h2>
                            <p style="color: #64748b; margin: 0; font-size: 14px;">
                                <strong>Solicitante:</strong> {{ $notification->data['requester_name'] ?? 'Usuario desconocido' }}
                            </p>
                        </div>
                        <div style="text-align: right;">
                            @if($notification->read_at)
                                <span style="background: #e0e7ff; color: #4338ca; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">Leída</span>
                            @else
                                <span style="background: #fef08a; color: #92400e; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">Nueva</span>
                            @endif
                        </div>
                    </div>

                    <div style="background: #f8fafc; padding: 15px; border-radius: 6px; margin-bottom: 15px; border-left: 3px solid var(--primary);">
                        <p style="color: #64748b; margin: 0; line-height: 1.6;">
                            {{ $notification->data['message'] ?? 'Sin mensaje' }}
                        </p>
                    </div>

                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <a href="{{ $notification->data['animal_url'] ?? '#' }}" class="btn" style="text-decoration: none; display: inline-block;">Ver Animal</a>
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #64748b; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                                    Marcar como Leída
                                </button>
                            </form>
                        @endif
                    </div>

                    <p style="color: #94a3b8; font-size: 12px; margin-top: 12px; margin-bottom: 0;">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
            @endforeach

            <!-- Pagination -->
            <div style="margin-top: 30px;">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    <style>
        .btn {
            background: var(--primary);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
    </style>
</x-app-layout>
