<?php
class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("SuperAdmin/WebModel", "", true);
        $this->load->model("LoginModel", "", true);
        $this->load->model("FeedModel","",TRUE);
        $this->load->model("BeritaModel","",TRUE);
        $this->load->model("KepuasanModel","",TRUE);
    }
    public function TambahAdminPus($kode_puskesmas)
    {
        if ($this->session->userdata('login_super')) {
            $foto = $this->session->userdata('foto');
            $data['title'] = 'Halaman Tambah Admin Puskesmas';
            $data['admin'] = $this->WebModel->getWebadmin($kode_puskesmas);
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/TambahAdminPus',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else {
            redirect(site_url("Auth"));
        }
    }
    public function tambahAdmin($kode_puskesmas)
    {
        $web = $this->WebModel->getWebadmin($kode_puskesmas);
        $username = $this->input->post("username");
        $email = $this->input->post("email");
    
        // Check if username or email already exists for the specific kode_puskesmas
        if ($this->WebModel->checkUsernameExists(strtolower($web->lokasi) . '_login', $username, $kode_puskesmas)) {
            $data['username_error'] = 'Username Sudah di gunakan.';
        }
    
        if ($this->WebModel->checkEmailExists(strtolower($web->lokasi) . '_login', $email, $kode_puskesmas)) {
            $data['email_error'] = 'Email Sudah di gunakan.';
        }
    
        if (isset($data['username_error']) || isset($data['email_error'])) {
            // Redirect to the add admin page with error messages as query parameters
            redirect(site_url('SuperAdmin/Admin/TambahAdminPus/' . $kode_puskesmas) . '?' . http_build_query($data));
        } else {
            if ($web) {
                $table_name = strtolower($web->lokasi) . '_login';
                $password = $this->input->post('password'); // Ambil password dari form
    
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
                $data = array(
                    "username" => $username,
                    "email" => $email,
                    "password" => $hashed_password,
                );
    
                // Insert the data into the table
                $inserted = $this->WebModel->tambahAdmin($table_name, $data);
    
                if ($inserted) {
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berhasil menambah admin puskesmas !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    Redirect(site_url('SuperAdmin/Content/Adminpuskesmas/'.$kode_puskesmas));
                } else {
                    $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Gagal menambah admin puskesmas !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return false;
                }
            } else {
                // Handle jika data tidak ditemukan
                return false;
            }
        }
    }
    public function deleteAdmin($id_login, $kode_puskesmas) {
        $web = $this->WebModel->getWebadmin($kode_puskesmas);
        $table_name = strtolower($web->lokasi) . '_login';
    
        if ($this->WebModel->hapusAdmin($table_name, $id_login)) {
            $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berhasil menghapus admin puskesmas!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        } else {
            $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gagal menghapus admin puskesmas!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        }
    
        redirect(site_url('SuperAdmin/Content/Adminpuskesmas/' . $kode_puskesmas));
    }
    public function UpdateAdminPus($id_login,$kode_puskesmas)
    {
        if ($this->session->userdata('login_super')) {
            $foto = $this->session->userdata('foto');
            $data['title'] = 'Halaman Tambah Admin Puskesmas';
            $data['webpuskesmas'] = $this->WebModel->getWebadmin($kode_puskesmas);
            $data['admin'] = $this->WebModel->getAdminpusByid($id_login,$kode_puskesmas)->row();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/UpdateAdminPus',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else {
            redirect(site_url("Auth"));
        }
    }
    public function prosesupdateAdmin($id_admin, $kode_puskesmas) {
        if ($this->session->userdata('login_super')) {
            $web = $this->WebModel->getWebadmin($kode_puskesmas);
            $table_name = strtolower($web->lokasi) . '_login';
            $existing_admin = $this->db->get_where( $table_name, array("id_login" => $id_admin))->row();
            // Mengambil data yang akan diperbarui dari form
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
    
            $data = array(
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            );
            // cek username dan email di ubah 
            if ($data['username'] !== $existing_admin->username) {
                $existing_username = $this->db->get_where( $table_name, array("username" => $data['username']))->row();
                if ($existing_username) {
                    // jika username sama 
                    $data['username_error'] = 'Username Sudah di gunakan.';
                    redirect(site_url('SuperAdmin/Admin/UpdateAdminPus/'.$id_admin .'/'. $kode_puskesmas) . '?' . http_build_query($data));
                }
            }

            if ($data['email'] !== $existing_admin->email) {
                $existing_email = $this->db->get_where( $table_name, array("email" => $data['email']))->row();
                if ($existing_email) {
                    // jika email sama
                    $data['email_error'] = 'Email Sudah di gunakan.';
                    redirect(site_url('SuperAdmin/Admin/UpdateAdminPus/' .$id_admin.'/'. $kode_puskesmas) . '?' . http_build_query($data));
                }
            }
    
            // Panggil model untuk melakukan pembaruan data admin
            if ($this->WebModel->updateAdmin($table_name, $id_admin, $data)) {
                $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berhasil update admin puskesmas !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect(site_url('SuperAdmin/Content/Adminpuskesmas/' . $kode_puskesmas));
            } else {
                $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Gagal menambah admin puskesmas !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect(site_url('SuperAdmin/Admin/UpdateAdmin/' . $id_admin . '/' . $kode_puskesmas));
            }
        } else {
            redirect(site_url('Auth'));
        }
    }
    
    

}

?>