<?php
declare(strict_types=1);
namespace app\core\Request;

use app\core\InputSanitizer\InputSanitizerInterface;

class Request implements RequestInterface
{

    protected array $getData;
    protected array $postData;
    protected array $cookies;
    protected array $server;

    protected array $files;

    protected array $headers;

    protected string $path;

    protected string $method;

    /**
     * @throws \Exception
     */
    public function __construct(
        protected InputSanitizerInterface $inputSanitizer,
        array                             $getData=null,
        array                             $postData=null,
        array                             $cookies=null,
        array                             $server=null,
        array                             $files=null
    ) {
        $this->setServer($server??$_SERVER);
        $this->setGetData($getData??$_GET);
        $this->setPostData($postData??$_POST);
        $this->setCookies($cookies??$_COOKIE);
        $this->setHeaders();
        $this->setPath();
        $this->setMethod();
    }

    /**
     * Sets the GET data from the server data that was provided to the script.
     *
     * @param array $data
     * @return void
     */
    protected function setGetData(array $data): void
    {
        $this->getData = $this->inputSanitizer->sanitizeGetData($data);
    }

    /**
     * Sets the POST data from the server.
     *
     * @param array $data
     * @return void
     */
    protected function setPostData(array $data): void
    {
        $this->postData = $this->inputSanitizer->sanitizePostData($data);
    }

    /**
     * Sets the COOKIES data from the server data that was provided to the script.
     *
     * @param $cookies
     * @return void
     */
    public function setCookies($cookies): void
    {
        $this->cookies = $this->inputSanitizer->sanitizeCookies($cookies);
    }

    /**
     * Sets the Headers data from the server data that was provided to the script.
     *
     * @return void
     */
    public function setHeaders(): void
    {
        $this->headers = $this->getHeadersFrom_SERVER();
    }

    protected function getHeadersFrom_SERVER(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $key = str_replace('HTTP_', '', $key);
                $headers[$key] = $value;
            }
        }

        return $this->inputSanitizer->sanitizeHeaders($headers);
    }


    /**
     * Sets the requested path from the server data that was provided to the script.
     *
     * @return void
     */
    public function setPath(): void
    {
        $this->path = $this->normalizeRequestURI($this->getRequestURIFromServer());
    }

    private function getRequestURIFromServer(): string
    {
        return $path ?? (explode('?', $this->server["REQUEST_URI"])[0] ?? '/');
    }

    protected function normalizeRequestURI(string $uri): string
    {
        // Remove duplicate slashes from the URI
        $uri = preg_replace('#/+#', '/', $uri);

        if (strlen($uri) > 1) {
            $uri = rtrim($uri, '/');
        }

        return urldecode($uri);
    }

    /**
     * Sets the request method from a given string.
     *
     * @return void
     * @throws \Exception
     */
    public function setMethod(): void
    {
        $method = strtolower($_SERVER["REQUEST_METHOD"]);
        if (!in_array($method, static::supportedMethods(), true)) {
            throw new \Exception('Invalid Request Method.');
        }
        $this->method = $method;
    }

    public static function supportedMethods(): array
    {
        return ['get', 'post'];
    }

    /**
     * Retrieves a specific value from the GET data or all the GET data is the $key is NULL or NULL if it is not found.
     *
     * @param string|null $key The data key to retrieve.
     * @return null|int|string|float|bool|array All The GET data or the value of the specified key or NULL if it is not found.
     */
    public function getData(string $key = null): null|int|string|float|bool|array
    {
        if ($key) {
            if (array_key_exists($key, $this->getData)) {
                return $this->getData[$key];
            }
            return null;
        }
        return $this->getData;
    }

    /**
     * Retrieves a specific value from the POST data or all the POST data is the $key is NULL or NULL if it is not found.
     *
     * @param string|null $key The data key to retrieve.
     * @return null|int|string|float|bool|array All The POST data or the value of the specified key  or NULL if it is not found.
     */
    public function postData(string $key = null): null|int|string|float|bool|array
    {
        if ($key) {
            if (array_key_exists($key, $this->postData)) {
                return $this->postData[$key];
            }
            return null;
        }
        return $this->postData;
    }

    /**
     * Retrieves a specific value from the COOKIES data or all the COOKIES data is the $key is NULL.
     *
     * @param string|null $key
     * @return null|int|string|float|bool|array All The cookie data or the value of the specified key.
     */
    public function cookies(string $key = null): null|int|string|float|bool|array
    {
        if ($key) {
            if (array_key_exists($key, $this->cookies)) {
                return $this->cookies[$key];
            }
            return null;
        }
        return $this->cookies;
    }

    public function headers(string $key = null): null|int|string|float|bool|array
    {
        if ($key) {
            if (array_key_exists($key, $this->headers)) {
                return $this->headers[$key];
            }
            return null;
        }
        return $this->headers;
    }

    public function path(): string
    {
        return $this->path;
    }

    /**
     * @throws \Exception
     */
    public function isPost(): bool
    {
        return $this->method() == 'post';
    }

    /**
     * Checks if the request method is POST.
     *
     * @return string True if the request method is POST, false otherwise.
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Checks if the request method is GET.
     *
     * @return bool True if the request method is GET, false otherwise.
     */
    public function isGet(): bool
    {
        return $this->method() == 'get';
    }


    /**
     * Retrieves all the data sent to the server in both get and post method.
     * * Note that data in POST will override the data in Get that has the same key.
     * @return null|int|string|float|bool|array
     */
    public function allData(): null|int|string|float|bool|array
    {
        return array_merge($this->getData, $this->postData);
    }


    /**
     * Retrieves a specific value from the POST data. If it is not found it will search in the GET data.
     * * Note that data in POST will override the data in Get that has the same key.
     * @param string $key The data key to retrieve.
     * @return null|int|string|float|bool|array The value of the specified key or NULL if it is not found.
     */
    public function input(string $key): null|int|string|float|bool|array
    {
        return $this->postData($key) ?? $this->getData($key);
    }

    private function setServer(array $server)
    {
        $this->server = $server;
    }


    public function validate(): bool|array
    {
        return true;
    }
}
