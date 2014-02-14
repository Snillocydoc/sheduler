<?php
include "Project1.php";//includes Project1.php which has two classes and reads the files
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Project1</title>
		<b>MEETING TIMES</b>
		<br />
	</head>
	<body>
		
			<table border=".5">
				<?php
					$totals=array();
					$count=0;//begin count as 0. This will hold number of time slots
					echo "<tr><td>User</td><td>Action</td>";//embedded html for table
					//iterates through every TimeSlot object, printing out onto table
					foreach($schedule as $val)
					{
						
						$arr=$val->getTimes();
						if(is_array($arr))
						{
							foreach($arr as $slot=>$t)
							{
								echo "<td> $t  </td>";
								$totals[$count]=0;
								$count++;
							}
						}
						else
						{
							echo "<td>     </td>";	
						}
					}
					echo "</tr>";
					$c=0;
					//iterates through every person, printing out $count tables
					foreach($people as $val)
					{
						//if theyve visited on this computer/browser
						if(isset($_COOKIE[$c])&&!isset($_POST["Edit$c"]))
						{
							echo "<tr><td> $val </td>";
							echo "<td>
									<form action=\"index.php\" method=\"post\">
										<input type=\"submit\" name=\"Edit$c\" value=\"Edit\">
									</form>
								</td>";
							for($i=0;$i<$count;$i++)
							{
								if(in_array($i,$val->timeSlots()))
								{
									echo "<td> &#x2714; </td>";
									if(isset($totals[$i]))
										$totals[$i]=$totals[$i]+1;
								}
								else
								{
									echo "<td>     </td>";	
								}
							}
							
						}
						//if theyve visited on here and clicked edit
						else if(isset($_COOKIE[$c])&&isset($_POST["Edit$c"]))
						{
							unset($_POST["Edit$c"]);
							
							echo "<tr><form action=\"EditFiles.php?edit=$c&count=$count\" method=\"POST\">
									<td><input type=\"text\" name=\"newname\"></td>";
								echo "<td><input type=\"submit\" name=\"editSubmit\"></td>";
							for($i=0;$i<$count;$i++)
							{
								if(in_array($i,$val->timeSlots()))
								{
									echo "<td><input type=\"checkbox\" name=\"$i\" value=\"$i\" checked></td>";
								}
								else
								{
									echo "<td><input type=\"checkbox\" name=\"$i\" value=\"$i\"></td>";	
								}
							}
							echo '</form></tr>';
							
						}
						//if this user was not on this computer/browser
						else
						{
							echo "<tr><td> $val </td>";
							echo "<td> </td>";
							for($i=0;$i<$count;$i++)
							{
								if(in_array($i,$val->timeSlots()))
								{
									echo "<td> &#x2714; </td>";
									$totals[$i]++;
								}
								else
								{
									echo "<td>     </td>";	
								}
							}
						}
						
						$c++;
						echo "</tr>";
					}
					//presents a "New" button
					if(!isset($_POST["new"]))
					{
						echo '<html>
									<form action="index.php" method="POST" >
										<tr>
											<td><input type="submit" value="New" name="new"></td>
										</tr>
									</form>
								</html>';
					}
					//if the "New" button was pressed
					else
					{
						unset($_POST["new"]);
						$co=count($people);
						echo "<html>
									<form action=\"EditFiles.php?count=$co&sched=$count\" method=\"post\" >
										<tr>
											<td> <input type=\"text\" name = \"name\"></td>
											<td>
												<input type=\"submit\" value=\"Submit\" name=\"Submit\">
											</td>";
						for($c=0;$c<$count;$c++)
						{
							echo "<td> <input type=\"checkbox\" name=\"$c\" value=\"$c\"></td>";
						}
						
						echo '</tr>' ;
					}
					echo '<tr><td></td><td></td>';
					//outputs totals per TimeSlot
					for($y=0;$y<$count;$y++)
					{
						
							echo "<td>$totals[$y]</td>";
					
					}
					echo '</tr></form> </html>';
					?>
			</table>
		
	</body>
</html>
