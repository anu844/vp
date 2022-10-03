<?php
require_once "../config.php";
//echo $server_host;

$author_name = "Anu Saraaa";
$full_time_now = date("d.m.Y H:i:s");
$weekday_now = date ("N");
$weekdaynames_et = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
$hours_now = date ("H");
$part_of_day = "suvaline päeva osa";

// <  >  >= <= == !=
if($weekday_now >= 1 && $weekday_now <= 5){
	if ($hours_now >= 7 and $hours_now < 8){
		$part_of_day = "kooli sättimise aeg";}		
	elseif($hours_now >= 8 and $hours_now <= 17){		
		$part_of_day = "kooliaeg";}		
	elseif($hours_now > 17 and $hours_now <= 23){
		$part_of_day = "vabaaeg";}	
	else{
		$part_of_day = "uneaeg" ;}
}
else{
	if ($hours_now >= 11  && $hours_now <= 23){
		$part_of_day = "puhkamise aeg";}
	else{
		$part_of_day = "uneaeg";}
}	

$smart_phrase = ["Loll pea on ihu nuhtlus", "Pill tuleb pika ilu peale", "Kes kannatab, see kaua elab", "Kel janu, sel jalad",
"Tahtmine on taevalik, saamine on iseasi", "Lootus on lollide lohutus", "Uhkus ajab upakile"];



// uurime semestri kestmist
$semester_begin = new DateTime ("2022-9-5");
$semester_end = new DateTime ("2022-12-18");
$semester_duration = $semester_begin->diff($semester_end);
//echo $semester_duration;
$semester_duration_days = $semester_duration->format("%r%a");
$from_semester_begin = $semester_begin->diff(new DateTime("now"));
$from_semester_begin_days = $from_semester_begin->format("%r%a");

//juhuslik arv
//küsin massiivi pikkust
//echo count($weekdaynames_et);
//echo mt_rand(0, count ($weekdaynames_et)-1);
//echo $weekdaynames_et [mt_rand(0, count ($weekdaynames_et)-1)];

//juhuslik foto
$photo_dir = "Pildid";
	//loen kataloogi sisu
	//$all_files = scandir($photo_dir);
$all_files = array_slice(scandir($photo_dir), 2);
	//kontrollin, kas ikka foto
$allowed_photo_types = ["image/jpeg", "image/png"];
	//tsükkel
	//Muutuja väärtuse suurendamine   $muutuja = $muutuja + 5
	// $muutuja += 5
	//kui on vaja liita 1
	//$muutuja ++
	//sama moodi $muutuja -= 5     $muutuja --
	/*for($i = 0;$i < count($all_files); $i ++){
	echo $all_files[$i];
}*/
$photo_files = [];
foreach($all_files as $filename){
	//echo $filename;
	$file_info = getimagesize($photo_dir ."/" .$filename);
	//var_dump($file_info);
		//kas on lubatud tüüpide nimekirjas
	if(isset($file_info["mime"])){
		if(in_array($file_info["mime"], $allowed_photo_types)){
			array_push($photo_files, $filename);
		}//if in_array
	}//if isset
}//foreach


	//var_dump($photo_files);
	//   <img src="kataloog/fail" alt="tekst">
$photo_html = '<img src="' .$photo_dir ."/" .$photo_files[mt_rand(0, count($photo_files) - 1)] .'"';
//$photo_html .= ' alt="Tallinna pilt">';
$photo_number = mt_rand(0, count($photo_files) - 1);
	//vaatame, mida vormis sisestati
	//var_dump($_POST);
	//echo $_POST["todays_adjective_input"];
$todays_adjective = "pole midagi sisestatud";
if(isset($_POST["todays_adjective_input"]) and !empty($_POST["todays_adjective_input"])){
	$todays_adjective = $_POST["todays_adjective_input"];
}
	
	//loome rippmenüü valikud
	//<option value="0">tln_1.JPG</option>
	//<option value="1">tln_106.JPG</option>
$select_html = '<option value="" selected disabled>Vali pilt</option>';
for($i = 0;$i < count($photo_files); $i ++){
	$select_html .= '<option value="' .$i .'">';
	$select_html .= $photo_files[$i];
	$select_html .= "</option>";
}
	
	//echo $_POST["photo_select"];
	//if(isset($_POST["photo_select"]) and !empty($_POST["photo_select"])){
if(isset($_POST["photo_select"]) and $_POST["photo_select"] >= 0){
	//echo "Valiti pilt nr:" .$_POST["photo_select"];
}
	
	//var_dump($photo_files);
	//   <img src="kataloog/fail" alt="tekst">
$photo_html = '<img src="' .$photo_dir ."/" .$photo_files[mt_rand(0, count($photo_files) - 1)] .'"';
$photo_html .= ' alt="Tallinna pilt">';
	
	//vaatame, mida vormis sisestati
	//var_dump($_POST);
	//echo $_POST["todays_adjective_input"];
