<?php

namespace App\Enums;

class StatusPedido
{
    const Em_Aberto = 0;
    const Pago = 1;
    const Cancelado = 2;

    public static function getText($status)
    {
        switch ($status) {
            case self::Em_Aberto:
                return 'Em Aberto';
            case self::Pago:
                return 'Pago';
            case self::Cancelado:
                return 'Cancelado';
            default:
                return 'Em Aberto';
        }
    }
}