<?php
       /* $query = $this->db->query("SELECT * FROM tb_user WHERE Email = '$username' AND Password = '$password'");
		if($query->num_rows === 1){
			return $query->row();
		}else{
			return false;
		}
		
	if(empty($document)){
			echo 'kosong';
			var_dump($document);
		}else{
					$data['user_id']    = $document['ID'];
					$data['user'] 		= $document['Name'];
					$data['roles']		= 'reg';
					$data['verified']	= $document['Verified'];
					$data['logged_in'] 	= true;
				var_dump($data);
			 
		}
		
		$document = $collection->findOne(array('Email' =>$email,'Password' =>$pass,));
		
		$username=$this->input->post('username', true);
		$email=$this->input->post('email', true);
		$gender=$this->input->post('gender', true);
		$password=$this->input->post('password', true);
		
		$checkemail = $collection->findOne(array('Email' =>$email));
		if(empty($checkemail)){
			$col_counter = $connection->bsts_new->tb_counter;
			$document = $col_counter->findOne(array('CollectionName' =>'web'));
			$ID=$document['IDCount']+1;
			$data = array(
			'ID' => $ID,
			'Name' => $username,
			'Email' => $email,
			'CountryCode' => 62,
			'PhoneNumber' => '-',
			'Gender' => $gender,
			'Birthday' => '-',
			'Password' => md5($password),
			'Joindate' => date('Y-m-d'),
			'Poin' => 100,
			'PoinLevel' => 100,
			'AvatarID' => 1,
			'FacebookID' => null,
			'Verified' => 0,
			'VerifiedNumber' => null,
			'Visibility' => 0,
			'Reputation' => 0,
			'Flag' => 1,
			'Barcode' => 0,
			'Deposit' => 0,
			'ID_role' => null,
			'Plat_motor' => null,
			'ID_ktp' => null,
			'Foto' => null,
			'PushID' => null,
			'Status_online' => null,
			'Path_foto' => null,
			'Nama_foto' => null,
			'Path_ktp' => null,
			'Nama_ktp' => null,
			'Username' => $username);
			$collection->insert($data);
			
			if($collection){
			$newdata = array('$set' => array("IDCount" => $ID));
			$col_counter->update(array("CollectionName" => "web"), $newdata);
			var_dump($data);	
			
			}else{
				$data['error'] = 'Registration Error, please try again';
				$data['login_url'] = $this->facebook->getLoginUrl(array(
			            'redirect_uri' => site_url('member/signinfb'), 
			            'scope' => array("email") // permissions here
			      ));
				$data['main_content'] = 'signup';
				$this->load->view('form', $data);
			}
			
		}else{
				$data['error'] = 'Email is already used';
				$data['login_url'] = $this->facebook->getLoginUrl(array(
		            'redirect_uri' => site_url('member/signinfb'), 
		            'scope' => array("email") // permissions here
		        ));
				$data['main_content'] = 'signin';
				$this->load->view('form', $data);	
			 
		}
		Exp : { $gte : new Date(dateNow)}},
		*/
		//1492590032000
		 $start =new \MongoDB\BSON\UTCDateTime(strtotime('2017-04-19T08:20:32.000Z')*1000);
		 echo $start;
?>