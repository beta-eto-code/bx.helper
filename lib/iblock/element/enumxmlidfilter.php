<?php

namespace Bx\Helper\Iblock\Element;

use Bx\Helper\Utils\Helper;

class EnumXmlIdFilter
{
    /**
     * @param  array    $params
     * @param  string   $propertyName
     * @param  string[] $xmlId
     * @return void
     */
    public static function update(array &$params, string $propertyName, array $xmlId)
    {
        $state = Helper::getOneOfStateStringKey([$propertyName, "=$propertyName"], $params['filter']);
        if ($state->isSuccess()) {
            $state->setValue($xmlId);
            return;
        }

        $params['filter']["=$propertyName"] = $xmlId;
    }
}
