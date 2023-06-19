<?php
declare(strict_types=1);
namespace app\controllers;

use app\core\Controller\Controller;
use app\core\view\ViewPath;
use app\models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products=Product::all() ;
        return $this->twig->render(ViewPath::HOME, [
            'products'=>$products,
        ]);
    }
}
