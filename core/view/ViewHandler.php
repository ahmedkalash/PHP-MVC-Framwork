<?php

namespace app\core\view;

use app\core\Application;
use Exception;

class ViewHandler
{

    /**
     * @throws Exception
     */
    public function render(string $view, array $params = []): string
    {
        $viewSections = $this->viewSections($view, $params);
        if(isset($viewSections["layout"])){
            $layoutContent = $this->layoutContent($viewSections["layout"]);
            $html = $layoutContent;
            foreach ($viewSections as $sectionName => $sectionContent) {
                if($sectionName != "layout"){
                    $html = str_replace("{{{$sectionName}}}", $sectionContent, $html);
                }
            }
            return $html;
        }

        return $viewSections["fullPage"]??'';
    }

    protected function layoutContent(string $layout)
    {
        ob_start();
        include_once Application::VIEWS_DIR . "/layouts/$layout.php";
        return ob_get_clean();
    }

    /**
     * @throws Exception
     */
    protected function viewSections(string $view, $params): array
    {

        $viewContent = include_once Application::ROOT_DIR . "views/$view.php";
        if (is_callable($viewContent)) {
            return call_user_func($viewContent, $params);
        }

        throw (new Exception('Invalid View'));
    }


    

}