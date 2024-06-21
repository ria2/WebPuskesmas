<?php

class LoginModel extends CI_Model
{
    public function getAdmin()
    {
        return $this->db->get('admin');
    }
    public function getAdminById($id)
    {
        $this->db->where("id_user",$id);
        return $this->db->get('admin');
    }
    function updateLogin($id){
        $this->db->update("id_user", $id);
    }
    //untuk cek username dan email yang sudah ada
    public function getUserByUsername($username)
    {
        return $this->db->get_where("admin", array("username" => $username))->row();
    }
    public function getUserByEmail($email)
    {
        return $this->db->get_where("admin", array("email" => $email))->row();
    }
    function totalData() {
        return $this->db->count_all('admin');
    }
    public function login()
    {
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        $this->db->where("username", $username);
        $query = $this->db->get("admin");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $hashed_password = $row->password;

            if (password_verify($password, $hashed_password)) {
                return $row; 
            }
        }

        return null; 
    }

    public function insertLogin($admin)
    {
        return $this->db->insert('admin', $admin);
    }

    public function deleteAdmin($id)
    {
        $this->db->where("id_user", $id);
        $admin = $this->db->get_where("admin", array("id_user" => $id))->row();
    
        if ($admin) {
            $photoPath = str_replace(base_url(), FCPATH, $admin->foto); 
    
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
    
            $this->db->where("id_user", $id);
            $this->db->delete("admin");
    
            $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Hapus Admin berhasil !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        } else {
            $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Admin tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
    
        redirect(site_url("SuperAdmin/Content/Admin"));
    }
    //riset password mengambil email untuk di berikan token
    public function get_user_by_email($email)
    {
        return $this->db->get_where('admin', ['email' => $email])->row_array();
    }

    public function set_reset_token($id, $token)
    {
        $data = [
            'reset_token' => $token,
            'reset_token_expiration' => date('Y-m-d H:i:s', strtotime('+1 hour')),
        ];

        $this->db->where('id_user', $id);
        $this->db->update('admin', $data);
    }
    //mengambil data user by token
    public function get_user_by_reset_token($token)
    {
        return $this->db->get_where('admin', ['reset_token' => $token])->row_array();
    }
    //update pw
    public function update_password($id, $password)
    {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'password' => $hashed_password,
        ];

        $this->db->where('id_user', $id);
        $this->db->update('admin', $data);
    }
    //hapus token yang sudah di gunakan
    public function remove_reset_token($id)
    {
        $data = [
            'reset_token' => null,
            'reset_token_expiration' => null,
        ];

        $this->db->where('id_user', $id);
        $this->db->update('admin', $data);
    }

    

}
