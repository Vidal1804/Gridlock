<?php
class AccidentsModel {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function SimpleAccidentQuery($startTime, $endTime) {
        $stmt = $this->pdo->prepare("SELECT id, severity, start_lat, start_lng, city, state, weather_condition, start_time, COUNT(*) OVER() as total_results
            FROM accidents WHERE start_time >= :start_time AND end_time <= :end_time");
        
        $stmt->execute([
            'start_time' => $startTime, 
            'end_time' => $endTime
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ComplexAccidentQuery($startTime, $endTime, $state, $severity, $weather) {
        $query = "SELECT id, severity, start_lat, start_lng, city, state, weather_condition, start_time, COUNT(*) OVER() as total_results
                  FROM accidents WHERE start_time >= :start_time AND end_time <= :end_time";
        
        $params = [
            'start_time' => $startTime,
            'end_time' => $endTime
        ];

        $query = $this->appendFilterConditions($query, $params, $state, $severity, $weather);

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function AccidentStats($startTime, $endTime, $state, $severity, $weather) {
        $baseQuery = "FROM accidents WHERE start_time >= :start_time AND end_time <= :end_time";
        $params = [
            'start_time' => $startTime,
            'end_time' => $endTime
        ];

        $baseQuery = $this->appendFilterConditions($baseQuery, $params, $state, $severity, $weather);

        $result = [];

        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total $baseQuery");
        $stmt->execute($params);
        $result['total_accidents'] = (int) $stmt->fetchColumn();

        $stmt = $this->pdo->prepare("SELECT severity, COUNT(*) AS count $baseQuery GROUP BY severity ORDER BY severity");
        $stmt->execute($params);
        $result['severity_counts'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT weather_condition AS label, COUNT(*) AS count $baseQuery GROUP BY weather_condition ORDER BY count DESC");
        $stmt->execute($params);
        $result['weather_counts'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT state AS label, COUNT(*) AS count $baseQuery GROUP BY state ORDER BY count DESC LIMIT 10");
        $stmt->execute($params);
        $result['top_states'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT DATE_FORMAT(start_time, '%Y-%m') AS period, COUNT(*) AS count $baseQuery GROUP BY period ORDER BY period");
        $stmt->execute($params);
        $result['monthly_counts'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result['average_per_day'] = $this->calculateAveragePerDay($startTime, $endTime, $result['total_accidents']);

        return $result;
    }

    private function appendFilterConditions($query, array &$params, $state, $severity, $weather) {
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

        return $query;
    }

    private function calculateAveragePerDay($startTime, $endTime, $total) {
        try {
            $start = new DateTime($startTime);
            $end = new DateTime($endTime);
            $days = max(1, (int)$start->diff($end)->format('%a'));
            return round($total / $days, 2);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function importCSV($tmpFilePath) {
        $tmpFilePath = str_replace('\\', '/', $tmpFilePath); 

        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        
        $query = "LOAD DATA LOCAL INFILE '" . $tmpFilePath . "'
                INTO TABLE accidents 
                FIELDS TERMINATED BY ',' 
                OPTIONALLY ENCLOSED BY '\"' 
                LINES TERMINATED BY '\n' 
                IGNORE 1 LINES 
                (id, severity, start_time, end_time, start_lat, start_lng, distance_mi, city, state, weather_condition)";

        return $this->pdo->query($query) !== false;
    }
}


