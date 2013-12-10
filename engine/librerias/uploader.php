<?php

function createThumbs($pathToImages, $fname, $pathToThumbs, $thumbWidth = 210) {
    // open the directory
    //$info = pathinfo($pathToImages . $fname);
    // continue only if this is a JPEG image
    $img = imagecreatefromjpeg("{$pathToImages}{$fname}");
    $width = imagesx($img);
    $height = imagesy($img);
    // calculate thumbnail size
    $new_width = $thumbWidth;
    $new_height = floor($height * ( $thumbWidth / $width ));
    // create a new temporary image
    $tmp_img = imagecreatetruecolor($new_width, $new_height);
    // copy and resize old image into new image 
    //imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    // save thumbnail into a file
    imagejpeg($tmp_img, "{$pathToThumbs}{$fname}");
}

$output_thumbs = "img/nye/thumb/";
$output_dir = "img/nye/";
if (isset($_FILES["myfile"])) {
    $ret = array();

    $error = $_FILES["myfile"]["error"];
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData() 
    if (!is_array($_FILES["myfile"]["name"])) { //single file
        $fileName = $_FILES["myfile"]["name"];
        $file_name = time() . substr($fileName, strrpos($fileName, "."));
        move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $file_name);
        $ret[] = $fileName;
        createThumbs($output_dir, $file_name, $output_thumbs);
    } else {  //Multiple files, file[]
        $fileCount = count($_FILES["myfile"]["name"]);
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES["myfile"]["name"][$i];
            $file_name = time() . substr($fileName, strrpos($fileName, "."));
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $file_name);
            //move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $fileName);
            $ret[] = $fileName;
            createThumbs($output_dir, $file_name, $output_thumbs);
        }
    }
    echo json_encode($ret);
}