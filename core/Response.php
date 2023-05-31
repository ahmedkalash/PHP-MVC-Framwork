<?php

namespace app\core;

/**
 * The Response class handles HTTP responses.
 */
class Response
{
    /**
     * @param array $headers An array to store response headers.
     * @param int $statusCode The HTTP response status code
     * @param mixed|null $content The response content.
     * @param mixed|null $files The response Binary Files.
     */

    public function __construct(
        protected array $headers = [],
        protected int   $statusCode = 200,
        protected mixed $content=null,
        protected mixed $files=null,
    ){}

    /**
     * Set the HTTP response status code.
     *
     * @param int $statusCode The HTTP status code to set.
     * @return void
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
    }


    /**
     * Sets a response header.
     *
     * @param string $name The name of the header.
     * @param string $value The value of the header.
     * @param bool $replace Whether to replace an existing header with the same name.
     *                      If set to false, the new value will be appended to the existing headers with the same name.
     *                      If set to true (default), the existing header value will be replaced.
     * @return void
     */
    public function setHeader(string $name, string $value, bool $replace = true,)
    {
        if(!$replace){
            $this->headers[$name][] = $value;
        } else{
            $this->headers[$name] = $value;
        }
    }

    /**
     * Set the HTML response content.
     * Sets the Content-Type header to text/html, indicating that the response contains HTML content.
     *
     * @param string $HTML The HTML content to set.
     * @return void
     */
    public function setHtmlContent(string $HTML){
        $this->setHeader('Content-Type', 'text/html');
        $this->content =  $HTML;
    }

    /**
     * Set the JSON response content.
     * Sets the Content-Type header to ta pplication/json, indicating that the response contains json content.
     * @param array $json The JSON content to set.
     * @return void
     */
    public function setJsonContent(array $json)
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->content = json_encode($json, JSON_PRETTY_PRINT);
    }


    /**
     * Send the HTTP response.
     *
     * @return void
     */
    public function send()
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $headerName => $headerValue) {
            if(is_array($headerValue)){
                foreach ($headerValue as $value){
                    header($headerName . ': ' . $value,false);
                }
            }else{
                header($headerName . ': ' . $headerValue);
            }

        }

        echo $this->content;
    }




}