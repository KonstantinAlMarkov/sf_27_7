<?php
class Model_Details extends Model
{
        function deleteComment($commentsFile, $comment)
        {
            if (file_exists($commentsFile)) 
            {
                $toDelete = trim($comment);
                //считываем файл в массив   
                $file=file($commentsFile);
                //удаляем все переносы строк в значениях массива
                $symbToReplace = array("\r\n","\r","\n","\\r","\\n","\\r\\n");
                $newFile = str_replace($symbToReplace, "", $file);   
                //ищем подходящее значение в массиве   
                if (($key = array_search($toDelete, $newFile, FALSE)) !== false) {
                    //если нашли, то удаляем ключ
                    unset($newFile[$key]);       
                    //пишем в файл, ставим перенос строки после каждой записи в массиве и ставя дополнительный перенос после последней записи
                    $newContent=implode("\n", $newFile);
                    $newContent = $newContent."\n";
                    file_put_contents($commentsFile, $newContent);   
                    array_push($messages, 'Комментарий был удалён'); 
                    var_dump($messages);
                } else echo $errors[] = 'Комментарий не найден';
            }
            else {
                print 'Файл не найден';
            }
        }

        function addComment($commentsFile, $comment)
        {
            setlocale(LC_TIME, 'ru-Latn');
            //Валидация коммента
            if($comment === '') {
                return false;
            } 
            else {
                $user_id = $this->checkUser();
                if(strlen($user_id)>0)
                {
                    $user_name = $this->GetUserName($user_id);
                    $symbToReplace = array("\r\n","\r","\n","\\r","\\n","\\r\\n");
                    $comment = str_replace($symbToReplace, "", $comment);
                    if(is_null($user_name))
                    {
                        $comment =  date("D M j G:i:s T Y").":"." Без имени ".$comment;
                    }
                    else
                    {
                        $comment =  date("D M j G:i:s T Y").":".$user_name.$comment;
                    }
                    //запись комментария
                    file_put_contents($commentsFile,$comment."\n",FILE_APPEND);                   
                    return true;
                }
                else
                {
                    return false;
                }
            }                         
        }
}