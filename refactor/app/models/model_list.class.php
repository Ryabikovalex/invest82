<?php

class model_list
{
    public static function getCategory(string $category,int $from,  int $to)
    {
        $sql = 'SELECT
    `products`.`name`,
    `products`.`cost`,
    `C`.`translit` AS `catTranslit`,
    `B`.`name` AS `subcatName`,
    `B`.`translit` AS `subcatTranslit`,
    `A`.`name` AS `cityName`,
    `A`.`translit` AS `cityTranslit`,
    `products`.`address`
FROM
    `products`
LEFT JOIN
    (
    SELECT
        `cities`.`id`,
        `cities`.`name`,
        `cities`.`translit`
    FROM
        `cities`
) `A`
ON
    `products`.`city` = `A`.`id`
LEFT JOIN
    (
    SELECT
        `categories`.`id`,
        `categories`.`name`,
        `categories`.`translit`,
        `categories`.`is_enabled`
    FROM
        `categories`
) `B`
ON
    `products`.`category` = `B`.`id`
LEFT JOIN
    (
    SELECT
        `categories`.`id`,
        `categories`.`translit`,
        `categories`.`is_enabled`
    FROM
        `categories`
    WHERE
        `categories`.`translit` = ?
) `C`
ON
    `products`.`category` = `B`.`id`
WHERE
    `C`.`is_enabled` = 1 AND `B`.`is_enabled` = 1 AND `products`.`category` IN(
    SELECT
        `categories`.`id`
    FROM
        `categories`
    WHERE
        `categories`.`parent` IN(
        SELECT
            `categories`.`id`
        FROM
            `categories`
        WHERE
            `categories`.`is_enabled` = 1 AND `categories`.`translit` = ?
    )
) LIMIT {from}, {to}';
        $sql = str_replace('{from}', $from, $sql);
        $sql = str_replace('{to}', $to, $sql);

        $stmt = DataBase::run($sql, [$category, $category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSubCategory()
    {
        $sql = '';
    }

    public static function getCity()
    {
        $sql = '';
    }
}