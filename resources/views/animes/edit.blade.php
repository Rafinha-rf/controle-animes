<x-layout title="Editar Anime '{!! $anime->nome !!}'">
    <x-animes.form :action="route('animes.update', $anime->id)" :nome="$anime->nome" :update="true"/>
</x-layout>