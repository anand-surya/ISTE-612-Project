<?php
    include("config.php");  //connect to the database
    
    $song_q = $_GET["sname"];
    if($song_q == null){
      $sql="SELECT * from export_combined_6 where id = '8' ";
    }
    else{
      $sql="SELECT * from export_combined_6 where SONG_NAME = '$song_q' ";
    }
    //$sql="SELECT * from export_combined_6 where SONG_NAME = '$ids' ";  //for demo purpose we have selected a random song and retrieved the recommendations for the song
    $result=mysqli_query($db,$sql);
    $storeArray = Array();
    $storeArray1 = Array();
    $storeArray2 = Array();
    while ($row = $result->fetch_assoc()) {  //fetch 4 recommendation
  
    $storeArray[0] = $row['0']; 
    $storeArray[1] = $row['1'];
    $storeArray[2] = $row['2'];
    $storeArray[3] = $row['3']; 
    $lyrics[0] = $row['SONG_NAME'];
    }
    if($song_q !=null){
      $storeArray[0] = $_GET["sname"];
    }
    //echo $storeArray[0];
    $sql1="SELECT * from export_combined_6 where SONG_NAME = '$storeArray[3]' ";  //fetch another 4 songs based on the last song
    
    $result1=mysqli_query($db,$sql1);
    while ($rows = $result1->fetch_assoc()) {
    $storeArray1[0] = $rows['0'];
    $storeArray1[1] = $rows['1'];
    $storeArray1[2] = $rows['2'];
    $storeArray1[3] = $rows['3'];  
    $lyrics[1] = $rows['SONG_NAME'];
    }
    $sql2="SELECT * from export_combined_6 where SONG_NAME = '$storeArray1[3]' ";  //fetch another 4 songs based on the last song
    $result2=mysqli_query($db,$sql2);
    while ($rowss = $result2->fetch_assoc()) {
    $storeArray2[0] = $rowss['0'];
    $storeArray2[1] = $rowss['1'];
    $storeArray2[2] = $rowss['2'];
    $storeArray2[3] = $rowss['3']; 
    $lyrics[2] = $rowss['SONG_NAME'];
    } 
    //echo $storeArray2[0];
    $sql3="SELECT * from export_combined_6 where SONG_NAME = '$storeArray2[3]' ";  //fetch another 4 songs based on the last song
    $result3=mysqli_query($db,$sql3);
    while ($rowsss = $result3->fetch_assoc()) {
    $storeArray3[0] = $rowsss['0'];
    $storeArray3[1] = $rowsss['1'];
    $storeArray3[2] = $rowsss['2'];
    $storeArray3[3] = $rowsss['3']; 
    $lyrics[3] = $rowsss['SONG_NAME']; 
    }  
    $sql4="SELECT * from export_combined_6 where SONG_NAME = '$storeArray3[3]' ";  //fetch another 4 songs based on the last song
    $result4=mysqli_query($db,$sql4);
    while ($rowssss = $result4->fetch_assoc()) {
    $storeArray4[0] = $rowssss['0'];
    $storeArray4[1] = $rowssss['1'];
    $storeArray4[2] = $rowssss['2'];
    $storeArray4[3] = $rowssss['3'];  
    $lyrics[4] = $rowssss['SONG_NAME'];
    } 

    $cleanarray = array_unique(array_merge($storeArray3, $storeArray4, $storeArray, $storeArray2, $storeArray1));  //check for repitation in the playsit genrated using 
   // $cleanarray1 = array_unique(array_merge($lyrics[0], $lyrics[1], $lyrics[2], $lyrics[3], $lyrics[4])); 
    //unique function and remove it
    $a = $cleanarray;
    //$a1 = $cleanarray1; 
     $count = 0;
    gg:
    if(sizeof($a)<20){ //check if playlist size is 20, if not generate for recommendation
    $q = end($a);
    //echo $q;
    $sql5="SELECT * from export_combined_6 where SONG_NAME = '$q' ";
    $result5=mysqli_query($db,$sql5);
    while ($rowsssss = $result5->fetch_assoc()) {
    $storeArray5[0] = $rowsssss['0'];
    $storeArray5[1] = $rowsssss['1'];
    $storeArray5[2] = $rowsssss['2'];
    $storeArray5[3] = $rowsssss['3'];  
    $lyrics1[0] = $rowsssss['SONG_NAME'];
    } 
    }
   
    $a = array_unique(array_merge($a, $storeArray5));   //check again for repetation
    $a1 = array_unique(array_merge($lyrics, $lyrics1));
    if(sizeof($a)<20){  //check if size equals 20, if not repeat generation of songs
             $count = $count+1;
             if($count <= 15){
            goto gg; 
            }
          
    
    }
    $b = array_unique(array_merge($a, $cleanarray));
    $b1= array_unique(array_merge($a1, $lyrics));  //final repetation checking
     //print_r($b);


     // while($row = $result->fetch_assoc()){
   //   $res = array(".$row[3].");
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="author" content="Script Tutorials" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Song Recommender</title>

    <!-- add styles and scripts -->
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
    <div class="topnav">
  
  <a>Music Player</a>
      </div>

    <div id="outer">
     <div class="search" id="inner">
          <form action="index1.php" method="get">
             
             <input type="text" id="fname" name="sname" placeholder="search song">
             <input type="submit" value="Submit">
          </form>
        </div>
      </div>
    <div class="example">
        <div class="player">
            <div class="pl"></div>   
            <div class="title"></div>                    <!--These are the divs used to display the music palayer  UI -->
            <div class="artist"></div>
            <div class="cover"></div>
            <div class="controls">
                <div class="play"></div>
                <div class="pause"></div>
                <div class="rew"></div>
                <div class="fwd"></div>
            </div>
            <div class="volume"></div>
            <div class="tracker"></div>
        </div>
       
         <ul class="playlist hidden">
         <?php

          /*       if($result->num_rows > 0){
                     while($rows = $result->fetch_assoc())
                      {
                      echo "<li audiourl='01.mp3' cover='cover.jpg' artist='Artist 1'>".$rows['0']."</li>
                        <li audiourl='02.mp3' cover='cover.jpg' artist='Artist 2'>".$rows['1']."</li>
                      <li audiourl='03.mp3' cover='cover.jpg' artist='Artist 3'>".$rows['2']."</li>
                      <li audiourl='04.mp3' cover='cover.jpg' id='A4' artist='Artist 4'>".$rows['3']."</li>
                      ";
          }
          while($row = $result1->fetch_assoc())
                      {
                      echo "<li audiourl='01.mp3' cover='cover.jpg' artist='Artist 1'>".$row['0']."</li>
                        <li audiourl='02.mp3' cover='cover.jpg' artist='Artist 2'>".$row['1']."</li>
                      <li audiourl='03.mp3' cover='cover.jpg' artist='Artist 3'>".$row['2']."</li>
                      <li audiourl='04.mp3' cover='cover.jpg' id='A4' artist='Artist 4'>".$row['3']."</li>
                      ";
          }
          }else {
              echo "0 results";       } */
           /*  echo "<li audiourl='01.mp3' cover='cover.jpg' artist='Artist 1'>".$storeArray['0']."</li>
                        <li audiourl='02.mp3' cover='cover.jpg' artist='Artist 2'>".$storeArray['1']."</li>
                      <li audiourl='03.mp3' cover='cover.jpg' artist='Artist 3'>".$storeArray['2']."</li>yu
                      <li audiourl='04.mp3' cover='cover.jpg' id='A4' artist='Artist 4'>".$storeArray['3']."</li>
                      <li audiourl='01.mp3' cover='cover.jpg' artist='Artist 1'>".$storeArray1['0']."</li>
                        <li audiourl='02.mp3' cover='cover.jpg' artist='Artist 2'>".$storeArray1['1']."</li>
                      <li audiourl='03.mp3' cover='cover.jpg' artist='Artist 3'>".$storeArray1['2']."</li>
                      <li audiourl='04.mp3' cover='cover.jpg' id='A4' artist='Artist 4'>".$storeArray1['3']."</li>
                      <li audiourl='01.mp3' cover='cover.jpg' artist='Artist 1'>".$storeArray2['0']."</li>
                        <li audiourl='02.mp3' cover='cover.jpg' artist='Artist 2'>".$storeArray2['1']."</li>
                      <li audiourl='03.mp3' cover='cover.jpg' artist='Artist 3'>".$storeArray2['2']."</li>
                      <li audiourl='04.mp3' cover='cover.jpg' id='A4' artist='Artist 4'>".$storeArray2['3']."</li>
                      <li audiourl='01.mp3' cover='cover.jpg' artist='Artist 1'>".$storeArray3['0']."</li>
                        <li audiourl='02.mp3' cover='cover.jpg' artist='Artist 2'>".$storeArray3['1']."</li>
                      <li audiourl='03.mp3' cover='cover.jpg' artist='Artist 3'>".$storeArray3['2']."</li>
                      <li audiourl='04.mp3' cover='cover.jpg' id='A4' artist='Artist 4'>".$storeArray3['3']."</li>
                      <li audiourl='01.mp3' cover='cover.jpg' artist='Artist 1'>".$storeArray4['0']."</li>
                        <li audiourl='02.mp3' cover='cover.jpg' artist='Artist 2'>".$storeArray4['1']."</li>
                      <li audiourl='03.mp3' cover='cover.jpg' artist='Artist 3'>".$storeArray4['2']."</li>
                      <li audiourl='04.mp3' cover='cover.jpg' id='A4' artist='Artist 4'>".$storeArray4['3']."</li>
                      ";
                   */
                      $e = 0;
                      while($e<count($b)){
                        echo "<li audiourl='01.mp3' cover='cover.jpg' artist='Artist 1'>".$b[$e]."</li>";   //print the repetitations in the webpage 
                        $e= $e+1;
                      }
               ?>
            


       <!--
            <li audiourl="01.mp3" cover="cover1.jpg" artist="Artist 1">01.mp3</li>
            <li audiourl="02.mp3" cover="cover2.jpg" artist="Artist 2">02.mp3</li>
            <li audiourl="03.mp3" cover="cover3.jpg" artist="Artist 3">03.mp3</li>
            <li audiourl="04.mp3" cover="cover4.jpg" artist="Artist 4">04.mp3</li>
            <li audiourl="05.mp3" cover="cover5.jpg" artist="Artist 5">05.mp3</li>
            <li audiourl="06.mp3" cover="cover6.jpg" artist="Artist 6">06.mp3</li>
            <li audiourl="07.mp3" cover="cover7.jpg" artist="Artist 7">07.mp3</li> -->
        </ul>
       

    </div>
</body>
</html>