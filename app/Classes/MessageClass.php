<?php

namespace App\Classes;

class MessageClass
{
    public function sendEmail($email, $data , $template)
    {
       
        $title = $data['title'];
        \Mail::send($template, compact('data'), function ($messages) use ($title, $email) {
            $messages->from(@config('mail.mailers.smtp.username'), $title);
            $messages->to($email)->subject($title);
        });
    
        
    }

}
