<?php

class Email
{
    public static function send($subject = null, $body = null, $to = null)
    {
        $config = include_once(ABSPATH_CONFIG . '/email.php');
        if (empty($config))
            throw new Exception('nao foi definido o arquivo de configuração do email em config/email.php');

        require ABSPATH . 'mailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        // $mail->SMTPDebug = 3;

        $mail->isSMTP();

        $mail->Host = $config['host'];
        $mail->SMTPAuth = $config['smtp_auth'];
        $mail->SMTPSecure = $config['encryption'];
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->Port = $config['port'];

        $mail->From = $config['from']['address'];
        $mail->FromName = $config['from']['name'];

        if ($to == null)
            $mail->addAddress($config['from']['address'], $config['from']['name']); // Add a recipient
        else
            $mail->addAddress($to);
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
           $mail->addCC($config['from']['address']);
        // $mail->addBCC('bcc@example.com');

        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        $mail->isHTML(true);
        $mail->Subject = $subject ? utf8_decode($subject) : 'Titulo';
		$body.="
		<br><br>
		Agradecemos sua atenção<br>
		Cordialmente,<br>
		<strong>Lista Local Fácil</strong>

		";
        $mail->Body = $body ?utf8_decode( $body ): 'This is the HTML message body <b>in bold!</b>';

        $send = $mail->send();
        if (!$send) {
            //erro 404? nao encontrou a página?? clico para enviar email e o response na aba de network me mostra a página de erro 404 ¬¬
            // Response::error(404, array('message' => 'Email não enviado', 'error' => $mail->ErrorInfo));
            Response::json(array('message' => 'Email não enviado', 'error' => $mail->ErrorInfo), 500);
//            echo json_encode(array('message' => 'Email não enviado', 'error' => $mail->ErrorInfo));
//            exit;
            //return '0';
        }
        return $send;
    }
}
