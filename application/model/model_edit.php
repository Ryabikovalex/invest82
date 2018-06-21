<?php

class model_edit extends model
{

    /** Выбрать запись из таблицы
     * @param $table string
     * @param $entry
     *
     * @return mixed
     */
    public function get_entry( $table,  $entry)
    {
        $sql = 'SELECT * FROM `'.$table.'` WHERE `id`=?';
        $result = Database::run($sql, [$entry])->fetch(PDO::FETCH_NUM);

        return $result;
    }

    /** Обновляет  заданное поле в таблице
     * @param $table
     * @param $entry
     * @param $param
     *
     * @return PDOStatement
     */
    public function update_entry($table, $entry, $param)
    {
        $sql = 'UPDATE `'.$table.'` SET ';
        foreach ( $param as $k => $value)
        {
            $sql .= '`'.$k.'`="'.$value.'", ';
        }
        $sql = substr($sql, 0, -2);
        $sql .= ' WHERE `id`=?';

        return Database::run($sql, [$entry]);
    }
}