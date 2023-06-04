<?php
declare(strict_types=1);
namespace app\core\Response;

/**
 * The Response Interface handles HTTP responses.
 */
interface ResponseInterface
{

    /**
     * Set the HTTP response status code.
     *
     * @param int $statusCode The HTTP status code to set.
     * @return static
     */
    public function setStatusCode(int $statusCode): static;


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
    public function setHeader(string $name, string $value, bool $replace = true): static;

    /**
     * Set the HTML response content.
     * Sets the Content-Type header to text/html, indicating that the response contains HTML content.
     *
     * @param string $HTML The HTML content to set.
     * @return static
     */
    public function setHtmlContent(string $HTML): static;

    /**
     * Set the JSON response content.
     * Sets the Content-Type header to ta application/json, indicating that the response contains json content.
     * @param array $json The JSON content to set.
     * @return static
     */
    public function setJsonContent(array $json): static;

    public function redirect(string $distURL): static;

    /**
     * Send the HTTP response.
     *
     * @return void
     */
    public function send(): void;


}
