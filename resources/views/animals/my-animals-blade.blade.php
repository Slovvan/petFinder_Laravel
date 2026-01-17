<x-app-layout>
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
            <h2 style="margin:0;">Mis Mascotas Publicadas</h2>
            <a href="{{ route('animals.create') }}" style="background:var(--primary); color:white; padding:10px 20px; border-radius:8px; text-decoration:none;">+ Publicar</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Ciudad</th>
                    <th style="text-align:right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animals as $animal)
                <tr>
                    <td><strong>{{ $animal->name }}</strong></td>
                    <td>{{ $animal->status }}</td>
                    <td>{{ $animal->city }}</td>
                    <td style="text-align:right;">
                        <a href="{{ route('animals.edit', $animal) }}" style="color:var(--primary); margin-right:10px;">Editar</a>
                        <form action="{{ route('animals.destroy', $animal) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" style="color:#ef4444; background:none; border:none; cursor:pointer;">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>