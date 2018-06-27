<?php

class model_uslugi extends model
{
    public function getUslugi ()
    {
        $sql = 'SELECT `name`, `min_cost`, `about` FROM `uslugi`';
        $fetch = Database::run($sql)->fetchAll(PDO::FETCH_NUM);

        return $fetch;
    }
}