
<?php

//Nacitanie premennych z ajaxu
$name = $_POST['meno'];
$mail = $_POST['mail'];
$secret="6LfvkcIUAAAAAOkBgO-Fv1uMb1UQ2Dts0OUuheSp";
$response=$_POST['text'];
$sprava =$_POST['sprava'];

//nacitanie nepovinneho cisla ak je prazdne napise do mailu ze
//nezadal telc
if($_POST['telc']){
    $telc = $_POST['telc'];
}else{
    $telc = "Nezedal tel c";
}
//echo "tel c " . $telc;
if($telc != "Nezedal tel c"){
   // echo gettype($telc);
    if($telc[0] != '0'){
        echo "na zaciatku nie je nula";
        die();
    }
    if(strlen($telc) != 10){
        echo "cislo je zadane v zlom formate a ma zlu dlzku";
        die();
    }

}
//kontrola white spaces v maily
if (preg_match( "/[\r\n]/", $mail ) ) {
    echo "medzera v maily nie";
    die();
}

if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    echo "mail nie je valid";
    die();
}

//controla reCaptchy
$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
    
    $captcha_success=json_decode($verify);
    
    //ak nie je platna vrati nie
    if ($captcha_success->success==false) {
     echo "captcha nie";
     die();
    }
    
    //ak je captcha platna pokracuje dalej
    else if ($captcha_success->success==true) {


        //kontrola prazdnych povinnych poli, ak su prazdne vrati nie
if(empty($name) || empty($mail) || empty($sprava)){
    echo "prazdne nie";
    die();
}
//ak ano vytvori sa text pre info@werise.dev
else{
       $text = '';
       $text .= 'Meno: '. $name . "<br>";
       $text .= 'Mail: '. $mail. "<br>";
       $text .= 'Telefon: '. $telc . "<br>";
       $text .= 'Sprava: '. $sprava;
    
$to = $mail; 
$from = 'info@werise.dev'; 
$fromName = 'WeRise'; 
 
$subject = "info"; 
 

//nacitanie html sablony emailu
$htmlContent = file_get_contents('mail_template.php');
 
// Set content-type header for sending HTML email 
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
 
// Additional headers 
$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
$headers .= 'Cc: welcome@example.com' . "\r\n"; 
$headers .= 'Bcc: welcome2@example.com' . "\r\n"; 
$header = "From: info@werise.dev" . "\r\n";
$header .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// Send email 
if(mail($to, $subject, $htmlContent, $headers)&&mail("info@werise.dev", $subject, $text, $header)){ 
    echo "ano"; 
}else{ 
   echo "neposlalo mail nie"; 
}


}
}
