<?php
$host='127.0.0.1';
$db='perpuski_db';
$user='root';
$pass='';
$dsn="mysql:host=$host;dbname=$db;charset=utf8";
try{
    $pdo=new PDO($dsn,$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    echo "Starting conversion of buku.tahun_terbit from INT to DATE\n";

    // Preview problematic rows
    $stmt = $pdo->query("SELECT COUNT(*) AS cnt_int FROM buku WHERE YEAR(CURDATE()) >= tahun_terbit AND tahun_terbit BETWEEN 1000 AND 9999");
    $cnt = $stmt->fetch(PDO::FETCH_ASSOC)['cnt_int'];
    echo "Rows with 4-digit year values: $cnt\n";

    // Add tmp column
    echo "Adding temporary column _tmp_tahun...\n";
    $pdo->exec("ALTER TABLE buku ADD COLUMN _tmp_tahun DATE NULL");

    echo "Populating _tmp_tahun...\n";
    $sql = "UPDATE buku SET _tmp_tahun = CASE 
        WHEN tahun_terbit IS NULL OR tahun_terbit = 0 THEN NULL
        WHEN tahun_terbit BETWEEN 1000 AND 9999 THEN STR_TO_DATE(CONCAT(tahun_terbit,'-01-01'), '%Y-%m-%d')
        ELSE STR_TO_DATE(tahun_terbit, '%Y%m%d')
    END";
    $pdo->exec($sql);

    echo "Dropping old column tahun_terbit...\n";
    $pdo->exec("ALTER TABLE buku DROP COLUMN tahun_terbit");

    echo "Renaming _tmp_tahun to tahun_terbit (DATE)...\n";
    $pdo->exec("ALTER TABLE buku CHANGE COLUMN _tmp_tahun tahun_terbit DATE NULL");

    echo "Conversion complete. Sample rows:\n";
    $stmt = $pdo->query("SELECT id, judul, tahun_terbit FROM buku ORDER BY id DESC LIMIT 10");
    foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $r){
        echo implode(' | ', [$r['id'], $r['judul'], $r['tahun_terbit']]) . "\n";
    }
}catch(Exception $e){
    echo 'ERROR: '.$e->getMessage()."\n";
    exit(1);
}
