<?php

namespace App\Enums;



enum ContratosStatusEnum: string
{

    case PREENCHIMENTO = 'PREENCHIMENTO';
    case AGUARDANDO = 'AGUARDANDO';
    case REVISAR = 'REVISAR';
    case REVISADO = 'REVISADO';
    case APROVADO = 'APROVADO';
    case CONCLUIDO = 'CONCLUIDO';

    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
