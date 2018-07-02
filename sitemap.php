<?php
ini_set('display_errors', 1);
require_once 'application/core/Database.php';
Database::instance('127.0.0.1:3366', 'kurocajy_shop', 'utf8', 'kurocajy', 'Mchp625ykQ3TTTAKsM');

$protocol = 'http://';
$domain = 'invest82.ru';
$site = $protocol.$domain;
$map_last_mod = date('c');
$data_last_mod = strrev(substr(strrev($map_last_mod), -10));

$all_limit = 10000;
$chunk_limit = 50000;
$sitemap_chunks = [
    ''
];

$changes = 'weekly';
$priority = 1;
$sitemap = [
    [
        'loc' => $site.'/',
        'priority' => $priority,
        'freq' => $changes
    ],
    [
        'loc' => $site.'/about/',
        'priority' => 0.5,
        'freq' => $changes
    ],
    [
        'loc' => $site.'/uslugi/',
        'priority' => 0.5,
        'freq' => $changes
    ],
    [
        'loc' => $site.'/main/',
        'priority' => 0.5,
        'freq' => $changes
    ]
];

///////////////////////////////////////////////////////////////////////////
$priority = 0.8;
$url_p = '/catalog/list/';
$fetch = Database::run('SELECT translit FROM categories WHERE parent=0')->fetchAll(PDO::FETCH_NUM);
foreach ($fetch as $k => $row)
{
    $url = [
        'loc' => $site.$url_p.'cat/'.$row[0].'/',
        'priority' => $priority,
        'freq' => $changes
    ];
    array_push($sitemap, $url);
}
$fetch = Database::run('SELECT translit FROM region WHERE country_id=3159')->fetchAll(PDO::FETCH_NUM);
foreach ($fetch as $k => $row)
{
    $url = [
        'loc' => $site.$url_p.'region/'.$row[0].'/',
        'priority' => $priority,
        'freq' => $changes
    ];
    array_push($sitemap, $url);
}
///////////////////////////////////////////////
/// //////////////////////////////////////////
$pritority = 0.7;
$fetch = Database::run('SELECT translit FROM categories WHERE parent=0')->fetchAll(PDO::FETCH_NUM);
$fetch1 = Database::run('SELECT translit FROM region WHERE country_id=3159')->fetchAll(PDO::FETCH_NUM);
foreach ($fetch as $k => $row)
{
    foreach ($fetch1 as $i=> $row1)
    {
        $url = [
            'loc' => $site.$url_p.'cat/'.$row[0].'/region/'.$row1[0].'/',
            'priority' => $priority,
            'freq' => $changes
        ];
        array_push($sitemap, $url);
    }
}
///////////////////////////////////////////////
$priority = 0.6;
$fetch = Database::run('SELECT translit, `A`.`subcatTranslit` FROM categories LEFT JOIN (SELECT `translit` AS `subcatTranslit`, `parent` AS `catPar` FROM `categories` WHERE parent!=0) `A` ON `id`=`A`.`catPar` WHERE parent=0')->fetchAll(PDO::FETCH_NUM);
foreach ($fetch as $k => $row)
{
    $url = [
        'loc' => $site.$url_p.'cat/'.$row[0].'/subcat/'.$row[1].'/',
        'priority' => $priority,
        'freq' => $changes
    ];
    array_push($sitemap, $url);
}
$fetch = Database::run('SELECT translit, `A`.`cityTranslit` FROM `region` LEFT JOIN (SELECT `translit` AS `cityTranslit`, `region_id` AS `catPar` FROM `city` WHERE `country_id`=3159) `A` ON `id`=`A`.`catPar` WHERE `country_id`=3159')->fetchAll(PDO::FETCH_NUM);
foreach ($fetch as $k => $row)
{
    $url = [
        'loc' => $site.$url_p.'region/'.$row[0].'/city/'.$row[1].'/',
        'priority' => $priority,
        'freq' => $changes
    ];
    array_push($sitemap, $url);
}
////////////////////////////////////////////////
$priority = 0.9;
$url_p = '/catalog/biznes/';
$fetch = Database::run('SELECT id FROM `products`')->fetchAll(PDO::FETCH_NUM);
foreach ($fetch as $k => $row)
{
    $url = [
        'loc' => $site.$url_p.'i/'.$row[0],
        'priority' => $priority,
        'freq' => $changes
    ];
    array_push($sitemap, $url);
}



$c = count($sitemap);
var_dump($c);
$dir = scandir($_SERVER['DOCUMENT_ROOT']);
foreach ( $dir as $row)
{
    if (preg_match('/sitemap.*\.xml/', $row))
    {
        unlink($row);
    }
}

$start = 0;
$index = fopen('sitemap.xml', 'w+');
fwrite($index, '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
while ( $c  > 0)
{
    $map = fopen('sitemap'.$start.'.xml', 'w+');
    fwrite($map, '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL);
    for ($i = 0; $i < $all_limit and $i < $chunk_limit and $c > 0; $i++, $c--)
    {
        $entry = $sitemap[$i];
        fwrite($map, '    <url>
        <loc>'.$entry['loc'].'</loc>
        <lastmod>'.$data_last_mod.'</lastmod>
        <changefreq>'.$entry['freq'].'</changefreq>
        <priority>'.$entry['priority'].'</priority>
    </url>'.PHP_EOL);
    }
    fwrite($map, '</urlset>');
    fclose($map);

    fwrite($index,'
    <sitemap>
        <loc>'.$site.'/sitemap'.$start.'.xml</loc>
        <lastmod>'.$map_last_mod.'</lastmod>
     </sitemap>'.PHP_EOL);
    $start++;
}
fwrite($index,'</sitemapindex>');
fclose($index);