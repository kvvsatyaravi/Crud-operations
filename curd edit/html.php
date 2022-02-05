<?php 

 if(isset($_POST['submit_edit'])){

   $status = $_POST['status'];
   $id = $_POST['id'];
   //$status = $_POST['status'];
   $errors = array('fName'=>'','lName'=>'','email'=>'','error'=>'');
   
   //$errors[] = '';
    //$errors[] = ['fName' => '', 'lName' => '', 'email' => '' ,'error'=>''];
   
   

   if(empty($_POST['first_name'])){
      $errors['fName'] = 'Please enter the First Name';

   }else{
      $fName = $_POST['first_name'];
   }

   if(empty($_POST['last_name'])){
      $errors['lName'] = 'Please enter the Last Name';
   }else{
      $lName = $_POST['last_name'];
   }
      
   if(empty($_POST['email'])){
      $errors['email'] = 'Please enter the email';
   }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'enter valid gmail address';
   }else{
      $email = $_POST['email'];
   }

   if(array_filter($errors)){
      $errors['error'] = 'Errors in the form';
   }else{
      $update = "UPDATE `users_data` SET `first_name` = '$fName',`last_name` = '$lName', `email` = '$email', `active` =  '$status' WHERE `users_data`.`user_id` = '$id'";
      //echo "UPDATE `users_data` SET `first_name` = '$fName',`last_name` = '$lName', `email` = '$email', 'active' =  '$status' WHERE `users_data`.`user_id` = '$id'";
      
      if(mysql_query($update)){
         header('refresh:3; url=go.php?widget=curd_op');
      }else{
         $errors['error'] = 'Data not updated';
      }
   }
 }

if($_GET['user_id']){
   $number=$_GET["user_id"];
   
   $query = " SELECT * FROM users_data WHERE user_id= ".$number;
   $result = mysql_query($query);
   $row = mysql_fetch_assoc($result);
}
?>
<center>Modifying Data</center>
<button class="btn btn-primary" style="float: right;" onclick="window.location.href='go.php?widget=curd_op';">
Home
</button><br>

<form method="POST">
    <?php if($errors['error']){ echo $errors['error']; }?>
   <label>First name</label><span class="text-red">*</span>
    <input type="text" class="form-control " name="first_name" placeholder="change first name" value="<?php if($row['first_name']) { echo $row['first_name']; }?>">
    <div class="text-red"><?php if($errors['fName']){ echo $errors['fName']; } ?></div>

   <label>last name</label><span class="text-red">*</span>
    <input type="text" class="form-control " name="last_name" placeholder="change last name" value="<?php if($row['last_name']) { echo $row['last_name']; }?>" >
    <div class="text-red"><?php if($errors['lName']){ echo $errors['lName']; } ?></div>

   <label>Email</label><span class="text-red">*</span>
   <input type="text" class="form-control " name="email" placeholder="change email" value="<?php if($row['email']) { echo $row['email']; }?>" >
    <div class="text-red"><?php if($errors['email']){ echo $errors['email']; } ?></div>

    <label>Status</label>
    <?php //var_dump($row['active']); ?>
   <select name="status" class="form-control ">
        <option value="1" <?php if($row['active'] == 1 ){echo 'selected'; } ?> >In_active</option>
        <option value="2" <?php if($row['active'] == 2 ){echo 'selected'; } ?>>Active</option>
        <option value="4" <?php if($row['active'] == 4 ){echo 'selected'; } ?>>On_hold</option>
        <option value="5" <?php if($row['active'] == 5 ){echo 'selected'; } ?>>Past due</option>
        </select>
    <br>
    <input type="hidden" name="id" value="<?=$row['user_id']?>" class="">
    <input type="submit" name="submit_edit" value="Modifying data" class="btn btn-primary col-md-offset-9">
</form>




