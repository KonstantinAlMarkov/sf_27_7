<?php
class Model
{
	protected $db;
	
	function __construct()
	{	
		$this->db = new PDO('pgsql:host='.DB_HOST_NAME.';port='.DB_PORT.';dbname='.DB_NAME.';user='.DB_USR_NAME.';password='.DB_PASSWORD);	
	}

	// проверяем, залогинен ли пользователь
	public function checkUser()
	{
		if(isset($_COOKIE['id']))
		{
			$sql = "select * from sfimggallery.users where user_id= '".intval($_COOKIE['id'])."' LIMIT 1";
			$createResult=$this->db->prepare($sql); 
            $createResult->execute();
			$userdata  = $createResult->FETCH(PDO::FETCH_ASSOC);     
			if($userdata)
			{			
				if(($userdata['user_hash'] !== $_COOKIE['hash']) or strcasecmp($userdata['user_hash'], $_COOKIE['hash']) !== 0)
				{
					setcookie("id", "", time() - 3600*24*30*12, "/");
					setcookie("hash", "", time() - 3600*24*30*12, "/", null, null, true); // httponly !!!
					//print "Хм, что-то не получилось";
					return null;
				}
				else
				{
					return $userdata['user_login'];
				}
			}
			else
			{
				return null; 
			}
		}
		else
		{
			//print "Куки не было".'</br>';
			return null;
		}
	}

	public function getUserName(string $UserName)
	{
		$sql = "select user_login from sfimggallery.users where user_id= '".$UserName."' LIMIT 1";
		$createResult=$this->db->prepare($sql); 
        $createResult->execute();
		$userdata  = $createResult->FETCH(PDO::FETCH_NUM);    
		if(strlen($userdata[0])>0) 
		{
			return $userdata[0]; 
		}	
		else
		{
			return null;
		}	
	}	
}
