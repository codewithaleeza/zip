<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" type="image/x-icon" href="zip.ico" />

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Poppins|Work+Sans&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Fjalla+One&display=swap" rel="stylesheet">

 <link rel="stylesheet" type="text/css" href="style.css">
  <title>PHP ZIP File</title>
</head>

<body>

<div class="container ">
  <center> <img src="zip.ico" style="height:100px; margin-top:5%;"> <h1>Create Zip File of Multiple Uploaded Files</h1></center>
<hr>
<?php
if ($_FILES && $_FILES['img']) {

    if (!empty($_FILES['img']['name'][0])) {

        $zip = new ZipArchive();
        $zip_name = getcwd() . "/uploads/upload_" . time() . ".zip";

        // Create a zip target
        if ($zip->open($zip_name, ZipArchive::CREATE) !== TRUE) {
            $error .= "Sorry ZIP creation is not working currently.<br/>";
        }

        $imageCount = count($_FILES['img']['name']);
        for($i=0;$i<$imageCount;$i++) {

            if ($_FILES['img']['tmp_name'][$i] == '') {
                continue;
            }
            $newname = date('YmdHis', time()) . mt_rand() . '.jpg';

            // Moving files to zip.
            $zip->addFromString($_FILES['img']['name'][$i], file_get_contents($_FILES['img']['tmp_name'][$i]));

            // moving files to the target folder.
            move_uploaded_file($_FILES['img']['tmp_name'][$i], './uploads/' . $newname);
        }
        $zip->close();

        // Create HTML Link option to download zip
        $success = basename($zip_name);
    } else {
        $error = '<strong>Error!! </strong> Please select a file.';
    }
}
?>
<div class="wrap">
  <form action="" method="post" enctype="multipart/form-data">
    <label>Please Select Multiple files and Click Upload: </label><br>

    <div class="input-group">

    <div class="custom-file">
        <input type="file" class="custom-file-input" name="img[]" multiple>
        <label class="custom-file-label" >Choose File</label>
    </div><br>
    <div >
        <input type="submit" class="btn " style="color:white;border-color: white;background-color: #007991;"value="Upload">
    </div>

  </div>
  <?php
  if(!empty($error)) {
  ?>
<p class="error text-center"><?php echo $error; ?></p>
  <?php
  }
  ?>
  <?php
  if(!empty($success)) {
  ?> <br>
<p class="success text-center" style="color:white; font-size:20px;">
  Files uploaded successfully and compressed into a zip format!
  </p>
  <p class="success text-center" style="font-size:20px;font-family: 'Fjalla One', sans-serif;">
  <a href="uploads/<?php echo $success; ?>" target="__blank">Click here to download the zip file</a>
  </p>
  <?php
  }
  ?>
</form>
  <hr>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</html>
