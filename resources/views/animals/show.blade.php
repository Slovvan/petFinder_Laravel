<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-3/5 bg-black flex items-center">
                        <img src="{{ asset('storage/'.$animal->image) }}" class="w-full h-125 object-contain">
                    </div>

                    <div class="md:w-2/5 p-8 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <h1 class="text-3xl font-extrabold text-gray-900">{{ $animal->name }}</h1>
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $animal->status == 'Perdido' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $animal->status }}
                                </span>
                            </div>
                            
                            <div class="mt-4 space-y-2 text-gray-600">
                                <p><strong>Especie:</strong> {{ $animal->species }}</p>
                                <p><strong>Ciudad:</strong> {{ $animal->city }}</p>
                                <p class="mt-4 leading-relaxed">{{ $animal->description }}</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t">
                            <h3 class="font-bold text-gray-800 mb-2">Contactar con el rescatista</h3>
                            <form action="{{ route('adopt.store', $animal) }}" method="POST">
                                @csrf
                                <textarea name="message" class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 mb-3" placeholder="Hola, me gustaría tener más información..."></textarea>
                                <x-primary-button class="w-full justify-center py-3">Enviar Mensaje Directo</x-primary-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>