<?php
error_reporting(E_ERROR | E_PARSE);
include("db.php");

// function to upload images
function uploadimage($dealpicturename,$dealpicturetype,$dealpictureerror,$dealpicturesize,$dealpicturetmpname)
{
$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = end(explode(".", $dealpicturename));

if ((($dealpicturetype == "image/gif")|| ($dealpicturetype == "image/jpeg")|| ($dealpicturetype == "image/png")|| ($dealpicturetype == "image/pjpeg"))
&& ($dealpicturesize < 20000)&& in_array($extension, $allowedExts))
  {
  if ($dealpictureerror > 0)
    {
    echo "Return Code: " . $dealpictureerror . "<br>";
    }
  else
    {
      $dealpicturename;
      $dealpicturetype;
      ($dealpicturesize / 1024);
      $dealpicturetmpname;

    if (file_exists("../upload/" . $dealpicturename))
      {
      echo $dealpicture. " already exists. ";
      }
    else
      {
      move_uploaded_file($dealpicturetmpname,
      "../upload/" . $dealpicturename);
      $imagepath =  "../upload/" . $dealpicturename;	   
      }
    }
  }
else
  {
  echo '<br/><div> Invalid file </div>';
  }
  return $imagepath;
 }
 
 // function to select the city name
 function selectcity($city_id)
 {
  $selectcity = mysql_query("select city_name from city where city_id= '$city_id'") or die ("select city_name from city where city_id= '$cityid'". mysql_error());
  $resultcity = mysql_fetch_array($selectcity);
  $cityname   = $resultcity["city_name"];
  return $cityname;
 }
 
 function selectcategory($cat_id)
 {
   $selectcategory = mysql_query("select name from category where id='$cat_id'") or die ("select name from category where id='$cat_id'".mysql_error());
   $resultcat = mysql_fetch_array($selectcategory);
   $name = $resultcat["name"];
   return $name;
 }
 
 function selectpartner()
 {
   $selectpartner = mysql_query("select id,username from partner") or die ("select id,username from partner".mysql_error());
   $resultpart = mysql_fetch_array($selectpartner);
   $id   = $resultpart["id"];
   $name = $resultpart["username"];
   return array($id,$name);
 }
 
?>
