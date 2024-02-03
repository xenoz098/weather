<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
 
     if(isset($_GET['q'])){
         $cityName = $_GET['q'];
     }else{
         $cityName = "Mysuru";
     }
     $url="https://api.openweathermap.org/data/2.5/weather?units=metric&q={$cityName}&APPID=9cf439b778e27ab987df28a6bfc130a0&units=metric";
     $response = file_get_contents($url);
     $data = json_decode($response, true);
 
     $day = date('Y-M-D');
     $city = $data['name'];
     $temperature = round($data['main']['temp']);
     $wind = $data['wind']['speed'];
     $cloud = $data['weather'][0]['icon'];
     $discription = $data['weather'][0]['description'];
     $humidity = $data['main']['humidity'];
     
     $servername = "localhost";
     $username = "root";
     $password = "";
    $database = "weatherweb";

    
    $conn = mysqli_connect($servername, $username, $password, $database);
    if($conn){
        
    }else{
        echo "connection failed" . mysqli_connect_error();
    }
    
    $createTable = "CREATE TABLE IF NOT EXISTS weather(Id int AUTO_INCREMENT PRIMARY KEY, city varchar(225),weather_description varchar(50), cloud varchar(50), temperature varchar(50), wind float(4,2), humidity varchar(50), timedate varchar(50))";
    (mysqli_query($conn, $createTable));


    $checkSql = "SELECT * FROM weather WHERE city = '$cityName' AND timedate = '$day'";
    $checkResult = $conn->query($checkSql); 

    if ($checkResult->num_rows === 0) {
        $insert= "INSERT INTO weather (city,weather_description, cloud, temperature,  wind, humidity, timedate) VALUE('$cityName','$discription','$cloud','$temperature','$wind','$humidity','$day')";
        mysqli_query($conn,$insert);

    }else{
        $update = "UPDATE weather SET  weather_description = '$discription', cloud =' $cloud', temperature = '$temperature',  wind = '$wind', humidity = '$humidity',WHERE city = '$cityName' AND timedate = '$day'"; 
    }
    $selectData="SELECT * FROM weather WHERE city = '$cityName' ORDER BY id ASC ";
    $result = mysqli_query($conn, $selectData);
    if (mysqli_num_rows($result) > 0){
        $data = array();
        while ($row = mysqli_fetch_assoc($result)){
            $data[]= $row;
        }
        print json_encode($data);
        return json_encode($data);
    }
    // $createDatabase = "CREATE DATABASE weatherweb";
    // (mysqli_query($conn, $createDatabase));
?>
