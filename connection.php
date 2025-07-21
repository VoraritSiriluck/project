    <?php

    //$db_host = "127.0.0.1";
    $db_host = "localhost";

    $db_username = "root";

    //$db_password = "Chom20_15chom";
    $db_password = "";

    //$db_name = "cleanReport";
    $db_name = "clean-system-db";

    try {
        $db = new PDO("mysql:host={$db_host}; dbname={$db_name}", $db_username, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        
        die("Connection failed: " . $e->getMessage());
    }
    ?>