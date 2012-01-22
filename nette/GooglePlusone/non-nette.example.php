<?php

include "nette.php";
include "GoogleButton.php";

$gb = new GoogleButton();
$gb->setAssynchronous(TRUE);
$gb->setAnnotation($gb::ANNOTATION_BUBBLE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>GooglePlusone html test</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<?php $gb->renderJavascript(); ?>
	</head>

<body>
<?php $gb->render(); ?>	
</body>

</html>
