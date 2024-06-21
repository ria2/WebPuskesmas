<?php

class FeedModel extends CI_Model
{
    public function getFeed()
    {
        return $this->db->get('umpan_balik');
    }
    function totalData() {
        return $this->db->count_all('umpan_balik');
    }
    public function getFeedById($id)
    {
        $this->db->where("id_umpan_balik",$id);
        return $this->db->get('umpan_balik');
    }
    public function insertLayananPublik($umpan_balik)
    {
        return $this->db->insert('umpan_balik', $umpan_balik);
    }
    public function captcha() {
        $config = [
            "img_path" => "./captcha/", // Sesuaikan dengan path direktori penyimpanan captcha Anda
            "img_url" => base_url("captcha/"), // Sesuaikan dengan URL ke direktori penyimpanan captcha Anda
            "img_width" => 500,
            "img_height" => 90,
            "border" => 0, // Tidak perlu border
            "expiration" => 900,
        ];
    
        $captcha = create_captcha($config);
    
        // Pastikan library session sudah aktif dan dikonfigurasi dengan benar
        $this->session->set_userdata('captcha_word', $captcha['word']);
    
        // URL gambar captcha yang benar akan disimpan di $captcha['image']
        return $captcha;
    }
    
    public function IsiPesan() {
        $nama = $this->input->post("nama");
        $email = $this->input->post("email");
        $subject = $this->input->post("subject");
        $pesan = $this->input->post('pesan');
        $puskesmas = $this->input->post('puskesmas');
        $captcha_input = $this->input->post('captcha'); // Ambil nilai captcha dari input
    
        // Lakukan validasi CAPTCHA
        
        $captcha_word = $this->session->userdata('captcha_word');
    
        if ($captcha_word !== $captcha_input) {
            $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Captcha tidak valid.</div>");
            // Mencegah pengiriman pesan jika CAPTCHA tidak valid
            return;
        }
        
        $umpan_balik = array(
            "nama" => $nama,
            "email" => $email,
            "subject" => $subject,
            "pesan" => $pesan,
            "puskesmas" => $puskesmas,
            "tanggal" =>  date('Y-m-d H:i:s', time()),
        );
        // Insert pesan ke database
        $insert_result = $this->db->insert("umpan_balik", $umpan_balik);
    
        if ($insert_result) {
            $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berhasil Mengirim Pengaduan !</div>");
        } else {
            $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Gagal mengirim pesan.</div>");
        }
        
    }
    
