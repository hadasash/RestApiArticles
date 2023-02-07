<?php
require ("controller\ArticleController.php");
require ("controller\BaseController.php");
require ("models\Article.php");



$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
if ((isset($uri[3]) && $uri[3] != 'article') || !isset($uri[4])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
$objFeedController = new ArticleController();
$strMethodName = $uri[4] . 'Action';
$objFeedController->{$strMethodName}();
?>