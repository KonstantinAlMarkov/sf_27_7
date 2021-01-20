<?php
class Controller_Home extends Controller
{	
	private $fileList = [];
	private $errors = [];
	private $messages = [];
	
	function createImageSet()
	{
		$this->fileList=scandir(UPLOAD_DIR);
		$this->fileList = array_filter($this->fileList, function ($file) {
			return !in_array($file, ['.', '..', '.gitkeep']);});
	}
	
	function createPage(string $viewName)
	{
		$this->createImageSet();
		$this->view->generate($viewName, 'default.php', $this->authorised, $this->fileList);
	}

	function uploadfile()
	{
		if ($this->authorised)
		{
			$errors = [];
			//добавляем файлы
			if (!empty($_FILES)){
				foreach($_FILES as $file){
					$uploadedName=$file['tmp_name'][0];
					$fileDir=UPLOAD_DIR.'/'.$file['name'][0];
					// Проверяем размер
					if ($file['size'][0] > UPLOAD_MAX_SIZE) {
						$errors[] = 'Недопостимый размер файла ' . $fileDir;
						continue;
					}
					// Проверяем формат
					if (!in_array($file['type'][0], ALLOWED_TYPES)) {
						$errors[] = 'Недопустимый формат файла ' . $fileDir;
						continue;
					}   
					// Пытаемся загрузить файл
					if (!move_uploaded_file($uploadedName,$fileDir)) {
						$errors[] = 'Ошибка загрузки файла ' . $fileName;
						continue;
					}          
				};
				if (empty($errors)) {
					print 'Файлы были загружены'.'</br>';
				}
				else{
					foreach($errors as $error)
					{
						print "Ошибка: ".$error.'</br>';
					}
				}
				//скидываем значение
				unset($_FILES);
			}	
			else 
			{
				echo "а файлов-то не было";
			}	
		}
	}

	function deleteFile()
	{
		if ($this->authorised)
		{
			$messages = [];
			$errors = [];
	
			if (!empty($_POST['name'])){
				$filePath=UPLOAD_DIR.'/'.$_POST['name'];
				$commentPath=COMMENT_DIR.'/'.$_POST['name'].'.txt';
				if (file_exists($filePath)) {
					unlink($filePath);
					$messages[] = 'Файл '.$filePath.' был удален';
				} else { $errors[] = 'Файл не найден '.$filePath;}
				if (file_exists($commentPath)) {
					unlink($commentPath);
					$messages[] = 'Комментарии к файлу были удалены';
				} else { $errors[] = 'Файл c комментариями не найден '.$commentPath;}
			
				foreach($errors as $error)
				{
					print "Ошибка: ".$error.'</br>';
				}
	
				foreach($messages as $message)
				{
					print "Удачно выполнено: ".$message.'</br>';
				}
				
				//скидываем значение
				unset($_POST['name']);
			}
		}
	}
}
