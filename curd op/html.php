<center><h3>Crud operations</h3></center>
<?php 	
	if(isset($_GET["user_id"])){
		$id = $_GET["user_id"];
		$sql="DELETE from users_data WHERE user_id=".$id;
		$result = mysql_query($sql);
		if($result){
			echo "<h5 class='deleted' >The id = ".$id." has been successful deleted <span class='close'>&times;</span></h5>";
		}		
	}						
?>
    
    <form>
		<input type='hidden' name='widget' value='curd_Add' >
        <input type="submit" value="Add new member"  class="btn btn-primary col-md-offset-10" />
    </form>
    <table border=1 class="table">
        <thead>
        <tr>
            <th>Member Id</th>
            <th >Full Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Start Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>                     
        
        <?php
        //include 'config.php';
        $sql = "SELECT * FROM users_data ";
        $result = mysql_query($sql);
        while($row = mysql_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['user_id'] ?></td>
                <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                <td><?= $row['email'] ?></td>	
					<?php
					    if($row['active']==1){
						$row['active']="In_active";
						}
					    else if($row['active']==2){
							$row['active']="Active";
						}
					    else if($row['active']==4){
							$row['active']="On_hold";
						}
					    else if($row['active']==5){
							$row['active']="Past due";
						}	
					?>
                <td><?= $row['active'] ?></td>		
					<?php 
						$d=strtotime($row['signup_date']);
						$row['signup_date']= date("d-m-Y ", $d);
					?>

                <td><input type="text" value="<?= $row['signup_date'] ?>" /></td>
                <td>		
                    <form>
                    <input type='hidden' name='widget' value='curd_Edit' >		
                    <input type='hidden' name='user_id' value='<?= $row["user_id"] ?>' >
					<input type='submit' value='Edit' class='btn btn-primary col-md-11' />
                    </form>
                            
					<form>
                        <input type='submit' value='Delete' class='btn btn-danger col-md-11' />
                        <input type='hidden' name='user_id' value='<?= $row["user_id"] ?>' >
                        <input type='hidden' name='widget' value='curd_op' >
                    </form>       
                </td>
            </tr>    
                        
		<? } ?>
		<!-- delete script -->
        </tbody> 
    </table>
           