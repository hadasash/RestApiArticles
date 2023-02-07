<?php
class ArticleController
{
/** 
* "/article/list" Endpoint - Get list of users 
*/
    public function listAction()
    {
        $strErrorDesc = '';

        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $articleModel = new Article;
                $arrArticles = $articleModel->getArticles();
                $responseData = json_encode($arrArticles);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

 /** 
* "/article/get" Endpoint - Get a specific article by its ID 
* https://localhost/ArticlesApi/index.php/article/get?id=2
*/
public function getAction()
{
        if (!isset($GLOBALS['loggedin'])) {
            echo $GLOBALS['loggedin'];
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Text to send if user hits Cancel button';
            exit;
        }
    $strErrorDesc = '';

    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $arrQueryStringParams = $this->getQueryStringParams();
    if (strtoupper($requestMethod) == 'GET') {
        try {
            $articleModel = new Article();
            $arrArticles = $articleModel->getArticle(reset($arrQueryStringParams));
            $responseData = json_encode($arrArticles);
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
    } else {
        $strErrorDesc = 'Method not supported';
        $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
    }
    // send output 
    if (!$strErrorDesc) {
        $this->sendOutput(
            $responseData,
            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
        );
    } else {
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
            array('Content-Type: application/json', $strErrorHeader)
        );
    }
}
     /** 
* __call magic method. 
*/
public function __call($name, $arguments)
{
    $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
}
/** 
* Get URI elements. 
* 
* @return array 
*/
protected function getUriSegments()
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode( '/', $uri );
    return $uri;
}
/** 
* Get querystring params. 
* 
* @return array 
*/
protected function getQueryStringParams()
{
    parse_str($_SERVER['QUERY_STRING'], $query);
    return $query;
}
/** 
* Send API output. 
* 
* @param mixed $data 
* @param string $httpHeader 
*/
protected function sendOutput($data, $httpHeaders=array())
{
    header_remove('Set-Cookie');
    if (is_array($httpHeaders) && count($httpHeaders)) {
        foreach ($httpHeaders as $httpHeader) {
            header($httpHeader);
        }
    }
    echo $data;
    exit;
}

 /** 
* "/article/update" Endpoint - update a specific article by its ID 
* https://localhost/ArticlesApi/index.php/article/update?id=5&title=hadasa&body=hello
*/
public function updateAction()
{
    $strErrorDesc = '';

    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $arrQueryStringParams = $this->getQueryStringParams();
    if (strtoupper($requestMethod) == 'PUT') {
        try {
            $articleModel = new Article();
            $id = $arrQueryStringParams['id'];
            $title = $arrQueryStringParams['title'];
            $body = $arrQueryStringParams['body'];
            $arrArticles = $articleModel->editArticle($id,$title,$body);
            $responseData = json_encode($arrArticles);
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
    } else {
        $strErrorDesc = 'Method not supported';
        $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
    }
    // send output 
    if (!$strErrorDesc) {
        $this->sendOutput(
            $responseData,
            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
        );
    } else {
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
            array('Content-Type: application/json', $strErrorHeader)
        );
    }
}
//https://localhost/ArticlesApi/index.php/article/delete?id=1"
    public function deleteAction()
    {
        $strErrorDesc = '';

        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        if (strtoupper($requestMethod) == 'DELETE') {
            try {
                if (!array_key_exists('id', $arrQueryStringParams)) {
                    throw new Error('ID is required');
                }
                $id = $arrQueryStringParams['id'];
                $articleModel = new Article();
                $articleModel->deleteArticle($id);
            } catch (Error $e) {
                //$strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                //$strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        // send output 
        if (!$strErrorDesc) {
            $this->sendOutput(
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }


    public function createAction()
{
    $strErrorDesc = '';

    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $arrQueryStringParams = $this->getQueryStringParams();
    if (strtoupper($requestMethod) == 'POST') {
        try {
            $articleModel = new Article();
            $title = $arrQueryStringParams['title'];
            $body = $arrQueryStringParams['body'];
            $published = $arrQueryStringParams['published'];

            $arrArticles = $articleModel->CreateArticle($title,$body, $published);
            $responseData = json_encode($arrArticles);
        } catch (Error $e) {
            $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
            $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
        }
    } else {
        $strErrorDesc = 'Method not supported';
        $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
    }
    // send output 
    if (!$strErrorDesc) {
        $this->sendOutput(
            $responseData,
            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
        );
    } else {
        $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
            array('Content-Type: application/json', $strErrorHeader)
        );
    }
}
}