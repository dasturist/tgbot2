<?php
    //error_reporting(E_ALL);
    
    define("API_KEY", "**************************************");
    function bot($method, $data=[]){
        $url ="https://api.telegram.org/bot".API_KEY."/".$method;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        if(curl_error($ch))
        {
            var_dump(curl_error($ch));
        }
        else
        {
            return json_decode($res);
        }
        
    }
    
    function type($chat){
        return bot('sendChatAction',[
                'chat_id' => $chat,
                'action' => 'typing',
            ]);
    }
    
    $update = file_get_contents('php://input');
    $update = json_decode($update, true);
    
    $message = $update['message'];
    $chat_id = $message['chat']['id'];
    $text = $message['text'];
    
    $button = json_encode([
        'resize_keyboard' => true,
        'keyboard' => [
            [['text'=> 'Biz haqimizda'], ['text'=> 'Adminga xat yozish'], ['text'=>'Bizning manzil'],],
            ],
        ]);
        
    $cancel = json_encode([
            'resize_keyboard' => true,
            'keyboard' => [
                    [['text'=>'❤️ Ortga qaytish'],],
                ]
        ]);
    
    if(isset($text)){
        type($chat_id);
    }
    if($text == '/start'){
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => 'Assalomu aleykum botga hush kelibsiz.',
            'parse_mode' => 'markdown',
            'reply_markup' => $button,
            ]);
    }
    
    if($text == 'Biz haqimizda')
    {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => 'Biz kimmiz? Biz CTT TECHNOLOGY LLC',
            'parse_mode' => 'markdown',
            'reply_markup' => $cancel,
            ]);
    }
    if($text == '❤️ Ortga qaytish')
    {
        bot('sendMessage',[
                'chat_id' => $chat_id,
                'text' => 'Assalomu aleykum botga hush kelibsiz.',
                'parse_mode' => 'markdown',
                'reply_markup' => $button,
            ]);
    }
    
    
    if($text == 'Bizning manzil'){
        bot('sendLocation', [
                'chat_id' => $chat_id,
                'latitude' => 40.365051,
                'longitude' => 71.774835,
                'reply_markup' => $cancel,
            ]);
    }
    
?>