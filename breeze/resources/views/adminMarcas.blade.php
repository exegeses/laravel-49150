<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Marcas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1>Panel de administración de marcas</h1>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Marca</th>
                                </tr>
                            </thead>
                            <tbody>
                    @foreach( $marcas as $marca )
                                <tr>
                                    <td>{{ $marca->idMarca }}</td>
                                    <td>{{ $marca->mkNombre }}</td>
                                </tr>
                    @endforeach
                            </tbody>
                        </table>

                {{ $marcas->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
