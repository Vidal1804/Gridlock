<?php
class AccidentModel {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function queryAccidentSimple($start_time, $end_time){
        
    }
}