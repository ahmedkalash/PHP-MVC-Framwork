<?php

namespace app\core;

class Request
{
    protected array $getData=[];
    protected array $postData=[];
    protected array $cookiesData=[];
    protected array $headersData=[];
    protected string $path='/';
    protected string $method='get';

    /**
     * @throws \Exception
     */
    public function __construct(
        ?array $getData=null,
        ?array $postData=null,
        ?array $cookiesData=null,
        ?array $headersData=null,
        string $path='/',
        string $method='get'
    ){
        $this->setGetData($getData);
        $this->setPostData($postData);
        $this->setCookiesData($cookiesData);
        $this->setHeadersData($headersData);
        $this->setPath($path);
        $this->setMethod($method);
    }



    public function setGetData(?array $data=null):void
    {
        $getData = InputSanitizer::sanitizeGetData($data??$_GET);
        foreach ($getData as $key=>$value){
            $this->getData[$key]= $value;
        }
    }



    public function setPostData(?array $data=null): void
    {
        $postData = InputSanitizer::sanitizePostData($data??$_POST);
        foreach ($postData as $key=>$value){
            $this->postData[$key]= $value;
        }
    }

    private function normalizeRequestURI(string $uri)
    {
        // Remove duplicate slashes from the URI
        $uri = preg_replace('#/+#', '/', $uri);

        if(strlen($uri) > 1){
            $uri = rtrim($uri, '/');
        }

        return urldecode($uri);
    }


    public function setCookiesData(?array $cookies=null): void
    {
        $cookies = $cookies??$_COOKIE;
        $cookies = InputSanitizer::sanitizeCookies($cookies);
        foreach ($cookies as $key=>$value){
            $this->cookiesData[$key]= $value;
        }
    }



    public static function getHeadersFrom_SERVER(): array
    {
        $headers=[];
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $key = str_replace('HTTP_', '', $key);
                $headers[$key]= $value;
            }
        }

        return InputSanitizer::sanitizeHeaders($headers);
    }
    public function setHeadersData(?array $headers=null): void
    {
        $headers = isset($headers) ? InputSanitizer::sanitizeHeaders($headers) : static::getHeadersFrom_SERVER();
        foreach ($headers as $headerName => $headerValue) {
            $this->headersData[$headerName]= $headerValue;
        }
    }

    private function getRequestURIFromServer(): string
    {
        return $path ?? (explode('?',$_SERVER["REQUEST_URI"])[0] ?? '/');
    }

    public function setPath(?string $path=null): void
    {
        $this->path = $this->normalizeRequestURI($this->getRequestURIFromServer());
    }


    /**
     * @throws \Exception
     */
    public function setMethod(?string $method=null): void
    {
        if(isset($method)){
            if(!in_array($method, static::supportedMethods(),true)){
                throw new \Exception('Invalid Request Method.');
            }
            $this->method = $method;
        }else {
            $this->method = strtolower($_SERVER["REQUEST_METHOD"]);
        }
    }

    private static function supportedMethods(): array
    {
        return ['get','post'];
    }


    public function getData(string $key=null):null|int|string|float|bool|array
    {
        if($key){
            if(array_key_exists($key, $this->getData)){
                return $this->getData[$key];
            }
            return null;
        }
        return $this->getData;
    }


    public function postData(string $key=null):null|int|string|float|bool|array
    {
        if($key){
            if(array_key_exists($key, $this->postData)){
                return $this->postData[$key];
            }
            return null;
        }
        return $this->postData;
    }


    public function cookiesData(string $cookieName=null):null|int|string|float|bool|array
    {
        if($cookieName){
            if(array_key_exists($cookieName, $this->cookiesData)){
                return $this->cookiesData[$cookieName];
            }
            return null;
        }
        return $this->cookiesData;
    }


    public function headersData(string $headerName=null):null|int|string|float|bool|array
    {
        if($headerName){
            if(array_key_exists($headerName, $this->headersData)){
                return $this->headersData[$headerName];
            }
            return null;
        }
        return $this->headersData;
    }

    public function path():string
    {
        return $this->path;
    }
    public function method():string
    {
        return $this->method;
    }

    public function isPost():bool
    {
        return $this->method()=='post';
    }
     
    public function isGet():bool
    {
        return $this->method()=='get';
    }


}