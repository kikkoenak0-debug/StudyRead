<?php
$host='127.0.0.1';
$db='perpuski_db';
$user='root';
$pass='';
$dsn="mysql:host=$host;dbname=$db;charset=utf8";
try{
    $pdo=new PDO($dsn,$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
    $stmt=$pdo->prepare("SELECT COLUMN_NAME,COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA=:db AND TABLE_NAME='buku'");
    $stmt->execute([':db'=>$db]);
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$rows){
        echo "No columns found or table doesn't exist\n";
        exit(0);
    }
    foreach($rows as $r){
        echo $r['COLUMN_NAME'].' '.$r['COLUMN_TYPE']."\n";
    }
}catch(Exception $e){
    echo 'ERROR: '.$e->getMessage()."\n";
}
