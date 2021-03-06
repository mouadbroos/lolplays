<?php

ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);

if (isset($_POST['submit']))
{
    $file_name = $_FILES['myfile']['name'];
    $file_type = $_FILES['myfile']['type'];
    $file_size = $_FILES['myfile']['size'];

    $allowed_extensions = array("webm", "mp4", "ogv");
    $file_size_max = 2147483648;
    $pattern = implode ($allowed_extensions, "|");

    if (!empty($file_name))
    {    //here is what I changed - as you can see above, I used implode for the array
        // and I am using it in the preg_match. You pro can do the same with file_type,
        // but I will leave that up to you
        if (preg_match("/({$pattern})$/i", $file_name) && $file_size < $file_size_max)
        {
            if (($file_type == "video/webm") || ($file_type == "video/mp4") || ($file_type == "video/ogv"))
            {
                if ($_FILES['myfile']['error'] > 0)
                {
                    echo "Unexpected error occured, please try again later.";
                } else {
                    if (file_exists("uploads/".$file_name))
                    {
                        echo $file_name." already exists.";
                    } else {
                        move_uploaded_file($_FILES["myfile"]["tmp_name"], "uploads/".$file_name);
                        echo "Stored in: " . "uploads/".$file_name;
                    }
                }
            } else {
                echo "Invalid video format.";
            }
        }else{
            echo "where is my mojo?? grrr";
        }
    } else {
        echo "Please select a video to upload.";
    }
}else{
	echo "nothing submitted";
}

?>