<?php

$username = " ";

if(isset($_GET['id']) && !empty($_GET['id'])) {
	$username = $_GET['id'];
}
else {
	echo '<meta HTTP-EQUIV="REFRESH" content="0; url=index.html?error">';
}


?>

<html>

<head>
        <title>Ahead</title>

        <link rel="stylesheet" type="text/css" href="style.css">
        <link href='http://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
</head>

<body>

        

        <div class = "header">
                <h1> <img class = "logo" src="img/logo.png"> </h1>

                <div class="whiteHeader">
                <?php print "<p style='font-size: 35px; text-shadow: 0 0 10px #000;'>Welcome, ".$username."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php' class='demo-pricing demo-pricing-1'>Logout</a></p>"; ?>	
             	</div>              	
             	<br><br>
        </div>        


        <div class = "form">
        
        <form method="post" action="newgoal.php">
        
                <input type="text" name="name" class ="date" placeholder = "Goal (e.g Weight loss)" required/> <br>
                <input type="text" name="description" class = "description" placeholder = "Description (e.g Eat less burritos)" required/> <br><br>
                
                <h1 class="grey" style="color: #fff;"> Remind me every <input type="text" name="frequency" class = "smallBox" placeholder = "5">  


            <div id='cssmenu'>
                <ul>
                   <li class='active'><input type="radio" name="freqUnit" value="hours" checked><span><br>Hours</span></input></li>
                </ul>
            </div>
            <div id='cssmenu'>
                <ul>
                   <li class='active'><input type="radio" name="freqUnit" value="days"><span><br>Days</span></input></li>
                </ul>
            </div>
            <div id='cssmenu'>
                <ul>
                   <li class='active'><input type="radio" name="freqUnit" value="months"><span><br>Months</span></input></li>
                </ul>
            </div>


            <br>

            until <input type="text" name="month" class = "smallBox" placeholder = "mm"/>-<input type="text" name="day" class = "smallBox" placeholder = "dd"/>-<input type="text" name="year" class = "medBox" placeholder = "yyyy"/>

				<input type="hidden" name="username" value="<?php echo $username; ?>" /><br><br>
                <input type="submit" class = "goal" value="Add New Goal" />
                
        </form>

        </div>        

        <div class="taskList">

                <div class="goalsTableContainer">
                
                    <div id="currentGoals" style="height: 40%; overflow: auto;">
                    <h1 style="text-align: center; text-shadow: 0 0 10px rgba(0,0,0,.8);">Current Goals</h1><br>
                    
<?php


// Database login info
	$dbusername = "darapper_ahead";
	$password = "aacodeday2014";
	$hostname = "localhost"; 

	// Connect to the database
	$dbhandle = new mysqli($hostname, $dbusername, $password, "darapper_ahead") 
	 or die("Unable to connect to MySQL");

	// Select a database to work with
	$selected = $dbhandle->select_db("darapper_ahead")
	 or die("Could not select examples");

	$currentGoalsQuery = "SELECT * FROM goals where username='$username' AND status='inprogress' ORDER BY date ASC";
	$completedGoalsQuery = "SELECT * FROM goals where username='$username' AND status='completed' ORDER BY date ASC";

	$currentGoalsResult = $dbhandle->query($currentGoalsQuery);
	$completedGoalsResult = $dbhandle->query($completedGoalsQuery);
	
	if(mysqli_num_rows($currentGoalsResult)==0)
	{
		echo "<h2 style='text-shadow: 0 0 10px rgba(0,0,0,.8); text-align: center;'>Looks like you don't have any goals yet. Make one, get ahead.</h2>";
	}
	else {
		
		echo "<table class='goalsTable'>";
		
		while ($row = $currentGoalsResult->fetch_array()) {
			$dateForClient = date("m / d / Y", strtotime($row{'date'}));
			echo "<tr><td>".$row{'name'}."</td><td>Remind every ".$row{'frequency'}." ".$row{'freqUnit'}."</td><td>".$dateForClient."</td></tr>";
		}
		
		echo "</table>";
		
	}




?>
                 
                 </div><br><br>
                 <hr/>
                 <div id="pastGoals" style="height: 20%; overflow: auto; margin-top: 5%; margin-bottom: 5%;">
                 
                 <h1 style="text-shadow: 0 0 10px rgba(0,0,0,.8); text-align: center;">Completed Goals</h1><br>
                 
                 <?php
                 
                 
                 	if(mysqli_num_rows($completedGoalsResult)==0)
					{
						echo "<h2 style='text-shadow: 0 0 10px rgba(0,0,0,.8); text-align: center;'>Looks like you haven't completed any  goals yet. Work towards one today, get ahead.</h2>";
					}
					else {
		
						echo "<table class='goalsTable'>";
		
						while ($row = $completedGoalsResult->fetch_array()) {
							$dateForClient = date("m / d / Y", strtotime($row{'date'}));
							echo "<tr><td>".$row{'name'}."</td><td>Remind every ".$row{'frequency'}." ".$row{'freqUnit'}."</td><td>".$dateForClient."</td></tr>";
						}
		
						echo "</table>";
		
					}
                 
                 
                 
                 ?>
                 
                 
                 </div>   
                    
                
            </div>
            
        </div>        



</body>


</html>