$todays_adjective = "pole midagi sisestatud";
if(isset($_POST["todays_adjective_input"]) and !empty($_POST["todays_adjective_input"])){
	$todays_adjective = $_POST["todays_adjective_input"];
}
	
	//loome rippmenüü valikud
	//<option value="0">tln_1.JPG</option>
	//<option value="1">tln_106.JPG</option>
$select_html = '<option value="" selected disabled>Vali pilt</option>';
for($i = 0;$i < count($photo_files); $i ++){
	$select_html .= '<option value="' .$i .'">';
	$select_html .= $photo_files[$i];
	$select_html .= "</option>";
}
	
	//echo $_POST["photo_select"];
	//if(isset($_POST["photo_select"]) and !empty($_POST["photo_select"])){
if(isset($_POST["photo_select"]) and $_POST["photo_select"] >= 0){
	//echo "Valiti pilt nr:" .$_POST["photo_select"];
}
$comment_error = null;
//Kas klikiti päeva kommentaari nuppu
if(isset($_POST["comment_submit"])){
	if(isset($_POST["comment_input"]) and !empty($_POST["comment_input"])){
		$comment = $_POST["comment_input"];
	} else {
		$comment_error = "Kommentaar jäi kirjutamata!";
	}
	//$comment = $_POST["comment_input"];
	$grade = $_POST["grade_input"];
	
	if(empty($comment_error)){
	
	//loon andmebaasiga ühenduse
	//server, kasutaja, parool, andmebaasiga
	$conn = new mysqli ($server_host, $server_user_name, $server_password, $database);
	//määran suhtlemisel kasutatava kooditabeli
	$conn->set_charset("utf8");
	//valmistame ette andmete saatmise SQL käsu
	$stmt = $conn->prepare("INSERT INTO vp_daycomment_2 (comment, grade) values(?,?)");
	echo $conn->error;
	//seome SQL käsu õigete andmetega
	//andmetüübid	i - integer		d - devimal		s - string
	$stmt->bind_param("si", $comment, $grade);
	if($stmt->execute()){
		$grade = 7;
		$comment = null;
	}
	//sulgeme käsu
	$stmt->close();
	//andmebaasiühenduse kinni
	$conn->close();
	}
}
	
?>


<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title><?php echo $author_name;?> programmeerib veebi</title>
</head>
<body>
<img src="pics/vp_banner_gs.png" alt="bänner">
<h1>Anu Sara programmeerib veebi</h1>
<p>See leht on loodud õppetöö raames ja ei sisalda tõsiseltvõetavat sisu!</p>
<p>Õppetöö toimus <a href="https://www.tlu.ee" target="_blank">Tallinna Ülikoolis</a> Digitehnoloogiate instituudis.</p>
<p>Lehe avamise hetk: <?php echo $weekdaynames_et[$weekday_now-1]; echo ", "; echo $full_time_now;?></p>
<p>Praegu on <?php echo $part_of_day;?>.</p>
<p>Tänane vanasõna: <?php echo $smart_phrase [ mt_rand(0,6)];?>.</p>
<p>Semestri pikkus on <?php echo $semester_duration_days;?> päeva. See on kestnud juba <?php echo $from_semester_begin_days; ?> päeva.</p>
<a href="https://www.tlu.ee" target="_blank"><img src="pics/tlu_42.jpg" alt="Tallinna Ülikooli Astra õppehoone"></a>

<hr>
<form method="POST">
	<label for = "comment input">Kommentaar tänase päeva kohta (140 tähte)</label>
	<br>
	<textarea id="comment_input" name="comment_input" cols ="35" rows="4"
	placeholder="kommentaar"></textarea>
	<br>
	<label for="grade_input">Hinne tänasele päevale (0-10)</label>
	<input type="number" id="grade_input" name="grade_input" min="0" max="10" step="1" value="<?php echo $grade; ?>">
	<br>
	<input type="submit" id="comment_submit" name="comment_submit" value="Salvesta">
	<span></php echo $comment_error; ?></span>
	
</form>
<br>
<hr>

<form method="POST">
	<input type="text" id="todays_adjective_input" name="todays_adjective_input" placeholder="Kirjuta siia omadussõna tänase päeva kohta">
	<input type="submit" id="todays_adjective_submit" name="todays_adjective_submit" value="Saada omadussõna!">
</form>
<p>Omadussõna tänase kohta: <?php echo $todays_adjective; ?></p>
<hr>
<form method="POST">
	<select id="photo_select" name="photo_select">
		<?php echo $select_html; ?>		
	</select>
	<input type="submit" id="photo_submit" name="photo_submit" value="Määra foto">
</form>
<?php echo $photo_html; ?>
<hr>

</body>
</html>