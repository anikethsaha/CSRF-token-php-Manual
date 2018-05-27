<?php 
	/**
	* 
	*/
	class session_Ecnryption{

		protected $encrypt_method;
		protected $secret_key;
		protected $secret_iv;
		protected $output;
		protected $key;
		protected $iv;
		
		
		function __construct()
		{
			
			$this->output = false;


			$this->encrypt_method = "AES-256-CBC";
		    $this->secret_key = 'flairtales';
		    $this->secret_iv = 'interns';

		    // hash
		    $this->key = hash('sha256', $this->secret_key);
		    
		    // iv - encrypt method AES-256-CBC expects 16 bytes - 
		    $this->iv = substr(hash('sha256', $this->secret_iv), 0, 16);
		}

		public function Encrypt($string)
		{
			
		   
		    $this->output = openssl_encrypt($string, $this->encrypt_method, $this->key, 0, $this->iv);
			return $this->output;	
		}

		public function Decrypt($string)
		{
			 $this->output = openssl_decrypt($string, $this->encrypt_method, $this->key, 0, $this->iv);
			 return $this->output;
		}


	}
	


 ?>