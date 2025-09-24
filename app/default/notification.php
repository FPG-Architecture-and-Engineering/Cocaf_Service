<?php
    class Notification{
        
        public function __construct(){

        }

        public static function sendEmail($to, $subject, $message, $cc=''){

            // $subject = 'PLEASE IGNORE - UAT SERVER TESTING | '.$subject;

            includeLibrary('mail/phpMailer.php');
            includeDefault('configuration');
            $configuration = Configuration::general();

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SetLanguage('en', 'phpmailer/language/');
            $mail->Host = $configuration['MAIL_HOST'];
            $mail->Port = $configuration['MAIL_PORT'];
            $mail->SMTPAuth = false;
            
            if(is_array($to)){
                foreach($to as $to_email){
                    $mail->addAddress($to_email);
                }
            }else{
                $mail->addAddress($to);
            }
            
            if(!empty($cc)){
                if(is_array($cc)){
                    foreach($cc as $cc_email){
                        $mail->AddCC($cc_email);
                    }
                }else{
                    $mail->AddCC($cc);
                }
            }

            $mail->AddBCC('aatienza@fpgins.com');
            $mail->AddBCC('eremoquillo@fpgins.com');
            $mail->AddBCC('ctoribio@fpgins.com');
            $mail->AddBCC('mestive@fpgins.com');
            $mail->AddBCC('jeffreydimla@fpgins.com');
            $mail->Subject = $subject;
            $mail->SetFrom('cocaf.donotreply@fpgins.com', 'COCAF');
            $mail->msgHTML($message);

            if(!$mail->send()){
                $return['status']  = 'failed';
                $return['message'] = 'Encounter sending email error. Mailer Error: '.$mail->ErrorInfo;
            }else{
                $return['status']  = 'success';
                $return['message'] = 'Email sent';
            }

        } 

        public static function template($message){

            includeDefault('configuration');
            $configuration = Configuration::general();

            $template = '   
                <html>
                    <head>
                        <title>'.$configuration['SYSTEM_NAME'].'</title>
                        <meta charset = "utf-8" />
                        <style>
                            html, body, div, span, applet, object, iframe,
                            h1, h2, h3, h4, h5, h6, p, blockquote, pre,
                            a, abbr, acronym, address, big, cite, code,
                            del, dfn, em, img, ins, kbd, q, s, samp,
                            small, strike, strong, sub, sup, tt, var,
                            b, u, i, center,
                            dl, dt, dd, ol, ul, li,
                            fieldset, form, label, legend,
                            table, caption, tbody, tfoot, thead, tr, th, td,
                            article, aside, canvas, details, embed, 
                            figure, figcaption, footer, header, hgroup, 
                            menu, nav, output, ruby, section, summary,
                            time, mark, audio, video {
                                margin: 0;
                                padding: 0;
                                border: 0;
                                font-size: 100%;
                                font: inherit;
                                vertical-align: baseline;
                            }
                            article, aside, details, figcaption, figure, 
                            footer, header, hgroup, menu, nav, section {
                                display: block;
                            }
                            body {
                                margin: 0; 
                                padding: 0; 
                                line-height: 1;
                                background: #f3f3f3; 
                            }
                            ol, ul {
                                list-style: none;
                            }
                            blockquote, q {
                                quotes: none;
                            }
                            blockquote:before, blockquote:after,
                            q:before, q:after {
                                content: "";
                                content: none;
                            }
                            table {
                                border-collapse: collapse;
                                border-spacing: 0;
                                mso-table-lspace:0pt; mso-table-rspace:0pt;
                            } 
                            .block      { margin: 0 auto; width: 600px; font-family: arial; -webkit-text-size-adjust:none; }
                            .logo       { display: inline-block; width: 200px; height: auto; margin-top: 25px; margin-bottom: 40px; }
                            .box        { display: inline-block; width: 100%; margin-top:10px; font-size: 12px; line-height: 20px; color: #333333; word-wrap: break-word; /*border: #afafaf solid 1px; -webkit-border-radius:7px; -moz-border-radius:7px; border-radius:7px;*/ background:#ffffff; }
                            .box div    { padding: 20px; }
                            h1          { display: inline-block; width: 100%; margin: 0; padding:10px 0; font-weight: bold; font-size: 18px; color: #5c666f; }
                            .link-btn   { display:inline-block; margin:5px 0 20px 0; padding:0 15px; /*background:#ff6b00;*/ height:30px; line-height:30px; font-size: 12px; font-weight: bold; color:#ff6b00; text-align:center; text-decoration: underline !important; cursor:pointer; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; }
                            .link-href  { color: #5c666f; text-decoration: none !important; }
                            .link-small { color: #a9a9a9; font-size: 11px; line-height:12px; text-decoration: none !important; }
                            small       { color: #a9a9a9; font-size: 11px; line-height:12px; }
                            a.site      { font-weight: bold; font-size: 13px; color: #5c666f; text-decoration: none !important; }
                            .footer     { display: inline-block; width: 100%; margin: 15px 0 35px 0; text-align:center; font-size: 11px; line-height: 14px; color: #969696; }

                            @media(max-width:650px) {
                                .block  { width: 100% !important; padding: 20px !important; box-sizing: border-box; }
                                .logo   { width: 175px; margin-top: 15px; margin-bottom: 20px; }
                                .footer { margin-bottom: 15px; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="block">
                            <div class="box">
                                <table width="100%" cellpadding="10" bgcolor="#ffffff" style="font-family: arial; -webkit-text-size-adjust:none; font-size: 12px; line-height: 20px; color: #333333; border: #afafaf solid 1px; -webkit-border-radius:7px; -moz-border-radius:7px; border-radius:7px;">
                                    <div>
                                        '.$message.'
                                    </div>
                                </table>
                            </div>
                            <div class="footer">
                                If you require further assistance, e-mail us at <a href="mailto:servicedesk@fpgins.com" target="_blank" class="link-href">servicedesk@fpgins.com</a>
                                <br>
                                Copyright &copy; '.date('Y').'. '.$configuration['SYSTEM_ALIAS'].' '.$configuration['SYSTEM_VERSION'].' 
                                <br>
                                <a href="'.openWithChromeUrl().'" target="_blank" class="link-href">www.ph-cocaf.fpgins.com</a>
                            </div>
                        </div>
                    </body>
                </html>
            ';      
        
            return $template;

        }

        public static function transaction($request, $response){

            $request_details = '
                <strong>Transaction ID:</strong>'.htmlDecode($request['transaction_id']).'
                <br>
                <strong>Transaction Type:</strong>'.htmlDecode($request['transaction_type']).'
                <br>
            ';

            if ($request['transaction_type'] != 'VERIFY') {

                $request_details .= '
                    <strong>Application:</strong>'.htmlDecode($request['app']).'
                    <br>
                    <strong>Registration Type:</strong>'.htmlDecode($request['coc_no']).'
                    <br>
                ';

                if ($request['transaction_type'] != 'RENEWAL') {

                    $request_details .= '
                        <strong>Plate No.:</strong>'.htmlDecode($request['plate_no']).'
                        <br>
                        <strong>MV File No.:</strong>'.htmlDecode($request['mv_file_no']).'
                        <br>
                    ';

                }

                if ($request['transaction_type'] != 'NEW') {

                    $request_details .= '
                        <strong>Engine No.:</strong>'.htmlDecode($request['engine_no']).'
                        <br>
                        <strong>Chassis No.:</strong>'.htmlDecode($request['chassis_no']).'
                        <br>
                    ';

                }

                $request_details .= '
                    <strong>COC No.:</strong>'.htmlDecode($request['coc_no']).'
                    <br>
                    <strong>Tax Type:</strong>'.htmlDecode($request['tax_type']).'
                    <br>
                    <strong>MV Type:</strong>'.htmlDecode($request['mv_type']).'
                    <br>
                    <strong>MV Premium Type:</strong>'.htmlDecode($request['mv_prem_type']).'
                    <br>
                    <strong>Inception Date:</strong>'.htmlDecode($request['inception_date']).'
                    <br>
                    <strong>Expiry Date:</strong>'.htmlDecode($request['expiry_date']).'
                    <br>
                    <strong>Assured Name:</strong>'.htmlDecode($request['assured_name']).'
                    <br>
                    <strong>Assured TIN:</strong>'.htmlDecode($request['assured_tin']).'
                    <br>
                    <strong>Created By:</strong>'.htmlDecode($request['created_name']).'
                    <br>
                    <strong>Created Date:</strong>'.htmlDecode($request['created_when']).'
                ';

            } else {

                $request_details .= '
                    <strong>Application:</strong>'.htmlDecode($request['app']).'
                    <br>
                    <strong>COC No.:</strong>'.htmlDecode($request['coc_no']).'
                ';

            }

            if ($response['status'] == 'success' && $response['transaction_type'] == 'VERIFY') {

                $response_details = '
                    <strong>Status:</strong>'.ucwords($response['status']).'
                    <br>
                    <strong>Message:</strong>COC Verification Successful!
                    <br>
                ';

            } elseif ($response['status'] == 'success') {

                $response_details = '
                    <strong>Status:</strong>'.ucwords($response['status']).'
                    <br>
                    <strong>Message:</strong>'.htmlDecode($response['success_message']).'
                    <br>
                ';

            } else {

                $response_details = '
                    <strong>Status:</strong>'.ucwords($response['status']).'
                    <br>
                    <strong>Message:</strong>'.htmlDecode($response['error_message']).'
                    <br>
                ';

            }

            if ($response['status'] == 'success') {

                if ($response['transaction_type'] == 'NEW') {

                    $response_details .= '
                        <strong>Authentication No.:</strong>'.htmlDecode($response['auth_no']).'
                        <br>
                        <strong>COC No.:</strong>'.htmlDecode($response['coc_no']).'
                        <br>
                        <strong>Premium Type:</strong>'.htmlDecode($response['premium_type']).'
                    ';

                } elseif ($response['transaction_type'] == 'RENEWAL') {

                    $response_details .= '
                        <strong>Authentication No.:</strong>'.htmlDecode($response['auth_no']).'
                        <br>
                        <strong>COC No.:</strong>'.htmlDecode($response['coc_no']).'
                        <br>
                        <strong>Plate No.:</strong>'.htmlDecode($response['plate_no']).'
                        <br>
                        <strong>Premium Type:</strong>'.htmlDecode($response['premium_type']).'
                    ';

                } elseif ($response['transaction_type'] == 'VERIFY') {

                    $response_details .= '
                        <strong>Authentication No.:</strong>'.htmlDecode($response['auth_no']).'
                        <br>
                        <strong>Authentication Type:</strong>'.htmlDecode($response['auth_type']).'
                        <br>
                        <strong>Authentication Date:</strong>'.htmlDecode($response['auth_date']).'
                        <br>
                        <strong>COC Statu:</strong>'.htmlDecode($response['coc_status']).'
                        <br>
                        <strong>COC No.:</strong>'.htmlDecode($response['coc_no']).'
                        <br>
                        <strong>Organization ID:</strong>'.htmlDecode($response['org_id']).'
                        <br>
                        <strong>Plate No.:</strong>'.htmlDecode($response['plate_no']).'
                        <br>
                        <strong>MV File No.:</strong>'.htmlDecode($response['mv_file_no']).'
                        <br>
                        <strong>Engine No.:</strong>'.htmlDecode($response['engine_no']).'
                        <br>
                        <strong>Chassis No.:</strong>'.htmlDecode($response['chassis_no']).'
                        <br>
                        <strong>Vehicle Type:</strong>'.htmlDecode($response['vehicle_type']).'
                        <br>
                        <strong>Tax Type:</strong>'.htmlDecode($response['tax_type']).'
                        <br>
                        <strong>MV Type:</strong>'.htmlDecode($response['mv_type']).'
                        <br>
                        <strong>Premium Type:</strong>'.htmlDecode($response['premium_type']).'
                        <br>
                        <strong>Inception Date:</strong>'.htmlDecode($response['inception_date']).'
                        <br>
                        <strong>Expiry Date:</strong>'.htmlDecode($response['expiry_date']).'
                        <br>
                        <strong>Registration Type:</strong>'.htmlDecode($response['reg_type']).'
                        <br>
                        <strong>LTO Verification Code:</strong>'.htmlDecode($response['lto_verification_code']).'
                        <br>
                        <strong>Username:</strong>'.htmlDecode($response['username']).'
                        <br>
                        <strong>Created Date:</strong>'.htmlDecode($response['created_when']).'
                    ';

                }

            }

            $message = '
                <p>
                    Dear Valued Client,
                    <br>
                    <br>
                    <strong>COCAF Request:</strong>
                    <br>
                    '.$request_details.'
                    <br>
                    <br>
                    <strong>COCAF Respnse:</strong>
                    <br>
                    '.$response_details.'
                </p>
            ';

            return self::template($message);

        }

    }
?>
