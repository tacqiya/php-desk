<?php 
require_once('directory_Class.php');

$yaha = new MainClass;
$showDir = $yaha->showDirectory();

$readFi = $yaha->readFile('show_directory.php');



// echo "<pre>"; print_r($readFi);echo "</pre>";




// read the textfile
// $text = file_get_contents($readFi);

?>
<!-- HTML form -->
<form action="" method="post">
<textarea name="text"><?php echo htmlspecialchars((string)$readFi); ?></textarea>
<input type="submit" />
<input type="reset" />
</form>