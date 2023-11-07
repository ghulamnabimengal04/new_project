<?php
 require_once("connection.php");

?>
<!DOCTYPE html>
    <head>
        <title>My Users Crud Application</title>
        <style>
            .header{
                height:70px;
                background-color:lightblue;
                border-radius:10px;
                text-align:center;
            }
            #header_text{
             padding-top:13px;   
            }
            .add_user{
                
            }
            fieldset{
                width:30%;
                height:400px
            }
            .ancher_tag{
                text-decoration:none;
            }
            #delete_button{
                background-color:red;
                width:60px;
                height:30px;
                border-radius:5px;
            }
            #update_button{
                background-color:lightblue;
                width:60px;
                height:30px;
                border-radius:5px;

            }
            #image_div{
                height:60px;
                width:40px;
            }
        </style>
    </head>
    <body>
        <div class="main_div">
            <div class="header">
                <h1 id="header_text">User Crud Application</h1>
            </div>
        
            <div class="add_user">
                <center>
                   
                        <?php
                            if(isset($_REQUEST['msg']) && $_REQUEST['color']=='red'){
                              ?>
                                <p style="color:red"><?php echo $_REQUEST['msg']?></p>
                              <?php 
                            }elseif(isset($_REQUEST['msg']) && $_REQUEST['color']=='green'){
                                ?>
                                  <p style="color:green"><?php echo $_REQUEST['msg']?></p>
                                <?php 
                              }elseif(isset($_REQUEST['user_id'])){
                                 $select_query = "SELECT * FROM users WHERE user_id=".$_REQUEST['user_id'];
                                 $results = mysqli_query($con,$select_query);
                                 if($results->num_rows>0){
                                    $userdata = mysqli_fetch_assoc($results);
                                    ?>
                                        
                                            <img style="height:50px;width:40px;" src="<?php echo $userdata['user_image']?>">
                                       
                                    <?php
                                 }
                              }

                        ?>
               
                 <fieldset>
                    <legend>Add User</legend>
                    <form action="process.php" method="POST" enctype="multipart/form-data">
                        <table cellpadding="6">
                            <input type="hidden" name="user_id" value="<?php echo $userdata['user_id']?>">
                            <tr>
                                <td><label>Full Name</label> </td>
                                <td><input type="text" name="name" value="<?php echo $userdata['name']??''?>"></td>
                            </tr>
                            <tr>
                                <td><label>Email</label> </td>
                                <td><input type="email" name="email" value="<?php echo $userdata['email']??''?>"></td>
                            </tr>
                            <tr>
                                <td><label>Password</label> </td>
                                <td><input type="password" name="password" value="<?php echo $userdata['password']??''?>"></td>
                            </tr>
                            <tr>
                                <td><label>Address</label> </td>
                                <td><input type="text" name="address" value="<?php echo $userdata['address']??''?>"></td>
                            </tr>
                            <tr>
                                <td><label>Gender</label> </td>
                                <td>
                                    Male<input type="radio" name="gender" value="Male"     <?php echo isset($userdata['gender']) && $userdata['gender']=='Male' ?"checked":""?>>
                                    Female<input type="radio" name="gender" value="Female" <?php echo isset($userdata['gender']) && $userdata['gender']=='Female'?"checked":""?>>
                               </td>
                            </tr>
                            <tr>
                                <td><label>Phone Number</label> </td>
                                <td><input type="number" name="number" value="<?php echo $userdata['phone_number']??''?>"></td>
                            </tr>
                            <tr>
                                <td><label>Select Country</label> </td>
                                <td>
                                    <select name="country">
                                        <option <?php echo isset($userdata['country']) && $userdata['country'] == "Pakistan" ? "selected" : ""; ?>>Pakistan</option>
                                        <option <?php echo isset($userdata['country']) && $userdata['country'] == "UAE" ? "selected" : ""; ?>>UAE</option>
                                        <option <?php echo isset($userdata['country']) && $userdata['country'] == "INDIA" ? "selected" : ""; ?>>INDIA</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><label>Profile Picture</label> </td>
                                <td><input type="file" name="user_image"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" name="Adduser" value="<?php if(isset($_REQUEST['user_id'])){
                                    echo"Update User";
                                }else{echo"Add User";}?>"></td>
                            </tr>
                        </table>
                    </form>
                 </fieldset>
                 <h2>All Users Data</h2>
                 <table border="2" cellpadding="5" align="center">
                    <thead>
                        <tr>
                            <th>User NO</th>
                            <th>Profile Image</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Gender</th> 
                            <th>Phone Number</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 0;
                            $select_query ="SELECT * FROM `users` ORDER BY user_id DESC LIMIT 5";
                            $results = mysqli_query($con , $select_query);
                            if($results->num_rows>0){
                                while($user_data = mysqli_fetch_assoc($results)){
                                    $count++;
                                    ?>
                                     <tr>
                                       <td><?php echo $count?></td>
                                       <td><img style="width:50px;height:60px" src="<?php echo $user_data['user_image']?>"> </td>
                                       <td><?php echo $user_data['name']?></td>
                                       <td><?php echo $user_data['email']?></td>
                                       <td><?php echo $user_data['address']?></td>
                                       <td><?php echo $user_data['gender']?></td>
                                       <td><?php echo $user_data['phone_number']?></td>
                                       <td><?php echo $user_data['country']?></td>
                                       <td>
                                        <button id="update_button"><a class="ancher_tag" href="index.php?user_id=<?php echo $user_data['user_id']?>">Update</a> </button>
                                        <button id="delete_button"><a class="ancher_tag" href="process.php?button=delete&user_id=<?php echo $user_data['user_id']?>">Delete</a></button>
                                       </td>
                                        
                                      </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                 </table>
                </center>
            </div>
        </div>
    </body>
</html>