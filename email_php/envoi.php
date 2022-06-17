<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require "PHPMailer.php";
require "SMTP.php";
require "Exception.php";

$servername = "localhost";
$username = "root";#"boba6866_CTO";
$password = "";#"Qe+x?QH2Ww?7";
$database = "contact";#"boba6866_taxi93";
$name = $_POST['name'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$depart = $_POST['depart'];
$arriver = $_POST['arriver'];
$type = $_POST['type'];
$heure = $_POST['heure'];
$nb_personne = $_POST['nb_personne'];
$bagage = $_POST['bagage'];
$autre = $_POST['autre'];

try {
    $co = new PDO('mysql:host='.$servername.';dbname='.$database,$username, $password);
    $stmt = $co->prepare( "INSERT INTO `taxi` (`name`, `telephone`, `email`, `depart`, `arriver`, `type`, `heure`, `nb_personne`, `autres`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array(
        $name,
        $email,
        $telephone,
        $depart,
        $arriver,
        $type,
        $heure,
        $nb_personne,
        $autre
    ));

    //Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    //SMTP::DEBUG_OFF = off (for production use)
    //SMTP::DEBUG_CLIENT = client messages
    //SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    //Use `$mail->Host = gethostbyname('smtp.gmail.com');`
    //if your network does not support SMTP over IPv6,
    //though this may cause issues with TLS

    //Set the SMTP port number:
    // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
    // - 587 for SMTP+STARTTLS
    $mail->Port = 465;

    //Set the encryption mechanism to use:
    // - SMTPS (implicit TLS on port 465) or
    // - STARTTLS (explicit TLS on port 587)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "taxi93conventionne@gmail.com";
    $mail->Password = "dndaamdsksjznbdz";
    //Set who the message is to be sent from
    //Note that with gmail you can only use your account address (same as `Username`)
    //or predefined aliases that you have configured within your account.
    //Do not use user-submitted addresses in here
    $mail->setFrom('taxi93conventionne@gmail.com', 'Taxi');

    //Set who the message is to be sent to
    $mail->addAddress('taxi93conventionne@gmail.com', 'Taxi');

    $mail->AltBody = 'Nouveau client';
    $mail->Body = 'Votre client'.'<br/>'.$name.'<br/>'.$email.'<br/>'.$telephone.'<br/>'.$depart.'<br/>'.$arriver.'<br/>'.$type.'<br/>'.$heure.'<br/>'.$nb_personne.'<br/>'.$autre. ".";

    //Set the subject line
    $mail->Subject = 'Nouvelle demande';

    //send the message, check for errors
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message sent!';
        header('Location: http://taxi-idf93.fr/');
        //Section 2: IMAP
        //Uncomment these to save your message in the 'Sent Mail' folder.
        #if (save_mail($mail)) {
        #    echo "Message saved!";
        #}
    }

} catch (Exception $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}


?>