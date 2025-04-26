<?php

namespace App\Http\Services\Api\V1\Sphinx;


class SphinxService
{
    protected $conn;

    public function __construct()
    {
        $this->conn = new \mysqli('127.0.0.1', 'root', '', '', 9306);
        if ($this->conn->connect_error) {
            die('Connection failed: ' . $this->conn->connect_error);
        }
    }

    private function getConn()
    {
        return $this->conn;
    }

    public function search($index, $query)
    {
        $query = "SELECT * FROM $index WHERE MATCH('$query')";
        $result = $this->conn->query($query);
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }
}
