<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = array('firstname'=> '' , 'lastname'=> '', 'email'=> '');

    
	$firstname=mysql_real_escape_string($_POST["First_name"]);
    $lastname=mysql_real_escape_string($_POST["Last_name"]);
    $gmail=mysql_real_escape_string($_POST["E-mail"]);
    $status=mysql_real_escape_string($_POST["status"]);

    $t=time();
                
    $Start=date("Y-m-d",$t);

    if($status=="In_active") {
        $status=1;
    }
    else if($status=="Active") {
        $status=2;
    }
    else if($status=="On_hold") {
        $status=4;
    }
    else if($status=="Past due") {
        $status=5;
    }

    if (empty($firstname)) {
        $errors['firstname'] = 'first name is required';
      } 

    if (empty($lastname)) {
        $errors['lastname'] = 'last name is required';
      } 

    if (empty($gmail)) {
        $errors['email'] = 'gmail is required';
    }
	else if(!filter_var($gmail, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'enter valid gmail';
    }
        
     

        if($errors['firstname'] == '' && $errors['lastname'] == '' && $errors['email']== '' ){
            $query = "INSERT into users_data (first_name,last_name,email,active,signup_date) VALUES 
                        ('$firstname','$lastname','$gmail','$status','$Start')  ";
            $result = mysql_query($query);
            
            if($result) {
            echo "data is successfully added";
			header('refresh:3; url=?widget=curd_op');
            
            
            }
        
            else {
            echo "something is wrong";
            }
        }  
}
            //$query = "DELETE from users_data where id=".$_POST['userid'].";
?>
<center>Adding new members</center>
<button class="btn btn-primary" style="float: right;" onclick="window.location.href='go.php?widget=curd_op';">
    Home
</button><br>
<form method="POST">
     <label>First name</label><span class="text-red">*</span>
     <input type="text" class="form-control " value="<?= $firstname  ?>" name="First_name" placeholder="Add first name">
     <div class="text-red"><?php echo $errors['firstname'] ?></div>
     <label>last name</label><span class="text-red">*</span>
     <input type="text" class="form-control " value="<?= $lastname  ?>" name="Last_name" placeholder="Add last name">
     <div class="text-red"><?php echo $errors['lastname'] ?></div>
     <label>Email</label><span class="text-red">*</span>
     <input type="text" class="form-control " value="<?= $gmail  ?>" name="E-mail" placeholder="Add email">
     <div class="text-red"><?php echo $errors['email'] ?></div>
     <label>Status</label>
     <select name="status" class="form-control ">
          <option>In_active</option>
          <option>Active</option>
          <option>On_hold</option>
          <option>Past due</option>
     </select>
     <br>
     <input type="submit" value="Modifying data" class="btn btn-primary col-md-offset-9">
</form>


