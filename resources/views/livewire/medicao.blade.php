@extends('filament::layouts.app')

@section('content')
    <x-filament-page-header title="Editar Usuário">
        <x-filament-action-link href="{{ route('users.index') }}">
            Voltar à lista
        </x-filament-action-link>
    </x-filament-page-header>

    <x-filament-form action="{{ route('users.update', $user) }}" method="put">
        <x-filament-input type="text" label="Nome" name="name" />

        <x-filament-button type="submit">
            Salvar
        </x-filament-button>
    </x-filament-form>
@endsection
