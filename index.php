<?php
    require 'config.php';
    $data = json_decode(file_get_contents('php://input'));
    $user_id = $data->object->user_id;
    $mess = $data->object->body;

    $user_info = json_decode(file_get_contents($conf['apiurl'].'users.get?user_id='.$uid.'&v='.$conf['v'].'access_token='.$conf['standalone']));
    $username = $user_info->response[0]->$first_name;
    /*
    $quest = file($conf['quest']);
    foreach ($quest as $key) {
        list($user, $do) = explode(";", $key)
        if ($user == $user_id){

        }
    }
    */
    switch ($data->type) {
        case 'confirmation':
            echo $conf['confirm_token'];
            break;
        case 'message_new':
            switch ($mess) {
                case 'Привет':
                    $sendto = "Здравия желаю!"
                    break;
                
                default:
                    $sendto = $conf['not_message']
                    break;
            }

            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => $conf['apiurl'].'messages.send?user_id='.$user_id.'&group_id='.$conf['group_id'].'&message='.urlencode($sendto).'&v='.$conf['v'].'&access_token='.$conf['standalone'],
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query(array())

            ));
            $response = curl_exec($myCurl);
            curl_close($myCurl);
            break;
    }
    echo("ok")
?>