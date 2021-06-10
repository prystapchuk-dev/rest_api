<?php
class  Category
{

    private $conn;
    private $table_name = 'categories';

    public $id;
    public $name;
    public $description;
    public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readAll() {

        $query = "SELECT
                    id, name, description
                  FROM
                    " . $this->table_name . "
                  ORDER BY
                    name";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }


    public function rowCount() {

        $query = "SELECT COUNT(*) 
                    AS total_rows
                    FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

}