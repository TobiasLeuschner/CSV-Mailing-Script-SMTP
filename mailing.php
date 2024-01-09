<?php
require_once('config.php');
// PHPMailer einbinden
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Funktion zum Senden einer E-Mail
function send_email($to, $subject, $message) {

    $mail = new PHPMailer(true);
    try {
        $mail->setFrom('deine_email@example.com', 'Dein Name'); // Absender
        $mail->addAddress($to); // Empfänger
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Fehler beim Senden der E-Mail: {$mail->ErrorInfo}";
        return false;
    }
}

// Dateipfad zur CSV-Datei
$csv_file = 'deine_datei.csv'; // Passe den Dateinamen an
$used_csv_file = 'verwendete_emails.csv'; // Datei für abgeschlossene E-Mails
$emails = [];

// CSV-Datei lesen und E-Mails in ein Array speichern
if (($handle = fopen($csv_file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $emails = array_merge($emails, $data); // Annahme: Alle E-Mails stehen in einer Spalte
    }
    fclose($handle);
}

// Überprüfe, ob die Datei für abgeschlossene E-Mails existiert, falls nicht, erstelle sie
if (!file_exists($used_csv_file)) {
    $handle = fopen($used_csv_file, 'w');
    fclose($handle);
}

// Deine E-Mail-Informationen
$message = 'Hier ist deine vorgefertigte Nachricht.'; // Passe deine Nachricht an

// Sende 10 E-Mails, falls verfügbar
$emailsToSend = array_splice($emails, 0, 10); // Die ersten 10 E-Mails auswählen

foreach ($emailsToSend as $receiver_email) {
    $subject = 'Dein Betreff'; // Passe den Betreff an
    send_email($receiver_email, $subject, $message);
    sleep(2); // 2 Sekunden Pause zwischen den E-Mails, um das Senden zu simulieren
    // Füge die verwendete E-Mail der Datei für abgeschlossene E-Mails hinzu
    $handle = fopen($used_csv_file, 'a');
    fputcsv($handle, [$receiver_email]);
    fclose($handle);
}

// Aktualisierte E-Mail-Liste in die CSV-Datei zurückschreiben
$handle = fopen($csv_file, 'w');
foreach ($emails as $row) {
    fputcsv($handle, [$row]);
}
fclose($handle);
?>
