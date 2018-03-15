<?php

//Função de validar email
function validateEmail($email)
{
    // verifica se campo é string
    if( ! is_string($email) ):
        return false;
    endif;
    
    //string padrao de email
    $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
   
    //retorna verificacao
    return preg_match($pattern, $email);
}

//função Recaptcha Google
function verifyRecapctha($captcha){
    
    if( ! is_string($captcha) || empty($captcha) ){
        return FALSE;        
    }
    
    //parametros a enviar
    $varJSON = json_encode(array(
        'secret'    => '6LfX8xsUAAAAAPIjMlQwo8_Gha-4AacQwwl5Xsjt',
        'response'  => $captcha
    ));
    
    //headers para requisição
    $headers = array(
        'ContentType'   => 'application/json',
        'Accept'        => 'accept:application/json'
    );
    
    //url para verificar 
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    
    //inicializa curl
    $c = curl_init();
    
    //setup de headers
    curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
    
    //setup de url
    curl_setopt($c, CURLOPT_URL, $url);
    
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    
    //setup de metodo http
    curl_setopt($c, CURLOPT_POST, true);
    
    //setup de variaveis
    curl_setopt($c, CURLOPT_POSTFIELDS, $varJSON);
    
    //Faz requisição e retorna resultado
    $response = curl_exec($c);
    
    //Fecha a conexão
    curl_close($c);
    
    return $response;
}

//Verifica array procurando email
if(  count($_POST) < 0 || $_SERVER['REQUEST_METHOD'] != 'POST'):
    return;
