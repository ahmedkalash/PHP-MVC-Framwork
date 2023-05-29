<?php

namespace app\core;

class Request
{
    protected array $getData;
    protected array $postData;
    protected array $cookiesData;
    protected array $headersData;
    protected string $path;
    protected string $method;
    public function __construct()
    {
        $this->setGetData();
        $this->setPostData();
        $this->setCookiesData();
        $this->setHeadersData();
        $this->setPath();
        $this->setMethod();
    }


    public function setGetData(): void
    {
        foreach ($_GET as $key=>$value){
            $filterResult = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            if($filterResult != 0 && $filterResult != null){
                $this->getData[$key]= $filterResult;
            }
        }
    }


    public function setPostData(): void
    {
        foreach ($_POST as $key=>$value){
            $filterResult = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            if($filterResult != 0 && $filterResult != null){
                $this->postData[$key]= $filterResult;
            }
        }
    }


    public function setCookiesData(): void
    {
        foreach ($_COOKIE as $key=>$value){
            $filterResult = filter_input(INPUT_COOKIE, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            if($filterResult != 0 && $filterResult != null){
                $this->cookiesData[$key]= $filterResult;
            }
        }
    }


    public function setHeadersData(): void
    {
        // Looping through all headers
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $headerName = str_replace('HTTP_', '', $key);
                $filterResult = filter_input(INPUT_SERVER, $headerName, FILTER_SANITIZE_SPECIAL_CHARS);
                if($filterResult != 0 && $filterResult != null){
                    $this->headersData[$headerName]= $filterResult;
                }
            }
        }
    }


    public function setPath(): void
    {
        $path = explode('?',$_SERVER["REQUEST_URI"])[0] ?? '/';
        if ($path!='/' && $path[-1]=='/'){
            $this->path = substr_replace($path,'',-1);
        }
        else{
            $this->path=$path;
        }
    }


    public function setMethod(): void
    {
        $this->method = strtolower($_SERVER["REQUEST_METHOD"]);
    }


    public function getData(string $varName=null):null|int|string|float|bool|array
    {
        if($varName){
            if(array_key_exists($varName, $this->getData)){
                return $this->getData[$varName];
            }
            return null;
        }
        return $this->getData;
    }


    public function postData(string $varName=null):null|int|string|float|bool|array
    {
        if($varName){
            if(array_key_exists($varName, $this->postData)){
                return $this->postData[$varName];
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