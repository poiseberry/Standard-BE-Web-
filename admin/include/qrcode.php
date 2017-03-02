<?php

class QrCodes
{
var $Size = 150;
var $CorrectionLevel="M";
var $Margin=4;
var $IsImage  = 1;
var $CoddingType = 0;
var $TransparencyLv=0;
var $addres="";
var $Background="FFFFFF";
public $envatoLink="";
public $codding="";
Public Function SelectCodding($codding)
{
  Switch ($codding)
		{
            Case 0:
                $codeText = "UTF-8";
				break;
            Case 1:
                $codeText = "Shift_JIS";
				break;
            Case 2:
              $codeText = "ISO-8859-1";
				break;

        }
return $codeText;
}
Public Function AsImage($text)
{

if ($this->IsImage == 1)
{
 $text = "<img src='" . $text ."'/>";
}

return $text;
}

Public Function CreateBasicAddres()
{
$transparency ="a,s,";
Switch ($this->TransparencyLv)
		{
            Case 0:
                $transparency .= "000000";
				break;
            Case 20:
                $transparency .= "000000CD";
				break;
            Case 40:
              $transparency .= "0000009B";
				break;
			Case 60:
              $transparency .= "00000064";
				break;
				Case 80:
              $transparency .= "00000032";
				break;
			Case 100:
              $transparency .= "00000000";
				break;	
        }

return "http://chart.apis.google.com/chart?chf=".$transparency."|bg,s,".$this->Background."&chs=" . $this->Size . "x". $this->Size ."&chld=".$this->CorrectionLevel."|".$this->Margin."&cht=qr&chl=";
}

Function GetCode($text)
     {   


	$text = $this->CreateBasicAddres() .urlencode($text) . "&choe=" . $this->SelectCodding($this->CoddingType);
    $text=str_replace("%250A", "%0A", $text);
	$text = $this->AsImage($text);
        Return $text;
	}
Function GetMail($email, $subjectMail, $bodyMessage)
{
	$createMail = "MATMSG:TO:" . $email . ";SUB:" . $subjectMail . ";BODY:" . $bodyMessage . ";";
	$createMail = $this->CreateBasicAddres() .urlencode($createMail) . "&choe=" .  $this->SelectCodding($this->CoddingType);
	$createMail=str_replace("%250A", "%0A", $createMail);
	$createMail = $this->AsImage($createMail);
	Return $createMail;
}

Function GetGeo($latitude, $longitude )
{
	$geo = "geo:" . $latitude . "," . $longitude;
	$geo = $this->CreateBasicAddres() .urlencode($geo) . "&choe=" .  $this->SelectCodding($this->CoddingType);
	$geo=str_replace("%250A", "%0A", $geo);
	$geo = $this->AsImage($geo);
	Return $geo;	
}

Function GetSms($phoneNumber, $smsMessage)
{
	$sms  = "smsto:+" . $phoneNumber.":" . $smsMessage;
	$sms = $this->CreateBasicAddres() .urlencode($sms) . "&choe=" .  $this->SelectCodding($this->CoddingType);
	$sms=str_replace("%250A", "%0A", $sms);
	$sms = $this->AsImage($sms);
	Return $sms ;	
}

Function GetMms($phoneNumber, $smsMessage)
{
	$sms  = "mmsto:+" . $phoneNumber.":" . $smsMessage;
	$sms = $this->CreateBasicAddres() .urlencode($sms) . "&choe=" .  $this->SelectCodding($this->CoddingType);
	$sms=str_replace("%250A", "%0A", $sms);
	$sms = $this->AsImage($sms);
	Return $sms ;	
}
Function GetPhone($phoneNumber)
{
	$phone = "tel:+" . $phoneNumber;
	$phone = $this->CreateBasicAddres() .urlencode($phone) . "&choe=" .  $this->SelectCodding($this->CoddingType);
	$phone=str_replace("%250A", "%0A", $phone);
	$phone = $this->AsImage($phone);
	Return $phone ;
}
Function GetBookmark($url, $titleUrl )
{
	$createUrl= "MEBKM:TITLE:" . $titleUrl . ";URL:" . $url. ";";
	$createUrl = $this->CreateBasicAddres() .urlencode($createUrl) . "&choe=" .  $this->SelectCodding($this->CoddingType);
	$createUrl=str_replace("%250A", "%0A", $createUrl);
	$createUrl = $this->AsImage($createUrl);
	Return $createUrl ; 
}
Function GetContact($name, $phone,$url,$emailContact ,$note )
{
	$createContact = "MECARD:N:" . $name . ";TEL:+" . $phone. ";URL:" . $url . ";EMAIL:" . $emailContact . ";NOTE:" . $note . ";";
	$createContact  = $this->CreateBasicAddres() .urlencode($createContact) . "&choe=" .  $this->SelectCodding($this->CoddingType);
	$createContact =str_replace("%250A", "%0A", $createContact );
	$createContact  = $this->AsImage($createContact );
	Return $createContact  ; 
}

Function GetVcard($name,$company,$title,$telWork,$telHome,$email,$url,$note)
{
$vcard="BEGIN:VCARD%0AVERSION:2.1%0AN:".$name."%0AORG:".$company."%0ATITLE:".$title."%0ATEL;WORK;VOICE:".$telWork."%0ATEL;HOME;VOICE:".$telHome;
$vcard.="%0AEMAIL;PREF;INTERNET:".$email."%0AURL:".$url."%0ANOTE:".$note."%0AEND:VCARD";
$vcard  = $this->CreateBasicAddres() .urlencode($vcard) . "&choe=" .  $this->SelectCodding($this->CoddingType);
$vcard =str_replace("%250A", "%0A", $vcard );
$vcard  = $this->AsImage($vcard );

return $vcard;
}

Function WiFi($sid,$password,$encryption)
{
  Switch ($encryption)
		{
            Case 0:
                $encryptionType = "WEP";
				break;
            Case 1:
                $encryptionType = "WPA";
				break;
            Case 2:
              $encryptionType = "nopass";
				break;

        }
	$wifi ="WIFI:S:".$sid.";T:".$encryptionType.";P:".$password.";;";
	$wifi = $this->CreateBasicAddres() .urlencode($wifi) . "&choe=" .  $this->SelectCodding($this->CoddingType);
	$wifi =str_replace("%250A", "%0A", $wifi );
	$wifi  = $this->AsImage($wifi );
	Return $wifi  ; 
}

// ***********************************************Adicional fucntions*/
	function AlexaInfo($domain_name)
{

return $this->GetCode("http://www.alexa.com/siteinfo/".$domain_name);
}

function WhoisInfo($domain_name)
{

return $this->GetCode("http://who.is/whois/".$domain_name);
}

function CompeteInfo($domain_name)
{

return $this->GetCode("http://siteanalytics.compete.com/".$domain_name);
}

function QuantcastInfo($domain_name)
{

return $this->GetCode("http://www.quantcast.com/".$domain_name);
}
function HistatsInfo($domainID)
{
return $this->GetCode("http://www.histats.com/viewstats/?sid=".$domainID);
}

function FacebookInfo($userName)
{
return $this->GetCode("http://facebook.com/".$userName);
}

function TwitterInfo($userName,$typeLink)
{

 Switch ($typeLink)
			{
		 Case 1:
			$twlink=$userName;
            break;
         Case 2:
			$twlink=$userName."/following";
			break;
		 Case 3:
			$twlink=$userName."/followers";
            break;
		 Case 4:
			$twlink=$userName."/favorites";
            break;
        }

return $this->GetCode("http://twitter.com/#!/".$twlink);
}


function EnvatoMarket($selectedMarket)
 {

 Switch ($selectedMarket)
			{
		 Case 1:
			$this->envatoLink="http://activeden.net/";
            break;
         Case 2:
			$this->envatoLink="http://themeforest.net/";
			break;
		 Case 3:
			$this->envatoLink="http://videohive.net/";
            break;
		 Case 4:
			$this->envatoLink="http://graphicriver.net/";
            break;
		Case 5:
			$this->envatoLink="http://3docean.net/";
            break;
		Case 6:
			$this->envatoLink="http://codecanyon.net/";
            break;
		Case 7:
			$this->envatoLink="http://marketplace.tutsplus.com/";
            break;
		Case 8:
			$this->envatoLink="http://photodune.net/";
            break;
			
        }
		
 return $this->envatoLink;
 }
 function EnvatoUser($userName,$selectedMarket)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."user/".$userName);
 }
 function EnvatoEdit($userName,$selectedMarket)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."user/".$userName."/edit");
 }
  function EnvatoDownloads($userName,$selectedMarket)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."user/".$userName."/downloads");
 }
  function EnvatoHistory($userName,$selectedMarket)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."user/".$userName."/invoices");
 }
   function EnvatoWithdrawal($userName,$selectedMarket)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."user/".$userName."/withdrawal");
 }
  function EnvatoEarnings($userName,$selectedMarket)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."user/".$userName."/earnings");
 }
  function EnvatoStatement($userName,$selectedMarket)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."user/".$userName."/statement");
 }
 
   function EnvatoItem($userName,$selectedMarket,$idItem)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."item/a/".$idItem);
 }
   function EnvatoItemFaq($userName,$selectedMarket,$idItem)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."item/a/faq/".$idItem);
 }
    function EnvatoItemComments($userName,$selectedMarket,$idItem)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."item/a/discussion/".$idItem);
 }
 
 function EnvatoItemEdit($userName,$selectedMarket,$idItem)
 {
 return $this->GetCode($this->EnvatoMarket($selectedMarket)."item/a/edit/".$idItem);
 }
 
 function PayPal($buttonID)
 {
 return $this->GetCode("https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=".$buttonID);
 }
 function GplusUser($userID)
{
 return $this->GetCode("https://plus.google.com/".$userID);
}
 function GplusAbout($userID)
{
 return $this->GetCode("https://plus.google.com/".$userID."/about");
} 
 function GplusPhotos($userID)
{
 return $this->GetCode("https://plus.google.com/".$userID."/photos");
} 
 function GplusVideo($userID)
{
 return $this->GetCode("https://plus.google.com/".$userID."/videos");
} 
 function GplusBuzz($userID)
{
 return $this->GetCode("https://plus.google.com/".$userID."/buzz");
} 
function YoutubeVideo($videoID)
{
return $this->GetCode("http://www.youtube.com/watch?v=".$videoID);
}
function YoutubeChannel($userName)
{
return $this->GetCode("http://www.youtube.com/".$userName);
}




}  // end class


?>