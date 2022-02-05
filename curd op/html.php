<?php 
    //pagination code logic
    if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
    } 
    else {
        $page_no = 1;
    }
     
    $total_records_per_page = 10;
    $offset = ($page_no-1) * $total_records_per_page;
    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;
    $adjacents = "2";
    $result_count = mysql_query("SELECT * FROM users_data"); 
    $total_records = mysql_num_rows($result_count);
    $total_no_of_pages = ceil($total_records / $total_records_per_page);
    $second_last = $total_no_of_pages - 5;
      
?>
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
	<div class="row">
		<form class="form-inline">
	        <div class="form-group col-md-offset-7  mx-sm-3 mb-2" >
	            <input type="text" name="search_db" class="form-control" placeholder="Search by Member Id">
	            <input type="hidden" name="widget" value="curd_op">
	            <input type="submit" value="Search" class="btn btn-primary"> 
	        </div>
	    </form>
	    <form class="form-inline">
	    	<div class="form-group  mx-sm-3 mb-2">
	    		<input type="hidden" name="widget" value="curd_Add">
	        	<input type="submit" value="Add new member" class="btn btn-primary col-md-offset-2">
	    	</div>
    	</form>
    </div>
	<br>

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
        $sql = "SELECT * FROM `users_data` ORDER BY user_id ASC LIMIT $offset, $total_records_per_page";
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
                    <br>   
					<form>
                        <input type='submit' style="margin-top: 11px;" value='Delete' class='btn btn-danger col-md-11' />
                        <input type='hidden' name='user_id' value='<?= $row["user_id"] ?>' >
                        <input type='hidden' name='widget' value='curd_op' >
                    </form>       
                </td>
            </tr>    
                        
		<? } ?>
		<!-- delete script -->
        </tbody> 
    </table>


    <? if ($total_records > $total_records_per_page) { ?>
        
        <div class="take" style="text-align:center;">
        <ul class="pagination">
           <?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } ?>
            
            <li <?php if($page_no <= 1){ echo "class='disabled' style='text-decoration:none;'"; } ?> >
           <a <?php if($page_no > 1){ echo "href='https://ww2.managemydirectory.com/admin/go.php?widget=curd_op&page_no=1'"; } ?> >&lt;&lt;</a>
           </li>
           <li <?php if($page_no <= 1){ echo "class='disabled' style='text-decoration:none;'"; } ?> >
           <a <?php if($page_no > 1){ echo "href='?widget=curd_op&page_no=$previous_page'"; } ?> >Previous</a>
           </li>
               
            <?php 
           if ($total_no_of_pages <= 4){     
              for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                 if ($counter == $page_no) {
                 echo "<li class='active'><a>$counter</a></li>"; 
                    }else{
                   echo "<li><a href='?widget=curd_op&page_no=$counter'>$counter</a></li>";
                    }
                }
           }
           elseif($total_no_of_pages > 5){
              
           if($page_no <= 4) {        
            for ($counter = 1; $counter < 7; $counter++){      
                 if ($counter == $page_no) {
                 echo "<li class='active'><a>$counter</a></li>"; 
                    }else{
                   echo "<li><a href='?widget=curd_op&page_no=$counter'>$counter</a></li>";
                    }
                }
              echo "<li><a>...</a></li>";
              echo "<li><a href='?widget=curd_op&page_no=$second_last'>$second_last</a></li>";
              echo "<li><a href='?widget=curd_op&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
              }

            elseif($page_no > 4 && $page_no < $total_no_of_pages - 6) {       
              echo "<li><a href='?widget=curd_op&page_no=1'>1</a></li>";
              echo "<li><a href='?widget=curd_op&page_no=2'>2</a></li>";
                echo "<li><a>...</a></li>";
                for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {       
                   if ($counter == $page_no) {
                 echo "<li class='active'><a>$counter</a></li>"; 
                    }else{
                   echo "<li><a href='?widget=curd_op&page_no=$counter'>$counter</a></li>";
                    }                  
               }
               echo "<li><a>...</a></li>";
              echo "<li><a href='?widget=curd_op&page_no=$second_last'>$second_last</a></li>";
              echo "<li><a href='?widget=curd_op&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
                    }
              
              else {
                echo "<li><a href='?widget=curd_op&page_no=1'>1</a></li>";
              echo "<li><a href='?widget=curd_op&page_no=2'>2</a></li>";
                echo "<li><a>...</a></li>";

                for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                  if ($counter == $page_no) {
                 echo "<li class='active'><a>$counter</a></li>"; 
                    }else{
                   echo "<li><a href='?widget=curd_op&page_no=$counter'>$counter</a></li>";
                    }                   
                        }
                    }
           }
        ?>
            
           <li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled' style='text-decoration:none;'"; } ?>>
           <a <?php if($page_no < $total_no_of_pages) { echo "href='?widget=curd_op&page_no=$next_page'"; } ?>>Next</a>
           </li>
            <?php if($page_no < $total_no_of_pages){
              echo "<li><a href='?widget=curd_op&page_no=$total_no_of_pages'> &gt;&gt;</a></li>";
              } ?>
        </ul>
        </div>
    
    <? }  ?>
           