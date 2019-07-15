<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Actions extends CI_Controller
{

    function index() {
        if (isset($_POST['load'])){
            $data = array();
            $page = $_POST['page'];
//            $this->check_sess->check();
            $data['robot'] = '';
//            if ($this->agent->is_robot()){
//                $data['robot'] = 'robot';
//            }
//            if (isset($_POST['lang'])){
//                $cookie_lang = $_POST['lang'];
//            } else {
//                $cookie_lang = $this->input->cookie('lang');
//            }
//            $this->lang->load($page,$cookie_lang);
//            $this->lang->load('main_content', $cookie_lang);
            $data['page'] = $page;
//            $data['lang'] = $cookie_lang;
            if ($page!=''){
//                $page_cache = $page."_".$cookie_lang;
//                if (isset($_SESSION[$page_cache]) and $_SESSION[$page_cache]!=''){
//                    echo $_SESSION[$page_cache];
//                    $this->load->view('pages/end_loaded_js.php',$data);
//                } else {
//                    die($set_cookie);
                $this->lib_view->subload($page,$data);
//                    $cache_content = $this->load->view('pages/'.$page,$data,true);
//                    $_SESSION[$page_cache] = $cache_content;
//                }
            }
        }
    }

    function order() {
        if (isset($_POST['phone'])){
            $phone = $_POST['phone'];

            $name = '';
            $mail = '';

            if (isset($_POST['name']) and $_POST['name']!=''){
                $name = $_POST['name'];
            }

            if (isset($_POST['email']) and $_POST['email']!=''){
                $mail = $_POST['email'];
            }

            $order_data = array(
                'cname'     => $name,
                'cphone'    => $phone,
                'cemail'    => $mail,
                'order_time'=> time(),
                'cstatus'   => 'created'
            );

            $this->db->insert('orders',$order_data);


            $message_to_user = '<html>
                    <head>
                      <title>New order from website</title>
                    </head>
                    <body>
                      <div style="border: 2px solid rgb(0,120,120);background-color: hsl(0,0%,15%);width: calc(100% - 4px);max-width: 600px;text-align: center;">
                        <p><img src="https://neydel.com/img/main_logo.png" style="width: 250px"/></p>
                        <p style="color: hsl(0,0%,85%);font-size: 18px;">Здравствуйте '.$name.'. Благодарим за ваш заказ!</p>
                      </div>
                      <div style="width: calc(100% - 4px);max-width: 604px; padding-top: 1em">
                        <a href="https://neydel.com" style="width: 200px; height: 50px; color: white; background: rgb(0,120,120); box-shadow: 1px 1px 5px black; text-decoration: none; padding: 1em; margin: 2em">
                            Перейти на сайт
                        </a>
                        <p style="font-size: 25px">
                            Для внесения предложений по усовершествованию сообщите на mail:
                        </p>
                        <a href="mailto:info@neydel.com">
                            info@neydel.com
                        </a>
                        <p style="font-size: 25px">
                            Есть проблемы с сайтом:
                        </p>
                        <a href="mailto:support@neydel.com">
                            support@neydel.com
                        </a>
                        <p style="font-size: 25px">
                            Связь с администрацией:
                        </p>
                        <a href="mailto:yevhen@neydel.com">
                            yevhen@neydel.com
                        </a>
                        <br>
                        <a href="tel:+380979294547">
                            +380979294547
                        </a>
                      </div>
                    </body>
                    </html>';

            $to_us     = $mail;
            $subject_us = 'Neydel.com';
            $headers_us  = 'MIME-Version: 1.0' . "\r\n";
            $headers_us .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers_us .= 'From: info@neydel.com' . "\r\n" .
                'Reply-To: yevhen@neydel.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion()."\r\n";

            $m_us = mail($to_us, $subject_us, $message_to_user, $headers_us);
            if ($m_us){

            }
            $message = '<html>
                    <head>
                      <title>New order from website</title>
                    </head>
                    <body>
                      <div style="border: 2px solid rgb(0,120,120);background-color: hsl(0,0%,15%);width: calc(100% - 4px);max-width: 600px;text-align: center;">
                        <p><img src="https://neydel.com/img/main_logo.png" style="width: 250px"/></p>
                        <p style="color: hsl(0,0%,85%);font-size: 18px;">Hello Yevhen, you have new order from site</p>
                      </div>
                      <table style="border: 1px solid hsl(0,0%,85%);width: 100%;max-width: 604px;text-align: center;">
                        <tr>
                          <th>Phone</th><th>Name</th><th>Mail</th><th>Date</th>
                        </tr>
                        <tr>
                          <td>'.$phone.'</td><td>'.$name.'</td><td>'.$mail.'</td><td>'.date('d.m.Y').'</td>
                        </tr>
                      </table>
                     
                    </body>
                    </html>';

// Для отправки HTML-письма должен быть установлен заголовок Content-type
            $to      = 'yevhen@neydel.com,jev.neydel@gmail.com';
            $subject = 'New order on website';
//            $message = 'Hello Yevhen, you have new order from site '."\r\n".'Phone: '.$phone."\r\n".'Name: '. $name."\r\n".'Mail: '.$mail;
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'From: robot@neydel.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion()."\r\n";


            $m = mail($to, $subject, $message, $headers);

            if ($m) {
                header('Location: https://neydel.com/#success');
            } else {
                header('Location: https://neydel.com/#wrong');
            }
        }
    }


    function resend_requers() {

        $mails = $_POST['mails'];
        $addMess = '';
        if (isset($_POST['message']) and $_POST['message']){
            $addMess = $_POST['message'];
        }
        $butt = "";
        if (isset($_POST['buttons']) and $_POST['buttons']){
            $buttons = $_POST['buttons'];
            if (isset($buttons[0])){
                for ($i=0;$i<count($buttons);$i++) {
                    $butt .= "<a href='".$buttons[$i]['link']."' style='width: 80%; height: 50px; color: white; background: rgb(0,120,120); box-shadow: 1px 1px 5px black; text-decoration: none; padding: 1em;margin:1em'>".$buttons[$i]['name']."</a>";
                }
            } else {
                $butt .= "<a href='".$buttons['link']."' style='width: 80%; height: 50px; color: white; background: rgb(0,120,120); box-shadow: 1px 1px 5px black; text-decoration: none; padding: 1em;margin:1em'>".$buttons['name']."</a>";
            }
        }
        $message = '<html>
                    <head>
                      <title>mail mess</title>
                    </head>
                    <body>
                      <div style="border: 2px solid rgb(0,120,120);background-color: hsl(0,0%,15%);width: calc(100% - 4px);max-width: 600px;text-align: center;padding-bottom: 3em">
                        <p><img src="https://neydel.com/img/main_logo.png" style="width: 250px"/></p>
                        <p style="color: hsl(0,0%,85%);font-size: 18px;">'.$addMess.'</p>
                        <div style="min-height: max-content;">
                        '.$butt.'
                        </div>
                        <br>
                      </div>
                      <br><br>
                      <div style="width: calc(100% - 4px);max-width: 604px; padding-top: 2em">
                        <a href="https://neydel.com" style="width: 200px; height: 50px; color: white; background: rgb(0,120,120); box-shadow: 1px 1px 5px black; text-decoration: none; padding: 1em; margin: 2em">
                            Перейти на сайт
                        </a>
                        <p style="font-size: 25px">
                            Для внесения предложений по усовершествованию сообщите на mail:
                        </p>
                        <a href="mailto:info@neydel.com">
                            info@neydel.com
                        </a>
                        <p style="font-size: 25px">
                            Есть проблемы с сайтом:
                        </p>
                        <a href="mailto:support@neydel.com">
                            support@neydel.com
                        </a>
                        <p style="font-size: 25px">
                            Связь с администрацией:
                        </p>
                        <a href="mailto:yevhen@neydel.com">
                            yevhen@neydel.com
                        </a>
                        <br>
                        <a href="tel:+380979294547">
                            +380979294547
                        </a>
                      </div>
                    </body>
                    </html>';

        $to      = $mails;
        $subject = $addMess;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: info@neydel.com' . "\r\n" .
            'Reply-To:'.'yevhen@neydel.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion()."\r\n";

        $m = mail($to, $subject, $message, $headers);

        if ($m){
            echo 'Error request 404';
        }
    }


}