else:
    
    //Se email estiver vazio, para função
    if(empty($_POST['msg']['email'])):        
    ?>
        <script>
            alert("O formulário não pode ser enviado. [Ocorreu um erro ao enviar email, contate o administrador do site.].");
        </script>
    <?php    
       return; 
    endif;
    
    /* ======================================
     * Composição de Email e Envio */
    
    //Carregando PHPMailer
    require_once("phpmailer/class.phpmailer.php");
    require_once("phpmailer/class.smtp.php");

    $referer = $_SERVER['HTTP_REFERER'];
    
    //Com valores de SMTP
    $smtp = array(
        'host'          => 'email-ssl.com.br',
        'port'          => 465,
        'smtpAuth'      => true,
        'smtpSecure'    => 'ssl',
        'username'      => 'contato@spacorado.com.br',
        'password'      => 'spacorado453',
        'fromEmail'     => 'contato@spacorado.com.br',
        'fromName'      => 'Contato Site - Spaço Radô',
        'emailTo'       => array( 0 => array('email' => 'malu@spacorado.com.br', 'name' => 'Malu Radomille')),
        'emailCC'       => array( 0 => array('email' => 'contato@spacorado.com.br', 'name' => 'Contato')),
        'html'          => true,
        'charset'       => 'utf-8',
        'subject'       => ( isset($_POST['formName']) ) ? $_POST['formName'] : "Contato Site - Spaço Radô",
        'maxFileSize'   => ( isset($_POST['filesize']) ) ? $_POST['filesize'] * 1024 : 1024000,
        'fileType'      => array('image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/msword')
    );
    
    // Inicia a classe PHPMailer
    $mail = new PHPMailer();
    $mail->IsSMTP(); // Define que a mensagem será SMTP
    $mail->Host = $smtp['host'];
    $mail->Port = $smtp['port'];
    $mail->SMTPAuth = $smtp['smtpAuth']; // Usa autenticação SMTP? (opcional)
    $mail->SMTPSecure = $smtp['smtpSecure'];   
    $mail->Username = $smtp['username']; // Usuário do servidor SMTP, PODE SER QUALQUER E-MAIL DA HOSPEDAGEM
    $mail->Password = $smtp['password']; // Senha do servidor SMTP, SENHA DO EMAIL
    $mail->From = $smtp['fromEmail']; // Seu e-mail
    $mail->FromName = $smtp['fromName']; // Seu e-mail
    
    //percorre array preenchendo com emails
    foreach ($smtp['emailTo'] as $key => $value) {
        $mail->AddAddress($value['email'], $value['name']); //Aqui vai o E-mail que recebe as Mensagens!
    }
    
    //percorre array preenchendo com emails
    foreach ($smtp['emailCC'] as $key => $value) {
        $mail->AddCC($value['email'], $value['name']); //Aqui vai o E-mail que recebe as Mensagens!
    }
    
    $mail->IsHTML($smtp['html']); // Define que o e-mail será enviado como HTML
    $mail->CharSet = $smtp['charset']; // Charset da mensagem (opcional)
    $mail->Subject  = $smtp['subject'] ; // Assunto da mensagem
    $max_filesize = $smtp['maxFileSize'];

    //Inicio do corpo de email
    $mail->Body = "<html lang='pt'>
                   <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                   <meta name='Generator' content='Microsoft Word 15 (filtered medium)'>
                    <!--[if !mso]><style>v\:* {behavior:url(#default#VML);}
                    o\:* {behavior:url(#default#VML);}
                    w\:* {behavior:url(#default#VML);}
                    .shape {behavior:url(#default#VML);}
                    </style>
                    <![endif]-->
                    <style>
                    table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
                    <!--/* Font Definitions */
                    @font-face
                            {font-family:'Cambria Math';
                            panose-1:2 4 5 3 5 4 6 3 2 4;}
                    @font-face
                            {font-family:Calibri;
                            panose-1:2 15 5 2 2 2 4 3 2 4;}
                    @font-face
                            {font-family:Verdana;
                            panose-1:2 11 6 4 3 5 4 4 2 4;}
                    @font-face
                            {font-family:Tahoma;
                            panose-1:2 11 6 4 3 5 4 4 2 4;}
                    /* Style Definitions */
                    p.MsoNormal, li.MsoNormal, div.MsoNormal
                            {margin:0cm;
                            margin-bottom:.0001pt;
                            font-size:11.0pt;
                            font-family:'Calibri',sans-serif;}
                    a:link, span.MsoHyperlink
                            {mso-style-priority:99;
                            color:blue;
                            text-decoration:underline;}
                    a:visited, span.MsoHyperlinkFollowed
                            {mso-style-priority:99;
                            color:purple;
                            text-decoration:underline;}
                    p.msonormal0, li.msonormal0, div.msonormal0
                            {mso-style-name:msonormal;
                            mso-margin-top-alt:auto;
                            margin-right:0cm;
                            mso-margin-bottom-alt:auto;
                            margin-left:0cm;
                            font-size:11.0pt;
                            font-family:'Calibri',sans-serif;}
                    span.EstiloDeEmail18
                            {mso-style-type:personal;
                            font-family:'Calibri',sans-serif;
                            color:windowtext;}
                    span.EstiloDeEmail22
                            {mso-style-type:personal-reply;
                            font-family:'Calibri',sans-serif;
                            color:windowtext;}
                    .MsoChpDefault
                            {mso-style-type:export-only;
                            font-size:10.0pt;}
                    @page WordSection1
                            {size:612.0pt 792.0pt;
                            margin:70.85pt 3.0cm 70.85pt 3.0cm;}
                    div.WordSection1
                            {page:WordSection1;}
                    --></style><!--[if gte mso 9]><xml>
                    <o:shapedefaults v:ext='edit' spidmax='1026' />
                    </xml><![endif]--><!--[if gte mso 9]><xml>
                    <o:shapelayout v:ext='edit'>
                    <o:idmap v:ext='edit' data='1' />
                    </o:shapelayout></xml><![endif]-->
                    <body>";
    
    require_once "email-templates.php"; //carrega arquivo de templates
    
    //Verifica o formulário enviado e assimala o padrão html para cada
    switch ($_POST['formName']) {
        case 'Contato':
            $mail->Body .= emailTemplate($_POST);
            break;        
        default:
            $mail->Body .= emailTemplate($_POST);
            break;
    }
    
    //Fechando corpo de email
    $mail->Body .= "</td></tr></table></body></html>";
    
    //Verifica se há arquivo anexado e faz validação
    if( isset($_FILES) && count($_FILES) > 0):
        foreach($_FILES as $key => $value):
            if ( $value['size'] < $smtp['maxFileSize'] && array_search($value['type'], $smtp['fileType']) ) {
                $mail->AddAttachment($value['tmp_name'], $value['name']);
            }
        endforeach;
    endif;


    //Enviando
    $enviado = $mail->Send();
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    if($enviado):
    ?>    
        <script>
            //Registrando conversão de meta
            var eventMeta = function(){
                    ga('send', {
                        hitType: 'event', 
                        eventCategory: 'Lead', 
                        eventAction: 'Envio de Formulário', 
                        eventLabel: 'Contato', 
                        eventValue: 2});
            };                
            alert("Sua mensagem foi enviada com sucesso. Em breve entraremos em contato.");
        </script>        
    <?php
    else:   
        //Registrando o erro PHP
        $logFile = fopen('log.txt', 'w+', true);
        $write = ( $logFile ) ? file_put_contents('log.txt', $mail->ErrorInfo, FILE_APPEND ) : false;
        fclose($logFile); //Fechando arquivo
    ?>
        <script>
            alert("O formulário não pode ser enviado. [Ocorreu um erro ao enviar email , contate o administrador do site.].");
        </script>
    <?php
    endif;
    
endif;

?>
  
