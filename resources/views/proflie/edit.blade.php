<div class="space-y-4">
    <x-input-label for="profile_photo" value="Foto de Perfil" />
    
    <div class="mb-4">
        <img id="preview" 
             src="{{ auth()->user()->profile->profile_photo ? asset('storage/' . auth()->user()->profile->profile_photo) : asset('images/default-avatar.png') }}" 
             class="w-32 h-32 rounded-full object-cover border-4 border-indigo-100">
    </div>

    <input type="file" name="profile_photo" id="profile_photo" 
           onchange="previewImage(event)"
           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>