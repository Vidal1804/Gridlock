<?php
class AccidentsModel {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function SimpleAccidentQuery($startTime, $endTime) {
        $stmt = $this->pdo->prepare("SELECT id, severity, start_lat, start_lng, city, state, weather_condition, start_time 
            FROM accidents WHERE start_time >= :start_time AND end_time <= :end_time");
        
        
        $stmt->execute([
            'start_time' => $startTime, 
            'end_time' => $endTime
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ComplexAccidentQuery($startTime, $endTime, $state, $severity, $weather) {
        
        $query = "SELECT id, severity, start_lat, start_lng, city, state, weather_condition, start_time
                  FROM accidents WHERE start_time >= :start_time AND end_time <= :end_time";
        
        $params = [
            'start_time' => $startTime,
            'end_time' => $endTime
        ];

        
        if (!empty($state) && $state !== "Any State") {
            $query .= " AND state = :state";
            $params['state'] = $state;
        }

        if (!empty($severity) && $severity !== "All Severities") {
            $query .= " AND severity = :severity";
            $params['severity'] = $severity;
        }

        if (!empty($weather) && $weather !== "Any weather") {
            $query .= " AND weather_condition LIKE :weather";
            $params['weather'] = "%" . $weather . "%";
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}