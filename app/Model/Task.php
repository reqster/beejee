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

    public function edit($id, $params){
        $params['edited'] = true;
        $qm = "";
        foreach ($params as $k => $param) {
            if ($k === array_key_last($params))
                $qm .= '?';
            else
                $qm .= '?, ';
        };
        $query = "UPDATE ".$this->table." SET ";
        $query .= " (".implode(",", array_keys($params)).") = (".$qm.")";
        $query .= " WHERE id = ?";
        $stm = $this->db->prepare($query);
        $i = 0;
        foreach ($params as $param) {
            $i++;
            $stm->bindValue($i, $param);
        }
        $stm->bindValue($i + 1, $id);
        $stm->execute();
        return true;
    }

}