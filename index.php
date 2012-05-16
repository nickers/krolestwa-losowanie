<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <title>Losowanie nagród</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="bootstrap/css/docs.css" rel="stylesheet">
    <link href="bootstrap/js/google-code-prettify/prettify.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Kopalnie</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="#">Losowanie</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
    
    	<h1>Losujemy nagrody dla graczy pracujących w kopalniach!</h1>
	<h2>Wpisz dane:</h2>
	<p>Format z przykładem:
		<blockquote style="float: left; display:block; width: 150px;">[liczba_dni] [osoba]<br/>[liczba_dni] [osoba]<br/>...</blockquote>
	 	<blockquote style="margin-left: 200px;">3 nickers<br>1 ameb<br>5 KtośTam_66</blockquote>
	</p>


<!-- teraz PHP! :D -->


<?php 
error_reporting(0); 
if (isset($_POST['dane_zapamietane'])) {
	$_POST['dane'] = unserialize(base64_decode($_POST['dane_zapamietane']));
}
?>

<form method="post" class="well">
	<label>Dane do losowania:</label>
	<textarea name="dane" cols="100" rows="10"><?php print $_POST['dane'];?></textarea>
	<label></label>
	<input class="btn btn-primary btn-large" type="submit" value="Wyślij" />
</form>

<form method="post" class="well">
<?php

$dni2kupony = array(
	1 => 0,
	2 => 0,
	3 => 1,
	4 => 2,
	5 => 2,
	6 => 2,
	7 => 3
);

	$all = array();
	$pattern = '/([1-7])[\t\ ]+([^\t\n\r\ ]+)/';
	preg_match_all($pattern, $_POST['dane'], $all, PREG_SET_ORDER);

	$ile_osob = count($all);
	$raport = array();
	foreach ($all as $d) {
		$dni = (int)$d[1];
		$osoba = $d[2];
		if (!isset($dni2kupony[$dni])) {
			printf("Zła ilośc dni (%d) dla %s", $dni, $osoba);
			exit;
		}
		if (isset($raport[$osoba])) {
			printf("Osoba %s występuje drugi raz!", $osoba);
			exit;
		}
		$raport[strtolower($osoba)] = $dni2kupony[$dni];
	}

	if (count($raport)>0) {
		$kupony = array();
		print '<table class="table table-condensed table-bordered table-stripped"><thead><tr><th>Osoba</th><th>Liczba kuponów</th></tr></thead>';
		print "\n<tbody>";
		foreach ($raport as $osoba=>$losow) {
			printf("<tr><td>%s</td><td>%d</td></tr>\n", $osoba, $losow);
			while ($losow-->0) $kupony[] = $osoba;
		}
		print "</tbody>";
		print "</table>";
	}
?>

	<input type="hidden" name="dane_zapamietane" value="<?php print base64_encode(serialize($_POST['dane'])); ?>" />
	<input type="hidden" name="kupony" value="<?php print base64_encode(serialize($kupony)); ?>" />
<?php if (count($kupony)>0) {  ?>
	<input type="submit" class="btn btn-inverse btn-large" name="losowanie" value="Losowanie!" />
<?php } ?>

<?php
	$kupony = array();
	if (isset($_POST['kupony'])) {
		$kupony = unserialize(base64_decode($_POST['kupony']));
		shuffle($kupony); // zeby nikt nie marudzil :)
		$zwyciezca = array_rand($kupony);
		printf('<p><h1 class="alert alert-info">Wygrał gracz: %s</h1></p>', $kupony[$zwyciezca]);
	}
?>
</form>


<!-- koniec PHP -->

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
