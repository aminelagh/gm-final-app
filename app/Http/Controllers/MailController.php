<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function send()
    {
        $data = [
            'a' => 'aaaaa',
            'b' => 'bbbbb',
            'c' => 'ccccc',
            'd' => 'ddddd',
            'e' => 'eeeee',
            'f' => 'fffff'
            ];
        try{
            Mail::send(['html'=>'emails.promotion'], $data, function($message){
                $message->subject('GolfMaroc');
                $message->from('amine.laghlabi@gmail.com','emetteur');
                $message->to('amine.laghlabi@e-polytechnique.ma','Mr P');
                $message->to('amine.laghlabi@gmail.com','Mr A');
                $message->to('amine.l56@hotmail.com','Mr AL56');
                $message->to('amine.laghlabi@hotmail.com','Mr AL');
                //$message->attach('‪C:\Users\Amine\Desktop\Modification.txt');
                //$message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
            });
            echo "done";
        }
        catch (\Exception $e){ echo "error<hr>";dump($e->getMessage());}
    }



}
