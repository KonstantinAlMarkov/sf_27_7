<?php
class Main{
    static function showPage()
    {
        $pageNumber = '1';
        $pages = include 'config/pages.php';
        if (!empty($_GET['page'])) {     
            $pageNumber = (int) $_GET['page'];     
        }       
        $page_name = $pages[$pageNumber];
        if(!strlen($page_name)>0)
        {        
            Main::ErrorPage404();
        }
        else
        {  
            $controller_file = strtolower($page_name);
            $controller_name = "Controller_".$page_name;
            $controller_path = "controller/controller_".$page_name.'.php';
            if(file_exists($controller_path))
            {
                include $controller_path;                
                $controller = new $controller_name;
                if(isset($_POST['submit'])&$pageNumber == 2){
                    $controller->submitted();
                }
                elseif(isset($_POST['submit'])&$pageNumber == 3){
                    $controller->submitted();
                }
                elseif(isset($_POST['submit'])&$pageNumber == 1){
                    $controller->uploadfile();
                }
                elseif(isset($_POST['name'])&$pageNumber == 1){
                    $controller->deleteFile();
                }
                elseif(isset($_POST['commentToDelete'])&$pageNumber == 5){
                    $controller->deleteComment();
                }
                elseif(isset($_POST['comment'])&$pageNumber == 5){
                    $controller->createComment();
                }


                if(file_exists('pages/'.$page_name.'.php'))
                {
                    $controller->createPage('pages/'.$page_name.'.php');
                }
            }
            else
            {
                Main::ErrorPage404();
            }          
        }       
    }  
    
	function ErrorPage404()
	{
        $page_name = "404";
        $controller_file = strtolower($page_name);
        $controller_name = "Controller_".$page_name;
        $controller_path = "controller/controller_".$page_name.'.php';
        if(file_exists($controller_path))
        {
            include $controller_path;                 
            $controller = new $controller_name;
            $controller->createPage('pages/'.$page_name.'.php');
        }
    }    
}
