<?php
declare(strict_types=1);
namespace app\core\Controller;

use app\core\QueryBuilder\QueryBuilderInterface;
use app\core\Request\RequestInterface;
use app\core\Response\ResponseInterface;
use app\core\Session\SessionHandler;
use app\core\Session\SessionHandlerInterface;
use Illuminate\Container\Container;
use Twig\Environment;

abstract class Controller implements ControllerInterface
{
    public function __construct(
        protected RequestInterface     $request,
        protected ResponseInterface    $response,
        protected Container   $container,
        protected Environment $twig,
        protected SessionHandlerInterface $sessionHandler,
        protected QueryBuilderInterface $queryBuilder
    ) {

    }
}
