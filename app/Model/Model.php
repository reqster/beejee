<?php

namespace BeeJee\Model;

use PDO;

abstract class Model {

    protected $db;
    protected $table;
    protected $pageLimit = 0;

    public function __construct($container){
        $this->db = $container['db'];
    }

    public function pageCount(){
        if ($this->pageLimit == 0)
            return 1;
        else{
            $stm = $this->db->query("SELECT COUNT(*) FROM ".$this->table);
            $c = $stm->fetchColumn();
            return intval(ceil($c / $this->pageLimit));
        }
    }

    public function get($page = 1, $orderBy = null, $sort = 'asc'){
        if ($sort !== 'asc')
            $sort = "desc";
        $query = "SELECT * FROM ".$this->table;
        if ($orderBy){
            $query .= " ORDER BY ".$orderBy." ".$sort;
        }
        if ($this->pageLimit){
            $query .= " LIMIT ".$this->pageLimit;
            if ($page >= 2){
                $offset = $this->pageLimit * ($page - 1);
                $query .= " OFFSET ".$offset;
            }
        }
        $stm = $this->db->prepare($query);
        $stm->execute();
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);        
        return $rows;
    }

    public function add($params){
        $qm = "";
        foreach ($params as $k => $param) {
            if ($k === array_key_last($params))
                $qm .= '?';
            else
                $qm .= '?, ';
        };
        $query = "INSERT INTO ".$this->table;
        if (count($params) > 0)
            $query .= " (".implode(",", array_keys($params)).") VALUES (".$qm.")";
        $stm = $this->db->prepare($query);
        $i = 0;
        foreach ($params as $param) {
            $i++;
            $stm->bindValue($i, $param);
        }
        $stm->execute();
        return true; // not really, requires exception handling
    }
}