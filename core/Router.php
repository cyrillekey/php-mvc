<?php

namespace app\core;

class Router
{
    public Request $request;
    public Response $response;
    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
    }
    protected array $routes = [];
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $back)
    {
        $this->routes['post'][$path] = $back;
    }
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback == false) {
            $this->response->getStatusCode(404);
            return $this->renderContent("NOT Found");
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)){
            $callback[0]=new $callback[0]();
        }
        return call_user_func($callback,$this->request);
    }
    public function renderView($view,$params=[])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view,$params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    public function renderContent($content)
    {
        $layoutContent = $this->layoutContent();

        return str_replace('{{content}}', $content, $layoutContent);
    }
    protected function layoutContent()
    {
        ob_start();
        include_once(Application::$ROOT_DIR . "/views/layouts/main.php");
        return ob_get_clean();
    }
    protected function renderOnlyView($view,$params=[])
    {
        foreach($params as $key=>$value){
            $$key=$value;
        }
        
        ob_start();
        include_once(Application::$ROOT_DIR . "/views/$view.php");
        return ob_get_clean();
    }
}
