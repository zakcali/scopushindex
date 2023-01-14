<!DOCTYPE html>
<!-- scopushindex V1.0: bu yazılım Dr. Zafer Akçalı tarafından oluşturulmuştur 
programmed by Zafer Akçalı-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>aid numarasından h-index'i bulur</title>
</head>

<body>
<?php
require_once 'getSHindex.php';
$sh=new getSHindex ();
if (isset($_POST['aid'])) {
	$gelenId=preg_replace("/[^0-9]/", "", $_POST['aid']); // Sadece rakamlar
	if ($gelenId !== '')
		$sh->sHindex ($gelenId);	
}

?>
<a href="Scopus aid nerede.png" target="_blank"> Scopus AuthorId nereden bakılır? </a>
<form method="post" action="">
Scopus aid  giriniz. <?php echo ' '.$sh->dikkat;?><br/>
<input type="text" name="aid" id="aid" value="<?php echo $sh->authorId;?>" >
<input type="submit" value="Yazar bilgilerini PHP ile getir">
</form>
<button id="scopusGoster" onclick="scopusGoster()">Scopus profil sayfasını göster</button>
<button id="scopusAtifGoster" onclick="scopusAtifGoster()">Scopus atıflarını göster</button> <br>
h-index: <input type="text" name="hindex" size="2"  id="hindex" value="<?php echo $sh->hindex;?>"> 
yayın sayısı: <input type="text" name="yayins" size="4"  id="yayins" value="<?php echo $sh->yayinS;?>"> 
atif sayısı: <input type="text" name="atifs" size="4"  id="atifs" value="<?php echo $sh->atifS;?>"> <br>
<script>

function scopusGoster() {
var	w=document.getElementById('aid').value.replace(" ","");
	urlText = 'http://www.scopus.com/authid/detail.uri?origin=resultslist&authorId='+w;
	window.open(urlText,"_blank");
}
function scopusAtifGoster() {
var	w=document.getElementById('aid').value.replace(" ","");
	urlText = 'https://www.scopus.com/hirsch/author.uri?accessor=authorProfile&auidList='+w+'&origin=AuthorProfile&display=hIndex';
	window.open(urlText,"_blank");
}
</script>
</body>
