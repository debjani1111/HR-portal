<?php 
$link = mysqli_connect("domain", "user", "password", "dbname");

//session_start();

$var ="candidatename";

/* getting edited data ina ny of form fields from form */
  if(isset($_POST["submit"])) 
{ 
  $name=$_POST['name']; 
  $headline=$_POST['headline']; 
  $industry = $_POST['industry'];   
  $role = $_POST['role'] ;
  $designation = $_POST['designation-value'] ;
  $exp = $_POST['exp'] ;
  $cur_loc =$_POST['cur_loc'];  
  $pref_loc =$_POST['pref_loc']; 
  $curr_sal =$_POST['curr_sal']; 
  $exp_sal =$_POST['exp_sal']; 
  $qua=$_POST['qua'];      
  $degree=$_POST['degree']; 
  $other=$_POST['other']; 
  $subject=$_POST['subject']; 
  $clg=$_POST['clg']; 
  $per=$_POST['per']; 
  $cgpa=$_POST['cgpa']; 
  $passingyr=$_POST['passingyr']; 
  $tskill=$_POST['tskill']; 

  /* All form data gets stored in a text file first */
  $fileHandle = fopen('Form_' .$var. '.txt', 'a') OR die ("Can't open file\n");
  
  //print_r($_POST);


/*Get qualification data from form, user can edit max 6 qualifications and all the 6 qualifications get encoded into a single string at backend*/
   for ($x = 0; $x <= (count($_POST['qua'])-1); $x++) {
   // $qualification=print_r(array_values($qua)[$x]);
    $level=print_r(array_values($qua)[$x],true);
    $degrees=print_r(array_values($degree)[$x],true); 
    $otherdegrees=print_r(array_values($other)[$x],true);
    $specialization=print_r(array_values($subject)[$x],true);
    $college=print_r(array_values($clg)[$x],true);  
    $percentage=print_r(array_values($per)[$x],true);
    $Cgpa=print_r(array_values($cgpa)[$x],true);
    $Passingyr=print_r(array_values($passingyr)[$x],true);

    if($degrees!="Other")
    $qua_string=$level . '.' . $degrees . '.' . $specialization . '.' . $college . '.' . $percentage . '.' . $Cgpa . '.' . $Passingyr;
    else
       $qua_string=$level . '.' . $otherdegrees . '.' . $specialization . '.' . $college . '.' . $percentage . '.' . $Cgpa . '.' . $Passingyr;
       $qualification .=$qua_string.',' . ' '; //echo $qualification;
    }


  /*technical skill data */
    for ($x = 0; $x <= (count($_POST['tskill'])-1); $x++) {
     // $qualification=print_r(array_values($qua)[$x]);
      $techskill=print_r(array_values($tskill)[$x],true);
      $technicalskill .=$techskill.',' . ' '; 
    }


    /*encoding concept for location*/
    switch (true) {

      case ($pref_loc[1] == null && $pref_loc[2] == null):
      $pref_loc=$pref_loc[0];
      break;

      case ($pref_loc[1] != null && $pref_loc[2] == null):
      $pref_loc=$pref_loc[0]*1000+$pref_loc[1];
      break;

      case ($pref_loc[1] != null && $pref_loc[2] != null):
      $pref_loc=((($pref_loc[0]*1000) +$pref_loc[1])*1000)+$pref_loc[2];
      break;
               } 

    /*writing all form data to the text file */

    fwrite ($fileHandle,Name."|"." ".headline."|"." ".industry."|"." ".role."|"." ".designation."|"." ".experience."|"." ".curr_loc."|"." "." ".pref_loc."|"." ".curr_sal."|"." ".exp_sal."|"." ".qualification."|"." ".skill."|"." ". PHP_EOL. PHP_EOL);  
    $name = fwrite ($fileHandle,$name."|"." ");  
    $headline = fwrite ($fileHandle,$headline."|"." ");  
    $industry = fwrite ($fileHandle,$industry."|"." ");  
    $role = fwrite ($fileHandle,$role."|"." ");   
    $designation=fwrite ($fileHandle,$designation."|"." ");  
    $exp=fwrite ($fileHandle,$exp."|"." "); 
    $cur_loc = fwrite ($fileHandle,$cur_loc."|"." ");
    $pref_loc = fwrite ($fileHandle,$pref_loc."|"." ");
    $curr_sal = fwrite ($fileHandle,$curr_sal."|"." ");  
    $exp_sal = fwrite ($fileHandle,$exp_sal."|"." ");  
   // $qua = fwrite ($fileHandle," qua:" .$level." "); 
   // $degree= fwrite ($fileHandle," degree:" .$degree1." "); 
    $qualification= fwrite ($fileHandle,$qualification."|"." "); 
    $technicalskill = fwrite ($fileHandle,$technicalskill. PHP_EOL. PHP_EOL); 
   // $subject= fwrite ($fileHandle," subject:" .$subject1." "); 
    fclose($fileHandle); 
    header('Location: experience.php');
  
}
?> 
<?php

  /* get data from table of the session user to display in edit resume form*/
  $sql = " SELECT * FROM candidate WHERE trim(email)='session-email' "; 

  if($result = mysqli_query($link, $sql)){

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
          $industry="/var/www/html/industry.txt";
          $desig="/var/www/html/desig.txt";
          $location="/var/www/html/Files/location.txt";
          $industry_lines=file($industry);
          $desig_lines=file($desig);  
          $location_lines=file($location);
           
    ?>  
    

<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="JD5.js"></script>
  </head>

  <body style="background-color:#D3D3D3">
    <h3 align="center">RESUME</h3>

   <!--  <form id="formname" name="formname" method="post" action="resume_new1.php" > -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">    
      <div style="position:absolute;left:100px;top:50px"> Name &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" maxlength="40" name="name" placeholder="Full Name" value=<?php echo $row['name'] ?> required/>  </div>   
      <div style="position:absolute;left:100px;top:90px">Resume Headline <input type="text" maxlength="100" name="headline" placeholder="Resume Headline" value=<?php echo $row['headline'] ?> required/></div>
      <div style="position:absolute;left:100px;top:130px">Date of Birth&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" id="datepicker" name="datepicker" value=<?php echo $row['dob'] ?>></div>
      <div id="header"> <h4 align="center">Required Position</h4>  </div>
      <table  id=table align="center" border='10' align="center" width="90%">
        <tr>  
          <td>Industry</td>
          <td>
                     <select id="tst" style="width:5cm" name="industry[]" onchange="getfuncarea(this)" required>
                      <option value="0"<?php echo (($row['industry']==0)?"selected":"") ?> >Business Services</option>
                      <option value="1"<?php echo (($row['industry']==1)?"selected":"") ?> >Energy & Natural resources</option>
                      <option value="2"<?php echo (($row['industry']==2)?"selected":"") ?> > Finance Services</option>
                      <option value="3"<?php echo (($row['industry']==3)?"selected":"") ?> > FMCG</option>
                      <option value="4"<?php echo (($row['industry']==4)?"selected":"") ?> > Healthcare/Pharmaceutical</option>
                      <option value="5"<?php echo (($row['industry']==5)?"selected":"") ?> > Industrial / Manufacturing</option>
                      <option value="6"<?php echo (($row['industry']==6)?"selected":"") ?> > Insurance</option>
                      <option value="7"<?php echo (($row['industry']==7)?"selected":"") ?> > Leisure, Travel & Tourism</option>
                      <option value="8"<?php echo (($row['industry']==8)?"selected":"") ?> > Life Sciences / Diagnostics</option>
                      <option value="9"<?php echo (($row['industry']==9)?"selected":"") ?> > Media & Agency</option>
                      <option value="10"<?php echo (($row['industry']==10)?"selected":"") ?> >Medical Device / Medical Equipment</option>
                      <option value="11"<?php echo (($row['industry']==11)?"selected":"") ?> >Not for Profit</option>
                      <option value="12"<?php echo (($row['industry']==12)?"selected":"") ?> >Property</option>
                      <option value="13"<?php echo (($row['industry']==13)?"selected":"") ?> >Public Sector</option>
                      <option value="14"<?php echo (($row['industry']==14)?"selected":"") ?> >Retail</option>
                      <option value="15"<?php echo (($row['industry']==15)?"selected":"") ?> >Technology & Telecoms</option>
                      <option value="16"<?php echo (($row['industry']==16)?"selected":"") ?> >Transport & Distribution</option> 
                    </select>
            </td>
            <td>Role :</td>
            <td>
              <select id="role" name="role" required>
                        <option value=''>Select</option>
                        <option value="1">Fresher</option>
                        <option value="2">Accountant/Bookkeeper</option>
                        <option value="3">Accounts Payable</option>
                        <option value="4">IT Business Analysis</option>
                        <option value="5">Internal Audit</option>
                        <option value="6">Financial Director</option>
              </select> 
            </td> 
          </tr>
        </table>

           <!-- <p align="center"><a href="http://localhost/resume_new1.php">Next</a></p>   -->
           <input type="submit" value="Next " name="submit"> 
   
    </form>
 <?php
           }
       }
  }?>

  </body>
</html>
 
