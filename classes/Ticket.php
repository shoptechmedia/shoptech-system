<?php

class TicketCore {

    public $id;

    public function __construct($id_ticket = ''){
        $this->prefix = _TICKETING_PREFIX_;
        $this->db = Db::getInstance();
        $this->context = Context::getContext();

        if($id_thread){
            $this->prepare();
        }
    }

    public function add(){
        $columns = $this->db->ExecuteS("
            SELECT COLUMN_NAME as name
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = '{$this->prefix}ticket'
        ");

        $sql  = "INSERT INTO {$this->prefix}ticket" . "\n";
        $sql .= "SET ";

        $i = 0;
        foreach ($columns as $column) {
            $value = $this->{$column['name']};

            if($value){
                if($i > 0)
                    $sql .= ',' . "\n";

                $sql .= "{$column['name']} = '{$value}'";

                $i++;
            }
        }

        $this->db->Execute($sql);

        $this->prepare();

        $this->id = $this->db->Insert_ID();
    }

    protected function prepare(){

    }

}