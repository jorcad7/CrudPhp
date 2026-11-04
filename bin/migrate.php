
<?php
declare(strict_types=1);
require __DIR__ . '/../src/bootstrap.php';
 
use App\Core\Database;
 
$db = Database::connection();
 
$db->exec(
    'CREATE TABLE IF NOT EXISTS schema_migrations (
        filename   VARCHAR(255) PRIMARY KEY,
        applied_at TIMESTAMPTZ NOT NULL DEFAULT now()
    )'
);
 
$applied = $db->query('SELECT filename FROM schema_migrations')->fetchAll(PDO::FETCH_COLUMN);
 
$files = glob(__DIR__ . '/../database/migrations/*.sql') ?: [];
sort($files);
 
$count = 0;
 
foreach ($files as $file) {
    $name = basename($file);
 
    if (in_array($name, $applied, true)) {
        continue;
    }
 
    echo "Aplicando $name ...\n";
 
    $db->beginTransaction();
 
    try {
        $db->exec((string) file_get_contents($file));
 
        $stmt = $db->prepare('INSERT INTO schema_migrations (filename) VALUES (:filename)');
        $stmt->execute(['filename' => $name]);
 
        $db->commit();
        $count++;
    } catch (Throwable $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
 
        fwrite(STDERR, "Error en $name: " . $e->getMessage() . "\n");
        exit(1);
    }
}
 
echo $count === 0 ? "Migraciones al día.\n" : "Migraciones aplicadas: $count\n";