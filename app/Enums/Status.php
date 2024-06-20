<?php

namespace App\Enums;

class Status
{
    const Ativo = 1;
    const Inativo = 0;

    public static function getText($status)
    {
        switch ($status) {
            case self::Ativo:
                return 'Ativo';
            case self::Inativo:
                return 'Inativo';
            default:
                return 'Ativo';
        }
    }
}