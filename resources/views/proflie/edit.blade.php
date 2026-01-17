<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">Mi Perfil</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <section class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <img id="preview" src="{{ $user->profile->profile_photo ? asset('storage/'.$user->profile->profile_photo) : asset('default-avatar.png') }}" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-indigo-50 shadow-md">
                        <label class="mt-4 inline-block cursor-pointer text-indigo-600 font-bold text-sm hover:underline">
                            Cambiar Foto
                            <input type="file" name="profile_photo" class="hidden" onchange="previewImage(event)">
                        </label>
                    </div>

                    <div class="md:col-span-3 space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Sobre mí</label>
                            <textarea name="bio" rows="4" class="w-full border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500" placeholder="Escribe algo sobre ti...">{{ old('bio', $user->profile->bio) }}</textarea>
                        </div>
                        <div class="flex justify-end">
                            <x-primary-button>Guardar Cambios</x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>

    <script>
        function previewImage(event) {
            const output = document.getElementById('preview');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
</x-app-layout>