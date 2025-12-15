<?php


namespace App\Enum;


class RoleEnum{
    const OWNER='owner';
    const MANAGER='manager';
    const MEMBER='member';

    const SET=[
        self::MANAGER,
        self::OWNER,
        self::MEMBER
    ];
}