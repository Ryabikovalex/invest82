<?php
ini_set('display_errors',1);
$logger = fopen('cron.log', 'a+');
$log = [date('[h:i:s t-m-Y]')];

///Обновление транслита в БД
$t = ['country', 'city', 'region', 'categories'];
foreach ($t as $v)
{
    /*$sql0 = 'SELECT `id`, `name` FROM `{r}`';
    $sql01 = 'UPDATE `{r}` SET `translit`=? WHERE `id`=?';
    $sql = str_ireplace('{r}', $v, $sql0);
    $sql1 = str_ireplace('{r}', $v, $sql01);
    $stmt = Database::run($sql, []);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for($i=0; $i < count($data); $i++)
    {
        $translit = to_translit($data[$i]['name']);
        Database::run($sql1, [ $translit, $data[$i]['id']]);
    }*/
    $log[] = 'Транслитерация произедена успешно в таблице '.strtoupper($v).'';
}


foreach ($log as $m)
{
    fwrite($logger,$m.PHP_EOL);
}
fclose($logger);