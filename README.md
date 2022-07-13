# Bitrix helper

## Элементы инфоблока
```php
use Bx\Helper\Iblock\Element\InSectionFilterByCode;
use Bx\Helper\Iblock\Element\EnumXmlIdFilter;
use Bx\Helper\Iblock\Element\ActualIBElementFilter;

$params = [
    'filter' => [
        '=IBLOCK_ID' => 1,
        '=ACTIVE' => 'Y',
    ],
    'select' => [
        'ID',
        'NAME',
    ],
];

// добавляем в выборку элементы из разделов news, innovations и всех вложенных разделов
InSectionFilterByCode::update($params, ['news', 'innovations'], true);

// добавляем в выборку элементы из разделов news, innovations без вложенных разделов
InSectionFilterByCode::update($params, ['news', 'innovations'], false);

// добавляем фильтрацию по XML_ID значений списка свойства COLOR
EnumXmlIdFilter::update($params, 'COLOR', ['white', 'black']);

// добавляем фильтр по активности и датам публикации
ActualIBElementFilter::update($params);
```

## Разделы инфоблока
```php
use Bx\Helper\Iblock\Section\ChildrenSectionFilter;
use Bx\Helper\Iblock\Section\ParentSectionFilter;

$sectionParams = [
    'filter' => [
        '=IBLOCK_ID' => 1,
        '=ACTIVE' => 'Y',
    ],
    'select' => [
        'ID',
        'NAME',
    ],
];

// выборка вложенных разделов
ChildrenSectionFilter::update($sectionParams, 'news');

// выборка родительский разделов
ParentSectionFilter::update($sectionParams, 'news');
```

## Runtime

```php
use Bx\Helper\RuntimeFactory;

$params = [
    'filter' => [
        '=IBLOCK_ID' => 1,
        '=ACTIVE' => 'Y',
    ],
    'select' => [
        'ID',
        'NAME',
    ],
];

// join по внешнему ключу с внешней таблицей и доп. фильтрацией
$testJoin = RuntimeFactory::createJoin('EXT_ID', TestTable::class, 'ID');
$testJoin->getCondition()->where('ACTIVE', '=', 'Y');
$params['runtime']['TEST'] = $testJoin->setJoinType('INNER')->compile('TEST');

// подсчет количества записей
$params['runtime']['TEST_COUNT'] = RuntimeFactory::createCountExpression('TEST.*')
    ->compile('TEST_COUNT');

// среднее значение    
$params['runtime']['AVG_COST'] = RuntimeFactory::createAvgExpression('TEST.COST')
    ->compile('AVG_COST');
    
// сумма
$params['runtime']['SUM_COST'] = RuntimeFactory::createSumExpression('TEST.COST')
    ->compile('SUM_COST');

// произвольное SQL выражение
$params['runtime']['CUSTOM_SUM'] = RuntimeFactory::createExpression('SUM(%s)', 'TEST.COST')
    ->compile('CUSTOM_SUM');
```