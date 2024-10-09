<?php
/**
 * Class Elementor_Form_Email_Attachments
 *
 * Send custom file as attachments to email in Elementor Pro forms
 */
class Elementor_Form_Email_Attachments {
    
    public function __construct() {
        add_action( 'elementor_pro/forms/process', [ $this, 'init_form_email_attachments' ], 11, 2 );
    }

    public function init_form_email_attachments(  $record,  $ajax_handler ) {
        add_filter( 'wp_mail', [ $this, 'wp_mail_attachments' ] );
    }

    

    public function wp_mail_attachments( $args ) {
        //error_log('EMAIL MESSAGE: '.$args['message']);
        if ( strpos($args['message'], '[elementor_form_attachment') == true ) {
            $str = $args['message'];
            $start = '[elementor_form_attachment id=';
            $end = ']';
            $pattern = sprintf('/%s(.+?)%s/ims',
    preg_quote($start, '/'), preg_quote($end, '/')
        );

if (preg_match($pattern, $str, $matches)) {
    list(, $match) = $matches;
    $match = str_replace('"', "", $match);
    $match =  str_replace("'", "", $match);
    //echo $match;
}
        //error_log('ATTACHED ID '.$match);
        $attachedFile[] = get_attached_file( (int)$match );
        //error_log('ATTACHED FILE PATH '.json_encode($attachedFile));
     
            $args['attachments'] = $attachedFile;
            
            
            $startR = '[elementor_form_attachment id=';
            $endR = ']';
            $patternR = sprintf('/%s(.+?)%s/ims',
    preg_quote($startR, '/'), preg_quote($endR, '/')
        );

        if (preg_match($patternR, $str, $matchesR)) {
    list(, $matchR) = $matchesR;
          // $match = str_replace('"', "", $match);
         // $match =  str_replace("'", "", $match);
   
        }
       
$matchR = "[elementor_form_attachment id=".$matchR."]";
//error_log('TO BE REMOVE: '.$matchR);
            $args['message'] = str_replace($matchR, '', $args['message']);
            
            //error_log('EMAIL MESSAGE CONDITION: '.$args['message']);
        } 
        return $args;
    }
}
new Elementor_Form_Email_Attachments();
