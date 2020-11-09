<?php

namespace BeeJee\Model;

class Task extends Model {

    protected $table = 'task';
    protected $pageLimit = 3;

    public function complete($id){
        $query = "UPDATE ".$this->table." SET state = TRUE WHERE id = ?";
        $stm = $this->db->prepare($query);
        $stm->bindValue(1, $id);
        $stm->execute();
        return true;        
    }

}