<?php
declare(strict_types=1);
namespace app\controllers;

use app\core\Controller\Controller;
use app\core\view\ViewPath;
use app\models\Product;

class ProductController extends Controller
{
    public function create()
    {
        return $this->twig->render(ViewPath::ADD_PRODUCT);
    }
}
