<?php 

namespace App\Database\Models;

use App\Database\Connection\Connection;

class Model extends Connection {
    public function search($table , $column , $value)
    {
        $query = "SELECT * FROM {$table} WHERE {$column} = ?";
        $stmt = $this->conn->prepare($query); 
        if(! $stmt){
            // error
        }
        $stmt->bind_param('s',$value);
        $stmt->execute();
        return $stmt->get_result();
    }
}