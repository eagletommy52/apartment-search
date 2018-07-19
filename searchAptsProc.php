<?php 

// 1.) there is no form to process, so skip the POST / GET vars part
// 2.) connect to MySQL

require_once("conn/connApts.php"); //import connection code

$bldg = $_GET['bldg'];
$bdrms = $_GET['bdrms'];
$baths = $_GET['baths'];
$maxRent = $_GET['maxRent'];
$minRent = $_GET['minRent'];
$orderBy = $_GET['orderBy'];
$ascDesc = $_GET['ascDesc'];

$query = "SELECT * from apartments, buildings, neighborhoods 
WHERE apartments.bldgID = buildings.IDbldg 
AND buildings.hoodID = neighborhoods.IDhood ";
if($bdrms!="999"){$query .= "AND bdrms IN ($bdrms) ";}
if($baths != "999"){$query .= "AND baths IN ($baths) ";}
if($bldg != "none") {$query .= "AND bldgID = '$bldg' ";}
if(isset($_GET['doorman'])) {$query .= " AND isDoorman=1";}
if(isset($_GET['pets'])) {$query .= " AND isPets=1";}
if(isset($_GET['parking'])) {$query .= " AND isParking=1";}
if(isset($_GET['gym'])) {$query .= " AND isGym=1";}
if($_GET['search'] != "") {
  $search = $_GET['search'];
  $query .= " AND (aptDesc LIKE '%$search%'
             OR bldgDesc LIKE '%$search%'
             OR hoodDesc LIKE '%$search%'
             OR bldgName LIKE '%$search%'
             OR aptTitle LIKE '%$search%')";
}
$query .= " AND rent BETWEEN '$minRent' AND '$maxRent' ORDER BY $orderBy $ascDesc";

$result = mysqli_query($conn, $query);  
$numResults = mysqli_num_rows($result);
?>

<!doctype html>

<html lang="en-us">
    
<head>
    
    <meta charset="utf-8">
    
    <title>Apt Search Processor</title>
    <link href="css/apts.css" rel="stylesheet">
</head>

<body>
    <table border="1" cellpadding="5">
    <tr>
        <td colspan="14" align="center">
            <h1 align="center">Lofty Heights Apartments - <?php echo $numResults; ?> Results Found</h1>
            </td>
        </tr>
        <?php 
        if ($numResults == 0) {
          echo '<tr><td colspan="14">Try your search again <br><br> Redirecting... <br>
          <button class="backButt" onclick="goBack()" width="100px">Click to go back</button></td></tr>';
          header("Refresh:3; url=searchApts.php", true, 303);
        } else { echo '      
          <tr>
            <th>ID</th>
            <th>Apt</th>
            <th>Building</th>
            <th>Bedrooms</th>
            <th>Baths</th>
            <th>Rent</th>
            <th>Floor</th>
            <th>Sqft</th>
            <th>Status</th>
            <th>Neighborhood</th>
            <th>Doorman</th>
            <th>Pets</th>
            <th>Gym</th>
            <th>Parking</th>
            
        </tr>';} ?>
        <?php
        while($row = mysqli_fetch_array($result)){ ?>
          <tr>
              <td><?php echo $row['IDapt']; ?></td>
              <td>
                <a href="aptDetails.php?IDapt=<?php echo $row['IDapt']. '"';?>>
                <?php 
              echo $row['apt']; 
              ?></a>
              </td>
              <td>
                <a href="bldgDetails.php?bldgID=<?php echo $row['bldgID']. '"';?>>
                <?php 
              echo $row['bldgName']; 
              ?></a>
              </td>
              <td><?php 
              if($row['bdrms'] == 0) {
                  echo "Studio";
              }
              else {
              echo $row['bdrms']; 
              }
              ?></td>
              <td><?php echo $row['baths']; ?></td>
              <td><?php echo '$' . number_format($row['rent']); ?></td>
              <td><?php echo $row['floor']; ?></td>
              <td><?php echo $row['sqft']; ?></td>
              <td><?php 
              if($row['isAvail'] == 0){
                echo "Occupied";
              }
              else {
                echo "Available";
              }
              
              ?></td>
              <td><?php echo $row['hoodName']; ?></td>
              <td><?php 
              
                if($row['isDoorman'] == 0){
                  echo 'No'; 
                }else{
                  echo 'Yes';
                }
              ?></td>
              <td><?php echo $row['isPets'] == 0 ? 'No':'Yes'; ?></td>
              <td><?php echo $row['isGym'] == 0 ? 'No':'Yes'; ?></td>
              <td><?php echo $row['isParking'] == 0 ? 'No':'Yes'; ?></td>
              
          </tr>
        
        <?php } ?>
    
    </table>
    <script>
		function goBack() {
			window.history.back();
		}
    </script>
</body>
</html>