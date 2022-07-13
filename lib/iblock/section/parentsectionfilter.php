<?php

namespace Bx\Helper\Iblock\Section;

use Bitrix\Iblock\SectionTable;
use Bx\Helper\RuntimeFactory;

class ParentSectionFilter
{
    /**
     * @param  array  $params
     * @param  string $sectionCode
     * @return void
     */
    public static function update(array &$params, string $sectionCode)
    {
        $joinRuntime = RuntimeFactory::createJoin(
            'IBLOCK_ID',
            SectionTable::class,
            'IBLOCK_ID'
        );
        $joinRuntime->getCondition()
            ->where('this.LEFT_MARGIN', '>=', 'this.LEFT_MARGIN')
            ->where('this.RIGHT_MARGIN', '<=', 'this.RIGHT_MARGIN');

        $params['runtime']['ROOT'] = $joinRuntime->compile('ROOT');
        $params['filter']['=ROOT.CODE'] = $sectionCode;
    }
}
