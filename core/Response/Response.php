<?php

namespace app\core\Response;

/**
 * The Response class handles HTTP responses.
 */
class Response implements ResponseInterface
{
    /**
     * @param array $headers An array to store response headers.
     * @param int $statusCode The HTTP response status code
     * @param mixed|null $content The response content.
     * @param mixed|null $files The response Binary Files.
     * @param array<array<string,string|int|float|bool>> $cookies
     */

    public function __construct(
        protected array $headers = [],
        protected int   $statusCode = 200,
        protected mixed $content = null,
        protected mixed $files = null,
        protected array $cookies = []
    ) {
    }

    /**
     * Set the HTTP response status code.
     *
     * @param int $statusCode The HTTP status code to set.
     * @return static
     */
    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }


    /**
     * Sets a response header.
     *
     * @param string $name The name of the header.
     * @param string $value The value of the header.
     * @param bool $replace Whether to replace an existing header with the same name.
     *                      If set to false, the new value will be appended to the existing headers with the same name.
     *                      If set to true (default), the existing header value will be replaced.
     * @return static
     */
    public function setHeader(string $name, string $value, bool $replace = true): static
    {
        if (!$replace) {
            $this->headers[$name][] = $value;
        } else {
            $this->headers[$name] = $value;
        }
        return $this;
    }

    /**
     * Set the HTML response content.
     * Sets the Content-Type header to text/html, indicating that the response contains HTML content.
     *
     * @param string $HTML The HTML content to set.
     * @return static
     */
    public function setHtmlContent(string $HTML): static
    {
        $this->setHeader('Content-Type', 'text/html');
        $this->content = $HTML;
        return $this;
    }

    /**
     * Set the JSON response content.
     * Sets the Content-Type header to ta application/json, indicating that the response contains json content.
     * @param array $json The JSON content to set.
     * @return static
     */
    public function setJsonContent(array $json): static
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->content = json_encode($json, JSON_PRETTY_PRINT);
        return $this;
    }

    public function redirect(string $distURL): static
    {
        $this->setHeader('Location', $distURL);
        return $this;
    }


    public function redirectBack(): static
    {
        $this->redirect($_SESSION['previous_path']);
        return $this;
    }

    /**
     * Set a cookie to be sent with the response
     * @param string $name <p>
     * The name of the cookie.
     * </p>
     * @param string $value [optional] <p>
     * The value of the cookie.
     * </p>
     * @param int $expires [optional] <p>
     * The time the cookie expires. This is a Unix timestamp so is
     * in number of seconds since the epoch. In other words, you'll
     * most likely set this with the time function
     * plus the number of seconds before you want it to expire. Or
     * you might use mktime.
     * time()+60*60*24*30 will set the cookie to
     * expire in 30 days. If set to 0, or omitted, the cookie will expire at
     * the end of the session (when the browser closes).
     * </p>
     * <p>
     * <p>
     * expire is compared to the client's time which can
     * differ from server's time.
     * </p>
     * </p>
     * @param string $path [optional] <p>
     * The path on the server in which the cookie will be available on.
     * If set to '/', the cookie will be available
     * within the entire domain. If set to
     * '/foo/', the cookie will only be available
     * within the /foo/ directory and all
     * sub-directories such as /foo/bar/ of
     * domain. The default value is the
     * current directory that the cookie is being set in.
     * </p>
     * @param string $domain [optional] <p>
     * The domain that the cookie is available.
     * To make the cookie available on all subdomains of example.com
     * then you'd set it to '.example.com'. The
     * . is not required but makes it compatible
     * with more browsers. Setting it to www.example.com
     * will make the cookie only available in the www
     * subdomain. Refer to tail matching in the
     * spec for details.
     * </p>
     * @param bool $secure [optional] <p>
     * Indicates that the cookie should only be transmitted over a
     * secure HTTPS connection from the client.
     * </p>
     * @param bool $httponly [optional] <p>
     * When true the cookie will be made accessible only through the HTTP
     * protocol. This means that the cookie won't be accessible by
     * scripting languages, such as JavaScript. This setting can effectively
     * help to reduce identity theft through XSS attacks (although it is
     * not supported by all browsers).
     * true or false
     * </p>
     * @return static
     */
    public function setCookie(string $name, $value = "", $expires = 0, $path = "/", $domain = "", $secure = true, $httponly = true): static
    {
        $this->cookies[] = [
            'name' => $name,
            'value' => $value,
            'expires' => $expires,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httponly' => $httponly
        ];
        return $this;
    }

    private function cookies()
    {
        return $this->cookies;
    }


    /**
     * Send the HTTP response.
     *
     * @return void
     */
    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $headerName => $headerValue) {
            if (is_array($headerValue)) {
                foreach ($headerValue as $value) {
                    header($headerName . ': ' . $value, false);
                }
            } else {
                header($headerName . ': ' . $headerValue);
            }
        }

        foreach ($this->cookies() as $cookie => $cookieArray) {
            setcookie(
                name: $cookieArray['name'],
                value: $cookieArray['value'],
                expires_or_options: $cookieArray['expires'] ?? 0,
                path: $cookieArray['path'] ?? '/',
                domain: $cookieArray['domain'] ?? '',
                secure: $cookieArray['secure'] ?? true,
                httponly: $cookieArray ['httponly'] ?? true,
            );
        }

        echo $this->content;
    }


}
