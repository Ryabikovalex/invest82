<?php

class model_log extends model
{
    public function auth( $name, $hash)
    {
        $sql = 'SELECT `name` FROM `users` WHERE `login`=? AND `pass`=?';
        $result = ['success' => -1];

        $stmt = Database::run($sql, [$name, $hash]);
        if ( $stmt->rowCount() == 1)
        {
            $_SESSION['name'] = $stmt->fetchAll(PDO::FETCH_NUM)[0][0];
            $_SESSION['auth'] =  hash("sha256", $hash.time());
            $result['success'] = 1;
        }else{
            $result['success'] = -1;
        }

        return $result;
    }
}