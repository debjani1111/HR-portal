<?php
session_start();

if(isset($_POST["submit"])) 

{   
   //if ( $err == '') // no error
  {

    $cname = $_POST['cname'];
    $industry = $_POST['industry']; 
    $location = $_POST['location'];  
    $datepicker = $_POST['datepicker'];  
    $comdes = $_POST['comdes'];
    $comweb = $_POST['comweb'];   
    $phone = $_POST['phone'];   
    $raddress = $_POST['raddress']; 
    $fullname = $_POST['fullname'];   
    $mobile = $_POST['mobile'];  echo $mobile;
    $email = $_POST['email']; 
    $cpan = $_POST['cpan']; 
    $cgst = $_POST['cgst']; 
    

     $con=mysqli_connect("region","username","password","dbname","3306"); 

      /*insert employer recors into table*/
        $sql =mysqli_query($con,"INSERT INTO employerprofile(cname,industry,location,datepicker,comdes,comweb,phone,raddress,fullname,mobile,email,cpan,cgst)  VALUES('$cname','$industry','$location','$datepicker','$comdes','$comweb','$phone','$raddress','$fullname',$mobile,'$email','$cpan','$cgst')");
        $id = mysqli_query($con,"SELECT ID from employerprofile where email='$var'");
        $sq1=mysqli_fetch_assoc($id);
        $sq3=$sq1['ID'];
        //echo $sq1." ".$var;
        $sq2=mysqli_query($con,"UPDATE employerlogin SET profileid='$sq3' where user='$var'");
        if (mysqli_query($con, $sql)) 
         {
        echo "New record created successfully";
         } 
        else 
         {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
         }

        mysqli_close($con);  
        header ("Location: ../Circle/employerhome.php");
  }   
}

?>
 
<html>
  <head>

  <style type="text/css">     
    select {
        width:320px;
           }

  </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="JD5.js"></script>
    <script src="test.php"></script>
    <script src="test1.php"></script>
    <script src="college.php"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>


  <script>
    /*gst validation*/
    $(document).on('change',".gstinnumber", function(){    
      var inputvalues = $(this).val();
      var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
      
      if (gstinformat.test(inputvalues)) {
       return true;
      } else {
          alert('Please Enter Valid GSTIN Number');
          $(".gstinnumber").val('');
          $(".gstinnumber").focus();
      }
      
    });

    $(document).ready(function() {
      $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});  
          });

      function disableSubmit() {
        document.getElementById("submit").disabled = true;
                               }

      function activateButton(element) {

          if(element.checked) {
            document.getElementById("submit").disabled = false;
           }
          else {
            document.getElementById("submit").disabled = true;
          }

      }

  </script>
  </head>

  <body onload="disableSubmit()" style="background-color:#D3D3D3" >

<!-- Employer form to fill details -->
 
      <form id="formname" name="formname" method="post" action="" >

        <h4 align="center"> Employer Profile </h4> 
        <table id=table align="center" border='10' align="center" width="90%">
          <tr>
            <td>Company Name:<label class="required">*</label> </td>
            <td><input type="text" maxlength="40" name="cname" placeholder="Company Name" required /></td>
            </td>
          </tr>
          <tr>
            <td>Industry:</td>
            <td> <option selected="selected" class="required" >Choose Industry:</option>
              <!--display option values from text file -->

            <?php  
            $industries = file('/var/www/html/Forms/industry.txt');
            $arr=0;
            $options = '';
                            
            foreach ($industries as $industry) {
            $arr++;
            $options .= '<option value="'.$arr.'">'.$industry.'</option>'; 
                                            }  
           ?>

            <select id="industry" name="industry"  required >
              <?php        

                $ind_file = "industry.txt";
                $ind_lines = file($ind_file);             
                for($i=1;$i<=(count($ind_lines));$i++){
                  ?>
                  <option value=<?php echo $i ?> <?php echo(($_SESSION['industry']==$i)?"selected":"") ?> ><?php echo $industries[$i-1] ?></option> 
                <?php } ?>
            </select>
            </td>     
          </tr>

          <td>Location:<label class="required">*</label></td>
          <td><?php  

             $locations = file('/var/www/html/Forms/location.txt');
             $arr=0;
             $options = '';

                                
            foreach ($locations as $location) {
            $arr++;
            $options .= '<option value="'.$arr.'">'.$location.'</option>'; 
                                            }  
                                          
            $select = '<select name="location[]" id="location" type="text" size="3"  required>'.$options.'</select>';
            echo $select;  
         ?> 
         </td>

        <tr>
          <td>Date of Commencement:</td>
          <td><input type="text" id="datepicker" name="datepicker"></td>
        </tr>  
        <tr>
          <td>Company Description </td>
          <td><textarea maxlength="300" rows="4" cols="50" name="comdes" placeholder="Company's Description"  ></textarea></td>
        </tr>
        <tr>
        <td>Company Website:<label class="required">*</label></td>
          <td><input type="url" name="comweb" placeholder="Company website"  required/></td>
        </tr>  
        <tr>
          <td>Office No:<label class="required">*</label> </td>
          <td><input type="tel" title="(022)-9999-9999" pattern='^\d{3}-\d{4}-\d{4}$'  name="phone" placeholder="phone" required  /></td>
        </tr>  
        <tr>
          <td>Recruiter Address :</td>
          <td><textarea maxlength="100" rows="4" cols="50" name="raddress" placeholder="Recruiter Address"></textarea></td>    
        </tr>
        <tr>
          <td>Full Name:<label class="required">*</label> </td>
          <td><input type="text" maxlength="40" name="fullname" placeholder="Full Name" required /></td>
        </tr>
        <tr>
          <td>Mobile </td>
          <td><input type="tel" title="(7/8/9)999999999" pattern='^[789]\d{9}$' name="mobile" placeholder="mobile"   /></td>
        </tr>  
        <tr>
          <td>Email:<label class="required">*</label> </td>
          <td><input type="email" name="email" placeholder="Email" required  /></td>
        </tr>   
        <tr>
        <td>Company Pan:<label class="required">*</label></td>
        <td><input type="text" name="cpan" id="ctrlID" placeholder="Company Pan" maxlength="10" required  /></td>
        </tr>
        <tr>
          <td>Company GST:<label class="required">*</label></td>
          <td><input type="text" name="cgst" class="gstinnumber" required/></td>
        </tr>
        <tr>      
          <td>Company handout </td>
          <td><input type="file" name="fileupload" value="uploadJD" id="fileupload" ></td> 
       </tr>    
     </table>   
      <br><br><input type="checkbox" style="margin-left: 35%; " name="terms" id="terms" onchange="activateButton(this)">  I Agree Terms Coditions
      <br><br>
      <input style="width: 300px;  margin-left: 35%; " type="submit" name="submit" id="submit">
      
      </body>
      </html>

