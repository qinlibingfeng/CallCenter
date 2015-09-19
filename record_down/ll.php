<?php

require("./inc/pub_func.php");
					global $db_conn;	
					$sql="select user,full_name from vicidial_users";
					$rows=mysqli_query($db_conn,$sql);
					$row_counts=mysqli_num_rows($rows);
					$list_arr=array();
		 
				if ($row_counts!=0) {
					while($rs= mysqli_fetch_array($rows)){ 
						echo $rs["user"];
					}
				}
?>
