<?php
ini_set('memory_limit', '-1');
class Direct {

    private $direct_url = 'https://api.direct.yandex.ru/live/v4/json/';

    private $login = 'timerlain-bikstudio';

    private $token = '4e399a6e3fdb434197d4e90a8ec29e9c';

    public function request($method, $params=null) {

        $request = array(
            'token'=> $this->token,
            'method'=> $method,
            'param'=> $params,
            'locale'=> 'ru',
        );

        $request = json_encode($request);

        $opts = array(
            'http'=>array(
                'method'=>"POST",
                'content'=>$request,
            )
        );

        $context = stream_context_create($opts);

        $result = json_decode(file_get_contents($this->direct_url, 0, $context));

        return $result;
    }

}
?>