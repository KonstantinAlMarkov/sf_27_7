<?php
class Controller_Details extends Controller
{	
    private $commentsList = [];
    private $commentsFile;
	
    function __construct()
	{
        require_once 'model/model_details.php';
        $this->model = new Model_Details();
        $this->authorised = $this->checkAuth();
        $this->view = new View();
	}       
    
    private function createCommentsSet($fileName)
	{
        $lines = [];
        if(file_exists($fileName))
        {               
            $lines = explode("\n", file_get_contents(URL.$filename));        
        }
        return $lines;
	}
	
	function createPage(string $viewName)
	{
        if(!empty($_GET['fileName']))
        {
            //$commentsFile = COMMENT_DIR.'/'.$_GET['fileName'].'.txt'; 
            $commentsFile = COMMENT_DIR.'/'.'test.txt';
            if (file_exists($commentsFile))
            {
                $this->commentsList = $this->createCommentsSet($commentsFile);
            }
            $this->view->generate($viewName, 'default.php', $this->authorised, $this->commentsList, $_GET['fileName']);
        }
        else
        {
            print "Картинка не найдена";
        }
    }

    function createComment(){
        if (!empty($_POST['comment']) && $this->authorised)
        {
            if(!empty($_GET['fileName']))
            {
                $commentsFile = COMMENT_DIR.'/'.$_GET['fileName'].'.txt';
                $newComment = $this->model->addComment($commentsFile, $_POST['comment']);
                if($newComment)
                {
                    print "Комментарий создан";
                }
                else{
                    print "Комментарий не создан";               
                }
            }
            else
            {
                print "Нет файла </br>";
            }
        }
    }

    function deleteComment()
    {
        if (!empty($_POST['commentToDelete']) && $this->authorised)   
        {
            if(!empty($_GET['fileName']))
            {
                $commentsFile = COMMENT_DIR.'/'.$_GET['fileName'].'.txt';
                echo('Файл для комментариев');
                $this->model->deleteComment($commentsFile,$_POST['commentToDelete']);
            }
            else
            {
                print "Нет файла </br>";
            }
        }   
    }
}