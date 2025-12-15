<?php
namespace App\Enum;

class StatusTask {
    const NEW ='new';
    const PROCCESSING='proccessing';
    const COMPLETED='completed';


    const SET=[
        self::NEW,
        self::PROCCESSING,
        self::COMPLETED
    ];
}