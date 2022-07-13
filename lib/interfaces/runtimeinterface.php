<?php

namespace Bx\Helper\Interfaces;

interface RuntimeInterface
{
    /**
     * @params string $resultFieldName
     * @return array|object
     */
    public function compile(string $resultFieldName);
}
