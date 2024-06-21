
            <?php
                class Auth extends CI_Controller
                {
                    public function __construct()
                    {
                        parent::__construct();
                        $this->load->model("Padalarang/LoginModel", "", true);
                        $this->load->library('form_validation');

                    }
                    public function index()
                    {
                        $data['title'] = 'Menu Login';
                        $this->load->view('Padalarang/Login', $data);
                    }
                    public function proseslogin()
                    {
                        $this->load->model("Padalarang/LoginModel");
                        
                        $user_data = $this->LoginModel->login();
                
                        if ($user_data !== null) {
                            $username = $this->input->post("username");
                            $session_data = array(
                                "login" => true,
                                "username" => $this->input->post("username"),
                                "privasi" => $user_data->privasi,
                                "id_login" => $user_data->id_login,
                            );
                            $this->session->set_userdata($session_data);
                                $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Selamat datang  $username !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                                redirect(site_url("Padalarang/Padalarang_admin"));
                
                            
                        } else {
                            $this->session->set_flashdata("error", "<div style='font-size: 15px; color: red;'>Username atau Password Salah !</div>");
                            redirect(site_url("Padalarang/Auth"));
                        }
                    }
                    
                    public function logout()
                    {
                        $this->session->sess_destroy();
                        redirect(site_url('Padalarang/Auth'));
                    }
                    public function lupapw()
                    {
                        $data['title'] = 'Lupa Password';
                        $this->load->view('Padalarang/Lupapw', $data);
                    }
                    public function reset_password()
                    {
                        $data['title'] = 'Reset Password';
                            $email = $this->input->post('email');

                        
                                $user = $this->LoginModel->get_user_by_email($email);

                                if ($user) {
                                    // Generate token reset password
                                    $token = bin2hex(random_bytes(32));

                                    // Simpan token di database dan atur waktu kadaluarsa
                                    $this->LoginModel->set_reset_token($user['id_login'], $token);

                                    // Kirim email dengan tautan reset password
                                    $config = [
                                        'mailtype' => 'html',
                                        'charset' => 'utf-8',
                                        'protocol' => 'smtp',
                                        'smtp_host' => 'smtp.gmail.com',
                                        'smtp_user' => 'Cosmicdrmr@gmail.com',
                                        'smtp_pass' => 'xyscgakjqsgxrkjh',
                                        'smtp_crypto' => 'tls',
                                        'smtp_port' => 587,
                                        'crlf' => "
",
                                        'newline' => "
"
                                    ];

                                    $this->load->library('email');
                                    $this->email->initialize($config);
                                    $this->email->from('Cosmicdrmr@gmail.com', 'Service');
                                    $this->email->to($email);
                                    $this->email->subject('Reset Password');
                                    $this->email->message('Klik tautan berikut untuk reset password: <a href="' . site_url('Padalarang/Auth/reset_password_form/'. $token) . '">Tekan di sini</a>');

                                    if ($this->email->send()) {
                                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Tautan reset password telah dikirimkan ke email Anda cek email anda !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                                    } else {
                                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Gagal Riset Password !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                                    }
                                    redirect('Padalarang/Auth');
                                } else {
                                    $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Email Tidak di temukan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                                    redirect('Padalarang/Auth/lupapw');
                                }
                        
                    }
                    public function reset_password_form($token)
                    {
                        // Cek apakah token reset password valid
                        $user = $this->LoginModel->get_user_by_reset_token($token);

                        if ($user) {
                            $data['token'] = $token;
                            $data['title'] = 'Reset Password';
                            $this->load->view('Padalarang/reset_password_form', $data);
                        } else {
                            // Token tidak valid, tampilkan pesan kesalahan
                            $this->session->set_flashdata('error', "<div class='alert alert-danger' role='alert'>Token Tidak Valid !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                            redirect('Padalarang/Auth');
                        }
                    }

                    public function update_password()
                    {
                        if ($this->input->post('token')) {
                            $token = $this->input->post('token');
                            $password = $this->input->post('password');
                            $confirm_password = $this->input->post('confirm_password');

                            // Cek apakah token reset password valid
                            $user = $this->LoginModel->get_user_by_reset_token($token);

                            if ($user) {
                                $this->LoginModel->update_password($user['id_login'], $password);
                                $this->LoginModel->remove_reset_token($user['id_login']);
                                $this->session->set_flashdata('success', "<div class='alert alert-success' role='alert'>Password Anda berhasil di reset , Silahkan Login !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                                redirect('Padalarang/Auth');
                            
                            } else {
                                $this->session->set_flashdata('error', "<div class='alert alert-danger' role='alert'>Token Tidak Valid !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                                redirect('Padalarang/Auth');
                            }
                        } else {
                            $this->session->set_flashdata('error', "<div class='alert alert-danger' role='alert'>Token Tidak tersedia !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                            redirect('Padalarang/Auth');
                        }
                    }
                }
            