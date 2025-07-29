<?php
final class TimezoneManager
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function applyTimezone(): void
    {
        try {
            $region = $_SESSION['timezone'] ?? 'America/Los_Angeles';
            $tz = new DateTimeZone($region);
            $now = new DateTime('now', $tz);
            $offset = $now->format('P'); // Ejemplo: -04:00
            $this->pdo->exec("SET time_zone = '{$offset}'");
        } catch (Exception $e) {
            error_log("Error applying timezone to MariaDB (PDO): " . $e->getMessage());
        }
    }
}
