<x-app-layout>
    <x-slot name="header">Mi Perfil</x-slot>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 style="margin-bottom: 20px; font-size: 1.5rem;">Información Personal</h2>

        @if (session('success'))
            <div style="background: #dcfce7; border: 1px solid #86efac; border-radius: 6px; padding: 12px; margin-bottom: 20px; color: #16a34a;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('info'))
            <div style="background: #dbeafe; border: 1px solid #93c5fd; border-radius: 6px; padding: 12px; margin-bottom: 20px; color: #2563eb;">
                {{ session('info') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background: #fee2e2; border: 1px solid #fca5a5; border-radius: 6px; padding: 12px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px; color: #dc2626;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Nombre</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                    style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                    style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Biografía</label>
                <textarea name="bio" rows="3" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">{{ old('bio', optional(auth()->user()->profile)->bio) }}</textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Foto de Perfil</label>
                @if(optional(auth()->user()->profile)->profile_photo)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/'.auth()->user()->profile->profile_photo) }}" alt="Avatar" style="height: 100px; width: 100px; object-fit: cover; border-radius: 9999px; border: 2px solid #e2e8f0;">
                    </div>
                @endif
                <input type="file" name="profile_photo" accept="image/*"
                    style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px; background: #fff;">
                <p style="color: #94a3b8; margin-top: 6px; font-size: 0.9rem;">Se almacena en el disco público (máx. 2MB).</p>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn">Guardar Cambios</button>
                <a href="{{ route('animals.index') }}" class="btn" style="background: #6b7280;">Cancelar</a>
            </div>
        </form>

        <hr style="margin: 30px 0; border: none; border-top: 1px solid #e2e8f0;">

        <h3 style="margin-bottom: 15px; font-size: 1.2rem; color: #dc2626;">Zona de Peligro</h3>
        <p style="color: #64748b; margin-bottom: 15px; font-size: 0.9rem;">
            Una vez eliminada tu cuenta, todos sus recursos y datos serán borrados permanentemente.
        </p>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn" style="background: #dc2626;">Eliminar Cuenta</button>
        </form>
    </div>
</x-app-layout>
