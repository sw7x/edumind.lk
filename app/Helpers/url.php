<?php

if(! function_exists('ValidUrl')){
   function ValidUrl($url) {
      // $regex = "((https?|ftp)\:\/\/)?";
      $regex  = "(https?\:\/\/)?";
      $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
      $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
      $regex .= "(\:[0-9]{2,5})?";
      $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
      $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
      $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";
          
      return preg_match("/^$regex$/i", $url);      
   }
}