    //Email pass app
    function balaspesan() {
        $email = $this->input->post('email');
        $subject = $this->input->post('subjectbalas');
        $balas = $this->input->post('balas');
    
        if (!empty($email) && !empty($subject) && !empty($balas)) {
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
    
            $this->email->from('Cosmicdrmr@gmail.com', 'Costumer Service KBB'); // 
            $this->email->to($email);
            $this->email->subject($subject);
            // $this->email->message($balas);
            $this->email->message('<!doctype html><html ⚡4email data-css-strict><head><meta charset="utf-8"><style amp4email-boilerplate>body{visibility:hidden}</style><script async src="https://cdn.ampproject.org/v0.js"></script>
            <style amp-custom>span.MsoHyperlink, span.MsoHyperlinkFollowed { color:inherit;}a.es-button { text-decoration:none; display:inline-block; background:#75B6C9; border-radius:28px; font-size:16px; font-family:"open sans", "helvetica neue", helvetica, arial, sans-serif; font-weight:normal; font-style:normal; line-height:120%; color:#FFFFFF; width:auto; text-align:center; padding:15px 25px 15px 25px;}.es-desk-hidden { display:none; float:left; overflow:hidden; width:0; max-height:0; line-height:0;}body { width:100%; height:100%;}table { border-collapse:collapse; border-spacing:0px;}table td, body, .es-wrapper { padding:0; Margin:0;}.es-content, .es-header, .es-footer { width:100%; table-layout:fixed;}p, hr { Margin:0;}h1, h2, h3, h4, h5, h6 { Margin:0; font-family:"open sans", "helvetica neue", helvetica, arial, sans-serif; letter-spacing:0;}.es-left { float:left;}.es-right { float:right;}.es-menu td { border:0;}
            s { text-decoration:line-through;}a { text-decoration:none; font-size:16px;}.es-menu td a { font-family:"open sans", "helvetica neue", helvetica, arial, sans-serif; text-decoration:none; display:block;}.es-wrapper { width:100%; height:100%;}.es-wrapper-color, .es-wrapper { background-color:#F6F6F6;}.es-content-body p, .es-footer-body p, .es-header-body p, .es-infoblock p { font-family:"open sans", "helvetica neue", helvetica, arial, sans-serif; line-height:150%; letter-spacing:0;}.es-header { background-color:transparent;}.es-header-body { background-color:transparent;}.es-header-body p { color:#B7BDC9; font-size:20px;}.es-header-body a { color:#B7BDC9; font-size:20px;}.es-content-body { background-color:#FFFFFF;}.es-content-body p, .es-content-body ul li, .es-content-body ol li { font-size:16px;}.es-content-body a { color:#75B6C9; font-size:14px;}.es-footer { background-color:transparent;}.es-footer-body { background-color:#F6F6F6;}
            .es-footer-body p { color:#999999; font-size:14px;}.es-footer-body a { color:#999999; font-size:14px;}.es-content-body p { color:#999999; font-size:14px;}.es-infoblock p { font-size:12px; color:#CCCCCC;}.es-infoblock a { font-size:12px; color:#CCCCCC;}h1 { font-size:40px; font-style:normal; font-weight:bold; line-height:120%; color:#444444;}h2 { font-size:20px; font-style:normal; font-weight:bold; line-height:120%; color:#444444;}h3 { font-size:18px; font-style:normal; font-weight:normal; line-height:120%; color:#444444;}.es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:40px;}.es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:20px;}.es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:18px;}h4 { font-size:24px; font-style:normal; font-weight:normal; line-height:120%; color:#333333;}
            h5 { font-size:20px; font-style:normal; font-weight:normal; line-height:120%; color:#333333;}h6 { font-size:16px; font-style:normal; font-weight:normal; line-height:120%; color:#333333;}.es-header-body h4 a, .es-content-body h4 a, .es-footer-body h4 a { font-size:24px;}.es-header-body h5 a, .es-content-body h5 a, .es-footer-body h5 a { font-size:20px;}.es-header-body h6 a, .es-content-body h6 a, .es-footer-body h6 a { font-size:16px;}a.es-button, button.es-button { padding:10px 20px 10px 20px; display:inline-block; background:#75B6C9; border-radius:28px 28px 28px 28px; font-size:16px; font-family:"open sans", "helvetica neue", helvetica, arial, sans-serif; font-weight:normal; font-style:normal; line-height:120%; color:#FFFFFF; text-decoration:none; width:auto; text-align:center; letter-spacing:0;}
            .es-button-border { border-style:solid; border-color:#75B6C9 #75B6C9 #75B6C9 #75B6C9; background:#75B6C9; border-width:1px 1px 1px 1px; display:inline-block; border-radius:28px 28px 28px 28px; width:auto;}.es-button img { display:inline-block; vertical-align:middle;}.es-fw, .es-fw .es-button { display:block;}.es-il, .es-il .es-button { display:inline-block;}.es-p15t { padding-top:15px;}.es-p20r { padding-right:20px;}.es-p15b { padding-bottom:15px;}.es-p20l { padding-left:20px;}.es-p10t { padding-top:10px;}.es-p25b { padding-bottom:25px;}.es-p40t { padding-top:40px;}.es-p25t { padding-top:25px;}.es-p20b { padding-bottom:20px;}.es-p20t { padding-top:20px;}.es-p5b { padding-bottom:5px;}.es-p10r { padding-right:10px;}.es-p10l { padding-left:10px;}.es-p10b { padding-bottom:10px;}.es-p40b { padding-bottom:40px;}.es-p30t { padding-top:30px;}.es-p30b { padding-bottom:30px;}ul li, ol li { margin-left:0;}
            .es-menu amp-img, .es-button amp-img { vertical-align:middle;}@media only screen and (max-width:600px) {h1 { font-size:30px; text-align:center } h2 { font-size:26px; text-align:center } h3 { font-size:20px; text-align:center } *[class="gmail-fix"] { display:none } p, a { line-height:150% } h1, h1 a { line-height:120% } h2, h2 a { line-height:120% } h3, h3 a { line-height:120% } h4, h4 a { line-height:120% } h5, h5 a { line-height:120% } h6, h6 a { line-height:120% } .es-header-body p { } .es-content-body p { } .es-footer-body p { } .es-infoblock p { } h4 { font-size:24px; text-align:left } h5 { font-size:20px; text-align:left } h6 { font-size:16px; text-align:left } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:30px } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px }
            .es-header-body h4 a, .es-content-body h4 a, .es-footer-body h4 a { font-size:24px } .es-header-body h5 a, .es-content-body h5 a, .es-footer-body h5 a { font-size:20px } .es-header-body h6 a, .es-content-body h6 a, .es-footer-body h6 a { font-size:16px } .es-menu td a { font-size:16px } .es-header-body p, .es-header-body a { font-size:16px } .es-content-body p, .es-content-body a { font-size:14px } .es-footer-body p, .es-footer-body a { font-size:16px } .es-infoblock p, .es-infoblock a { font-size:12px } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3, .es-m-txt-c h4, .es-m-txt-c h5, .es-m-txt-c h6 { text-align:center } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3, .es-m-txt-r h4, .es-m-txt-r h5, .es-m-txt-r h6 { text-align:right } .es-m-txt-j, .es-m-txt-j h1, .es-m-txt-j h2, .es-m-txt-j h3, .es-m-txt-j h4, .es-m-txt-j h5, .es-m-txt-j h6 { text-align:justify }
            .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3, .es-m-txt-l h4, .es-m-txt-l h5, .es-m-txt-l h6 { text-align:left } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img, .es-m-txt-r .rollover:hover .rollover-second, .es-m-txt-c .rollover:hover .rollover-second, .es-m-txt-l .rollover:hover .rollover-second { display:inline } .es-m-txt-r .rollover div, .es-m-txt-c .rollover div, .es-m-txt-l .rollover div { line-height:0; font-size:0 } .es-spacer { display:inline-table } .es-m-fw, .es-m-fw.es-fw, .es-m-fw .es-button { display:block } .es-m-il, .es-m-il .es-button, .es-social, .es-social td, .es-menu { display:inline-block } .es-adaptive table, .es-left, .es-right { width:100% } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%; max-width:600px } .adapt-img:not([src*="default-img"]) { width:100%; height:auto } .es-mobile-hidden, .es-hidden { display:none }
            tr.es-desk-hidden { display:table-row } table.es-desk-hidden { display:table } td.es-desk-menu-hidden { display:table-cell } .es-menu td { width:1% } table.es-table-not-adapt, .esd-block-html table { width:auto } .es-social td { padding-bottom:10px } a.es-button, button.es-button { display:inline-block } .es-button-border { display:inline-block } .es-desk-hidden { display:table-row; width:auto; overflow:visible; max-height:inherit } }</style>
            </head><body data-new-gr-c-s-loaded="14.1135.0"><div dir="ltr" class="es-wrapper-color" lang="en"> <!--[if gte mso 9]><v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t"> <v:fill type="tile" color="#f6f6f6"></v:fill> </v:background><![endif]--><table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"><tr><td valign="top"><table cellpadding="0" cellspacing="0" class="es-content" align="center"><tr><td align="center"><table class="es-content-body" style="background-color: transparent" width="640" cellspacing="0" cellpadding="0" align="center"><tr><td class="es-p15t es-p15b es-p20r es-p20l" align="left"> <!--[if mso]><table width="600" cellpadding="0" cellspacing="0"><tr><td width="290" valign="top"><![endif]--><table class="es-left" cellspacing="0" cellpadding="0" align="left"><tr><td width="290" align="left"><table width="100%" cellspacing="0" cellpadding="0"><tr>
            <td class="es-infoblock es-m-txt-c" align="left"><p style="font-family: arial, helvetica\ neue, helvetica, sans-serif">Put your preheader text here<br></p></td></tr></table></td></tr></table> <!--[if mso]></td><td width="20"></td><td width="290" valign="top"><![endif]--><table class="es-right" cellspacing="0" cellpadding="0" align="right"><tr><td width="290" align="left"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="right" class="es-infoblock es-m-txt-c"><p><a href="https://viewstripo.email" target="_blank" class="view" style="font-family: "arial", "helvetica neue", "helvetica", "sans-serif"">View in browser</a></p></td></tr></table></td></tr></table> <!--[if mso]></td></tr></table><![endif]--></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center"><tr>
            <td align="center"><table class="es-content-body" style="background-color: #f6f6f6" width="640" cellspacing="0" cellpadding="0" bgcolor="#f6f6f6" align="center"><tr><td class="es-p10t es-p20r es-p20l" align="left"><table width="100%" cellspacing="0" cellpadding="0"><tr><td width="600" valign="top" align="center"><table width="100%" cellspacing="0" cellpadding="0"><tr><td class="es-p20t es-p20b" align="center" style="font-size:0"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td style="border-bottom: 1px solid #f6f6f6;background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height: 1px;width: 100%;margin: 0px"></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center"><tr>
            <td align="center"><table class="es-content-body" style="background-color: transparent" width="640" cellspacing="0" cellpadding="0" align="center"><tr><td class="es-p20r es-p20l" align="left"><table width="100%" cellspacing="0" cellpadding="0"><tr><td width="600" valign="top" align="center"><table width="100%" cellspacing="0" cellpadding="0" style="border-radius:3px;border-collapse:separate;background-color:#ffffff" bgcolor="#ffffff"><tr><td align="center" style="font-size: 0px"><a target="_blank" href="https://viewstripo.email"><amp-img class="adapt-img" src="'.base_url('asset/img/pengaduan.png').'" alt="Newsletter article #1" style="border-radius: 3px 3px 0px 0px;display: block" title="Newsletter article #1" width="600" layout="responsive"></amp-img></a></td></tr><tr><td class="es-p25t es-p5b es-p20r es-p20l" align="center"><h2>Halo,'.$email.'&nbsp;</h2></td></tr><tr>
            <td class="es-p10t es-p15b es-p20r es-p20l" align="center"><p><span class="product-description">'.$balas.'</span></p></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center"><tr><td align="center"><table class="es-content-body" style="background-color: #f6f6f6" width="640" cellspacing="0" cellpadding="0" bgcolor="#f6f6f6" align="center"><tr><td class="es-p10t es-p20r es-p20l" align="left"><table width="100%" cellspacing="0" cellpadding="0"><tr><td width="600" valign="top" align="center"><table width="100%" cellspacing="0" cellpadding="0"><tr><td class="es-p20t es-p15b" align="center" style="font-size:0"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
            <td style="border-bottom: 1px solid #f6f6f6;background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height: 1px;width: 100%;margin: 0px"></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center"><tr><td align="center"><table class="es-content-body" style="background-color: #f6f6f6" width="640" cellspacing="0" cellpadding="0" bgcolor="#f6f6f6" align="center"><tr><td class="es-p10t es-p20r es-p20l" align="left"><table width="100%" cellspacing="0" cellpadding="0"><tr><td width="600" valign="top" align="center"><table width="100%" cellspacing="0" cellpadding="0"><tr><td class="es-p10t es-p10b" align="center" style="font-size:0"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td style="border-bottom: 1px solid #f6f6f6;background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height: 1px;width: 100%;margin: 0px"></td></tr>
            </table></td></tr></table></td></tr></table></td></tr></table></td></tr></table><table class="es-content" cellspacing="0" cellpadding="0" align="center"><tr><td style="background-color: #f6f6f6" bgcolor="#f6f6f6" align="center"><table class="es-content-body" style="background-color: transparent" width="640" cellspacing="0" cellpadding="0" align="center"><tr><td class="es-p30t es-p30b es-p20r es-p20l" align="left"><table width="100%" cellspacing="0" cellpadding="0"><tr><td width="600" valign="top" align="center"><table width="100%" cellspacing="0" cellpadding="0"><tr><td align="center" style="display: none"></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body></html>');
    
            if ($this->email->send()) {
                $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Pesan anda telah dikirim ke $email !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            } else {
                $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Pesan anda gagal dikirim ke $email !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            }
    
            
        }
    }
    
    // function deleteUmpanBalik($id){
    //     $this->db->where("id_umpan_balik",$id);
    //     $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berhasil Hapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    //     return $this->db->delete("umpan_balik");
    // }
    public function hapusCaptchaKadaluarsa() {
        $directory = "./captcha/"; 
        $expiration = 900; 
    
        foreach (scandir($directory) as $file) {
            if (is_file($directory . $file) && filemtime($directory . $file) < time() - $expiration) {
                unlink($directory . $file);
            }
        }
    }
    
}
?>