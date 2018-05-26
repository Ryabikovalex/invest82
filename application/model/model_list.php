<?php
class model_list extends model
{
    public function getList( int $from = 0,int $to = 49,array $ctg, ...$params)
    {
        list( $_sort) = $params;
        $sql = 'SELECT
    `products`.`id`,
    `products`.`name`,
    `products`.`cost`,
    `B`.`catTranslit`,
    `B`.`name` AS `subcatName`,
    `B`.`subcatTranslit`,
    `A`.`name` AS `cityName`,
    `A`.`translit` AS `cityTranslit`
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
        `categories`.`translit` AS `subcatTranslit`,
        `categories`.`is_enabled` AS `subcatEnabled`,
        `C`.`translit` AS `catTranslit`,
        `C`.`is_enabled` AS `catEnabled`
    FROM
        `categories`
    LEFT JOIN
        (
        SELECT
            `categories`.`id`,
            `categories`.`translit`,
            `categories`.`is_enabled`
        FROM
            `categories`
        WHERE
            `categories`.`level` = 0
    ) `C`
ON
    `categories`.`parent` = `C`.`id`
WHERE
    `categories`.`is_enabled` = 1 AND `C`.`is_enabled` = 1 AND `categories`.`level` > 0
) `B`
ON
    `products`.`category` = `B`.`id`
WHERE
    `B`.`catEnabled` = 1 AND `B`.`subcatEnabled` = 1 ';
        $payload = [];

        switch (count($ctg))
        {
            case 1:
                if($ctg[0] !== '')
                {

                    /*$sql = 'SELECT
                        `products`.`id`,
                        `products`.`name`,
                        `products`.`cost`,
                        `C`.`translit` AS `catTranslit`,
                        `B`.`name` AS `subcatName`,
                        `B`.`translit` AS `subcatTranslit`,
                        `A`.`name` AS `cityName`,
                        `A`.`translit` AS `cityTranslit`
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
                    ) ';*/
                    $sql = 'SELECT
    `products`.`id`,
    `products`.`name`,
    `products`.`cost`,
    `B`.`catTranslit`,
    `B`.`name` AS `subcatName`,
    `B`.`subcatTranslit`,
    `A`.`name` AS `cityName`,
    `A`.`translit` AS `cityTranslit`
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
        `categories`.`translit` AS `subcatTranslit`,
        `categories`.`is_enabled` AS `subcatEnabled`,
        `C`.`translit` AS `catTranslit`,
        `C`.`is_enabled` AS `catEnabled`
    FROM
        `categories`
    LEFT JOIN
        (
        SELECT
            `categories`.`id`,
            `categories`.`translit`,
            `categories`.`is_enabled`
        FROM
            `categories`
        WHERE
            `categories`.`level` = 0
    ) `C`
ON
    `categories`.`parent` = `C`.`id`
WHERE
    `categories`.`is_enabled` = 1 AND `C`.`is_enabled` = 1 AND `categories`.`level` > 0
) `B`
ON
    `products`.`category` = `B`.`id`
WHERE
    `B`.`catEnabled` = 1 AND `B`.`subcatEnabled` = 1 AND `B`.`catTranslit`=?';
                    $payload = [$ctg[0]];
                }
                break;
            case 2:
                /*$sql = 'SELECT
    `products`.`id`,
    `products`.`name`,
    `products`.`cost`,
    `C`.`translit` AS `catTranslit`,
    `B`.`name` AS `subcatName`,
    `B`.`translit` AS `subcatTranslit`,
    `A`.`name` AS `cityName`,
    `A`.`translit` AS `cityTranslit`
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
        `categories`.`is_enabled`,
        `categories`.`parent`
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
    `B`.`parent` = `C`.`id`
WHERE
    `C`.`is_enabled` = 1 AND `B`.`is_enabled` = 1 AND `products`.`city` = (SELECT `cities`.`id` FROM `cities` WHERE `cities`.`translit`=?)';*/
                $sql = 'SELECT
    `products`.`id`,
    `products`.`name`,
    `products`.`cost`,
    `B`.`catTranslit`,
    `B`.`name` AS `subcatName`,
    `B`.`subcatTranslit`,
    `A`.`name` AS `cityName`,
    `A`.`translit` AS `cityTranslit`
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
        `categories`.`translit` AS `subcatTranslit`,
        `categories`.`is_enabled` AS `subcatEnabled`,
        `C`.`translit` AS `catTranslit`,
        `C`.`is_enabled` AS `catEnabled`
    FROM
        `categories`
    LEFT JOIN
        (
        SELECT
            `categories`.`id`,
            `categories`.`translit`,
            `categories`.`is_enabled`
        FROM
            `categories`
        WHERE
            `categories`.`level` = 0
    ) `C`
ON
    `categories`.`parent` = `C`.`id`
WHERE
    `categories`.`is_enabled` = 1 AND `C`.`is_enabled` = 1 AND `categories`.`level` > 0
) `B`
ON
    `products`.`category` = `B`.`id`
WHERE
    `B`.`catEnabled` = 1 AND `B`.`subcatEnabled` = 1 AND `B`.`catTranslit`=? AND `A`.`translit`=?';
                $payload = [ $ctg[0], $ctg[1]];
                break;
            case 3:
                $sql = 'SELECT
    `products`.`id`,
    `products`.`name`,
    `products`.`cost`,
    `B`.`catTranslit`,
    `B`.`name` AS `subcatName`,
    `B`.`subcatTranslit`,
    `A`.`name` AS `cityName`,
    `A`.`translit` AS `cityTranslit`
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
        `categories`.`translit` AS `subcatTranslit`,
        `categories`.`is_enabled` AS `subcatEnabled`,
        `C`.`translit` AS `catTranslit`,
        `C`.`is_enabled` AS `catEnabled`
    FROM
        `categories`
    LEFT JOIN
        (
        SELECT
            `categories`.`id`,
            `categories`.`translit`,
            `categories`.`is_enabled`
        FROM
            `categories`
        WHERE
            `categories`.`level` = 0
    ) `C`
ON
    `categories`.`parent` = `C`.`id`
WHERE
    `categories`.`is_enabled` = 1 AND `C`.`is_enabled` = 1 AND `categories`.`level` > 0
) `B`
ON
    `products`.`category` = `B`.`id`
WHERE
    `B`.`catEnabled` = 1 AND `B`.`subcatEnabled` = 1 AND `B`.`catTranslit`=? AND `A`.`translit`=? AND `B`.`subcatTranslit`=?';
                $payload = [ $ctg[0], $ctg[1], $ctg[2]];
                break;
        }

        if(isset($_sort) and count($_sort)) {
            $sort = ' ORDER BY `'.array_values($_sort)[0].'` ';
            $sort .= ' ';
            if (array_keys($_sort)[0] == 1)
            {
                $sort .= 'DESC';
            }else
            {
                $sort .= 'ASC';
            }

        }else
        {
            $sort = ' ORDER BY `name` DESC';
        }

        $sql .= ' {sort} LIMIT {from}, {to}';
        $sql = str_replace('{sort}', $sort, $sql);
        $sql = str_replace('{from}', $from, $sql);
        $sql = str_replace('{to}', $to, $sql);
        $stmt = DataBase::run($sql, $payload);

        return $stmt->fetchAll();
    }
}