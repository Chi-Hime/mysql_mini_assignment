<?php
require("../dbconnect.php");
$title = "My car table";
include("header.inc.php");
$row_class = "odd";
// Create connection
$conn = new mysqli($host, $db_user, $db_pw, $db_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// inserting new record
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$engine = $_POST["car_engine"];
	$model = $_POST["car_model"];
	$year = $_POST["car_year"];
	$fuel = $_POST["car_fuel"];
	$make_id = $_POST["car_make"];
	//don't forget to quote your inserted variables :-(
	$sql_insert = "INSERT INTO Vehicles (id, model, engine, year, fuel, make_id) VALUES (NULL, '$model', '$engine', '$year', '$fuel', '$make_id')";
	if ($conn->query($sql_insert) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
//delete requested record
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_id"])){
    $delete_id = $_GET["delete_id"];
    $sql_delete = "DELETE FROM Vehicles WHERE id = '$delete_id'";
    if($conn->query($sql_delete) === TRUE) {
        echo "Record deleted";
    } else {
        echo "Error on delete:" . $sql_delete . "<br>" .$conn->error;
    }
}
// reading current cars
$sql = "SELECT Vehicles.id, Vehicles.model, Vehicles.year, Vehicles.engine, Vehicles.fuel, makers.name FROM Vehicles LEFT OUTER JOIN makers ON makers.id = Vehicles.make_id";
$result = $conn->query($sql);
// reading makers
$sql_makers = "SELECT * FROM makers";
$result_makers = $conn->query($sql_makers);
echo "<table class='Vehicles'>\n";
echo "<tr class='header-row'>\n";
echo "\t<th>Make</th>\n"; // `\t` is tab space
echo "\t\t<th>Model</th>\n";
echo "\t\t<th>Year</th>\n";
echo "\t\t<th>Engine</th>\n";
echo "\t\t<th>Fuel</th>\n";
// new for delete
echo "\t\t<th>Delete</th>\n";
echo "</tr>\n";

if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		echo "<tr class='data-row $row_class'>";
		echo "<td>" . $row["name"] . "</td>";
		echo "<td>" . $row["model"] . "</td>";
		echo "<td>" . $row["year"] . "</td>";
		echo "<td>" . $row["engine"] . "</td>";
        echo "<td>" . $row["fuel"] . "</td>";
		// <a href="mypage.php?delete_id=2">Delete</a>
		echo "<td><a href=". $_SERVER["PHP_SELF"]. "?delete_id=".$row['id']."> delete</a></td>";
		echo "</tr>";
		if($row_class == "odd"){
			$row_class = "even";
		} else if($row_class == "even") {
			$row_class = "odd";
		}
	}
} else {
	echo "0 results; nope";
}
echo "</table>";
$conn->close();
?>
<br><div class="wrapper">
	<div id="leftsidebar">
    <wrapper action="" method="post">
        
        <label for="newCarMake"> Make:
        <select name="car_make">
        
        <?php
            if($result_makers->num_rows > 0){
                while($maker_row = $result_makers->fetch_assoc()){
                echo "<option value='".$maker_row["id"]."'>".$maker_row["name"]."</option>";
                }
            }
        ?>

        </select>
        </label>
        
        <ul id="menulist">
            <div id="mail">
      <li class="newCarModel"> Model:
    		<input type="text" name="car_model" id="newCarModel" />
    	</li>
        
    	<li class="newCarYear"> Year:
    		<input type="text" name="car_year" id="newCarYear" />
    	</li>
    	
        <li class="newCarEngine"> Engine:
    		<input type="text" name="car_engine" id="newCarEngine" />
    	</li>
    	
        <li class="newCarFuel"> Fuel:
            <input type="text" name="car_fuel" id="newCarFuel" />
    	</li></br>
    	
		<button type="submit">Insert new car</button>

</ul>
</div>
	</wrapper>

</div>
<?php
include("footer.inc.php");
?>