<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'Shuttle@123');
   define('DB_DATABASE', 'csv_dv_8');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   if(!$db)
{
echo "CONNECTION ERROR";
}
?>