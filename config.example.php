$mail->isSMTP();
$mail->Host       = 'smtp.example.com'; // SMTP-Host eintragen
$mail->SMTPAuth   = true;
$mail->Username   = 'deine_email@example.com'; // SMTP-Benutzername eintragen
$mail->Password   = 'dein_passwort'; // SMTP-Passwort eintragen
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587; // Port entsprechend konfigurieren
