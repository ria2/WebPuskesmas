
            <?php

            class LoginModel extends CI_Model
            {
                public function getAdmin()
                {
                    return $this->db->get('Padalarang_login');
                }
                //Tamabahan
                public function getAdminById($id)
                {
                    $this->db->where("id_login",$id);
                    return $this->db->get('Padalarang_login');
                }
                public function getUsernameById($id)
                {
                    $this->db->where("username",$id);
                    return $this->db->get('Padalarang_login');
                }
                public function getEmailById($id)
                {
                    $this->db->where("email",$id);
                    return $this->db->get('Padalarang_login');
                }
                //tambahan
                function totalData() {
                    return $this->db->count_all('Padalarang_login');
                }
                public function login()
                {
                    $username = $this->input->post("username");
                    $password = $this->input->post("password");

                    $this->db->where("username", $username);
                    $query = $this->db->get("Padalarang_login");

                    if ($query->num_rows() > 0) {
                        $row = $query->row();
                        $hashed_password = $row->password;

                        if (password_verify($password, $hashed_password)) {
                            return $row; // Mengembalikan seluruh data row user
                        }
                    }
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Selamat datang $username !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return null; // Tidak ditemukan atau password tidak sesuai
                }
                public function insertLogin($Padalarang_login)
                {
                    return $this->db->insert('Padalarang_login', $Padalarang_login);
                }
                //tamabahan
                public function prosesUpdate($id)
                {
                    $this->load->model("LoginModel", "", true);

                    $username = $this->input->post("username");
                    $email = $this->input->post("email");
                    $password = $this->input->post('password');

                    $existing_admin = $this->db->get_where( 'Padalarang_login', array("id_login" => $id))->row();

                    $data = array(
                        'username' => $username,
                        'email' => $email,
                        'privasi' => '1',
                        'password' => password_hash($password, PASSWORD_DEFAULT)
                    );

                    // cek username dan email di ubah 
                    if ($data['username'] !== $existing_admin->username) {
                        $existing_username = $this->db->get_where( 'Padalarang_login', array("username" => $data['username']))->row();
                        if ($existing_username) {
                            // jika username sama 
                            $data['username_error'] = 'Username Sudah di gunakan.';
                            redirect(site_url('Padalarang/Padalarang_admin/UpdateAdmin/'.$id_admin ) . '?' . http_build_query($data));
                        }
                    }

                    if ($data['email'] !== $existing_admin->email) {
                        $existing_email = $this->db->get_where( 'Padalarang_login', array("email" => $data['email']))->row();
                        if ($existing_email) {
                            // jika email sama
                            $data['email_error'] = 'Email Sudah di gunakan.';
                            redirect(site_url('Padalarang/Padalarang_admin/UpdateAdmin/' .$id_admin) . '?' . http_build_query($data));
                        }
                    }
                    // Refresh session data
                    $this->load->library('session');
                    $user_data = array(
                        'username' => $data['username'],
                        'privasi' => $data['privasi'],
                        
                    );
                    $this->session->set_userdata($user_data);

                    $this->db->where("id_login", $id);
                    if ($this->db->update("Padalarang_login", $data)) {
                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Admin berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        redirect(site_url("Padalarang/Padalarang_admin"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/EditAdmin/{$id}"));
                    }
                }

                // Di dalam LoginModel.php
                public function checkUsernameExists($username) {
                    $this->db->where('username', $username);
                    $query = $this->db->get('Padalarang_login'); // Ganti 'users' dengan nama tabel yang sesuai
                    return $query->num_rows() > 0;
                }
                // Di dalam LoginModel.php
                public function checkEmailExists($email) {
                    $this->db->where('email', $email);
                    $query = $this->db->get('Padalarang_login'); // Ganti 'users' dengan nama tabel yang sesuai
                    return $query->num_rows() > 0;
                }

                public function get_user_by_email($email)
                {
                    return $this->db->get_where('Padalarang_login', ['email' => $email])->row_array();
                }

                public function set_reset_token($id, $token)
                {
                    $data = [
                        'reset_token' => $token,
                        'reset_token_expiration' => date('Y-m-d H:i:s', strtotime('+1 hour')),
                    ];

                    $this->db->where('id_login', $id);
                    $this->db->update('Padalarang_login', $data);
                }
                //mengambil data user by token
                public function get_user_by_reset_token($token)
                {
                    return $this->db->get_where('Padalarang_login', ['reset_token' => $token])->row_array();
                }
                //update pw
                public function update_password($id, $password)
                {
                    
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $data = [
                        'password' => $hashed_password,
                    ];

                    $this->db->where('id_login', $id);
                    $this->db->update('Padalarang_login', $data);
                }
                //hapus token yang sudah di gunakan
                public function remove_reset_token($id)
                {
                    $data = [
                        'reset_token' => null,
                        'reset_token_expiration' => null,
                    ];

                    $this->db->where('id_login', $id);
                    $this->db->update('Padalarang_login', $data);
                }
            }


            