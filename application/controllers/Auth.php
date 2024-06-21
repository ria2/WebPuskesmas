<?php
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("LoginModel", "", true);
        $this->load->library('form_validation');

    }
    public function index()
    {
        $data['title'] = 'Menu Login';
        $this->load->view('Auth/Login', $data);
    }
    public function buatAkun()
    {
        $data['title'] = 'Menu Buat Akun';
        $this->load->view('Auth/BuatAkun', $data);
    }
    public function lupapw()
    {
        $data['title'] = 'Lupa Password';
        $this->load->view('Auth/Lupapw', $data);
    }
    public function UpdateAdmin($id)
    {
        if($this->session->userdata('login_super')){
            $foto = $this->session->userdata('foto');
        
            $data['title'] = 'Halaman Update Super Admin';
            $data['admin'] = $this->LoginModel->getAdminById($id)->row();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/UpdateAdmin',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
            redirect(site_url('Auth'));
        }

    }
    public function TambahAdmin()
    {
        if($this->session->userdata('login_super')){
            $foto = $this->session->userdata('foto');
            $data['title'] = 'Halaman Tambah Super Admin';
            // $data['admin'] = $this->LoginModel->getAdmin();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/TambahAdmin',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
            redirect(site_url('Auth'));
        }

    }
    public function deleteAdmin($id) {
        $this->LoginModel->deleteAdmin($id);
        redirect(site_url("SuperAdmin/Content/admin"));
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
                    $this->LoginModel->set_reset_token($user['id_user'], $token);

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
                        'crlf' => "\r\n",
                        'newline' => "\r\n"
                    ];

                    $this->load->library('email');
                    $this->email->initialize($config);
                    $this->email->from('Cosmicdrmr@gmail.com', 'Service');
                    $this->email->to($email);
                    $this->email->subject('Reset Password');
                    // $this->email->message('Klik tautan berikut untuk reset password: <a href="' . site_url('auth/reset_password_form/'. $token) . '">Tekan di sini</a>');
                    $this->email->message('<!doctype html><html ⚡4email data-css-strict><head><meta charset="utf-8"><style amp4email-boilerplate>body{visibility:hidden}</style><script async src="https://cdn.ampproject.org/v0.js"></script>
                    <style amp-custom>.es-desk-hidden { display:none; float:left; overflow:hidden; width:0; max-height:0; line-height:0;}body { width:100%; font-family:arial, "helvetica neue", helvetica, sans-serif;}table { border-collapse:collapse; border-spacing:0px;}table td, body, .es-wrapper { padding:0; Margin:0;}.es-content, .es-header, .es-footer { table-layout:fixed; width:100%;}p, hr { Margin:0;}h1, h2, h3, h4, h5 { Margin:0; line-height:120%; font-family:arial, "helvetica neue", helvetica, sans-serif;}.es-left { float:left;}.es-right { float:right;}.es-p5 { padding:5px;}.es-p5t { padding-top:5px;}.es-p5b { padding-bottom:5px;}.es-p5l { padding-left:5px;}.es-p5r { padding-right:5px;}.es-p10 { padding:10px;}.es-p10t { padding-top:10px;}.es-p10b { padding-bottom:10px;}.es-p10l { padding-left:10px;}.es-p10r { padding-right:10px;}.es-p15 { padding:15px;}.es-p15t { padding-top:15px;}.es-p15b { padding-bottom:15px;}.es-p15l { padding-left:15px;}
                    .es-p15r { padding-right:15px;}.es-p20 { padding:20px;}.es-p20t { padding-top:20px;}.es-p20b { padding-bottom:20px;}.es-p20l { padding-left:20px;}.es-p20r { padding-right:20px;}.es-p25 { padding:25px;}.es-p25t { padding-top:25px;}.es-p25b { padding-bottom:25px;}.es-p25l { padding-left:25px;}.es-p25r { padding-right:25px;}.es-p30 { padding:30px;}.es-p30t { padding-top:30px;}.es-p30b { padding-bottom:30px;}.es-p30l { padding-left:30px;}.es-p30r { padding-right:30px;}.es-p35 { padding:35px;}.es-p35t { padding-top:35px;}.es-p35b { padding-bottom:35px;}.es-p35l { padding-left:35px;}.es-p35r { padding-right:35px;}.es-p40 { padding:40px;}.es-p40t { padding-top:40px;}.es-p40b { padding-bottom:40px;}.es-p40l { padding-left:40px;}.es-p40r { padding-right:40px;}.es-menu td { border:0;}s { text-decoration:line-through;}p, ul li, ol li { font-family:arial, "helvetica neue", helvetica, sans-serif; line-height:150%;}
                    ul li, ol li { Margin-bottom:15px; margin-left:0;}a { text-decoration:underline;}.es-menu td a { text-decoration:none; display:block; font-family:arial, "helvetica neue", helvetica, sans-serif;}.es-wrapper { width:100%; height:100%;}.es-wrapper-color, .es-wrapper { background-color:#FAFAFA;}.es-header { background-color:transparent;}.es-header-body { background-color:transparent;}.es-header-body p, .es-header-body ul li, .es-header-body ol li { color:#333333; font-size:14px;}.es-header-body a { color:#666666; font-size:14px;}.es-content-body { background-color:#FFFFFF;}.es-content-body p, .es-content-body ul li, .es-content-body ol li { color:#333333; font-size:14px;}.es-content-body a { color:#5C68E2; font-size:14px;}.es-footer { background-color:transparent;}.es-footer-body { background-color:#FFFFFF;}.es-footer-body p, .es-footer-body ul li, .es-footer-body ol li { color:#333333; font-size:12px;}
                    .es-footer-body a { color:#333333; font-size:12px;}.es-infoblock, .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li { line-height:120%; font-size:12px; color:#CCCCCC;}.es-infoblock a { font-size:12px; color:#CCCCCC;}h1 { font-size:46px; font-style:normal; font-weight:bold; color:#333333;}h2 { font-size:26px; font-style:normal; font-weight:bold; color:#333333;}h3 { font-size:20px; font-style:normal; font-weight:normal; color:#333333;}.es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:46px;}.es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px;}.es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px;}
                    a.es-button, button.es-button { padding:10px 30px 10px 30px; display:inline-block; background:#5C68E2; border-radius:5px; font-size:20px; font-family:arial, "helvetica neue", helvetica, sans-serif; font-weight:normal; font-style:normal; line-height:120%; color:#FFFFFF; text-decoration:none; width:auto; text-align:center;}.es-button-border { border-style:solid solid solid solid; border-color:#2CB543 #2CB543 #2CB543 #2CB543; background:#5C68E2; border-width:0px 0px 0px 0px; display:inline-block; border-radius:5px; width:auto;}.es-menu amp-img, .es-button amp-img { vertical-align:middle;}@media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150% } h1, h2, h3, h1 a, h2 a, h3 a { line-height:120% } h1 { font-size:36px; text-align:left } h2 { font-size:26px; text-align:left } h3 { font-size:20px; text-align:left } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:36px; text-align:left }
                    .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px; text-align:left } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px; text-align:left } .es-menu td a { font-size:12px } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:14px } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:14px } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:14px } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px } *[class="gmail-fix"] { display:none } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left }
                    .es-m-txt-r amp-img { float:right } .es-m-txt-c amp-img { margin:0 auto } .es-m-txt-l amp-img { float:left } .es-button-border { display:inline-block } a.es-button, button.es-button { font-size:20px; display:inline-block } .es-adaptive table, .es-left, .es-right { width:100% } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%; max-width:600px } .es-adapt-td { display:block; width:100% } .adapt-img { width:100%; height:auto } td.es-m-p0 { padding:0 } td.es-m-p0r { padding-right:0 } td.es-m-p0l { padding-left:0 } td.es-m-p0t { padding-top:0 } td.es-m-p0b { padding-bottom:0 } td.es-m-p20b { padding-bottom:20px } .es-mobile-hidden, .es-hidden { display:none } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto; overflow:visible; float:none; max-height:inherit; line-height:inherit } tr.es-desk-hidden { display:table-row } table.es-desk-hidden { display:table }
                    td.es-desk-menu-hidden { display:table-cell } .es-menu td { width:1% } table.es-table-not-adapt, .esd-block-html table { width:auto } table.es-social { display:inline-block } table.es-social td { display:inline-block } td.es-m-p5 { padding:5px } td.es-m-p5t { padding-top:5px } td.es-m-p5b { padding-bottom:5px } td.es-m-p5r { padding-right:5px } td.es-m-p5l { padding-left:5px } td.es-m-p10 { padding:10px } td.es-m-p10t { padding-top:10px } td.es-m-p10b { padding-bottom:10px } td.es-m-p10r { padding-right:10px } td.es-m-p10l { padding-left:10px } td.es-m-p15 { padding:15px } td.es-m-p15t { padding-top:15px } td.es-m-p15b { padding-bottom:15px } td.es-m-p15r { padding-right:15px } td.es-m-p15l { padding-left:15px } td.es-m-p20 { padding:20px } td.es-m-p20t { padding-top:20px } td.es-m-p20r { padding-right:20px } td.es-m-p20l { padding-left:20px } td.es-m-p25 { padding:25px } td.es-m-p25t { padding-top:25px }
                    td.es-m-p25b { padding-bottom:25px } td.es-m-p25r { padding-right:25px } td.es-m-p25l { padding-left:25px } td.es-m-p30 { padding:30px } td.es-m-p30t { padding-top:30px } td.es-m-p30b { padding-bottom:30px } td.es-m-p30r { padding-right:30px } td.es-m-p30l { padding-left:30px } td.es-m-p35 { padding:35px } td.es-m-p35t { padding-top:35px } td.es-m-p35b { padding-bottom:35px } td.es-m-p35r { padding-right:35px } td.es-m-p35l { padding-left:35px } td.es-m-p40 { padding:40px } td.es-m-p40t { padding-top:40px } td.es-m-p40b { padding-bottom:40px } td.es-m-p40r { padding-right:40px } td.es-m-p40l { padding-left:40px } .es-desk-hidden { display:table-row; width:auto; overflow:visible; max-height:inherit } .h-auto { height:auto } }</style>
                    </head><body data-new-gr-c-s-loaded="14.1135.0"><div dir="ltr" class="es-wrapper-color" lang="id"> <!--[if gte mso 9]><v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t"> <v:fill type="tile" color="#fafafa"></v:fill> </v:background><![endif]--><table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"><tr><td valign="top"><table cellpadding="0" cellspacing="0" class="es-content" align="center"><tr><td class="es-info-area" align="center"><table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="background-color: transparent" bgcolor="rgba(0, 0, 0, 0)"><tr><td class="es-p20" align="left"><table cellpadding="0" cellspacing="0" width="100%"><tr><td width="560" align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" class="es-infoblock"><p><a target="_blank">View online version</a></p></td></tr></table></td></tr></table></td></tr>
                    </table></td></tr></table><table cellpadding="0" cellspacing="0" class="es-header" align="center"><tr><td align="center"><table bgcolor="rgba(0, 0, 0, 0)" class="es-header-body" align="center" cellpadding="0" cellspacing="0" width="600"><tr><td class="es-p10t es-p10b es-p20r es-p20l" align="left"><table cellpadding="0" cellspacing="0" width="100%"><tr><td width="560" class="es-m-p0r" valign="top" align="center"><table cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" style="font-size: 0px"><amp-img class="adapt-img" src="https://echgouq.stripocdn.email/content/guids/CABINET_98e153acd16d9b2d7ba91c2188f94e1db19340bbf646b54b82d227ab0a9effe2/images/pngwingcom_1.png" alt style="display: block" width="128" height="153" layout="responsive"></amp-img></td></tr><tr>
                    <td align="center"><p style="font-size: 24px;font-family: "trebuchet ms", "lucida grande", "lucida sans unicode", "lucida sans", tahoma, sans-serif"><strong>Puskesmas Kabupaten Bandung Barat</strong></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table cellpadding="0" cellspacing="0" class="es-content" align="center"><tr><td align="center"><table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600"><tr><td class="es-p15t es-p20r es-p20l" align="left"><table cellpadding="0" cellspacing="0" width="100%"><tr><td width="560" align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%"><tr><td align="left" class="es-p10t es-p10b"><p style="font-size: 16px">Anda menerima email ini karena kami menerima permintaan pengaturan ulang kata sandi untuk akun anda.</p></td></tr></table></td></tr></table></td></tr><tr>
                    <td class="es-p10b es-p20r es-p20l" align="left"><table cellpadding="0" cellspacing="0" width="100%"><tr><td width="560" align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%" style="border-radius: 5px;border-collapse: separate"><tr><td align="center" class="es-p10t es-p10b"> <!--[if mso]><a href="'.site_url("auth/reset_password_form/". $token).'" target="_blank" hidden> <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" esdevVmlButton href="'.site_url("auth/reset_password_form/". $token).'" style="height:44px; v-text-anchor:middle; width:273px" arcsize="14%" stroke="f" fillcolor="#38761d"> <w:anchorlock></w:anchorlock> <center style="color:#ffffff; font-family:arial, "helvetica neue", helvetica, sans-serif; font-size:18px; font-weight:400; line-height:18px; mso-text-raise:1px">Atur ulang Kata Sandi</center> </v:roundrect></a>
                    <![endif]--> <!--[if !mso]><!-- --><span class="msohide es-button-border" style="border-radius: 6px;background: #38761d"><a href="'.site_url("auth/reset_password_form/". $token).'" class="es-button" target="_blank" style="padding-left: 30px;padding-right: 30px;border-radius: 6px;background: #38761d;mso-border-alt: 10px solid #38761d">Atur ulang Kata Sandi</a></span> <!--<![endif]--></td></tr><tr><td align="left" class="es-p20t es-p10b"><p style="line-height: 150%">Perlu bantuan ? Hubungi Kami Cosmicdrmr@gmail.com<br>Terima kasih,</p><p>Tim Puskesmas Kabupaten Bandung Barat</p></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table cellpadding="0" cellspacing="0" class="es-footer" align="center"><tr><td align="center"><table class="es-footer-body" align="center" cellpadding="0" cellspacing="0" width="640" style="background-color: transparent"><tr>
                    <td class="es-p20t es-p20b es-p20r es-p20l" align="left"><table cellpadding="0" cellspacing="0" width="100%"><tr><td width="600" align="left"><table cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" class="es-p35b"><p>Puskesmas Kabupaten Bandung Barat © 2023 .</p></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table cellpadding="0" cellspacing="0" class="es-content" align="center"><tr><td class="es-info-area" align="center"><table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="background-color: transparent" bgcolor="rgba(0, 0, 0, 0)"><tr><td class="es-p20" align="left"><table cellpadding="0" cellspacing="0" width="100%"><tr><td width="560" align="center" valign="top"><table cellpadding="0" cellspacing="0" width="100%"><tr><td align="center" class="es-infoblock"><p><a target="_blank"></a>
                    No longer want to receive these emails?&nbsp;<a href target="_blank">Unsubscribe</a>.<a target="_blank"></a></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body></html>');
                    if ($this->email->send()) {
                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Tautan reset password telah dikirimkan ke email Anda cek email anda !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    } else {
                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Gagal Riset Password !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    }
                    redirect('auth');
                } else {
                    $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Email Tidak di temukan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    redirect('auth/lupapw');
                }
        
    }
    public function reset_password_form($token)
    {
        // Cek apakah token reset password valid
        $user = $this->LoginModel->get_user_by_reset_token($token);

        if ($user) {
            $data['token'] = $token;
            $data['title'] = 'Reset Password';
            $this->load->view('Auth/reset_password_form', $data);
        } else {
            // Token tidak valid, tampilkan pesan kesalahan
            $this->session->set_flashdata('error', "<div class='alert alert-danger' role='alert'>Token Tidak Valid !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect('auth');
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

                    // Update kata sandi pengguna
                    $this->LoginModel->update_password($user['id_user'], $password);

                    // Hapus token reset password
                    $this->LoginModel->remove_reset_token($user['id_user']);

                    // Tampilkan pesan sukses dan redirect ke halaman login
                    $this->session->set_flashdata('success', "<div class='alert alert-success' role='alert'>Password Anda berhasil di reset , Silahkan Login !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    redirect('auth');
               
            } else {
                $this->session->set_flashdata('error', "<div class='alert alert-danger' role='alert'>Token Tidak Valid !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('error', "<div class='alert alert-danger' role='alert'>Token Tidak tersedia !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect('auth');
        }
    }
    public function prosesBuatAkun()
    {
        $this->load->model("LoginModel", "", true);
        $nama = $this->input->post("nama");
        $email = $this->input->post("email");
        $no_hp = $this->input->post("no_hp");
        $username = $this->input->post("username");
        $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
        $date_create = date('Y-m-d H:i:s', time());

        // cek username dan email di data base
        $existing_username = $this->LoginModel->getUserByUsername($username);
        $existing_email = $this->LoginModel->getUserByEmail($email);

        if ($existing_username) {
            $this->session->set_flashdata('username_message', "<div class='alert alert-danger' role='alert'>Username Sudah di gunakan !</div>");
            redirect(site_url("SuperAdmin/Content/TambahAdmin"));
        }

        if ($existing_email) {
            $this->session->set_flashdata('email_message', "<div class='alert alert-danger' role='alert'>Email sudah di gunakan</div>");
            redirect(site_url("SuperAdmin/Content/TambahAdmin"));
        }

        $config['upload_path'] = './asset/img';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('gambar')) {
            $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $upload_data = $this->upload->data();
            $foto = base_url("asset/img/") . $upload_data['file_name'];

            $admin = array(
                "nama" => $nama,
                "email" => $email,
                "no_hp" => $no_hp,
                "username" => $username,
                "password" => $password,
                "date_create" => $date_create,
                "privasi" => '0',
                "foto" => $foto
            );

            if ($this->LoginModel->insertLogin($admin)) {
                $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Buat akun Admin $username berhasil !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect(site_url("SuperAdmin/Content/Admin"));
            } else {
                $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Buat akun Admin $username gagal !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect(site_url("SuperAdmin/Content/TambahAdmin"));
            }
        }
    }


    public function prosesUpdateAdmin($id)
    {
        $admin = array(
            "nama" => $this->input->post("nama"),
            "email" => $this->input->post("email"),
            "no_hp" => $this->input->post("no_hp"),
            "username" => $this->input->post("username"),
            "privasi" => '1',
            'date_create' => date('Y-m-d H:i:s', time()),
        );

        // cek kata sandi di ubah apa tidak
        $password = $this->input->post('password1');
        if (!empty($password)) {
            $admin["password"] = password_hash($password, PASSWORD_DEFAULT);
        }

        $existing_admin = $this->db->get_where("admin", array("id_user" => $id))->row();

        // cek updaload gamabr 
        if ($_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
            $config['upload_path'] = './asset/img';
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $upload_data = $this->upload->data();
                $admin['foto'] = base_url("asset/img/") . $upload_data['file_name'];

                // hapus gambar sebelumnya
                if (!empty($existing_admin->foto)) {
                    unlink($existing_admin->foto); // Remove the old file
                }
            }
        } else {
            // jika tidak upload gunakan gambar sebelumnya
            $admin['foto'] = $existing_admin->foto;
        }

        // cek username dan email di ubah 
        if ($admin['username'] !== $existing_admin->username) {
            $existing_username = $this->db->get_where("admin", array("username" => $admin['username']))->row();
            if ($existing_username) {
                // jika username sama 
                $this->session->set_flashdata('username_message', "<div class='alert alert-danger' role='alert'>Username Sudah di gunakan !</div>");
                redirect(site_url("SuperAdmin/Content/UpdateAdmin/$id"));
            }
        }

        if ($admin['email'] !== $existing_admin->email) {
            $existing_email = $this->db->get_where("admin", array("email" => $admin['email']))->row();
            if ($existing_email) {
                // jika email sama
                
                $this->session->set_flashdata('email_message', "<div class='alert alert-danger' role='alert'>Email sudah di gunakan</div>");
                redirect(site_url("SuperAdmin/Content/UpdateAdmin/$id"));
            }
        }

        $this->db->where("id_user", $id);
        if ($this->db->update("admin", $admin)) {
            // Refresh session data
            $this->load->library('session');
            $user_data = array(
                'username' => $admin['username'],
                'foto' => $admin['foto'],
                'privasi' => $admin['privasi'],
                
            );
            $this->session->set_userdata($user_data);
            $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Update Admin berhasil !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect(site_url("SuperAdmin/Content/Admin"));
        } else {
            // Handle update failure
            redirect(site_url("SuperAdmin/Content/UpdateAdmin/$id"));
        }
    }
    public function proseslogin()
    {
        $this->load->model("LoginModel");
        
        $user_data = $this->LoginModel->login();

        if ($user_data !== null) {
            $username = $this->input->post("username");
            $session_data = array(
                "login_super" => true,
                "username" => $this->input->post("username"),
                "foto" => $user_data->foto,
                "privasi" => $user_data->privasi,
                "id_user" => $user_data->id_user,
            );
            $this->session->set_userdata($session_data);
            $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Selamat datang  $username !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect(site_url("SuperAdmin/SuperAdmin"));
        } else {
            $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Username atau Password Salah !</div>");
            redirect(site_url("Auth"));
        }
    }
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }
    
}
