<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Model {
	function insert_user($data){
		$this->db->insert('users',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	
	function login($username,$password){

		/*$this->db->where('userrole', 1);
		$this->db->where('userstatus', 1);*/
		$this->db->where("(email='$username')", NULL, FALSE);
		$query = $this->db->get('people');

		if($query->num_rows()>0){
			$rows = $query->row();
	        $hashed_password = $rows->password;
	        
			//if(password_verify($password, $hashed_password)){	
			if(md5($password) == $hashed_password ){	
				$newdata = array(
					'UserID' 	=> $rows->ID,
					'name' 		=> $rows->Name." ".$rows->Surname,
					'user_type' => $rows->Type,
					'user_role' => $rows->Entity_id,
					'logged_in' => TRUE,
				);
				$this->session->set_userdata($newdata);
				return true;  
			}else{
				return false;
			}          
		}
		return false;
	}

	function checkpassword($UserID,$password){
		$this->db->where("(UserID='$UserID')", NULL, FALSE);
		$query = $this->db->get('users');
		if($query->num_rows()>0){
			$rows = $query->row();
	        $hashed_password = $rows->password;
			if(password_verify($password, $hashed_password)){	
				return true;
			}else{
				return false;
			}          
		}
		return false;
	}



	public function updateusertoken($UserID,$enc_usertoken)
	{
		$this->db->where('UserID', $UserID);
		$this->db->update('users', array('usertoken'=> $enc_usertoken));
	}

	public function get_user_detail($user_id){
		$query = $this->db->get_where('users',array('UserID'=>$user_id));
		$result = $query->result_array();
		return $result[0];
	}

	public function update_user($data,$UserID)
	{
		$this->db->where('UserID', $UserID);
		$this->db->update('users', $data);
	}	

	function delete_user($UserID)
	{
		$this ->db-> where('UserID', $UserID);
    	$this ->db-> delete('users');
    	return $UserID;
	}

	public function get_users_count()
	{
		$query = $this->db->get('users');
		return $query->num_rows();
	}

	public function get_users($limit,$offset)
	{
		$query = $this->db->select()
						  ->from('users')
						  ->limit($limit,$offset)
						  ->get();
		return $query->result();
	}

	function get_userprofile($UserID){
    	$query = $this->db->get_where('users',array('UserID'=>$UserID));
    	$result = $query->result();
   		return $result[0]; 
	}

	function delete_profile_image_only($UserID)
	{
		$query = $this->db->get_where('users',array('UserID'=>$UserID));
		$result = $query->row();
		@$delete_image = $result->image;
		@unlink(UPLOADROOT."UserProfile/".$delete_image );
		@unlink(UPLOADROOT."UserProfile/thumbnail/".$delete_image );
	}

	

	
}
?>
