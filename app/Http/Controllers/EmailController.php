<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailController extends Controller
{
    //
    public static function general($emailData){
        view()->share(compact('emailData'));
        $mail = new PHPMailer(true);
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;               // Enable verbose debug output
            $mail->DEBUG_OFF = SMTP::DEBUG_SERVER;                  // Enable verbose debug output
            $mail->isSMTP();                                        // Send using SMTP
            $mail->Host       = env('MAIL_HOST');                   // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                               // Enable SMTP authentication
            $mail->Username   = env('MAIL_USERNAME');               // SMTP username
            $mail->Password   = env('MAIL_PASSWORD');               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            //
            //Recipients
            $mail->setFrom(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
            $mail->addAddress($emailData['email']);                              // Add a recipient
            $mail->addReplyTo(env('MAIL_FROM_ADDRESS'), 'Lixnet Payroll');
            // $mail->addBCC('bcc@example.com');
            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            // Content
            $mail->isHTML(true);                                     // Set email format to HTML
            $mail->Subject = 'Payroll';
            $mail->Body    = view('mail.index')->render();
            // $mail->AltBody = strip_tags($message);
            $mail->send();
            EmailController::updateMail($emailData['id']);
        }
        catch (Exception $e){
            $message="Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            dd($message);
            EmailController::notifyAdmin($message);
        }
    }
    //Send
    public function sendEmail(){
        ini_set('max_execution_time',600);
        $emailList = Email::where('organization_id',Auth::user()->organization_id)->where('status',0)->paginate(16);

        if (count($emailList)>0){
            foreach ($emailList  as $email){
                $emailData = [
                    'id'=>$email['id'],
                    'email'=>$email->employee->email_office,
                ];
                if ($emailData){
//                    $users = User::first();
//                    $details = [
//                        'data'=>'Queued Emails Send'
//                    ];
//                    $users->notify(new UserNotification($details));
//                    dd($emailData);
                    EmailController::general($emailData);
                }
                else
                {
                    toast('No Emails Remaining in Queue','info','top-right');
                }
            }
        }
    }
    //
    public static function updateMail($id){
        $update = Email::where('organization_id',Auth::user()->organization_id)->where('status',false)->find($id);
        $update->status  = 1;
        $update->push();
        return $update;
    }
    public static function notifyAdmin($message){
        $to = 'nelson.saammy@gmail.com';
        $from = 'support@lixnet.net';
        $subject = 'System Failure';

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Compose a simple HTML email message
        $data = '<html><body>';
        $data .= '<p>Hello Mr Nelson Sammy,</p>';
        $data .= '<p>I hope this email find you well.
                     I have encountered the following error during my normal operations</p>';
        $data .= '<p>'.$message.'</p>';
        $data .= '<p>Kindly check it out and thank you in advance</p>';
        $data .= '<p>Sincerely Home Autism  System </p>';
        $data .= '</body></html>';

        // Sending email
        if(mail($to, $subject, $data, $headers)){
             echo 'Your mail has been sent successfully.';
        } else{
             echo 'Unable to send email. Please try again.';
        }
    }
}
