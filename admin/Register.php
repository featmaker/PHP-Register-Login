<?php 
/**
* register
*/
class Register
{
	private $username;
	private $db;
	private $email;
	private $pwd;
	private $con;
	private $code;
	function __construct()
	{
		if (!isset($_POST['type'])) {
			echo "<script>alert('You access the page does not exist!');history.go(-1);</script>";
			exit();
		}
		require '../config.php';
		$this->db = new mysqli(DB_HOST,DB_USER,DB_PWD,DB_NAME) or die('数据库连接异常');
	}

	public function uniqueName()
	{
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
		    if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])){
		        $this->username = $_POST['username'];
		        $sql = "SELECT count(*) FROM users WHERE username = '".$this->username."'";
		        $count = mysqli_fetch_row($this->db->query($sql))[0];
		        if ($count) {
		        	echo "1";
		        }else{
		        	echo "0";
		        }
		    }else{
		    	echo "hello world";
		    }
		}else{
			echo "hello world";
		}
	}

	public function uniqueEmail()
	{
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
		    if('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])){
		        $this->email = $_POST['email'];
		        $sql = "SELECT count(*) FROM users WHERE email = '".$this->email."'";
		        $count = mysqli_fetch_row($this->db->query($sql))[0];
		        if ($count) {
		        	echo "1";
		        }else{
		        	echo "0";
		        }
		    }else{
		    	echo "hello world";
		    }
		}else{
			echo "hello world";
		}
	}

	public function checkCode()
	{
		if ($this->code != $_SESSION['code']) {
			echo "<script>alert('Verification code is not correct.please try again!');history.go(-1);</script>";
			exit();
		}
	}

	public function checkPwd(){
		if (trim($this->pwd) == '' || strlen($this->pwd) < 6 || strlen($this->pwd) > 20) {
			echo "<script>alert('PassWord format incorrect.please try again!');history.go(-1);</script>";
			exit();
		}
		if ($this->pwd != $this->con) {
			echo "<script>alert('Confirm password do not match.please try again!');history.go(-1);</script>";
			exit();
		}
		$this->pwd = md5($this->pwd);
	}
	public function checkEmail()
	{
		$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
		if (!preg_match($pattern,$this->email)) {
			echo "<script>alert('Email format incorrect.please try again!');history.go(-1);</script>";
			exit();
		}
	}

	public function checkName()
	{
		$length = strlen($this->username);
		if (trim($this->username) == '' || $length < 2 || $length > 20) {
			echo "<script>alert('UserName format incorrect.please try again!');history.go(-1);</script>";
			exit();
		}
	}
	public function doRegister()
	{
		$this->email = $_POST['email'];
		$this->username = $_POST['username'];
		$this->code = $_POST['code'];
		$this->pwd = $_POST['password'];
		$this->con = $_POST['confirm'];
		$this->checkCode();
		$this->checkPwd();
		$this->checkName();
		$this->checkEmail();
		$sql = "INSERT INTO users (username, email, password) VALUES ('".$this->username."','".$this->email."','".$this->pwd."')";
		$result = $this->db->query($sql);
		if ($result) {
			$this->db->close();
			echo "<script>alert('Successful registration, please log in!');location.href = '/';</script>";
			exit();
		}else{
			echo $this->db->error;
			exit();
		}
	}
}

$reg = new Register();
switch ($_POST['type']) {
	case 'name':
		$reg->uniqueName();
		break;
	case 'email':
		$reg->uniqueEmail();
		break;
	case 'all':
		$reg->doRegister();
		break;
	default:
		echo "hello world";
		break;
}

