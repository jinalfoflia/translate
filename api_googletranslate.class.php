<?
class GoogleTranslateApi{

	var $BaseUrl = 'http://ajax.googleapis.com/ajax/services/language/translate';
	var $FromLang = 'sv';
	var $ToLang = 'en';
	var $Version = '1.0';
	
	var $CallUrl;
	
	var $Text = 'Hej v�rlden!';
	
	var $TranslatedText;
	var $DebugMsg;
	var $DebugStatus;
	
	function GoogleTranslateApi(){
		$this->CallUrl = $this->BaseUrl . "?v=" . $this->Version . "&q=" . urlencode($this->Text) . "&langpair=" . $this->FromLang . "%7C" . $this->ToLang;
	}
	
	function makeCallUrl(){
		$this->CallUrl = $this->BaseUrl . "?v=" . $this->Version . "&q=" . urlencode($this->Text) . "&langpair=" . $this->FromLang . "%7C" . $this->ToLang;
	}
	
	function translate($text = ''){
		if($text != ''){
			$this->Text = $text;
		}
		$this->makeCallUrl();
		if($this->Text != '' && $this->CallUrl != ''){
			$handle = fopen($this->CallUrl, "rb");
			$contents = '';
			while (!feof($handle)) {
			$contents .= fread($handle, 8192);
			}
			fclose($handle);
			
			$json = json_decode($contents, true);
			
			if($json['responseStatus'] == 200){ //If request was ok
				$this->TranslatedText = $json['responseData']['translatedText'];
				$this->DebugMsg = $json['responseDetails'];
				$this->DebugStatus = $json['responseStatus'];
				return $this->TranslatedText;
			} else { //Return some errors
				return false;
				$this->DebugMsg = $json['responseDetails'];
				$this->DebugStatus = $json['responseStatus'];
			}
		} else {
			return false;
		}
	}
}
?>
