<?php

namespace Bx\Helper\Interfaces;

interface ParamDecoratorInterface
{
    /**
     * @param array $params
     * @return void
     */
    public static function update(array &$params);
}
