<?php
class getSHindex {
	function __construct() {
		$this->initialize();
		}
	function initialize () {
		$this->authorId='';  $this->yayinS=''; $this->atifS=''; $this->hindex=''; $this->dikkat=''; 
		}
	final function sHindex ($said) {
	$this->initialize();
	$yazar=$this->yazarBilgisiAl($said); 
}	
	
	private function yazarBilgisiAl($id) {
	$preText='https://api.elsevier.com/content/author?author_id=';
// https://dev.elsevier.com/sc_author_retrieval_views.html
	$postText='&view=metrics'; // basic, metrics, light, standard, enhanced
	$url = $preText.$id.$postText;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'X-ELS-APIKey: your-API-KEY'));
	$data=curl_exec($ch);
	curl_close($ch);
	$scopusBilgi=(json_decode($data, true));
print_r ($scopusBilgi);
	if ( isset ($scopusBilgi['error-response'])) {
		$this->dikkat = 'siteye bağlanamadı'; // message:Forbidden
		return false;	}
	if ( isset ($scopusBilgi['service-error'])) {
		$this->dikkat = 'siteye bağlanamadı'; //  AUTHORIZATION_ERROR
		return false;	}
	if (!isset($scopusBilgi['author-retrieval-response'][0]['coredata']['dc:identifier'])) { // böyle bir yazar yok 
		$this->dikkat = 'yazar bulunamadı';
		return false;
	}
	$this->authorId=$id;
	if (isset($scopusBilgi['author-retrieval-response'][0]['coredata']['document-count']))
		$this->yayinS=$scopusBilgi['author-retrieval-response'][0]['coredata']['document-count'];
	if (isset($scopusBilgi['author-retrieval-response'][0]['coredata']['cited-by-count']))
		$this->atifS=$scopusBilgi['author-retrieval-response'][0]['coredata']['cited-by-count'];
	if (isset($scopusBilgi['author-retrieval-response'][0]['h-index'])) // enhanced or metrics view
		$this->hindex=$scopusBilgi['author-retrieval-response'][0]['h-index'];
	}
}
