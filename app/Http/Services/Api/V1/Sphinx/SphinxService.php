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

    public function search($index, $query, $filters = [] ,$range_query=null,$limit=18)
    {
        $query = "SELECT * FROM $index WHERE MATCH('$query')";
        if (!empty($filters))
            foreach ($filters as $filter => $value)
                $query .= " AND $filter=$value";
        if($range_query)
            $query.=$range_query;
        $query.="ORDER BY updated_at DESC";
        $page = (int) (request()->get('page', 1));
        $limit = (int) (request()->get('limit', $limit));
        $offset = ($page - 1) * $limit;
        $query.=" LIMIT $limit OFFSET $offset";
        $result = $this->conn->query($query);
        return array_map(fn($item) => $item['id'], $result->fetch_all(MYSQLI_ASSOC));
    }
}
