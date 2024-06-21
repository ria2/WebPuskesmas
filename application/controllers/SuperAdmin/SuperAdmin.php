<?php
class SuperAdmin extends CI_Controller
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
    //Halaman Utama
    public function index()
    {
        if ($this->session->userdata('login_super')) {
            $foto = $this->session->userdata('foto');
           
            $data['title'] = 'Halaman Super Admin';
            $data['webpuskesmas'] = $this->WebModel->totalData();
            $data['admin'] = $this->LoginModel->totalData();
            $data['umpan_balik'] = $this->FeedModel->totalData();
            $data['survey'] = $this->KepuasanModel->get_survey_results(); 
            $data['survey_reason'] = $this->KepuasanModel->getSurveyReason(); 
            $data['berita'] = $this->BeritaModel->totalData();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/Dashboard', $data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        } else {
            redirect(site_url("Auth"));
        }
        
    }
    // generator
    public function Generator(){
        if($this->session->userdata('login_super')){
            $foto = $this->session->userdata('foto');
            $data['title'] = 'Halaman Web Engine';
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/Generator');
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
                
            redirect(site_url("Auth"));
        }
    }
    //prosses ganerate
    function Generate(){
        if ($this->input->post()) {
            $kode_puskesmas = $this->input->post('kode_puskesmas');
            $lokasi = $this->input->post('lokasi');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $no_hp = $this->input->post('no_hp');
            $kode_pos = $this->input->post('kode_pos');
            $alamat = $this->input->post('alamat');
            $alamat_map = $this->input->post('alamat_map');
            $meta = $this->input->post('meta_keyword');
            $meta_desk = $this->input->post('meta_deskripsi');
        
            // Cek apakah lokasi sudah ada di database
            $this->load->model('SuperAdmin/WebModel'); 
            if ($this->WebModel->isLokasiExist($lokasi)) {
                // Jika lokasi sudah ada, set flashdata dan redirect
                $this->session->set_flashdata('lokasi_message', "<div class='alert alert-danger' role='alert'>Puskesmas Sudah di ada !</div>");
                redirect(site_url("SuperAdmin/SuperAdmin/Generator"));
            }
        
            // Cek apakah kode puskesmas sudah ada di database
            if ($this->WebModel->isKodePuskesmasExist($kode_puskesmas)) {
                // Jika kode puskesmas sudah ada, set flashdata dan redirect
                $this->session->set_flashdata('kode_message', "<div class='alert alert-danger' role='alert'>kode puskesmas sudah di gunakan !</div>");
                redirect(site_url("SuperAdmin/SuperAdmin/Generator"));
            }
            date_default_timezone_set('Asia/Jakarta');
            // Simpan informasi puskesmas ke dalam database
            $web = array(
                'kode_puskesmas' =>  $this->input->post('kode_puskesmas'),
                'lokasi' => $lokasi,
                'nama_aplikasi' => 'Web Puskesmas '.$lokasi,
                'kecamatan' => $this->input->post('kecamatan'),
                'alamat' => $this->input->post('alamat'),
                'deskripsi' => $this->input->post('deskripsi'),
                'domain' => base_url($lokasi . '/' . $lokasi),
                'email' => $this->input->post('email'),
                'no_hp' => $this->input->post('no_hp'),
                'kode_pos' => $this->input->post('kode_pos'),
                'meta_keyword' => $this->input->post('meta_keyword'),
                'meta_deskripsi' => $this->input->post('meta_deskripsi'),
                'create' => date_create('now', new DateTimeZone('Asia/Jakarta'))->format('Y-m-d H:i:s'),
                'logo' => base_url('asset/img/logodefault.png'),
                
            );
            $this->WebModel->insertWeb($web); 

            //Untuk Membuat folder
            $puskesmas_folder = APPPATH . 'controllers/' . $lokasi . '/';
            if (!is_dir($puskesmas_folder)) {
                mkdir($puskesmas_folder, 0777, true);
            }

            // Buat berkas Controller
            $controller_content = "
            
            <?php
            class ${lokasi} extends CI_Controller {
                public function __construct()
                {
                    parent::__construct();
                    \$this->load->model(\"${lokasi}/CorouselModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/VisiMisiModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/PegawaiModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/LoginModel\",\"\",TRUE);
                    \$this->load->model(\"FeedModel\",\"\",TRUE);
                    \$this->load->model(\"BeritaModel\",\"\",TRUE);
                    \$this->load->model(\"KepuasanModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/OrganisasiModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/GaleryModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/LayananPublikModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/LayananKhususModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/SejarahModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/SosialMediaModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/PendaftaranModel\",\"\",TRUE);
                    ;

                }
                public function index()
                {

                    \$data['title'] = 'Halaman Awal';
                    \$data['${lokasi}_corousel'] = \$this->CorouselModel->getCorousel();
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['berita'] = \$this->BeritaModel->getBerita();
                    \$data['${lokasi}_galery'] = \$this->GaleryModel->getGalery();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$data['${lokasi}_pegawai'] = \$this->PegawaiModel->getPegawai();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Dashboard',\$data);
                    \$this->load->view('${lokasi}/Berita',\$data);
                    \$this->load->view('${lokasi}/PegawaiAktif',\$data);
                    \$this->load->view('${lokasi}/Galery',\$data);
                    \$this->load->view('${lokasi}/Alamat',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Sejarah()
                {

                    \$data['title'] = 'Halaman Sejarah';
                    
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Sejarah',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Visi()
                {

                    \$data['title'] = 'Halaman Visi & Misi';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/VisiMisi',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Struktur()
                {

                    \$data['title'] = 'Halaman Strukture Organisasi';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_organisasi'] = \$this->OrganisasiModel->getOrganisasi();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Organisasi',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function DataPegawai()
                {

                    \$data['title'] = 'Halaman Data Pegawai';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_pegawai'] = \$this->PegawaiModel->getPegawai();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Pegawai',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Lokasi()
                {

                    \$data['title'] = 'Halaman Data Pegawai';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Lokasi',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Maklumat()
                {

                    \$data['title'] = 'Halaman Maklumat';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Maklumat',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Agenda()
                {

                    \$data['title'] = 'Halaman Agenda';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_galery'] = \$this->GaleryModel->getGalery();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Agenda',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Artikel()
                {

                    \$data['title'] = 'Halaman Artikel & Berita';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['berita'] = \$this->BeritaModel->getBerita();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Artikel',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function ArtikelLengkap(\$id)
                {

                    \$data['title'] = 'Halaman Artikel & Berita';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['berita'] = \$this->BeritaModel->getBeritaById(\$id)->row();
                    \$data['${lokasi}_galery'] = \$this->GaleryModel->getGalery();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$data['berita_data'] = \$this->BeritaModel->getBerita();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/ArtikelLengkap',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Mekanisme()
                {

                    \$data['title'] = 'Mekanisme Layanan Publik';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_layananpublik'] = \$this->LayananPublikModel->getLayanan();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Mekanisme',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Sarana()
                {

                    \$data['title'] = 'Mekanisme Layanan Publik';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_layananpublik'] = \$this->LayananPublikModel->getLayanan();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Sarana',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Fasilitas()
                {

                    \$data['title'] = 'Mekanisme Layanan Publik';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_layananpublik'] = \$this->LayananPublikModel->getLayanan();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Fasilitas',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Tarif()
                {

                    \$data['title'] = 'Mekanisme Layanan Publik';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_layananpublik'] = \$this->LayananPublikModel->getLayananPublik();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Tarif',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Kompensasi()
                {

                    \$data['title'] = 'Mekanisme Layanan Publik';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_layananpublik'] = \$this->LayananPublikModel->getLayanan();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Kompensasi',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Standar()
                {

                    \$data['title'] = 'Mekanisme Layanan Publik';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_layananpublik'] = \$this->LayananPublikModel->getLayanan();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Standar',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function VisiPelayanan()
                {

                    \$data['title'] = 'Visi & Misi Layanan Khusus';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_layanankhusus'] = \$this->LayananKhususModel->getLayananKhusus();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/VisiPelayanan',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Atribut()
                {

                    \$data['title'] = 'Visi & Misi Layanan Khusus';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_layanankhusus'] = \$this->LayananKhususModel->getLayananKhusus();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Atribut',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Layanan()
                {

                    \$data['title'] = 'Visi & Misi Layanan Khusus';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_layanankhusus'] = \$this->LayananKhususModel->getLayananKhusus();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/LayananTerpadu',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function TataNilai()
                {

                    \$data['title'] = 'Tata Nilai';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/TataNilai',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Pengaduan()
                {

                    \$data['title'] = 'Pengaduan ';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$data['umpan_balik'] = \$this->FeedModel->getFeed();
                    \$data['captcha'] = \$this->FeedModel->captcha();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/UmpanBalik',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function IsiPesan(){
                    if (\$this->FeedModel->IsiPesan()) {
                        redirect(site_url(\"${lokasi}/${lokasi}/Pengaduan\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}/Pengaduan\"));
                    }
                }
                public function Kepuasan()
                {

                    \$data['title'] = 'Kepuasan ';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['survey'] = \$this->KepuasanModel->get_survey_results();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Kepuasan',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function submit_penilaian(\$type) {
                    \$alasan_type = \$this->input->post('alasan_type');
                    \$alasan = \$this->input->post('alasan_' . \$alasan_type);
                    \$this->KepuasanModel->submit_survey(\$type, \$alasan);
                    redirect('${lokasi}/${lokasi}/Kepuasan');
                }
                public function Pendaftaran()
                {

                    \$data['title'] = 'Pendaftaran ';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$data['${lokasi}_layananpublik'] = \$this->LayananPublikModel->getLayananPublik();
                    \$data['antrian'] = \$this->PendaftaranModel->get_last_queue_number();
                    \$data['sisa'] = \$this->PendaftaranModel->sisa();
                    \$this->load->view('${lokasi}/Navbar',\$data);
                    \$this->load->view('${lokasi}/Pendaftaran',\$data);
                    \$this->load->view('${lokasi}/Footer',\$data);
                }
                public function Daftar(){
                    \$id = \$this->PendaftaranModel->Daftar(); // Menyimpan ID pendaftaran yang baru saja dibuat
                
                    if (\$id) {
                        redirect(site_url(\"${lokasi}/${lokasi}/Tiket/\" . \$id));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}/Pendaftaran\"));
                    }
                }                
                public function Tiket(\$id)
                {
                    \$data['title'] = 'Tiket';
                    \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                    \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                    \$data['${lokasi}_pendaftaran'] = \$this->PendaftaranModel->getPendaftaranById(\$id)->row(); // Perubahan di sini
                    \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                    \$this->load->view('${lokasi}/Navbar', \$data);
                    \$this->load->view('${lokasi}/Tiket', \$data);
                    \$this->load->view('${lokasi}/Footer', \$data);
                }
                
            }
            
            ";
            file_put_contents($puskesmas_folder . ucfirst($lokasi) . '.php', $controller_content);



            // Buat berkas Controller
            $controller_content = "
            <?php
                class Auth extends CI_Controller
                {
                    public function __construct()
                    {
                        parent::__construct();
                        \$this->load->model(\"${lokasi}/LoginModel\", \"\", true);
                        \$this->load->library('form_validation');

                    }
                    public function index()
                    {
                        \$data['title'] = 'Menu Login';
                        \$this->load->view('${lokasi}/Login', \$data);
                    }
                    public function proseslogin()
                    {
                        \$this->load->model(\"${lokasi}/LoginModel\");
                        
                        \$user_data = \$this->LoginModel->login();
                
                        if (\$user_data !== null) {
                            \$username = \$this->input->post(\"username\");
                            \$session_data = array(
                                \"login\" => true,
                                \"username\" => \$this->input->post(\"username\"),
                                \"privasi\" => \$user_data->privasi,
                                \"id_login\" => \$user_data->id_login,
                            );
                            \$this->session->set_userdata(\$session_data);
                                \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Selamat datang  \$username !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                                redirect(site_url(\"${lokasi}/${lokasi}_admin\"));
                
                            
                        } else {
                            \$this->session->set_flashdata(\"error\", \"<div style='font-size: 15px; color: red;'>Username atau Password Salah !</div>\");
                            redirect(site_url(\"${lokasi}/Auth\"));
                        }
                    }
                    
                    public function logout()
                    {
                        \$this->session->sess_destroy();
                        redirect(site_url('${lokasi}/Auth'));
                    }
                    public function lupapw()
                    {
                        \$data['title'] = 'Lupa Password';
                        \$this->load->view('${lokasi}/Lupapw', \$data);
                    }
                    public function reset_password()
                    {
                        \$data['title'] = 'Reset Password';
                            \$email = \$this->input->post('email');

                        
                                \$user = \$this->LoginModel->get_user_by_email(\$email);

                                if (\$user) {
                                    // Generate token reset password
                                    \$token = bin2hex(random_bytes(32));

                                    // Simpan token di database dan atur waktu kadaluarsa
                                    \$this->LoginModel->set_reset_token(\$user['id_login'], \$token);

                                    // Kirim email dengan tautan reset password
                                    \$config = [
                                        'mailtype' => 'html',
                                        'charset' => 'utf-8',
                                        'protocol' => 'smtp',
                                        'smtp_host' => 'smtp.gmail.com',
                                        'smtp_user' => 'Cosmicdrmr@gmail.com',
                                        'smtp_pass' => 'xyscgakjqsgxrkjh',
                                        'smtp_crypto' => 'tls',
                                        'smtp_port' => 587,
                                        'crlf' => \"\r\n\",
                                        'newline' => \"\r\n\"
                                    ];

                                    \$this->load->library('email');
                                    \$this->email->initialize(\$config);
                                    \$this->email->from('Cosmicdrmr@gmail.com', 'Service');
                                    \$this->email->to(\$email);
                                    \$this->email->subject('Reset Password');
                                    \$this->email->message('Klik tautan berikut untuk reset password: <a href=\"' . site_url('${lokasi}/Auth/reset_password_form/'. \$token) . '\">Tekan di sini</a>');

                                    if (\$this->email->send()) {
                                        \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Tautan reset password telah dikirimkan ke email Anda cek email anda !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                                    } else {
                                        \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Gagal Riset Password !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                                    }
                                    redirect('${lokasi}/Auth');
                                } else {
                                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-danger' role='alert'>Email Tidak di temukan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                                    redirect('${lokasi}/Auth/lupapw');
                                }
                        
                    }
                    public function reset_password_form(\$token)
                    {
                        // Cek apakah token reset password valid
                        \$user = \$this->LoginModel->get_user_by_reset_token(\$token);

                        if (\$user) {
                            \$data['token'] = \$token;
                            \$data['title'] = 'Reset Password';
                            \$this->load->view('${lokasi}/reset_password_form', \$data);
                        } else {
                            // Token tidak valid, tampilkan pesan kesalahan
                            \$this->session->set_flashdata('error', \"<div class='alert alert-danger' role='alert'>Token Tidak Valid !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect('${lokasi}/Auth');
                        }
                    }

                    public function update_password()
                    {
                        if (\$this->input->post('token')) {
                            \$token = \$this->input->post('token');
                            \$password = \$this->input->post('password');
                            \$confirm_password = \$this->input->post('confirm_password');

                            // Cek apakah token reset password valid
                            \$user = \$this->LoginModel->get_user_by_reset_token(\$token);

                            if (\$user) {
                                \$this->LoginModel->update_password(\$user['id_login'], \$password);
                                \$this->LoginModel->remove_reset_token(\$user['id_login']);
                                \$this->session->set_flashdata('success', \"<div class='alert alert-success' role='alert'>Password Anda berhasil di reset , Silahkan Login !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                                redirect('${lokasi}/Auth');
                            
                            } else {
                                \$this->session->set_flashdata('error', \"<div class='alert alert-danger' role='alert'>Token Tidak Valid !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                                redirect('${lokasi}/Auth');
                            }
                        } else {
                            \$this->session->set_flashdata('error', \"<div class='alert alert-danger' role='alert'>Token Tidak tersedia !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect('${lokasi}/Auth');
                        }
                    }
                }
            ";
            file_put_contents($puskesmas_folder . 'Auth.php', $controller_content);

            $controller_content = "
            <?php
            class ${lokasi}_admin extends CI_Controller {
                public function __construct() {
                    parent::__construct();
                    \$this->load->model(\"${lokasi}/CorouselModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/VisiMisiModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/PegawaiModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/LoginModel\",\"\",TRUE);
                    \$this->load->model(\"FeedModel\",\"\",TRUE);
                    \$this->load->model(\"BeritaModel\",\"\",TRUE);
                    \$this->load->model(\"KepuasanModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/OrganisasiModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/GaleryModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/LayananPublikModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/LayananKhususModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/SejarahModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/SosialMediaModel\",\"\",TRUE);
                    \$this->load->model(\"${lokasi}/PendaftaranModel\",\"\",TRUE);
                    
                    ;
                }
                public function index()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Admin';
                        \$data['${lokasi}_login'] = \$this->LoginModel->totalData();
                        \$data['umpan_balik'] = \$this->FeedModel->totalData();
                        \$data['survey'] = \$this->KepuasanModel->get_survey_results(); 
                        \$data['survey_reason'] = \$this->KepuasanModel->getSurveyReason(); 
                        \$data['berita'] = \$this->BeritaModel->totalData();
                        \$data['pendaftaran'] = \$this->PendaftaranModel->totalData();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Dashboard_admin', \$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                        
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function Corousel()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Setting Corousel';
                        \$data['${lokasi}_corousel'] = \$this->CorouselModel->getCorousel();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Corousel_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function VisiMisi()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Setting Visi & Misi';
                        \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisi();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Visi_Misi_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function Berita()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Setting Berita';
                        \$data['berita'] = \$this->BeritaModel->getBerita();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Berita_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                
                public function Feed()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Umpan Balik';
                        \$data['umpan_balik'] = \$this->FeedModel->getFeed();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Umpan_Balik_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function DataPegawai()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Data Pegawai';
                        \$data['${lokasi}_pegawai'] = \$this->PegawaiModel->getPegawai();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/DataPegawai_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }

                }
                public function Organisasi()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Data Organisasi';
                        \$data['${lokasi}_organisasi'] = \$this->OrganisasiModel->getOrganisasi();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Organisasi_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }

                }
                public function admin()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Setting Admin';
                        \$data['${lokasi}_login'] = \$this->LoginModel->getAdmin();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function TambahAdmin()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Tambah Admin';
                        \$data['${lokasi}_login'] = \$this->LoginModel->getAdmin();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Tambah_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function UpdateAdmin(\$id)
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Tambah Admin';
                        \$data['${lokasi}_login'] = \$this->LoginModel->getAdminById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Update_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesUpdate(\$id){
                    if (\$this->LoginModel->prosesUpdate(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/admin\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateAdmin/\$id\"));
                    }
                }
                public function deleteAdmin(\$id) {
                    \$this->LoginModel->deleteAdmin(\$id);
                    redirect(site_url(\"${lokasi}/${lokasi}_admin/admin\"));
                }
                public function UpdateVisi(\$id) {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Tamabah Visi & Misi';
                        \$data['${lokasi}_visi_misi'] = \$this->VisiMisiModel->getVisiMisiById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Update_Visi_Misi',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prossesUpdateVisi(\$id){
                    if (\$this->VisiMisiModel->prosesUpdate(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/VisiMisi\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateVisi/\$id\"));
                    }
                }
                public function TambahPegawai()
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Tambah Pegawai';
                        \$data['${lokasi}_pegawai'] = \$this->PegawaiModel->getPegawai();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/TambahPegawai',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prossesTambahPegawai(){
                    if (\$this->PegawaiModel->prosesTambahPegawai()) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/DataPegawai\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/DataPegawai\"));
                    }
                }
                public function UpdatePegawai(\$id)
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Tambah Pegawai';
                        \$data['${lokasi}_pegawai'] = \$this->PegawaiModel->getPegawaiById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/UpdatePegawai',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prossesUpdatePegawai(\$id){
                    if (\$this->PegawaiModel->prosesUpdatePegawai(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/DataPegawai\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/DataPegawai\"));
                    }
                }
                public function deletePegawai(\$id) {
                    \$this->PegawaiModel->deletePegawai(\$id);
                    redirect(site_url(\"${lokasi}/${lokasi}_admin/DataPegawai\"));
                }
                public function TambahBerita()
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Tambah Berita';
                        \$data['berita'] = \$this->BeritaModel->getBerita();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/TambahBerita',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesTambahBerita(){
                    if (\$this->BeritaModel->prosesTambahBerita()) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/Berita\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/TambahBerita\"));
                    }
                }
                public function UpdateBerita(\$id)
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Tambah berita';
                        \$data['berita'] = \$this->BeritaModel->getBeritaById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/UpdateBerita',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesUpdateBerita(\$id){
                    if (\$this->BeritaModel->prosesUpdateBerita(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/Berita\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateBerita\"));
                    }
                }
                public function deleteBerita(\$id) {
                    \$this->BeritaModel->deleteBerita(\$id);
                    redirect(site_url(\"${lokasi}/${lokasi}_admin/berita\"));
                }
                public function TambahCorousel()
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Tambah Slide Show';
                        \$data['${lokasi}_Corousel'] = \$this->CorouselModel->getCorousel();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/TambahCorousel',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesTambahCorousel(){
                    if (\$this->CorouselModel->prosesTambahCorousel()) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/Corousel\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/TambahCorousel\"));
                    }
                }
                public function UpdateCorousel(\$id)
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Tambah Corousel';
                        \$data['${lokasi}_corousel'] = \$this->CorouselModel->getCorouselById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/UpdateCorousel',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesUpdateCorousel(\$id){
                    if (\$this->CorouselModel->prosesUpdateCorousel(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/Corousel\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateCorousel\"));
                    }
                }
                public function deleteCorousel(\$id) {
                    \$this->CorouselModel->deleteCorousel(\$id);
                    redirect(site_url(\"${lokasi}/${lokasi}_admin/Corousel\"));
                }
                public function UpdateOrganisasi(\$id)
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Update Organisasi';
                        \$data['${lokasi}_organisasi'] = \$this->OrganisasiModel->getOrganisasiById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/UpdateOrganisasi',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesUpdateOrganisasi(\$id){
                    if (\$this->OrganisasiModel->prosesUpdateOrganisasi(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/Organisasi\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateOrganisasi\"));
                    }
                }
                public function Galery()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Setting Galery';
                        \$data['${lokasi}_galery'] = \$this->GaleryModel->getGalery();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Galery_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function TambahGalery()
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Tambah Galery';
                        \$data['${lokasi}_galery'] = \$this->GaleryModel->getGalery();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/TambahGalery',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesTambahGalery(){
                    if (\$this->GaleryModel->prosesTambahGalery()) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/Galery\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/TambahGalery\"));
                    }
                }
                public function UpdateGalery(\$id)
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Tambah Galery';
                        \$data['${lokasi}_galery'] = \$this->GaleryModel->getGaleryById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/UpdateGalery',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesUpdateGalery(\$id){
                    if (\$this->GaleryModel->prosesUpdateGalery(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/Galery\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateGalery\"));
                    }
                }
                public function deleteGalery(\$id) {
                    \$this->GaleryModel->deleteGalery(\$id);
                    redirect(site_url(\"${lokasi}/${lokasi}_admin/Galery\"));
                }

                public function LayananPublik()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Setting Layanan Publik';
                        \$data['${lokasi}_layananpublik'] = \$this->LayananPublikModel->getLayananPublik();
                        \$data['${lokasi}_layanan'] = \$this->LayananPublikModel->getLayanan();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/LayananPublik_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function TambahLayananPublik()
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Tambah LayananPublik';
                        \$data['${lokasi}_layananpublik'] = \$this->LayananPublikModel->getLayananPublik();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/TambahLayananPublik',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesTambahLayananPublik(){
                    if (\$this->LayananPublikModel->prosesTambahLayananPublik()) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/LayananPublik\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/TambahLayananPublik\"));
                    }
                }
                public function UpdateLayananPublik(\$id)
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Update Layanan Publik';
                        \$data['${lokasi}_layananpublik'] = \$this->LayananPublikModel->getLayananPublikById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/UpdateLayananPublik',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function UpdateLayanan(\$id)
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Update Mekanisme Layanan Publik';
                        \$data['${lokasi}_layanan'] = \$this->LayananPublikModel->getLayananById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/UpdateLayanan',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesUpdateLayananPublik(\$id){
                    if (\$this->LayananPublikModel->prosesUpdateLayananPublik(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/LayananPublik\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateLayananPublik\"));
                    }
                }
                public function prosesUpdateLayanan(\$id){
                    if (\$this->LayananPublikModel->prosesUpdateLayanan(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/LayananPublik\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateLayanan/\".\$id));
                    }
                }
                public function deleteLayananPublik(\$id) {
                    \$this->LayananPublikModel->deleteLayananPublik(\$id);
                    redirect(site_url(\"${lokasi}/${lokasi}_admin/LayananPublik\"));
                }
                public function LayananKhusus()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Setting Layanan Khusus';
                        \$data['${lokasi}_layanankhusus'] = \$this->LayananKhususModel->getLayananKhusus();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/LayananKhusus_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                
                public function UpdateLayananKhusus(\$id)
                {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Update Layanan Khusus';
                        \$data['${lokasi}_layanankhusus'] = \$this->LayananKhususModel->getLayananKhususById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/UpdateLayananKhusus',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prosesUpdateLayananKhusus(\$id){
                    if (\$this->LayananKhususModel->prosesUpdateLayananKhusus(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/LayananKhusus\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateLayananKhusus\"));
                    }
                }
               
                public function Sejarah()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Setting Sejarah';
                        \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarah();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Sejarah_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                //Tambahan
                public function UpdateSejarah(\$id) {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman Sejarah & Maklumat';
                        \$data['${lokasi}_sejarah'] = \$this->SejarahModel->getSejarahById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/UpdateSejarah',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prossesUpdateSejarah(\$id){
                    if (\$this->SejarahModel->prosesUpdate(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/Sejarah\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateVisi/\$id\"));
                    }
                }
                public function SosialMedia()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Setting Sosial Media';
                        \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMedia();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/SosialMedia_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                //Tambahan
                public function UpdateSosialMedia(\$id) {
                    if(\$this->session->userdata('login')){
                        \$data['title'] = 'Halaman update Sosial Media ';
                        \$data['${lokasi}_sosialmedia'] = \$this->SosialMediaModel->getSosialMediaById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/UpdateSosialMedia',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function prossesUpdateSosialMedia(\$id){
                    if (\$this->SosialMediaModel->prosesUpdate(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/SosialMedia\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/UpdateSosialMedia/\$id\"));
                    }
                }
                public function Pendaftaran()
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Halaman Data Pendaftaran';
                        \$data['${lokasi}_pendaftaran'] = \$this->PendaftaranModel->getPendaftaran();
                        \$data['antrian'] = \$this->PendaftaranModel->getAntrian()->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/Pendaftaran_admin',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('${lokasi}/Auth'));
                    }
                }
                public function deletePendaftaran(\$id) {
                    \$this->PendaftaranModel->deletePendaftaran(\$id);
                    redirect(site_url(\"${lokasi}/${lokasi}_admin/Pendaftaran\"));
                }
                public function BalasPengaduan(\$id)
                {
                    if(\$this->session->userdata('login')){
                        \$foto = \$this->session->userdata('foto');
                        \$data['title'] = 'Balas Pengaduan';
                        \$data['umpan_balik'] = \$this->FeedModel->getFeedById(\$id)->row();
                        \$this->load->view('${lokasi}/Navbar_admin', \$data);
                        \$this->load->view('${lokasi}/BalasPengaduan',\$data);
                        \$this->load->view('${lokasi}/Footer_admin');
                        \$this->load->view('${lokasi}/Modal_admin');
                    }else{
                        redirect(site_url('Auth'));
                    }
            
                }
                public function BalasPesan() {
                    \$this->FeedModel->balaspesan();
                    redirect(site_url(\"${lokasi}/${lokasi}_admin/Feed\"));
                }
                public function DeleteFeed(\$id) {
                    \$this->FeedModel->deleteUmpanBalik(\$id);
                    redirect(site_url(\"${lokasi}/${lokasi}_admin/Feed\"));
                }
                public function UpdateAntrian(\$id){
                    if (\$this->PendaftaranModel->UpdateAntrian(\$id)) {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/Pendaftaran\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/Pendaftaran\"));
                    }
                }

            }
            ";
            file_put_contents($puskesmas_folder . ucfirst($lokasi) . '_admin.php', $controller_content);




            // Buat berkas Model di dalam direktori 'models'
            $puskesmas_folder2 = APPPATH . 'models/' . $lokasi . '/';
            if (!is_dir($puskesmas_folder2)) {
                mkdir($puskesmas_folder2, 0777, true);
            }
            

            $model_content = "<?php

            class CorouselModel extends CI_Model
            {
                public function getCorousel()
                {
                    return \$this->db->get('${lokasi}_corousel');
                }
                public function getCorouselById(\$id)
                {
                    \$this->db->where(\"id_corousel\",\$id);
                    return \$this->db->get('${lokasi}_corousel');
                }
                public function prosesTambahCorousel(){
                    \$judul = \$this->input->post(\"judul\");
                    \$keterangan = \$this->input->post(\"keterangan\");
                   
                    
                    \$${lokasi}_corousel = array(
                        \"judul\" => \$judul,
                        \"keterangan\" => \$keterangan,
                        \"date_create\" => date('Y-m-d H:i:s', Time()),
                    );
                    \$config['upload_path'] = './asset/${lokasi}';
                    \$config['allowed_types'] = 'gif|jpg|png';

                    \$this->load->library('upload', \$config);

                    if (!\$this->upload->do_upload('gambar')) {
                        \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                        redirect(\$_SERVER['HTTP_REFERER']);
                    } else {
                        \$upload_data = \$this->upload->data();
                        \$${lokasi}_corousel['gambar'] = base_url(\"asset/${lokasi}/\") . \$upload_data['file_name'];
                    }

                    \$this->db->where(\"id_corousel\");
                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Slide show berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return \$this->db->insert(\"${lokasi}_corousel\",\$${lokasi}_corousel);
                }
                public function prosesUpdateCorousel(\$id) {
                    \$judul = \$this->input->post(\"judul\");
                    \$keterangan = \$this->input->post(\"keterangan\");
                    
                    
                    \$${lokasi}_corousel = array(
                        \"judul\" => \$judul,
                        \"keterangan\" => \$keterangan,
                        
                        \"date_create\" => date('Y-m-d H:i:s', Time()),
                    );
                
                    \$existing_corousel = \$this->db->get_where(\"${lokasi}_corousel\", array(\"id_corousel\" => \$id))->row();
                    
                    // Check if a new image is uploaded
                    if (\$_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
                        \$config['upload_path'] = './asset/${lokasi}';
                        \$config['allowed_types'] = 'gif|jpg|png';
                
                        \$this->load->library('upload', \$config);
                
                        if (!\$this->upload->do_upload('gambar')) {
                            \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect(\$_SERVER['HTTP_REFERER']);
                        } else {
                            \$upload_data = \$this->upload->data();
                            \$${lokasi}_corousel['gambar'] = base_url(\"asset/${lokasi}/\") . \$upload_data['file_name'];
                
                            // Delete the old image if it exists
                            if (!empty(\$existing_corousel->gambar)) {
                                unlink(\$existing_corousel->gambar); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded, retain the existing image
                        \$${lokasi}_corousel['gambar'] = \$existing_corousel->gambar;
                    }
                
                    \$this->db->where(\"id_corousel\", \$id);
                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Slide show berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return \$this->db->update(\"${lokasi}_corousel\", \$${lokasi}_corousel);
                }
                function deleteCorousel(\$id){
                    \$this->db->where(\"id_corousel\", \$id);
                    \$${lokasi}_corousel = \$this->db->get_where(\"${lokasi}_corousel\", array(\"id_corousel\" => \$id))->row();

                    if (\$${lokasi}_corousel) {
                        \$photoPath = str_replace(base_url(), FCPATH, \$${lokasi}_corousel->gambar); // Convert URL to server path

                        if (file_exists(\$photoPath)) {
                            unlink(\$photoPath);
                        }

                        \$this->db->where(\"id_corousel\", \$id);
                        \$this->db->delete(\"${lokasi}_corousel\");

                        \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Slide show berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    } else {
                        \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Slide show tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    }
                }
                
            }
            ?>
            ";
            file_put_contents($puskesmas_folder2 . 'CorouselModel.php', $model_content);

            $model_content = "<?php

            class PegawaiModel extends CI_Model
            {
                public function getPegawai()
                {
                    return \$this->db->get('${lokasi}_pegawai');
                }
                public function getPegawaiById(\$id)
                {
                    \$this->db->where(\"id_pegawai\",\$id);
                    return \$this->db->get('${lokasi}_pegawai');
                }
                public function insertPegawai(\$${lokasi}_pegawai)
                {
                    return \$this->db->insert('${lokasi}_pegawai', \$${lokasi}_pegawai);
                }
                public function checkEmailExists(\$email) {
                    \$this->db->where('email', \$email);
                    \$query = \$this->db->get('${lokasi}_pegawai'); // Ganti 'users' dengan nama tabel yang sesuai
                    return \$query->num_rows() > 0;
                }
                public function prosesTambahPegawai(){
                        \$nama = \$this->input->post(\"nama\");
                        \$email = \$this->input->post(\"email\");
                        \$no_hp = \$this->input->post(\"no_hp\");
                        \$jabatan = \$this->input->post(\"jabatan\");
                        \$jammasuk = \$this->input->post(\"jammasuk\");
                        \$jamkeluar = \$this->input->post(\"jamkeluar\");
                       

                        if (\$this->PegawaiModel->checkEmailExists(\$email)) {
                            \$data['email_error'] = 'Email Sudah di gunakan.';
                        }
                        if (isset(\$data['email_error'])) {
                            // Load view with error messages
                            redirect(site_url('${lokasi}/${lokasi}_admin/TambahPegawai') . '?' . http_build_query(\$data));

                            return;
                        }
                       

                        \$${lokasi}_pegawai = array(
                            \"nama\" => \$nama,
                            \"email\" => \$email,
                            \"no_hp\" => \$no_hp,
                            \"jabatan\" => \$jabatan,
                            \"jammasuk\" => \$jammasuk,
                            \"jamkeluar\" => \$jamkeluar,
                            
                            \"create\" => date('Y-m-d H:i:s', Time()),
                        );
                        \$config['upload_path'] = './asset/${lokasi}';
                        \$config['allowed_types'] = 'gif|jpg|png';

                        \$this->load->library('upload', \$config);

                        if (!\$this->upload->do_upload('foto')) {
                            \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect(\$_SERVER['HTTP_REFERER']);
                        } else {
                            \$upload_data = \$this->upload->data();
                            \$${lokasi}_pegawai['foto'] = base_url(\"asset/${lokasi}/\") . \$upload_data['file_name'];
                        }

                        if (\$this->PegawaiModel->insertPegawai(\$${lokasi}_pegawai)) {
                            \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Pegawai berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect(site_url(\"${lokasi}/${lokasi}_admin/DataPegawai\"));
                        } else {
                            \$this->session->set_flashdata(\"success\", \"<div class='alert alert-danger' role='alert'>Pegawai gagal ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect(site_url(\"${lokasi}/${lokasi}_admin/TambahAdmin\"));
                        }
                }
                public function prosesUpdatePegawai(\$id) {
                    \$nama = \$this->input->post(\"nama\");
                    \$email = \$this->input->post(\"email\");
                    \$no_hp = \$this->input->post(\"no_hp\");
                    \$jabatan = \$this->input->post(\"jabatan\");
                    \$jammasuk = \$this->input->post(\"jammasuk\");
                    \$jamkeluar = \$this->input->post(\"jamkeluar\");
                  
                    \$${lokasi}_pegawai = array(
                        \"nama\" => \$nama,
                        \"email\" => \$email,
                        \"no_hp\" => \$no_hp,
                        \"jabatan\" => \$jabatan,
                        \"jammasuk\" => \$jammasuk,
                        \"jamkeluar\" => \$jamkeluar,
                        \"jamkeluar\" => \$jamkeluar,
                       
                        \"create\" => date('Y-m-d H:i:s', Time()),
                    );
                    \$existing_pegawai = \$this->db->get_where(\"${lokasi}_pegawai\", array(\"id_pegawai\" => \$id))->row();
                
                // Check if a new image is uploaded
                if (\$_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
                    \$config['upload_path'] = './asset/${lokasi}';
                    \$config['allowed_types'] = 'gif|jpg|png';
            
                    \$this->load->library('upload', \$config);
            
                    if (!\$this->upload->do_upload('foto')) {
                        \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                        redirect(\$_SERVER['HTTP_REFERER']);
                    } else {
                        \$upload_data = \$this->upload->data();
                        \$${lokasi}_pegawai['foto'] = base_url(\"asset/${lokasi}/\") . \$upload_data['file_name'];
            
                        // Delete the old image if it exists
                        if (!empty(\$existing_pegawai->foto)) {
                            unlink(\$existing_pegawai->foto); // Remove the old file
                        }
                    }
                } else {
                    // No new image uploaded, retain the existing image
                    \$${lokasi}_pegawai['foto'] = \$existing_pegawai->foto;
                }

                    \$this->db->where(\"id_pegawai\",\$id);
                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Pegawai berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return \$this->db->update(\"${lokasi}_pegawai\",\$${lokasi}_pegawai);
            }
            
            function deletePegawai(\$id){
                \$this->db->where(\"id_pegawai\", \$id);
                \$${lokasi}_pegawai = \$this->db->get_where(\"${lokasi}_pegawai\", array(\"id_pegawai\" => \$id))->row();

                if (\$${lokasi}_pegawai) {
                    \$photoPath = str_replace(base_url(), FCPATH, \$${lokasi}_pegawai->foto); // Convert URL to server path

                    if (file_exists(\$photoPath)) {
                        unlink(\$photoPath);
                    }

                    \$this->db->where(\"id_pegawai\", \$id);
                    \$this->db->delete(\"${lokasi}_pegawai\");

                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Pegawai berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                } else {
                    \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Pegawai tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                }
            }
            }
            ?>
            ";
            file_put_contents($puskesmas_folder2 .  'PegawaiModel.php', $model_content);

            

            $model_content = "<?php

            class VisiMisiModel extends CI_Model
            {
                public function getVisiMisi()
                {
                    return \$this->db->get('${lokasi}_visi_misi');
                }
                public function getVisiMisiById(\$id)
                {
                    \$this->db->where(\"id_visi\",\$id);
                    return \$this->db->get('${lokasi}_visi_misi');
                }
                function prosesUpdate(\$id){
                    \$${lokasi}_visi_misi = array(
                        \"visi\" => \$this->input->post(\"visi\"),
                        \"misi\" => \$this->input->post(\"misi\"),
                        \"motto\" => \$this->input->post(\"motto\"),
                        \"tatanilai\" => \$this->input->post(\"tatanilai\"),
                        
                        
                        );
                        \$this->db->where(\"id_visi\",\$id);
                        \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Visi & Misi berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                        return \$this->db->update(\"${lokasi}_visi_misi\",\$${lokasi}_visi_misi);
                    }
            }
            ?>
            ";
            file_put_contents($puskesmas_folder2 .'VisiMisiModel.php', $model_content);


            $model_content = "
            <?php

            class LoginModel extends CI_Model
            {
                public function getAdmin()
                {
                    return \$this->db->get('${lokasi}_login');
                }
                //Tamabahan
                public function getAdminById(\$id)
                {
                    \$this->db->where(\"id_login\",\$id);
                    return \$this->db->get('${lokasi}_login');
                }
                public function getUsernameById(\$id)
                {
                    \$this->db->where(\"username\",\$id);
                    return \$this->db->get('${lokasi}_login');
                }
                public function getEmailById(\$id)
                {
                    \$this->db->where(\"email\",\$id);
                    return \$this->db->get('${lokasi}_login');
                }
                //tambahan
                function totalData() {
                    return \$this->db->count_all('${lokasi}_login');
                }
                public function login()
                {
                    \$username = \$this->input->post(\"username\");
                    \$password = \$this->input->post(\"password\");

                    \$this->db->where(\"username\", \$username);
                    \$query = \$this->db->get(\"${lokasi}_login\");

                    if (\$query->num_rows() > 0) {
                        \$row = \$query->row();
                        \$hashed_password = \$row->password;

                        if (password_verify(\$password, \$hashed_password)) {
                            return \$row; // Mengembalikan seluruh data row user
                        }
                    }
                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Selamat datang \$username !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return null; // Tidak ditemukan atau password tidak sesuai
                }
                public function insertLogin($${lokasi}_login)
                {
                    return \$this->db->insert('${lokasi}_login', $${lokasi}_login);
                }
                //tamabahan
                public function prosesUpdate(\$id)
                {
                    \$this->load->model(\"LoginModel\", \"\", true);

                    \$username = \$this->input->post(\"username\");
                    \$email = \$this->input->post(\"email\");
                    \$password = \$this->input->post('password');

                    \$existing_admin = \$this->db->get_where( '${lokasi}_login', array(\"id_login\" => \$id))->row();

                    \$data = array(
                        'username' => \$username,
                        'email' => \$email,
                        'privasi' => '1',
                        'password' => password_hash(\$password, PASSWORD_DEFAULT)
                    );

                    // cek username dan email di ubah 
                    if (\$data['username'] !== \$existing_admin->username) {
                        \$existing_username = \$this->db->get_where( '${lokasi}_login', array(\"username\" => \$data['username']))->row();
                        if (\$existing_username) {
                            // jika username sama 
                            \$data['username_error'] = 'Username Sudah di gunakan.';
                            redirect(site_url('${lokasi}/${lokasi}_admin/UpdateAdmin/'.\$id_admin ) . '?' . http_build_query(\$data));
                        }
                    }

                    if (\$data['email'] !== \$existing_admin->email) {
                        \$existing_email = \$this->db->get_where( '${lokasi}_login', array(\"email\" => \$data['email']))->row();
                        if (\$existing_email) {
                            // jika email sama
                            \$data['email_error'] = 'Email Sudah di gunakan.';
                            redirect(site_url('${lokasi}/${lokasi}_admin/UpdateAdmin/' .\$id_admin) . '?' . http_build_query(\$data));
                        }
                    }
                    // Refresh session data
                    \$this->load->library('session');
                    \$user_data = array(
                        'username' => \$data['username'],
                        'privasi' => \$data['privasi'],
                        
                    );
                    \$this->session->set_userdata(\$user_data);

                    \$this->db->where(\"id_login\", \$id);
                    if (\$this->db->update(\"${lokasi}_login\", \$data)) {
                        \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Admin berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                        redirect(site_url(\"${lokasi}/${lokasi}_admin\"));
                    } else {
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/EditAdmin/{\$id}\"));
                    }
                }

                // Di dalam LoginModel.php
                public function checkUsernameExists(\$username) {
                    \$this->db->where('username', \$username);
                    \$query = \$this->db->get('${lokasi}_login'); // Ganti 'users' dengan nama tabel yang sesuai
                    return \$query->num_rows() > 0;
                }
                // Di dalam LoginModel.php
                public function checkEmailExists(\$email) {
                    \$this->db->where('email', \$email);
                    \$query = \$this->db->get('${lokasi}_login'); // Ganti 'users' dengan nama tabel yang sesuai
                    return \$query->num_rows() > 0;
                }

                public function get_user_by_email(\$email)
                {
                    return \$this->db->get_where('${lokasi}_login', ['email' => \$email])->row_array();
                }

                public function set_reset_token(\$id, \$token)
                {
                    \$data = [
                        'reset_token' => \$token,
                        'reset_token_expiration' => date('Y-m-d H:i:s', strtotime('+1 hour')),
                    ];

                    \$this->db->where('id_login', \$id);
                    \$this->db->update('${lokasi}_login', \$data);
                }
                //mengambil data user by token
                public function get_user_by_reset_token(\$token)
                {
                    return \$this->db->get_where('${lokasi}_login', ['reset_token' => \$token])->row_array();
                }
                //update pw
                public function update_password(\$id, \$password)
                {
                    
                    \$hashed_password = password_hash(\$password, PASSWORD_DEFAULT);

                    \$data = [
                        'password' => \$hashed_password,
                    ];

                    \$this->db->where('id_login', \$id);
                    \$this->db->update('${lokasi}_login', \$data);
                }
                //hapus token yang sudah di gunakan
                public function remove_reset_token(\$id)
                {
                    \$data = [
                        'reset_token' => null,
                        'reset_token_expiration' => null,
                    ];

                    \$this->db->where('id_login', \$id);
                    \$this->db->update('${lokasi}_login', \$data);
                }
            }


            ";
            file_put_contents($puskesmas_folder2 .'LoginModel.php', $model_content);

            $model_content = "
            <?php

            class OrganisasiModel extends CI_Model
            {
                public function getOrganisasi()
                {
                    return \$this->db->get('${lokasi}_organisasi');
                }
                public function getOrganisasiById(\$id)
                {
                    \$this->db->where(\"id_organisasi\",\$id);
                    return \$this->db->get('${lokasi}_organisasi');
                }
                public function prosesUpdateOrganisasi(\$id) {
                    \$keterangan = \$this->input->post(\"keterangan\");
                    
                    
                    \$${lokasi}_organisasi = array(
                        \"keterangan\" => \$keterangan,
                        \"date_create\" => date('Y-m-d H:i:s', Time()),
                    );
                
                    \$existing_organisasi = \$this->db->get_where(\"${lokasi}_organisasi\", array(\"id_organisasi\" => \$id))->row();
                    
                    // Check if a new image is uploaded
                    if (\$_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
                        \$config['upload_path'] = './asset/${lokasi}';
                        \$config['allowed_types'] = 'gif|jpg|png';
                
                        \$this->load->library('upload', \$config);
                
                        if (!\$this->upload->do_upload('gambar')) {
                            \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect(\$_SERVER['HTTP_REFERER']);
                        } else {
                            \$upload_data = \$this->upload->data();
                            \$${lokasi}_organisasi['gambar'] = base_url(\"asset/${lokasi}/\") . \$upload_data['file_name'];
                
                            // Delete the old image if it exists
                            if (!empty(\$existing_organisasi->gambar)) {
                                unlink(\$existing_organisasi->gambar); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded, retain the existing image
                        \$${lokasi}_organisasi['gambar'] = \$existing_organisasi->gambar;
                    }
                
                    \$this->db->where(\"id_organisasi\", \$id);
                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Organisasi berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return \$this->db->update(\"${lokasi}_organisasi\", \$${lokasi}_organisasi);
                }
                 
            }
            ?>
            
            ";
            file_put_contents($puskesmas_folder2 .'OrganisasiModel.php', $model_content);

            $model_content = "
            
            <?php

            class GaleryModel extends CI_Model
            {
                public function getGalery()
                {
                    return \$this->db->get('${lokasi}_galery');
                }
                public function getGaleryById(\$id)
                {
                    \$this->db->where(\"id_galery\",\$id);
                    return \$this->db->get('${lokasi}_galery');
                }
                public function prosesTambahGalery(){
                    \$kegiatan = \$this->input->post('kegiatan');
                    
                    \$${lokasi}_galery = array(
                        \"kegiatan\" => \$kegiatan,
                        \"date_create\" => date('Y-m-d H:i:s', Time()),
                    );
                    \$config['upload_path'] = './asset/${lokasi}';
                    \$config['allowed_types'] = 'gif|jpg|png';

                    \$this->load->library('upload', \$config);

                    if (!\$this->upload->do_upload('gambar')) {
                        \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                        redirect(\$_SERVER['HTTP_REFERER']);
                    } else {
                        \$upload_data = \$this->upload->data();
                        \$${lokasi}_galery['gambar'] = base_url(\"asset/${lokasi}/\") . \$upload_data['file_name'];
                    }

                    \$this->db->where(\"id_galery\");
                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Galery berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return \$this->db->insert(\"${lokasi}_galery\",\$${lokasi}_galery);
                }
                public function prosesUpdateGalery(\$id) {
                    \$kegiatan = \$this->input->post('kegiatan');
                    
                    \$${lokasi}_galery = array(
                        \"kegiatan\" => \$kegiatan,
                        \"date_create\" => date('Y-m-d H:i:s', Time()),
                    );
                
                    \$existing_galery = \$this->db->get_where(\"${lokasi}_galery\", array(\"id_galery\" => \$id))->row();
                    
                    // Check if a new image is uploaded
                    if (\$_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
                        \$config['upload_path'] = './asset/${lokasi}';
                        \$config['allowed_types'] = 'gif|jpg|png';
                
                        \$this->load->library('upload', \$config);
                
                        if (!\$this->upload->do_upload('gambar')) {
                            \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect(\$_SERVER['HTTP_REFERER']);
                        } else {
                            \$upload_data = \$this->upload->data();
                            \$${lokasi}_galery['gambar'] = base_url(\"asset/${lokasi}/\") . \$upload_data['file_name'];
                
                            // Delete the old image if it exists
                            if (!empty(\$existing_galery->gambar)) {
                                unlink(\$existing_galery->gambar); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded, retain the existing image
                        \$${lokasi}_galery['gambar'] = \$existing_galery->gambar;
                    }
                
                    \$this->db->where(\"id_galery\", \$id);
                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Galery berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return \$this->db->update(\"${lokasi}_galery\", \$${lokasi}_galery);
                }
                function deleteGalery(\$id){
                    \$this->db->where(\"id_galery\", \$id);
                    \$${lokasi}_galery = \$this->db->get_where(\"${lokasi}_galery\", array(\"id_galery\" => \$id))->row();

                    if (\$${lokasi}_galery) {
                        \$photoPath = str_replace(base_url(), FCPATH, \$${lokasi}_galery->gambar); // Convert URL to server path

                        if (file_exists(\$photoPath)) {
                            unlink(\$photoPath);
                        }

                        \$this->db->where(\"id_galery\", \$id);
                        \$this->db->delete(\"${lokasi}_galery\");

                        \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Berita berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    } else {
                        \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Berita tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    }
                }
                
            }
            ?>
            
            ";
            file_put_contents($puskesmas_folder2 .'GaleryModel.php', $model_content);


           

            $model_content = "
            <?php

            class LayananPublikModel extends CI_Model
            {
                public function getLayananPublik()
                {
                    return \$this->db->get('${lokasi}_layananpublik');
                }
                public function getLayanan()
                {
                    return \$this->db->get('${lokasi}_layanan');
                }
                public function getLayananPublikById(\$id)
                {
                    \$this->db->where(\"id_layananpublik\",\$id);
                    return \$this->db->get('${lokasi}_layananpublik');
                }
                public function getLayananById(\$id)
                {
                    \$this->db->where(\"id_layanan\",\$id);
                    return \$this->db->get('${lokasi}_layanan');
                }
                public function insertLayananPublik(\$${lokasi}_layananpublik)
                {
                    return \$this->db->insert('${lokasi}_layananpublik', \$${lokasi}_layananpublik);
                }
                public function prosesTambahLayananPublik(){
                    \$produk = \$this->input->post(\"produk\");
                    \$biaya = \$this->input->post('biaya');
                    
                    \$${lokasi}_layananpublik = array(
                        \"produk\" => \$produk,
                        \"biaya\" => \$biaya,
                       
                    );

                    if (\$this->LayananPublikModel->insertLayananPublik(\$${lokasi}_layananpublik)) {
                        \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Layanan berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/LayananPublik\"));
                    } else {
                        \$this->session->set_flashdata(\"success\", \"<div class='alert alert-danger' role='alert'>Layanan gagal ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                        redirect(site_url(\"${lokasi}/${lokasi}_admin/TambahLayananPublik\"));
                    }
                }
                
                public function prosesUpdateLayananPublik(\$id) {
                    \$produk = \$this->input->post(\"produk\");
                    \$biaya = \$this->input->post('biaya');
                   
                  
                    
                    \$${lokasi}_layananpublik = array(
                        \"produk\" => \$produk,
                        
                        \"biaya\" => \$biaya,
   
                    );
                    
                    \$this->db->where(\"id_layananpublik\", \$id);
                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Layanan berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return \$this->db->update(\"${lokasi}_layananpublik\", \$${lokasi}_layananpublik);
                }  
                function prosesUpdateLayanan(\$id){
                    \$fasilitas = \$this->input->post(\"fasilitas\");
                    \$sarana = \$this->input->post(\"sarana\");
                    \$mekanisme = \$this->input->post('mekanisme');
                  
                    
                    \$${lokasi}_layanan = array(
                        \"fasilitas\" => \$fasilitas,
                        \"sarana\" => \$sarana,
                        \"mekanisme\" => \$mekanisme,
                        
                    );
                    
                    \$existing_layanan = \$this->db->get_where(\"${lokasi}_layanan\", array(\"id_layanan\" => \$id))->row();
                    
                    // Check if a new image is uploaded for konpensasi
                    if (\$_FILES['konpensasi']['error'] !== UPLOAD_ERR_NO_FILE) {
                        \$config['upload_path'] = './asset/${lokasi}';
                        \$config['allowed_types'] = 'gif|jpg|png';
                        
                        \$this->load->library('upload', \$config);
                        
                        if (!\$this->upload->do_upload('konpensasi')) {
                            \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect(\$_SERVER['HTTP_REFERER']);
                        } else {
                            \$upload_data = \$this->upload->data();
                            \$${lokasi}_layanan['konpensasi'] = base_url(\"asset/${lokasi}/\") . \$upload_data['file_name'];
                            
                            // Delete the old image if it exists
                            if (!empty(\$existing_layanan->konpensasi)) {
                                unlink(\$existing_layanan->konpensasi); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded for konpensasi, retain the existing image
                        \$${lokasi}_layanan['konpensasi'] = \$existing_layanan->konpensasi;
                    }
                    
                    // Check if a new image is uploaded for spm
                    if (\$_FILES['spm']['error'] !== UPLOAD_ERR_NO_FILE) {
                        \$config['upload_path'] = './asset/${lokasi}';
                        \$config['allowed_types'] = 'gif|jpg|png';
                        
                        \$this->load->library('upload', \$config);
                        
                        if (!\$this->upload->do_upload('spm')) {
                            \$error = \$this->upload->display_errors();
                            \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect(\$_SERVER['HTTP_REFERER']);
                        } else {
                            \$upload_data = \$this->upload->data();
                            \$${lokasi}_layanan['spm'] = base_url(\"asset/${lokasi}/\") . \$upload_data['file_name'];
                            
                            // Delete the old image if it exists
                            if (!empty(\$existing_layanan->spm)) {
                                unlink(\$existing_layanan->spm); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded for spm, retain the existing image
                        \$${lokasi}_layanan['spm'] = \$existing_layanan->spm;
                    }
                    \$this->db->where(\"id_layanan\", \$id);
                    \$this->session->set_flashdata(\"success_edit\", \"<div class='alert alert-success' role='alert'>Layanan berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return \$this->db->update(\"${lokasi}_layanan\", \$${lokasi}_layanan);
                }                        
                
                function deleteLayananPublik(\$id) {
                    \$this->db->where(\"id_layananpublik\", \$id);
                    \$${lokasi}_layananpublik = \$this->db->get_where(\"${lokasi}_layananpublik\", array(\"id_layananpublik\" => \$id))->row();
                
                    if (\$${lokasi}_layananpublik) {
                       
                
                        
                
                            \$this->db->where(\"id_layananpublik\", \$id);
                            \$this->db->delete(\"${lokasi}_layananpublik\");
                
                            \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Layanan berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                        
                    } else {
                        \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Layanan tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    }
                
                   
                }
                
            }
            ?>
            
            
            ";
            file_put_contents($puskesmas_folder2 .'LayananPublikModel.php', $model_content);

            $model_content = "
            <?php

            class LayananKhususModel extends CI_Model
            {
                public function getLayananKhusus()
                {
                    return \$this->db->get('${lokasi}_layanankhusus');
                }
                public function getLayananKhususById(\$id)
                {
                    \$this->db->where(\"id_layanankhusus\",\$id);
                    return \$this->db->get('${lokasi}_layanankhusus');
                }
                public function prosesTambahLayananKhusus(){
                    \$visi = \$this->input->post(\"visi\");
                    \$misi = \$this->input->post(\"misi\");
                    \$atribut = \$this->input->post('atribut');
                    \$layananterpadu = \$this->input->post('layananterpadu');
                    
                    
                    \$${lokasi}_layanankhusus = array(
                        \"visi\" => \$visi,
                        \"misi\" => \$misi,
                        \"atribut\" => \$atribut,
                        \"layananterpadu\" => \$layananterpadu,

                    );
                    

                    \$this->db->where(\"id_layanankhusus\");
                    return \$this->db->insert(\"${lokasi}_layanankhusus\",\$${lokasi}_layanankhusus);
                }
                public function prosesUpdateLayananKhusus(\$id) {
                    \$visi = \$this->input->post(\"visi\");
                    \$misi = \$this->input->post(\"misi\");
                    \$atribut = \$this->input->post('atribut');
                    \$layananterpadu = \$this->input->post('layananterpadu');
                    
                    
                    \$${lokasi}_layanankhusus = array(
                        \"visi\" => \$visi,
                        \"misi\" => \$misi,
                        \"atribut\" => \$atribut,
                        \"layananterpadu\" => \$layananterpadu,
                        
                    );
                
                    \$this->db->where(\"id_layanankhusus\", \$id);
                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Layanan Khusus berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return \$this->db->update(\"${lokasi}_layanankhusus\", \$${lokasi}_layanankhusus);
                }
                
                
            }
            ?>
            
            
            ";
            file_put_contents($puskesmas_folder2 .'LayananKhususModel.php', $model_content);

            $model_content = "
            <?php

            class SejarahModel extends CI_Model
            {
                public function getSejarah()
                {
                    return \$this->db->get('${lokasi}_sejarah');
                }
                //Tamabahan
                public function getSejarahById(\$id)
                {
                    \$this->db->where(\"id_sejarah\",\$id);
                    return \$this->db->get('${lokasi}_sejarah');
                }
                function prosesUpdate(\$id) {
                    \$${lokasi}_sejarah = array(
                        \"sejarah\" => \$this->input->post(\"sejarah\"),
                        \"alamat\" => \$this->input->post(\"alamat\"),
                    );
                
                    // Retrieve the existing data
                    \$existing_sejarah = \$this->db->get_where(\"${lokasi}_sejarah\", array(\"id_sejarah\" => \$id))->row();
                
                    // Check if a new image is uploaded
                    if (\$_FILES['maklumat']['error'] !== UPLOAD_ERR_NO_FILE) {
                        \$config['upload_path'] = './asset/${lokasi}';
                        \$config['allowed_types'] = 'gif|jpg|png';
                
                        \$this->load->library('upload', \$config);
                
                        if (!\$this->upload->do_upload('maklumat')) {
                            \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                            redirect(\$_SERVER['HTTP_REFERER']);
                        } else {
                            \$upload_data = \$this->upload->data();
                            \$${lokasi}_sejarah['maklumat'] = base_url(\"asset/${lokasi}/\") . \$upload_data['file_name'];
                
                            // Delete the old image if it exists
                            if (!empty(\$existing_sejarah->maklumat)) {
                                unlink(\$existing_sejarah->maklumat); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded, retain the existing image
                        \$${lokasi}_sejarah['maklumat'] = \$existing_sejarah->maklumat;
                    }
                
                    // Retain the existing alamat_map
                    \$${lokasi}_sejarah['alamat_map'] = \$existing_sejarah->alamat_map;
                
                    // Update the database with new values
                    \$this->db->where(\"id_sejarah\", \$id);
                    \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    return \$this->db->update(\"${lokasi}_sejarah\", \$${lokasi}_sejarah);
                }
                
                    
            }
            
        ?>

            ";
            file_put_contents($puskesmas_folder2 .'SejarahModel.php', $model_content);

            $model_content = "

            <?php

            class SosialMediaModel extends CI_Model
            {
                public function getSosialMedia()
                {
                    return \$this->db->get('${lokasi}_sosialmedia');
                }
                //Tamabahan
                public function getSosialMediaById(\$id)
                {
                    \$this->db->where(\"id_sosialmedia\",\$id);
                    return \$this->db->get('${lokasi}_sosialmedia');
                }
                function prosesUpdate(\$id){
                    \$${lokasi}_sosialmedia = array(
                        \"instagram\" => \$this->input->post(\"instagram\"),
                        \"facebook\" => \$this->input->post(\"facebook\"),
                        \"twiter\" => \$this->input->post(\"twiter\"),
                        \"email\" => \$this->input->post(\"email\"),
                        \"no_hp\" => \$this->input->post(\"no_hp\"),
                        \"kode_pos\" => \$this->input->post(\"kode_pos\"),
                        
                        
                        );
                        \$this->db->where(\"id_sosialmedia\",\$id);
                        \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Sosial Media berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                        return \$this->db->update(\"${lokasi}_sosialmedia\",\$${lokasi}_sosialmedia);
                }
                    
            }
            
         ?>
            
            ";
            file_put_contents($puskesmas_folder2 .'SosialMediaModel.php', $model_content);

            $model_content = "

            <?php
            class PendaftaranModel extends CI_Model
            {
                public function getPendaftaran()
                {
                    return \$this->db->get('${lokasi}_pendaftaran');
                }
                function totalData() {
                    return \$this->db->count_all('${lokasi}_pendaftaran');
                }
                public function deletePendaftaran(\$id)
                {
                    \$this->db->where(\"id_pendaftaran\", \$id);
                    \$${lokasi}_pendaftaran = \$this->db->get_where(\"${lokasi}_pendaftaran\", array(\"id_pendaftaran\" => \$id))->row();

                    if (\$${lokasi}_pendaftaran) {
                        \$photoPath = str_replace(base_url(), FCPATH, \$${lokasi}_pendaftaran->qr_code); // Convert URL to server path

                        if (file_exists(\$photoPath)) {
                            unlink(\$photoPath);
                        }

                        \$this->db->where(\"id_pendaftaran\", \$id);
                        \$this->db->delete(\"${lokasi}_pendaftaran\");

                        \$this->session->set_flashdata(\"success\", \"<div class='alert alert-success' role='alert'>Pendaftaran berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    } else {
                        \$this->session->set_flashdata(\"error\", \"<div class='alert alert-danger' role='alert'>Pendaftaran tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>\");
                    }
                }

                public function getPendaftaranById(\$id)
                {
                    \$this->db->where(\"id_pendaftaran\", \$id);
                    return \$this->db->get('${lokasi}_pendaftaran');
                }
                public function getAntrian()
                {
                    return \$this->db->get('${lokasi}_antrian');
                }
                public function getAntrianById(\$id)
                {
                    \$this->db->where(\"id\", \$id);
                    return \$this->db->get('${lokasi}_antrian');
                }
                public function UpdateAntrian(\$id) {
                    \$max_nomber = \$this->input->post(\"max_nomber\");
                    \$antrian = array(
                        \"max_nomber\" => \$max_nomber,   
                    );
                    \$this->db->where(\"id\", \$id);
                    \$this->session->set_flashdata('success', \"<div class='alert alert-success' role='alert'>Max Antrian di perbaharui!</div>\");
                    return \$this->db->update(\"${lokasi}_antrian\", \$antrian);
                }

                public function Daftar()
                {
                    \$this->load->library('ciqrcode');
                    \$this->load->library('session');

                    if (\$this->input->post()) {
                        \$last_queue_number = \$this->PendaftaranModel->get_last_queue_number(); // Get the last queue number from the database
                        \$antrian =  \$this->PendaftaranModel->getAntrian()->row();
                        \$max = \$antrian->max_nomber;

                        
                            // Check if the current day is different from the last recorded day
                            \$last_recorded_date = \$this->PendaftaranModel->get_last_recorded_date();
                            \$current_date = date('Y-m-d');

                            if (\$last_recorded_date != \$current_date) {
                                \$next_queue_number = 1; // Reset the queue number to 1 for a new day
                            } else {
                                \$next_queue_number = \$last_queue_number + 1;
                            
                        }

                        if (\$next_queue_number <= \$max) { // Check if the next queue number is within the desired range
                            \$data = array(
                                'nomor_pendaftaran' => \$next_queue_number,
                                'nama' => \$this->input->post('nama'),
                                'tanggal_lahir' => \$this->input->post('tanggal_lahir'),
                                'alamat' => \$this->input->post('alamat'),
                                'layanan' => \$this->input->post('layanan'),
                                'tanggal' => date('Y-m-d H:i:s', time()),
                            );

                            \$qr_code_path = \$this->generate_qr_code(\$data);

                            if (\$qr_code_path) {
                                \$data['qr_code'] = \$qr_code_path;
                                \$id = \$this->PendaftaranModel->save_data(\$data);
                                \$this->session->set_flashdata('success', \"<div class='alert alert-success' role='alert'>Daftar berhasil!</div>\");
                                redirect(site_url(\"${lokasi}/${lokasi}/Tiket/\" . \$id));
                            } else {
                                \$this->session->set_flashdata('error', 'Gagal melakukan pendaftaran.');
                            }
                        } else {
                            \$this->session->set_flashdata('success', \"<div class='alert alert-danger' role='alert'>Pendaftaran Penuh!</div>\");
                        }

                        redirect('${lokasi}/${lokasi}/Pendaftaran');
                    }
                }

                public function get_last_recorded_date()
                {
                    \$this->db->select_max('tanggal');
                    \$query = \$this->db->get('${lokasi}_pendaftaran');
                    \$result = \$query->row_array();

                    return isset(\$result['tanggal']) ? date('Y-m-d', strtotime(\$result['tanggal'])) : null;
                }
                
                public function get_last_queue_number()
                {
                    date_default_timezone_set('Asia/Jakarta');
                    \$current_date = date('Y-m-d');
                    
                    \$this->db->select('nomor_pendaftaran');
                    \$this->db->where('DATE(tanggal)', \$current_date);
                    \$this->db->order_by('nomor_pendaftaran', 'DESC');
                    \$this->db->limit(1);
                    \$query = \$this->db->get('${lokasi}_pendaftaran');

                    \$result = \$query->row_array();

                    if (empty(\$result)) {
                        return 0; // Reset to 0 when no records found for the current date
                    }

                    return isset(\$result['nomor_pendaftaran']) ? \$result['nomor_pendaftaran'] : 0;
                }
                

                public function generate_qr_code(\$data)
                {
                    \$this->load->library('ciqrcode');

                    \$qr_code_data = \"Nama: \" . \$data['nama'] . \"\n\";
                    \$qr_code_data .= \"No Pendaftaran: \" . \$data['nomor_pendaftaran'] . \"\n\";
                    \$qr_code_data .= \"Tanggal: \" . \$data['tanggal'] . \"\n\";
                    \$qr_code_data .= \"Layanan: \" . \$data['layanan'] . \"\n\"; // Menambahkan informasi layanan
                    // Tambahkan informasi lain sesuai kebutuhan, dengan format yang sesuai

                    \$qr_code_name = \$data['nama'] . '_layanan_' . \$data['layanan'] . '.png'; // Ubah format nama file

                    \$config['cacheable'] = true;
                    \$config['cachedir'] = './asset/image/qrcodes/';
                    \$config['errorlog'] = './asset/image/qrcodes/';
                    \$config['quality'] = true;
                    \$config['size'] = 1024;
                    \$config['black'] = array(224, 255, 255);
                    \$config['white'] = array(70, 130, 180);

                    \$this->ciqrcode->initialize(\$config);

                    try {
                        \$params['data'] = \$qr_code_data;
                        \$params['level'] = 'H';
                        \$params['size'] = \$config['size'];
                        \$params['savename'] = \$config['cachedir'] . \$qr_code_name;
                        \$this->ciqrcode->generate(\$params);
                    } catch (Exception \$e) {
                        return false;
                    }

                    \$qr_code_path = base_url() . 'asset/image/qrcodes/' . \$qr_code_name;
                    return \$qr_code_path;
                }

                public function save_data(\$data)
                {
                    \$this->db->insert('${lokasi}_pendaftaran', \$data);
                    return \$this->db->insert_id(); // Mengembalikan ID yang baru saja dibuat
                }
                public function sisa(){
                    \$last_queue_number = \$this->PendaftaranModel->get_last_queue_number();
                    \$antrian =  \$this->PendaftaranModel->getAntrian()->row();
                    \$max = \$antrian->max_nomber;
                
                    \$sisa_pendaftaran = \$max - \$last_queue_number;
                
                    return \$sisa_pendaftaran;
                }
            }

            ?>
            
            ";
            file_put_contents($puskesmas_folder2 .'PendaftaranModel.php', $model_content);

            // Buat berkas View di dalam direktori 'views'
            $puskesmas_folder3 = APPPATH . 'views/' . $lokasi . '/';
            if (!is_dir($puskesmas_folder3)) {
                mkdir($puskesmas_folder3, 0777, true);
            }

            
            $view_content = "
            <!DOCTYPE html>
            <html lang=\"en\">
            <head>
            <meta charset=\"utf-8\">
                <meta content=\"width=device-width, initial-scale=1.0\" name=\"viewport\">
                <meta content=\"Free HTML Templates\" name=\"keywords\">
                <meta content=\"Free HTML Templates\" name=\"description\">
                <title><?=\$title?></title>
                <!-- Favicon -->
                <link href=\"<?php echo base_url('asset/assets_user/img/favicon.ico'); ?>\" rel=\"icon\">

                <!-- Google Web Fonts -->
                <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\">
                <link href=\"https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap\" rel=\"stylesheet\"> 

                <!-- Icon Font Stylesheet -->
                <link href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css\" rel=\"stylesheet\">
                <link href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css\" rel=\"stylesheet\">

                <!-- Libraries Stylesheet -->
                <link href = \"<?php echo base_url(); ?>asset/assets_user/lib/owlcarousel/assets/owl.carousel.min.css\" rel=\"stylesheet\">
                <link href = \"<?php echo base_url(); ?>asset/assets_user/lib/animate/animate.min.css\" rel=\"stylesheet\">
                <link href = \"<?php echo base_url(); ?>asset/assets_user/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css\" rel=\"stylesheet\" />
                <link href = \"<?php echo base_url(); ?>asset/assets_user/lib/twentytwenty/twentytwenty.css\" rel=\"stylesheet\" />

                <!-- Customized Bootstrap Stylesheet -->
                <link href = \"<?php echo base_url(); ?>asset/assets_user/css/bootstrap.min.css\" rel=\"stylesheet\"> 

                <!-- Template Stylesheet -->
                <link href = \"<?php echo base_url(); ?>asset/assets_user/css/style.css\" rel=\"stylesheet\"> 
                <link rel=\"icon\" href=\"<?php echo base_url('asset/img/logodefault.png'); ?>\" type=\"image/x-icon\">
                <meta name=\"description\" content=\"${meta_desk}\">

                <style>
                    .map-responsive {
                        overflow: hidden;
                        padding-bottom: 56.25%;
                        position: relative;
                        height: 0;
                    }
                
                    .map-responsive iframe {
                        left: 0;
                        top: 0;
                        height: 100%;
                        width: 100%;
                        position: absolute;
                    }
                    #carouselExampleIndicators {
                        max-width: 1600px; /* Adjust the max-width as needed */
                        margin: 0 auto; /* Center the carousel */
                    }
                    
                    .carousel-inner {
                        max-height: 500px; /* Adjust the max-height as needed */
                    }
                    
                    .carousel-inner img {
                        max-height: 100%; /* Make the images fill the carousel height */
                        object-fit: cover; /* Maintain aspect ratio and cover the carousel */
                    }
                </style>
            </head>
            <body>
                <!-- Navbar Start -->
                <nav class=\"navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0\">
                <a href=\"<?= site_url('${lokasi}/${lokasi}')?>\" class=\"navbar-brand p-0\">
                <?php
                foreach (\$${lokasi}_visi_misi->result() as \$row) {?>
                <img src=\"<?=\$row->logo?>\" alt=\"\" width=\"30\" height=\"40\" class=\"d-inline-block align-text-mid\">
                <?php }?>
                    Puskesmas ${lokasi}
                </a>
                <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarCollapse\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
                <div class=\"collapse navbar-collapse\" id=\"navbarCollapse\">
                    <div class=\"navbar-nav ms-auto py-0\">
                        <a href=\"<?= site_url('${lokasi}/${lokasi}')?>\" class=\"nav-item nav-link\">Beranda</a>
                        <a href=\"<?=site_url('${lokasi}/${lokasi}/Pendaftaran')?>\" class=\"nav-item nav-link\">Pendaftaran Online</a>
                        <div class=\"nav-item dropdown\">
                            <a href=\"#\" class=\"nav-link dropdown-toggle\" data-bs-toggle=\"dropdown\">Profile</a>
                            <div class=\"dropdown-menu m-0\">
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Sejarah')?>\" class=\"dropdown-item\">Sejarah</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Visi')?>\" class=\"dropdown-item\">Visi & Misi</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Tatanilai')?>\" class=\"dropdown-item\">Tata Nilai</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Struktur')?>\" class=\"dropdown-item\">Struktur Ogranisasi</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Datapegawai')?>\" class=\"dropdown-item\">Data Pegawai</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Lokasi')?>\" class=\"dropdown-item\">Lokasi & Kontak</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Maklumat')?>\" class=\"dropdown-item\">Maklumat</a>
                            </div>
                        </div>
                        <div class=\"nav-item dropdown\">
                            <a href=\"#\" class=\"nav-link dropdown-toggle\" data-bs-toggle=\"dropdown\">Layanan Publik</a>
                            <div class=\"dropdown-menu m-0\">
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Mekanisme')?>\" class=\"dropdown-item\">Mekanisme & Prosedur</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Sarana')?>\" class=\"dropdown-item\">Sarana & Prasarana</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Fasilitas')?>\" class=\"dropdown-item\">Fasilitas</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Tarif')?>\" class=\"dropdown-item\">Produk & Tarif Layanan</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Kompensasi')?>\" class=\"dropdown-item\">Kompensasi Pelayanan</a>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/Standar')?>\" class=\"dropdown-item\">Standar Pelayanan Minimal</a>
                            </div>
                        </div>
                        <div class=\"nav-item dropdown\">
                            <a href=\"#\" class=\"nav-link dropdown-toggle\" data-bs-toggle=\"dropdown\">Layanan Khusus</a>
                            <div class=\"dropdown-menu m-0\">
                                <a href=\"<?php echo site_url('${lokasi}/${lokasi}/VisiPelayanan'); ?>\" class=\"dropdown-item\">Visi & Pelayanan</a>
                                <a href=\"<?php echo site_url('${lokasi}/${lokasi}/Atribut'); ?>\" class=\"dropdown-item\">Atribut</a>
                                <a href=\"<?php echo site_url('${lokasi}/${lokasi}/Layanan'); ?>\" class=\"dropdown-item\">Layanan Terpadu</a>
                            </div>
                        </div>
                        <div class=\"nav-item dropdown\">
                            <a href=\"#\" class=\"nav-link dropdown-toggle\" data-bs-toggle=\"dropdown\">Pengaduan</a>
                            <div class=\"dropdown-menu m-0\">
                                <a href=\"<?php echo site_url('${lokasi}/${lokasi}/Pengaduan'); ?>\" class=\"dropdown-item\">Pengaduan Pasien</a>
                                <a href=\"<?php echo site_url('${lokasi}/${lokasi}/Kepuasan'); ?>\" class=\"dropdown-item\">Kepuasan Pasien</a>
                            </div>
                        </div>
                        <div class=\"nav-item dropdown\">
                            <a href=\"#\" class=\"nav-link dropdown-toggle\" data-bs-toggle=\"dropdown\">Berita</a>
                            <div class=\"dropdown-menu m-0\">
                                <a href=\"<?php echo site_url('${lokasi}/${lokasi}/Agenda'); ?>\" class=\"dropdown-item\">Agenda Kegiatan</a>
                                <a href=\"<?php echo site_url('${lokasi}/${lokasi}/Artikel'); ?>\" class=\"dropdown-item\">Artikel & Berita</a>
                            </div>
                        </div>
                    </div>
                    <a href=\"<?=site_url('${lokasi}/Auth')?>\" class=\"btn btn-primary py-2 px-4 ms-3\">Login</a>
                </div>
                </nav>
                <!-- Navbar End -->


            ";
            file_put_contents($puskesmas_folder3 .  'Navbar.php', $view_content);

            $view_content = "
            <!-- Footer Start -->
            <div class=\"container-fluid bg-dark text-light py-5 wow fadeInUp\" data-wow-delay=\"0.3s\" style=\"margin-top: -75px;\">
                    <div class=\"container pt-5\">
                        <div class=\"row g-5 pt-4\">
                            <div class=\"col-lg-3 col-md-6\">
                            
                                <h3 class=\"text-white mb-4\">Kontak Kami</h3>
                                <?php
                                    foreach (\$${lokasi}_sejarah->result() as \$row) {?>
                                <p class=\"mb-2\"><i class=\"bi bi-geo-alt text-primary me-2\"></i><?php echo \$row->alamat?></p>
                                <?php }?>
                                <?php
                                    foreach (\$${lokasi}_sosialmedia->result() as \$row) {?>
                                <p class=\"mb-2\"><i class=\"bi bi-envelope-open text-primary me-2\"></i><?php echo \$row->email?></p>
                                <p class=\"mb-0\"><i class=\"bi bi-telephone text-primary me-2\"></i><?php echo \$row->no_hp?></p>
                                <?php }?>
                            </div>
                            <div class=\"col-lg-3 col-md-6\">
                                <h3 class=\"text-white mb-4\">Tautan</h3>
                                <div class=\"d-flex flex-column justify-content-start\">
                                    <a class=\"text-light mb-2\" href=\"#\"><i class=\"bi bi-arrow-right text-primary me-2\"></i>Kabupaten Bandung Barat</a>
                                    <a class=\"text-light mb-2\" href=\"#\"><i class=\"bi bi-arrow-right text-primary me-2\"></i>Dinkes KBB</a>
                                    <a class=\"text-light mb-2\" href=\"#\"><i class=\"bi bi-arrow-right text-primary me-2\"></i>Diskominfotik KBB</a>
                                </div>
                            </div>
                            <div class=\"col-lg-3 col-md-6\">
                                <h3 class=\"text-white mb-4\">Jam Pelayanan</h3>
                                <div class=\"d-flex flex-column justify-content-start\">
                                <p class=\"text-white mb-2\">Jam Pelayanan Puskesmas <br>
                                                            Senin-Kamis : 07.00 - 15.00 <br>
                                                            Jumat : 07.00 - 11.00 <br>
                                                            Unit Pelayanan Bersalin 24 Jam <br>
                                                            Info lebih lanjut silahkan lihat  dibagian Layanan pada tab Layanan <br>
                                </p>
                                </div>
                            </div>
                            <div class=\"col-lg-3 col-md-6\">
                                <h3 class=\"text-white mb-4\">Sosial Media Kami</h3>
                                <div class=\"d-flex\">
                                <?php
                                    foreach (\$${lokasi}_sosialmedia->result() as \$row) {?>
                                    <a class=\"btn btn-lg btn-dark btn-lg-square rounded me-2\" href=\"<?php echo \$row->twiter?>\"><i class=\"fab fa-twitter fw-normal\"></i></a>
                                    <a class=\"btn btn-lg btn-dark btn-lg-square rounded me-2\" href=\"<?php echo \$row->facebook?>\"><i class=\"fab fa-facebook-f fw-normal\"></i></a>
                                    <a class=\"btn btn-lg btn-dark btn-lg-square rounded\" href=\"<?php echo \$row->instagram?>\"><i class=\"fab fa-instagram fw-normal\"></i></a>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class=\"container-fluid text-light py-4\" style=\"background: #27ae60;\">
                    <div class=\"container\">
                        <div class=\"row g-0\">
                            <div class=\"col-md-6 text-center text-md-start\">
                                <p class=\"mb-md-0\">&copy; <a class=\"text-white border-bottom\" href=\"#\">2023</a>: Diskominfotik Kabupaten Bandung Barat</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer End -->

                <!-- JavaScript Libraries -->
            <script src=\"https://code.jquery.com/jquery-3.4.1.min.js\"></script>
            <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js\"></script>
            <script src=\"<?php echo base_url('asset/assets_user/lib/wow/wow.min.js'); ?>\"></script>
            <script src=\"<?php echo base_url('asset/assets_user/lib/easing/easing.min.js'); ?>\"></script>
            <script src=\"<?php echo base_url('asset/assets_user/lib/waypoints/waypoints.min.js'); ?>\"></script>
            <script src=\"<?php echo base_url('asset/assets_user/lib/owlcarousel/owl.carousel.min.js'); ?>\"></script>
            <script src=\"<?php echo base_url('asset/assets_user/lib/tempusdominus/js/moment.min.js'); ?>\"></script>
            <script src=\"<?php echo base_url('asset/assets_user/lib/tempusdominus/js/moment-timezone.min.js'); ?>\"></script>
            <script src=\"<?php echo base_url('asset/assets_user/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js'); ?>\"></script>
            <script src=\"<?php echo base_url('asset/assets_user/lib/twentytwenty/jquery.event.move.js'); ?>\"></script>
            <script src=\"<?php echo base_url('asset/assets_user/lib/twentytwenty/jquery.twentytwenty.js'); ?>\"></script>


            <!-- Template Javascript -->
            <script src=\"<?php echo base_url('asset/assets_user/js/main.js'); ?>\"></script>
            </body>
            </html>
            ";
            file_put_contents($puskesmas_folder3 .  'Footer.php', $view_content);

            $view_content = "
            <!-- Isi content -->

            <style>
            .carousel-caption {
                background-color: rgba(0, 0, 0, 0.5); /* Warna hitam dengan tingkat transparansi 0.5 */
                color: white; /* Warna teks putih */
            }
        </style>
        
        <div id=\"carouselExampleIndicators\" class=\"carousel slide\" data-ride=\"carousel\">
            <ol class=\"carousel-indicators\">
                <?php
                \$indicatorIndex = 0;
                foreach (\$${lokasi}_corousel->result() as \$row) {
                    \$indicatorClass = (\$indicatorIndex === 0) ? 'class=\"active\"' : '';
                    echo '<li data-target=\"#carouselExampleIndicators\" data-slide-to=\"' . \$indicatorIndex . '\" ' . \$indicatorClass . '></li>';
                    \$indicatorIndex++;
                }
                ?>
            </ol>
            <div class=\"carousel-inner\">
                <?php
                \$itemIndex = 0;
                foreach (\$${lokasi}_corousel->result() as \$row) {
                    \$itemClass = (\$itemIndex === 0) ? 'carousel-item active' : 'carousel-item';
                    echo '<div class=\"' . \$itemClass . '\">';
                    echo '<img class=\"d-block w-100\" src=\"' . \$row->gambar . '\" alt=\"Slide ' . \$itemIndex . '\">';
                    echo '<div class=\"carousel-caption\">'; // Add a div for the caption
                    echo '<br>'; 
                    echo '<br>'; 
                    echo '<br>'; 
                    echo '<br>'; 
                    echo '<br>'; 
                    echo '<br>'; 
                    echo '<p class=\"display-4 text-white\">' . \$row->judul . '</p>'; // Display the title from the data
                    echo '<p class=\"display-6 text-white\">' . \$row->keterangan . '</p>'; // Display the description from the data
                    echo '</div>'; // Close the caption div
                    echo '</div>';
                    \$itemIndex++;
                }
                ?>
            </div>
            <a class=\"carousel-control-prev\" href=\"#carouselExampleIndicators\" role=\"button\" data-slide=\"prev\">
                <span class=\"carousel-control-prev-icon\" aria-hidden=\"true\"></span>
                <span class=\"sr-only\">Previous</span>
            </a>
            <a class=\"carousel-control-next\" href=\"#carouselExampleIndicators\" role=\"button\" data-slide=\"next\">
                <span class=\"carousel-control-next-icon\" ariahidden=\"true\"></span>
                <span class=\"sr-only\">Next</span>
            </a>
        </div>
                
                <!-- Include jQuery and Bootstrap JS -->
                <script src=\"https://code.jquery.com/jquery-3.5.1.slim.min.js\"></script>
                <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js\"></script>
                
                <script>
                    $(document).ready(function() {
                        $('#carouselExampleIndicators').carousel();
                    });
                </script>
            ";

            file_put_contents($puskesmas_folder3 .  'Dashboard.php', $view_content);

            $view_content = "
            <!-- Begin Page Content -->
            <div class=\"container-fluid\">

            <!-- Page Heading -->
            <div class=\"d-sm-flex align-items-center justify-content-between mb-4\">
                <h1 class=\"h3 mb-0 text-gray-800\">Dashboard</h1>
                
            </div>
            <?php echo \$this->session->userdata(\"success\"); ?>
            <div class=\"row\">
       
                <!-- Earnings (Monthly) Card Example -->
                <div class=\"col-xl-3 col-md-6 mb-4\">
                    <div class=\"card border-left-danger shadow h-100 py-2\">
                        <div class=\"card-body\">
                            <div class=\"row no-gutters align-items-center\">
                                <div class=\"col mr-2\">
                                    <div class=\"text-xs font-weight-bold text-danger text-uppercase mb-1\">
                                        Total Admin</div>
                                    <div class=\"h5 mb-0 font-weight-bold text-gray-800\"><?php echo \$${lokasi}_login; ?></div>
                                </div>
                                <div class=\"col-auto\">
                                    <i class=\"fas fa-user fa-2x text-gray-300\"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class=\"col-xl-3 col-md-6 mb-4\">
                    <div class=\"card border-left-primary shadow h-100 py-2\">
                        <div class=\"card-body\">
                            <div class=\"row no-gutters align-items-center\">
                                <div class=\"col mr-2\">
                                    <div class=\"text-xs font-weight-bold text-primary text-uppercase mb-1\">
                                        Total Berita</div>
                                    <div class=\"h5 mb-0 font-weight-bold text-gray-800\"><?php echo \$berita; ?></div>
                                </div>
                                <div class=\"col-auto\">
                                    <i class=\"fas fa-newspaper fa-2x text-gray-300\"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Earnings (Monthly) Card Example -->
                <div class=\"col-xl-3 col-md-6 mb-4\">
                        <div class=\"card border-left-primary shadow h-100 py-2\">
                            <div class=\"card-body\">
                                <div class=\"row no-gutters align-items-center\">
                                    <div class=\"col mr-2\">
                                        <div class=\"text-xs font-weight-bold text-primary text-uppercase mb-1\">
                                            Total Pendaftaran</div>
                                        <div class=\"h5 mb-0 font-weight-bold text-gray-800\"><?php echo \$pendaftaran; ?></div>
                                    </div>
                                    <div class=\"col-auto\">
                                        <i class=\"fas fa-user fa-2x text-gray-300\"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Pending Requests Card Example -->
                <div class=\"col-xl-3 col-md-6 mb-4\">
                    <div class=\"card border-left-warning shadow h-100 py-2\">
                        <div class=\"card-body\">
                            <div class=\"row no-gutters align-items-center\">
                                <div class=\"col mr-2\">
                                    <div class=\"text-xs font-weight-bold text-warning text-uppercase mb-1\">
                                        Pengaduan</div>
                                    <div class=\"h5 mb-0 font-weight-bold text-gray-800\"><?=\$umpan_balik?></div>
                                </div>
                                <div class=\"col-auto\">
                                    <i class=\"fas fa-comments fa-2x text-gray-300\"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id=\"content-wrapper\" class=\"d-flex flex-column\">
                <!-- Main Content -->
                <div id=\"content\">
                    <!-- Begin Page Content -->
                    <div class=\"container-fluid\">
                        <!-- Content Row -->
                        <div class=\"row\">
                            <div class=\"col-md-6\">
                                <div class=\"card shadow mb-4\">
                                    <div class=\"card-body\">
                                        <div class=\"row justify-content-center align-items-top-center\" style=\"height: 50vh;\">
                                            <div class=\"col-md-7\">
                                                <canvas id=\"chartCanvas\"></canvas>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=\"col-md-6\">
                                <div class=\"card shadow mb-4\">
                                    <div class=\"card-body\">
                                        <div class=\"table-responsive\">
                                            <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                                <thead>
                                                    <tr>
                                                        <th>Nilai</th>
                                                        <th>Deskripsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach (\$survey_reason->result() as \$row): ?>
                                                        <tr>
                                                            <td><?= ucfirst(\$row->type) ?></td>
                                                            <td><?= ucfirst(\$row->reason) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.container-fluid -->
                    </div>
                    <!-- End of Main Content -->
                </div>
            </div>
            </div>
            </div>
            <script src=\"https://cdn.jsdelivr.net/npm/chart.js\"></script>
            <script>
                var surveyData = {
                    labels: ['Puas', 'Cukup', 'Kurang'],
                    datasets: [{
                        data: [<?=\$survey->puas?>, <?=\$survey->cukup?>, <?=\$survey->kurang?>],
                        backgroundColor: ['#007bff', '#28a745', '#dc3545']
                    }]
                };

                var options = {
                    responsive: true
                };

                var ctx = document.getElementById('chartCanvas').getContext('2d');
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: surveyData,
                    options: options
                });
            </script>
            <!-- Include SweetAlert2 CSS -->
            <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css\">
            <!-- Include SweetAlert2 JavaScript -->
            <script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>
            <script>
            // Periksa apakah pengguna harus mengganti kata sandi
            function periksaGantiKataSandi() {
                // Ambil nilai 'privasi' dari sesi pengguna
                var nilaiUbahPass = \"<?php echo \$this->session->userdata('privasi'); ?>\"; // Tambahkan tanda kutip

                if (nilaiUbahPass === '0') {
                    tampilkanPopupGantiKataSandi();
                }
            }

            // Tampilkan popup yang memberi tahu pengguna untuk mengganti kata sandi
            function tampilkanPopupGantiKataSandi() {
                Swal.fire({
                    title: 'Pemberitahuan Privasi dan Keamanan',
                    text: 'Anda belum mengganti kata sandi. Silakan perbarui!',
                    icon: 'info',
                    showCloseButton: true,
                    confirmButtonText: '<a id=\"linkGantiKataSandi\">Ganti Kata Sandi</a>',
                    confirmButtonColor: '#005700', 
                });

                // Tambahkan event listener untuk tautan \"Ganti Kata Sandi\"
                const linkGantiKataSandi = document.getElementById('linkGantiKataSandi');
                linkGantiKataSandi.addEventListener('click', function (event) {
                    event.preventDefault();
                    const url = \"<?= site_url('${lokasi}/${lokasi}_admin/updateAdmin/' . \$this->session->userdata('id_login')) ?>\";
                    // Redirect ke URL yang dihasilkan saat tombol \"Ganti Kata Sandi\" diklik
                    window.location.href = url;
                });
            }



            // Panggil fungsi untuk memeriksa apakah pengguna harus mengganti kata sandi saat halaman dimuat
            window.onload = periksaGantiKataSandi;
        </script>


            ";

            file_put_contents($puskesmas_folder3 .  'Dashboard_admin.php', $view_content);

            $view_content = "
            <?php
            \$current_page = basename(\$_SERVER['PHP_SELF']); // Mengambil nama file halaman saat ini
            ?>
            <!DOCTYPE html>
            <html lang=\"en\">

            <head>

                <meta charset=\"utf-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
                <meta name=\"description\" content=\"\">
                <meta name=\"author\" content=\"\">

                <title><?=\$title?></title>

                <!-- Custom fonts for this template-->
                <link href=\"<?php echo base_url('asset/') ?>vendor/fontawesome-free/css/all.min.css\" rel=\"stylesheet\" type=\"text/css\">
                <link
                    href=\"https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i\"
                    rel=\"stylesheet\">
                <!-- Custom styles for this template-->
                <link href=\"<?php echo base_url('asset/') ?>css/sb-admin-2.min.css\" rel=\"stylesheet\">
                <!-- tambahan -->
                <script src=\"https://cdn.quilljs.com/1.3.6/quill.js\"></script>
                <link href=\"https://cdn.quilljs.com/1.3.6/quill.snow.css\" rel=\"stylesheet\">
                <link rel=\"icon\" href=\"<?php echo base_url('asset/img/logodefault.png'); ?>\" type=\"image/x-icon\">
                <style>
                    .label {
                        display: inline-block;
                        width: 150px; 
                        font-weight: bold;
                    }
                    .bg-gradient-green-sea {
                    background: #034419;
                
                    }   
                    .btn-success {
                        background-color: #005700; 
                        border-color: #005700; 
                    }
                    .btn-danger {
                        background-color: #7F0000; 
                        border-color: #7F0000; 
                    }
                </style>
            </head>

            <body id=\"page-top\">

                <!-- Page Wrapper -->
                <div id=\"wrapper\">

                    <!-- Sidebar -->
                    <ul class=\"navbar-nav bg-gradient-green-sea sidebar sidebar-dark accordion\" id=\"accordionSidebar\">

                        <!-- Sidebar - Brand -->
                        <div class=\"sidebar-brand d-flex align-items-center justify-content-center mt-3\">
                                <img src=\"<?php echo base_url('asset/img/logodefault.png'); ?>\" width=\"50\" height=\"60\"></img>
                            </div> 
                        <a class=\"sidebar-brand d-flex align-items-center justify-content-center\" href=\"<?=site_url('${lokasi}/${lokasi}_admin')?>\">
                                <div class=\"sidebar-brand-text mx-2\">Puskesmas Admin ${lokasi}</div>
                        </a>

                        <!-- Divider -->
                        <hr class=\"sidebar-divider my-0\">

                        <!-- Nav Item - Dashboard -->
                        <li class=\"nav-item <?php echo (site_url('${lokasi}/${lokasi}_admin') === current_url()) ? 'active' : ''; ?>\">
                            <a class=\"nav-link\" href=\"<?=site_url('${lokasi}/${lokasi}_admin')?>\">
                                <i class=\"fas fa-fw fa-tachometer-alt\"></i>
                                <span>Dashboard</span></a>
                        </li>

                        <!-- Divider -->
                        <hr class=\"sidebar-divider\">

                        <!-- Heading -->
                        <div class=\"sidebar-heading\">
                            User Management
                        </div>
                        <!-- Nav Item - Charts -->
                        <li class=\"nav-item <?php echo (site_url('${lokasi}/${lokasi}_admin/Pendaftaran') === current_url()) ? 'active' : ''; ?>\">
                            <a class=\"nav-link\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/Pendaftaran')?>\">
                                <i class=\"fas fa-fw fa-folder\"></i>
                                <span>Data Pendaftaran</span></a>
                        </li>
                        <li class=\"nav-item <?php echo (site_url('${lokasi}/${lokasi}_admin/DataPegawai') === current_url()) ? 'active' : ''; ?>\">
                            <a class=\"nav-link\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/DataPegawai')?>\">
                                <i class=\"fas fa-database\"></i>
                                <span>Data Pegawai</span></a>
                        </li>
                        <li class=\"nav-item <?php echo (site_url('${lokasi}/${lokasi}_admin/Organisasi') === current_url()) ? 'active' : ''; ?>\">
                            <a class=\"nav-link\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/Organisasi')?>\">
                                <i class=\"fas  fa-sitemap\"></i>
                                <span>Organisasi</span></a>
                        </li>
                        <li class=\"nav-item <?php echo (site_url('${lokasi}/${lokasi}_admin/Feed') === current_url()) ? 'active' : ''; ?>\">
                            <a class=\"nav-link\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/Feed')?>\">
                                <i class=\"fas fa-fw fa-comments\"></i>
                                <span>Pengaduan</span></a>
                        </li>

                        

                        <!-- Divider -->
                        <hr class=\"sidebar-divider\">

                        <!-- Heading -->
                        <div class=\"sidebar-heading\">
                            Setting
                        </div>
                        <!-- Nav Item - Utilities Collapse Menu -->
                        <li class=\"nav-item <?php echo (site_url('${lokasi}/${lokasi}_admin/Corousel') === current_url() || 
                        site_url('${lokasi}/${lokasi}_admin/VisiMisi') === current_url()|| site_url('${lokasi}/${lokasi}_admin/Sejarah') === current_url()|| 
                        site_url('${lokasi}/${lokasi}_admin/Sejarah') === current_url()|| 
                        site_url('${lokasi}/${lokasi}_admin/SosialMedia') === current_url()|| 
                        site_url('${lokasi}/${lokasi}_admin/Berita') === current_url()|| site_url('${lokasi}/${lokasi}_admin/Galery') === current_url()) ? 'active' : ''; ?>\">
                            <a class=\"nav-link collapsed\" href=\"#\" data-toggle=\"collapse\" data-target=\"#collapseUtilities\"
                                aria-expanded=\"true\" aria-controls=\"collapseUtilities\">
                                <i class=\"fas fa-fw fa-wrench\"></i>
                                <span>Konten</span>
                            </a>
                            <div id=\"collapseUtilities\" class=\"collapse\" aria-labelledby=\"headingUtilities\"
                                data-parent=\"#accordionSidebar\">
                                <div class=\"bg-white py-2 collapse-inner rounded\">
                                    <h6 class=\"collapse-header\">Isi Konten:</h6>
                                    <a class=\"collapse-item\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/Corousel')?>\">Slide Show</a>
                                    <a class=\"collapse-item\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/VisiMisi')?>\">Visi & Misi</a>
                                    <a class=\"collapse-item\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/Sejarah')?>\">Sejarah & Maklumat</a>
                                    <a class=\"collapse-item\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/SosialMedia')?>\">Sosial Media</a>
                                    <a class=\"collapse-item\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/Berita')?>\">Berita</a>
                                    <a class=\"collapse-item\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/Galery')?>\">Galeri</a>
                                </div>
                            </div>
                        </li>

                        <!-- Nav Item - Charts -->
                        <!-- Nav Item - Utilities Collapse Menu -->
                        <li class=\"nav-item <?php echo (site_url('${lokasi}/${lokasi}_admin/LayananPublik') === current_url() || site_url('${lokasi}/${lokasi}_admin/LayananKhusus') === current_url()) ? 'active' : ''; ?>\">
                            <a class=\"nav-link collapsed\" href=\"#\" data-toggle=\"collapse\" data-target=\"#collapseUtilities1\"
                                aria-expanded=\"true\" aria-controls=\"collapseUtilities\">
                                <i class=\"fas fa-fw fa-tag\"></i>
                                <span>Layanan</span>
                            </a>
                            <div id=\"collapseUtilities1\" class=\"collapse\" aria-labelledby=\"headingUtilities\"
                                data-parent=\"#accordionSidebar\">
                                <div class=\"bg-white py-2 collapse-inner rounded\">
                                    <h6 class=\"collapse-header\">Isi Layanan:</h6>
                                    <a class=\"collapse-item\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/LayananPublik')?>\">Layanan Publik</a>
                                    <a class=\"collapse-item\" href=\"<?=site_url('${lokasi}/${lokasi}_admin/LayananKhusus')?>\">Layanan Khusus</a>
                                    
                                </div>
                            </div>
                        </li>

                        

                        <!-- Divider -->
                        <hr class=\"sidebar-divider d-none d-md-block\">

                        <!-- Sidebar Toggler (Sidebar) -->
                        <div class=\"text-center d-none d-md-inline\">
                            <button class=\"rounded-circle border-0\" id=\"sidebarToggle\"></button>
                        </div>



                    </ul>
                    <!-- End of Sidebar -->

                    <!-- Content Wrapper -->
                    <div id=\"content-wrapper\" class=\"d-flex flex-column\">

                        <!-- Main Content -->
                        <div id=\"content\">

                            <!-- Topbar -->
                            <nav class=\"navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow \">

                                <!-- Sidebar Toggle (Topbar) -->
                                <button id=\"sidebarToggleTop\" class=\"btn btn-link d-md-none rounded-circle mr-3\">
                                    <i class=\"fa fa-bars\"></i>
                                </button>

                                <!-- Topbar Search -->
                                

                                <!-- Topbar Navbar -->
                                <ul class=\"navbar-nav ml-auto\">

                                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                                    <li class=\"nav-item dropdown no-arrow d-sm-none\">
                                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"searchDropdown\" role=\"button\"
                                            data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                            <i class=\"fas fa-search fa-fw\"></i>
                                        </a>
                                        <!-- Dropdown - Messages -->
                                        <div class=\"dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in\"
                                            aria-labelledby=\"searchDropdown\">
                                            <form class=\"form-inline mr-auto w-100 navbar-search\">
                                                <div class=\"input-group\">
                                                    <input type=\"text\" class=\"form-control bg-light border-0 small\"
                                                        placeholder=\"Search for...\" aria-label=\"Search\"
                                                        aria-describedby=\"basic-addon2\">
                                                    <div class=\"input-group-append\">
                                                        <button class=\"btn btn-success\" type=\"button\">
                                                            <i class=\"fas fa-search fa-sm\"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </li>




                                    <div class=\"topbar-divider d-none d-sm-block\"></div>

                                    <!-- Nav Item - User Information -->
                                    <li class=\"nav-item dropdown no-arrow\">
                                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"userDropdown\" role=\"button\"
                                            data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                            <span class=\"mr-2 d-none d-lg-inline text-gray-600 small\"><?php echo ucfirst(\$this->session->userdata('username')); ?></span>
                                            <i class=\"fas fa-user-circle fa-2x\"></i>
                                        </a>
                                        <!-- Dropdown - User Information -->
                                        <div class=\"dropdown-menu dropdown-menu-right shadow animated--grow-in\"
                                            aria-labelledby=\"userDropdown\">
                                            
                                            <div class=\"dropdown-divider\"></div>
                                            <a class=\"dropdown-item\" href=\"#\" data-toggle=\"modal\" data-target=\"#logoutModal\">
                                                <i class=\"fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400\"></i>
                                                Logout
                                            </a>
                                        </div>
                                    </li>

                                </ul>

                            </nav>
                            <!-- End of Topbar -->





            <!-- Scroll to Top Button-->
            <a class=\"scroll-to-top rounded\" href=\"#page-top\">
                    <i class=\"fas fa-angle-up\"></i>
                </a>

                <!-- Logout Modal-->
                <div class=\"modal fade\" id=\"logoutModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\"
                    aria-hidden=\"true\">
                    <div class=\"modal-dialog\" role=\"document\">
                        <div class=\"modal-content\">
                            <div class=\"modal-header\">
                                <h5 class=\"modal-title\" id=\"exampleModalLabel\">Ready to Leave?</h5>
                                <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\">
                                    <span aria-hidden=\"true\">×</span>
                                </button>
                            </div>
                            <div class=\"modal-body\">Anda yakin melakukan Logout?</div>
                            <div class=\"modal-footer\">
                                <button class=\"btn btn-secondary\" type=\"button\" data-dismiss=\"modal\">Cancel</button>
                                <a class=\"btn btn-success\" href=\"<?=site_url('${lokasi}/Auth/logout')?>\">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>


            ";

            file_put_contents($puskesmas_folder3 .  'Navbar_admin.php', $view_content);

            $view_content = "
            <!-- Footer -->
            <footer class=\"footer sticky-footer bg-white \">
                            <div class=\"container my-auto\">
                                <div class=\"copyright text-center my-auto\">
                                    <span>Copyright &copy; Diskominfotik 2023</span>
                                </div>
                            </div>
                        </footer>
                        <!-- End of Footer -->
                        </div>
                    <!-- End of Content Wrapper -->

                </div>
                <!-- End of Page Wrapper -->

            ";

            file_put_contents($puskesmas_folder3 .  'Footer_admin.php', $view_content);

            $view_content = "
            

                <!-- Bootstrap core JavaScript-->
                <script src=\"<?php echo base_url('asset/') ?>vendor/jquery/jquery.min.js\"></script>
                <script src=\"<?php echo base_url('asset/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>

                <!-- Core plugin JavaScript-->
                <script src=\"<?php echo base_url('asset/') ?>vendor/jquery-easing/jquery.easing.min.js\"></script>

                <!-- Custom scripts for all pages-->
                <script src=\"<?php echo base_url('asset/') ?>js/sb-admin-2.min.js\"></script>

                <!-- Page level plugins -->
                <script src=\"<?php echo base_url('asset/') ?>vendor/chart.js/Chart.min.js\"></script>

                <!-- Page level custom scripts -->
                <script src=\"<?php echo base_url('asset/') ?>js/demo/chart-area-demo.js\"></script>
                <script src=\"<?php echo base_url('asset/') ?>js/demo/chart-pie-demo.js\"></script>
                <link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css\" />
                <script src=\"https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js\"></script>
                <script src=\"https://code.jquery.com/jquery-3.4.1.min.js\"></script>
                <script src=\"https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js\"></script>
                <script>
                $(document).ready(function() {
                    $('#dataTable').DataTable(); // Mengaktifkan fitur DataTable pada tabel dengan id \"dataTable\"
                });
            </script>
            </body>

            </html>
            ";

            file_put_contents($puskesmas_folder3 .  'Modal_admin.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold text\">Data Berita</h6>
                    </div>
                    <div class=\"card-body\">
                        <div class=\"box\">
                        <div class=\"box-header d-flex justify-content-between\">
                            
                            <a href=\"<?php echo site_url('${lokasi}/${lokasi}_admin/TambahBerita'); ?>\" class=\"btn btn-success mb-3\">Tambah Berita</a>
                        </div>

                            <div class=\"box-body\">
                                <div class=\"table-responsive\">
                                <?php echo \$this->session->userdata(\"success\"); ?>
                                    <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Deskripsi</th>
                                                <th>Penulis</th>
                                                <th>Gambar</th>
                                                <th>Created</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach (\$berita->result() as \$row) {
                                                \$edit = '<a class=\"btn btn-success  btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdateBerita/\" . \$row->id_berita) . '\"><i class=\"fas fa-edit\"></i></a>';
                                                \$hapus = '<a class=\"btn btn-danger btn-sm\" href=\"#\" data-toggle=\"modal\" data-target=\"#deleteModal_' . \$row->id_berita . '\"><i class=\"fas fa-trash\"></i></a>';
                                                echo \"<tr>\";
                                                echo \"<td>\" . \$row->judul . \"</td>\";
                                                echo \"<td>\" . substr(\$row->deskripsi, 0, 200) . \"</td>\";
                                                echo \"<td>\" . \$row->penulis . \"</td>\";
                                                echo \"<td><img src='\" . \$row->gambar . \"' width='100px' height='100px'></img></td>\";
                                                echo \"<td>\" .\$row->date_create . \"</td>\";
                                                echo \"<td>\" . \$edit . \"<br><br> \" . \$hapus . \"</td>\";
                                                echo \"</tr>\";

                                                // Modal konfirmasi hapus
                                                echo '<div class=\"modal fade\" id=\"deleteModal_' . \$row->id_berita . '\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel\" aria-hidden=\"true\">';
                                                echo '    <div class=\"modal-dialog\">';
                                                echo '        <div class=\"modal-content\">';
                                                echo '            <div class=\"modal-header\">';
                                                echo '                <h5 class=\"modal-title\" id=\"deleteModalLabel\">Konfirmasi Hapus</h5>';
                                                echo '                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">';
                                                echo '                    <span aria-hidden=\"true\">&times;</span>';
                                                echo '                </button>';
                                                echo '            </div>';
                                                echo '            <div class=\"modal-body\">';
                                                echo '                Apakah Anda yakin ingin menghapus berita' . \$row->judul .'?';
                                                echo '            </div>';
                                                echo '            <div class=\"modal-footer\">';
                                                echo '                <a href=\"' . site_url(\"${lokasi}/${lokasi}_admin/deleteBerita/\" . \$row->id_berita) . '\" class=\"btn btn-danger\">Ya</a>';
                                                echo '                <button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">Tidak</button>';
                                                echo '            </div>';
                                                echo '        </div>';
                                                echo '    </div>';
                                                echo '</div>';
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            </div>

            ";

            file_put_contents($puskesmas_folder3 .  'Berita_admin.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text\">Data Pengaduan</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"box\">
        
                        <div class=\"box-body\">
                            <div class=\"table-responsive\">
                            <?php echo \$this->session->userdata(\"success\"); ?>
                                <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                    <thead>
                                        <tr>
                                            <th>Nama </th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Pesan</th>
                                            <th>Tanggal</th>
                                            <th>Balas</th>
                                            
                                        </tr>
                                    </thead>
        
                                    <tbody>
                                    <?php
                                        foreach (\$umpan_balik->result() as \$row) {
                                            if (\$row->puskesmas == '${lokasi}') {
                                                \$hapus = '<a class=\"btn btn-danger btn-sm\" href=\"#\" data-toggle=\"modal\" data-target=\"#deleteModal_' . \$row->id_umpan_balik . '\"><i class=\"fas fa-trash\"></i></a>';
                                                \$balas = '<a class=\"btn btn-warning btn-sm \" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/BalasPengaduan/\" . \$row->id_umpan_balik) . '\"><i class=\"fas fa-share\"></i></a>';
                                                echo \"<tr>\";
                                                echo \"<td>\" . \$row->nama . \"</td>\";
                                                echo \"<td>\" . \$row->email . \"</td>\";
                                                echo \"<td>\" . \$row->subject . \"</td>\";
                                                echo \"<td>\" . \$row->pesan . \"</td>\";
                                                echo \"<td>\" . \$row->tanggal . \"</td>\";
                                                echo \"<td>\" . \$balas . \" \" . \$hapus . \"</td>\";
                                                echo \"</tr>\";
                                                // Modal konfirmasi hapus
                                                echo '<div class=\"modal fade\" id=\"deleteModal_' . \$row->id_umpan_balik. '\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel\" aria-hidden=\"true\">';
                                                echo '    <div class=\"modal-dialog\">';
                                                echo '        <div class=\"modal-content\">';
                                                echo '            <div class=\"modal-header\">';
                                                echo '                <h5 class=\"modal-title\" id=\"deleteModalLabel\">Konfirmasi Hapus</h5>';
                                                echo '                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">';
                                                echo '                    <span aria-hidden=\"true\">&times;</span>';
                                                echo '                </button>';
                                                echo '            </div>';
                                                echo '            <div class=\"modal-body\">';
                                                echo '                  Apakah Anda yakin ingin menghapus atas nama' . \$row->nama . '?';
                                                echo '            </div>';
                                                echo '            <div class=\"modal-footer\">';
                                                echo '                <a href=\"' . site_url(\"${lokasi}/${lokasi}_admin/deleteFeed/\" . \$row->id_umpan_balik) . '\" class=\"btn btn-danger\">Ya</a>';
                                                echo '                <button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">Tidak</button>';
                                                echo '            </div>';
                                                echo '        </div>';
                                                echo '    </div>';
                                                echo '</div>';
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
        </div>
        

            ";

            file_put_contents($puskesmas_folder3 .  'Umpan_Balik_admin.php', $view_content);

            $view_content = "
            
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold text\">Data Slide Show</h6>
                    </div>
                    <div class=\"card-body\">
                        <div class=\"box\">
                        <div class=\"box-header d-flex justify-content-between\">
                            
                            <a href=\"<?php echo site_url('${lokasi}/${lokasi}_admin/TambahCorousel'); ?>\" class=\"btn btn-success mb-3\">Tambah Slide Show</a>
                        </div>

                            <div class=\"box-body\">
                                <div class=\"table-responsive\">
                                <?php echo \$this->session->userdata(\"success\"); ?>
                                    <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Keterangan</th>
                                                <th>Gambar</th>
                                                <th>Di Edit</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach (\$${lokasi}_corousel->result() as \$row) {
                                                \$edit = '<a class=\"btn btn-success  btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdateCorousel/\" . \$row->id_corousel) . '\"><i class=\"fas fa-edit\"></i></a>';
                                                \$hapus = '<a class=\"btn btn-danger btn-sm\" href=\"#\" data-toggle=\"modal\" data-target=\"#deleteModal_' . \$row->id_corousel . '\"><i class=\"fas fa-trash\"></i></a>';
                                                echo \"<tr>\";
                                                echo \"<td>\" . \$row->judul . \"</td>\";
                                                echo \"<td>\" . \$row->keterangan . \"</td>\";
                                                echo \"<td><img src='\" . \$row->gambar . \"' width='100px' height='100px'></img></td>\";
                                                echo \"<td>\" . \$row->date_create . \"</td>\";
                                                echo \"<td>\" . \$edit . \" \" . \$hapus . \"</td>\";
                                                echo \"</tr>\";

                                                 // Modal konfirmasi hapus
                                                 echo '<div class=\"modal fade\" id=\"deleteModal_' . \$row->id_corousel . '\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel\" aria-hidden=\"true\">';
                                                 echo '    <div class=\"modal-dialog\">';
                                                 echo '        <div class=\"modal-content\">';
                                                 echo '            <div class=\"modal-header\">';
                                                 echo '                <h5 class=\"modal-title\" id=\"deleteModalLabel\">Konfirmasi Hapus</h5>';
                                                 echo '                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">';
                                                 echo '                    <span aria-hidden=\"true\">&times;</span>';
                                                 echo '                </button>';
                                                 echo '            </div>';
                                                 echo '            <div class=\"modal-body\">';
                                                 echo '                Apakah Anda yakin ingin menghapus Slide Show' . \$row->judul .'?';
                                                 echo '            </div>';
                                                 echo '            <div class=\"modal-footer\">';
                                                 echo '                <a href=\"' . site_url(\"${lokasi}/${lokasi}_admin/deleteCorousel/\" . \$row->id_corousel) . '\" class=\"btn btn-danger\">Ya</a>';
                                                 echo '                <button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">Tidak</button>';
                                                 echo '            </div>';
                                                 echo '        </div>';
                                                 echo '    </div>';
                                                 echo '</div>';
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>

            ";

            file_put_contents($puskesmas_folder3 .  'Corousel_admin.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text\">Data Pegawai</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"box\">
                        <div class=\"box-header d-flex justify-content-between\">
                            <a href=\"<?php echo site_url('${lokasi}/${lokasi}_admin/TambahPegawai'); ?>\" class=\"btn btn-success mb-3\">Tambah Pegawai</a>
                        </div>
                        <div class=\"box-body\">
                            <div class=\"table-responsive\">
                            <?php echo \$this->session->userdata(\"success\"); ?>
                                <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>NO HP</th>
                                            <th>Jabatan</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Keluar</th>
                                            <th>Created</th>
                                            <th>Foto</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach (\$${lokasi}_pegawai->result() as \$row) {
                                            \$edit = '<a class=\"btn btn-success btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdatePegawai/\" . \$row->id_pegawai) . '\"><i class=\"fas fa-edit\"></i></a>';
                                            \$hapus = '<a class=\"btn btn-danger btn-sm\" href=\"#\" data-toggle=\"modal\" data-target=\"#deleteModal_' . \$row->id_pegawai . '\"><i class=\"fas fa-trash\"></i></a>';
                                            echo \"<tr>\";
                                            echo \"<td>\" . \$row->nama . \"</td>\";
                                            echo \"<td>\" . \$row->email . \"</td>\";
                                            echo \"<td>\" . \$row->no_hp . \"</td>\";
                                            echo \"<td>\" . \$row->jabatan . \"</td>\";
                                            echo \"<td>\" . \$row->jammasuk . \"</td>\";
                                            echo \"<td>\" . \$row->jamkeluar . \"</td>\";
                                            echo \"<td>\" . \$row->create . \"</td>\";
                                            echo \"<td><img src='\" . \$row->foto . \"' width='100px' height='100px'></img></td>\";
                                            echo \"<td>\" . \$edit . \"<br><br> \" . \$hapus . \"</td>\";
                                            echo \"</tr>\";
        
        
                                            // Modal konfirmasi hapus
                                            echo '<div class=\"modal fade\" id=\"deleteModal_' . \$row->id_pegawai. '\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel\" aria-hidden=\"true\">';
                                            echo '    <div class=\"modal-dialog\">';
                                            echo '        <div class=\"modal-content\">';
                                            echo '            <div class=\"modal-header\">';
                                            echo '                <h5 class=\"modal-title\" id=\"deleteModalLabel\">Konfirmasi Hapus</h5>';
                                            echo '                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">';
                                            echo '                    <span aria-hidden=\"true\">&times;</span>';
                                            echo '                </button>';
                                            echo '            </div>';
                                            echo '            <div class=\"modal-body\">';
                                            echo '                  Apakah Anda yakin ingin menghapus ' . \$row->nama . '?';
                                            echo '            </div>';
                                            echo '            <div class=\"modal-footer\">';
                                            echo '                <a href=\"' . site_url(\"${lokasi}/${lokasi}_admin/deletePegawai/\" . \$row->id_pegawai) . '\" class=\"btn btn-danger\">Ya</a>';
                                            echo '                <button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">Tidak</button>';
                                            echo '            </div>';
                                            echo '        </div>';
                                            echo '    </div>';
                                            echo '</div>';
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        

            ";

            file_put_contents($puskesmas_folder3 .  'DataPegawai_admin.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
                

                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold text\">Data Visi & Misi</h6>
                    </div>
                    <div class=\"card-body\">
                        <div class=\"box\">
                        <div class=\"box-header d-flex justify-content-between\">
                            
                        </div>

                            <div class=\"box-body\">
                                <div class=\"table-responsive\">
                                <?php echo \$this->session->userdata(\"success\"); ?>
                                    <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                        <thead>
                                            <tr>
                                                <th>Visi</th>
                                                <th>Misi</th>
                                                <th>Motto</th>
                                                <th>Tata Nilai</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach (\$${lokasi}_visi_misi->result() as \$row) {
                                                \$edit = '<a class=\"btn btn-success btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdateVisi/\" . \$row->id_visi) . '\"><i class=\"fas fa-edit\"></i></a>';
                                            
                                                echo \"<tr>\";
                                                echo \"<td>\" . substr(\$row->visi, 0, 200) . \"</td>\";
                                                echo \"<td>\" .substr(\$row->misi, 0, 200) . \"</td>\";
                                                echo \"<td>\" . substr(\$row->motto, 0, 200). \"</td>\";
                                                echo \"<td>\" . substr(\$row->tatanilai, 0, 200) . \"</td>\";
                                                echo \"<td>\" . \$edit . \"</td>\";
                                                echo \"</tr>\";
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>

            ";

            file_put_contents($puskesmas_folder3 .  'Visi_Misi_admin.php', $view_content);

            $view_content = "
            <!DOCTYPE html>
            <html lang=\"en\">

            <head>

                <meta charset=\"utf-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
                <meta name=\"description\" content=\"\">
                <meta name=\"author\" content=\"\">

                <title><?=\$title?></title>

                <!-- Custom fonts for this template-->
                <link href=\"<?php echo base_url('asset/'); ?>vendor/fontawesome-free/css/all.min.css\" rel=\"stylesheet\" type=\"text/css\">
                <link href=\"https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i\" rel=\"stylesheet\">

                <!-- Custom styles for this template-->
                <link href=\"<?php echo base_url('asset/'); ?>css/sb-admin-2.min.css\" rel=\"stylesheet\">
                <link rel=\"icon\" href=\"<?php echo base_url('asset/img/logodefault.png'); ?>\" type=\"image/x-icon\">
                <style>
                    .label {
                        display: inline-block;
                        width: 150px; 
                        font-weight: bold;
                    }
                    .bg-gradient-green-sea {
                    background: #034419;
                
                    }   
                    .btn-success {
                        background-color: #005700; 
                        border-color: #005700; 
                    }
                    .btn-danger {
                        background-color: #7F0000; 
                        border-color: #7F0000; 
                    }
                </style>
            </head>

            <body class=\"bg-gradient-green-sea\">

                <div class=\"container\">

                    <!-- Outer Row -->
                    <div class=\"row justify-content-center\">

                        <div class=\"col-xl-10 col-lg-12 col-md-9\">

                            <div class=\"card o-hidden border-0 shadow-lg my-5\">
                                <div class=\"card-body p-0\">
                                    <!-- Nested Row within Card Body -->
                                    <div class=\"row\">
                                        <div class=\"col-lg-6 d-none d-lg-block \"><img src=\"<?=base_url('asset/img/logodefault.png')?>\" class=\"img-fluid\" style=\"width: 100%;\"></div>
                                        <div class=\"col-lg-6\">
                                            <div class=\"p-5\">
                                                <div class=\"text-center\">
                                                    <br>
                                                    <br>
                                                    <br>
                                                    
                                                    <h1 class=\"h4 text-gray-900 mb-4\">Menu Login</h1>
                                                </div>
                                                <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/Auth/prosesLogin')?>\" enctype=\"multipart/form-data\">
                                                    <div class=\"form-group\">
                                                        <input type=\"text\" class=\"form-control form-control-user\"
                                                            id=\"email\" name=\"username\" aria-describedby=\"emailHelp\"
                                                            placeholder=\"Masukan Username\">
                                                    </div>
                                                    <div class=\"form-group\">
                                                        <input type=\"password\" class=\"form-control form-control-user\"
                                                            id=\"exampleInputPassword\"  name=\"password\" placeholder=\"Password\">
                                                    </div>
                                                    <?php echo \$this->session->userdata(\"error\"); ?>
                                                    <button type=\"submit\" class=\"form-group btn btn-success btn-user btn-block\">
                                                        Login
                                                    </button>
                                                </form>
                                                <hr>
                                                <div class=\"text-center\">
                                                    <a class=\"small\" href=\"<?=site_url('${lokasi}/Auth/Lupapw')?>\">Lupa Password?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Bootstrap core JavaScript-->
                <script src=\"<?php echo base_url('asset/'); ?>vendor/jquery/jquery.min.js\"></script>
                <script src=\"<?php echo base_url('asset/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>

                <!-- Core plugin JavaScript-->
                <script src=\"<?php echo base_url('asset/'); ?>vendor/jquery-easing/jquery.easing.min.js\"></script>

                <!-- Custom scripts for all pages-->
                <script src=\"js/sb-admin-2.min.js\"></script>

            </body>

            </html>

            ";

            file_put_contents($puskesmas_folder3 .  'Login.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
    
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold \">Tambah Admin</h6>
                </div>
                <div class=\"card-body\">
                    <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/Auth/prosesTambahAdmin')?>\" enctype=\"multipart/form-data\">
                   
                        <div class=\"mb-3\">
                            <input type=\"text\" class=\"form-control\" name=\"username\" placeholder=\"Username\" required>
                        </div>
                        <div class=\"mb-3\">
                            <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Email\" required>
                        </div>
                        <div class=\"mb-3\">
                            <input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"Password\" required>
                        </div>
                        
                        <?php if(isset(\$_GET['username_error'])) { ?>
                            <div class=\"alert alert-danger\" role=\"alert\">
                                <?php echo \$_GET['username_error']; ?>
                            </div>
                        <?php } ?>
        
                        <?php if(isset(\$_GET['email_error'])) { ?>
                            <div class=\"alert alert-danger\" role=\"alert\">
                                <?php echo \$_GET['email_error']; ?>
                            </div>
                        <?php } ?>
        
                        <hr>
                        <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Tambah</button>
                    </form>
                </div>
            </div>
        
        </div>
        

            ";

            file_put_contents($puskesmas_folder3 .  'Tambah_admin.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold \">Update Admin</h6>
                    </div>
                    <div class=\"card-body\">
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesUpdate/'.\$${lokasi}_login->id_login)?>\" enctype=\"multipart/form-data\">
                    
                            <div class=\"mb-3\">
                                <input type=\"text\" class=\"form-control\" name=\"username\" placeholder=\"Username\" required value=\"<?php echo \$${lokasi}_login->username; ?>\">
                            </div>
                            <div class=\"mb-3\">
                                <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Email\" required value=\"<?=\$${lokasi}_login->email;?>\"> 
                            </div>
                            <div class=\"mb-3\">
                                <input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"Password\"  value=\"\">
                            </div>
                            <?php if(isset(\$_GET['username_error'])) { ?>
                                <div class=\"alert alert-danger\" role=\"alert\">
                                    <?php echo \$_GET['username_error']; ?>
                                </div>
                            <?php } ?>

                            <?php if(isset(\$_GET['email_error'])) { ?>
                                <div class=\"alert alert-danger\" role=\"alert\">
                                    <?php echo \$_GET['email_error']; ?>
                                </div>
                            <?php } ?>

                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Ubah</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>

        

            ";

            file_put_contents($puskesmas_folder3 .  'Update_admin.php', $view_content);



            $view_content = "
            <div class=\"container-fluid\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold\">Data Profile</h6>
                </div>
                <div class=\"card-body\">
                    <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prossesUpdateVisi/'. \$${lokasi}_visi_misi->id_visi)?>\" enctype=\"multipart/form-data\">
                    <div class=\"row\">
                            <div class=\"col-md-6\">    
                    <!-- Input Visi -->
                        <div class=\"mb-3\">
                            <label for=\"visi\">Visi</label>
                            <div id=\"visiEditor\"></div>
                            <input type=\"hidden\" name=\"visi\" id=\"visiInput\" required>
                        </div>
                        
                        <!-- Editor Misi -->
                        <div class=\"mb-3\">
                            <label for=\"misi\">Misi</label>
                            <div id=\"misiEditor\"></div>
                            <input type=\"hidden\" name=\"misi\" id=\"misiInput\" required>
                        </div>
                        </div>
                        <div class=\"col-md-6\">
                        <!-- Input Motto -->
                        <div class=\"mb-3\">
                            <label for=\"motto\">Motto</label>
                            <div id=\"mottoEditor\"></div>
                            <input type=\"hidden\" name=\"motto\" id=\"mottoInput\" required>
                        </div>
                         <!-- Input Tatanilai -->
                         <div class=\"mb-3\">
                            <label for=\"tatanilai\">Tata Nilai</label>
                            <div id=\"tatanilaiEditor\"></div>
                            <input type=\"hidden\" name=\"tatanilai\" id=\"tatanilaiInput\" required>
                        </div>
                        </div>
                        
                        <hr>
                        <button type=\"button\" class=\"btn btn-success btn-user btn-block\" id=\"submitBtn\">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
        <script src=\"https://cdn.quilljs.com/1.3.6/quill.js\"></script>
            <script>
                var templateParagrafvisi = `<?=\$${lokasi}_visi_misi->visi?>`;
                var templateParagrafmisi = `<?=\$${lokasi}_visi_misi->misi?>`;
                var templateParagrafmotto = `<?=\$${lokasi}_visi_misi->motto?>`;
                var templateParagraftatanilai = `<?=\$${lokasi}_visi_misi->tatanilai?>`;
        
                var visiEditor = new Quill('#visiEditor', {
                theme: 'snow'
            });
            visiEditor.clipboard.dangerouslyPasteHTML(templateParagrafvisi);
        
            var misiEditor = new Quill('#misiEditor', {
                theme: 'snow'
            });
            misiEditor.clipboard.dangerouslyPasteHTML(templateParagrafmisi);
        
            var mottoEditor = new Quill('#mottoEditor', {
                theme: 'snow'
            });
            mottoEditor.clipboard.dangerouslyPasteHTML(templateParagrafmotto);
        
            var tatanilaiEditor = new Quill('#tatanilaiEditor', {
                theme: 'snow'
            });
            tatanilaiEditor.clipboard.dangerouslyPasteHTML(templateParagraftatanilai);
        
            var submitBtn = document.getElementById('submitBtn');
        
            submitBtn.addEventListener('click', function() {
                document.getElementById('visiInput').value = visiEditor.root.innerHTML;
                document.getElementById('misiInput').value = misiEditor.root.innerHTML;
                document.getElementById('mottoInput').value = mottoEditor.root.innerHTML;
                document.getElementById('tatanilaiInput').value = tatanilaiEditor.root.innerHTML;
                document.querySelector('form.user').submit(); // Submit the form
            });
            </script>
        
            ";

            file_put_contents($puskesmas_folder3 .  'Update_Visi_Misi.php', $view_content);


            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold \">Tambah Pegawai</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prossesTambahPegawai')?>\" enctype=\"multipart/form-data\">
                    
                            <div class=\"mb-3\">
                                <input type=\"text\" class=\"form-control\" name=\"nama\" placeholder=\"Nama Lengkap\" required>
                            </div>
                            <div class=\"mb-3\">
                                <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Email\" required>
                            </div>
                            <?php if(isset(\$_GET['email_error'])) { ?>
                                <div class=\"alert alert-danger\" role=\"alert\">
                                    <?php echo \$_GET['email_error']; ?>
                                </div>
                            <?php } ?>
                            <div class=\"mb-3\">
                                <input type=\"number\" class=\"form-control\" name=\"no_hp\" placeholder=\"No Telpn\" required>
                            </div>
                            <div class=\"mb-3\">
                                <input type=\"text\" class=\"form-control\" name=\"jabatan\" placeholder=\"jabatan\" required>
                            </div>
                            
                            <div class=\"row\">
                                <div class=\"col-md-6\">  
                                    <div class=\"mb-3\">
                                        <label for=\"jammasuk\">Jam Masuk:</label>
                                        <input type=\"time\" class=\"form-control\" name=\"jammasuk\" id=\"jammasuk\" required>
                                    </div>
                                </div>
                                <div class=\"col-md-6\">
                                    <div class=\"mb-3\">
                                        <label for=\"jamkeluar\">Jam Keluar:</label>
                                        <input type=\"time\" class=\"form-control\" name=\"jamkeluar\" id=\"jamkeluar\" required>
                                    </div>
                                </div>
                            </div>
                            <div class=\"mb-3\">
                                <label>Foto</label>
                                <input type=\"file\" class=\"form-control\" name=\"foto\" placeholder=\"Foto\" required>
                                <div class=\"form-text\" id=\"basic-addon4\"> Format : (.png/.jpg/.gif)  Size min : 1 MB , Dimension Recomended : 500 x 450 </div>
                            </div>

                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Tambah</button>
                        </form>
                    </div>
                </div>

            </div>
            </div>

            ";

            file_put_contents($puskesmas_folder3 .  'TambahPegawai.php', $view_content);


            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Edit Pegawai</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?= site_url('${lokasi}/${lokasi}_admin/prossesUpdatePegawai/'.\$${lokasi}_pegawai->id_pegawai) ?>\" enctype=\"multipart/form-data\">

                            <div class=\"mb-3\">
                                <input type=\"text\" class=\"form-control\" name=\"nama\" placeholder=\"Nama Lengkap\" value=\"<?= \$${lokasi}_pegawai->nama ?>\" required>
                            </div>
                            <div class=\"mb-3\">
                                <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Email\" value=\"<?= \$${lokasi}_pegawai->email ?>\" required>
                            </div>
                            <div class=\"mb-3\">
                                <input type=\"number\" class=\"form-control\" name=\"no_hp\" placeholder=\"No Telpn\" value=\"<?= \$${lokasi}_pegawai->no_hp ?>\" required>
                            </div>
                            <div class=\"mb-3\">
                                <input type=\"text\" class=\"form-control\" name=\"jabatan\" placeholder=\"Jabatan\" value=\"<?= \$${lokasi}_pegawai->jabatan ?>\" required>
                            </div>
                           
                            <div class=\"row\">
                                <div class=\"col-md-6\">  
                                    <div class=\"mb-3\">
                                        <label for=\"jammasuk\">Jam Masuk:</label>
                                        <input type=\"time\" class=\"form-control\" name=\"jammasuk\" id=\"jammasuk\" value=\"<?= \$${lokasi}_pegawai->jammasuk ?>\">
                                    </div>
                                </div>
                                <div class=\"col-md-6\">
                                    <div class=\"mb-3\">
                                        <label for=\"jamkeluar\">Jam Keluar:</label>
                                        <input type=\"time\" class=\"form-control\" name=\"jamkeluar\" id=\"jamkeluar\" value=\"<?= \$${lokasi}_pegawai->jamkeluar ?>\" >
                                    </div>
                                </div>
                            </div>
                            <div class=\"mb-3\">
                                <label>Foto</label>
                                <img src=\"<?= \$${lokasi}_pegawai->foto ?>\" width=\"50\" height=\"60\">
                                <input type=\"hidden\" name=\"default_foto\" value=\"<?= \$${lokasi}_pegawai->foto ?>\">
                                <input type=\"file\" class=\"form-control\" name=\"foto\" placeholder=\"Foto\">
                                <div class=\"form-text\" id=\"basic-addon4\"> Format : (.png/.jpg/.gif)  Size min : 1 MB , Dimension Recomended : 500 x 450</div>
                            </div>
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Update</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            ";

            file_put_contents($puskesmas_folder3 .  'UpdatePegawai.php', $view_content);
            

            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Buat Berita</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesTambahBerita')?>\" enctype=\"multipart/form-data\">
                            <!-- Input Judul -->
                            <div class=\"input-group mb-3\">
                                <label for=\"deskripsi\">Judul</label>
                                <div class=\"col-sm-12\">
                                <input type=\"judul\" class=\"form-control\" name=\"judul\" placeholder=\"Masukan Judul\"  required>
                                </div>
                            </div>
                            
                            <!-- Editor Misi -->
                            <div class=\"mb-3\">
                                <label for=\"deskripsi\">Deskripsi</label>
                                <div id=\"deskripsiEditor\"></div>
                                <input type=\"hidden\" class=\"form-control\" name=\"deskripsi\" id=\"deskripsiInput\" required>
                            </div>
                            <!-- Input Judul -->
                            <div class=\"input-group mb-3\">
                                <label for=\"penulis\">Penulis</label>
                                <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" name=\"penulis\" placeholder=\"Masukan Penulis\"  required>
                                </div>
                            </div>
                            <!-- Input Sumber -->
                            <div class=\"input-group mb-3\">
                                <label for=\"sumber\">Sumber</label>
                                <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" name=\"sumber\" placeholder=\"Masukan Link sumber\" >
                                </div>
                            </div>
                            <div class=\"mb-3\">
                                <label for=\"gambar\" class=\"col-sm-2 control-label\">Foto</label>
                                    <div class=\"col-sm-12\">
                                        <input type=\"file\" class=\"form-control\" id=\"gambar\" name=\"gambar\">
                                    </div>
                            </div>
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Buat Berita</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <script src=\"https://cdn.quilljs.com/1.3.6/quill.js\"></script>
            <script>
            

                var deskripsiEditor = new Quill('#deskripsiEditor', {
                    theme: 'snow'
                });
                
                var submitBtn = document.querySelector('form.user button[type=\"submit\"]');

                submitBtn.addEventListener('click', function() {
                    document.getElementById('deskripsiInput').value = deskripsiEditor.root.innerHTML;
                    
                });
            </script>


            ";

            file_put_contents($puskesmas_folder3 .  'TambahBerita.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Update Berita</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesUpdateBerita/'.\$berita->id_berita)?>\" enctype=\"multipart/form-data\">
                            <!-- Input Judul -->
                            <div class=\"input-group mb-3\">
                                <label for=\"judul\">Judul</label>
                                <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" name=\"judul\" placeholder=\"Masukan Judul\" value=\"<?=\$berita->judul?>\" required>
                                </div>
                            </div>
                            
                            <!-- Editor Misi -->
                            <div class=\"mb-3\">
                                <label for=\"deskripsi\">Deskripsi</label>
                                <div id=\"deskripsiEditor\"></div>
                                <input type=\"hidden\" name=\"deskripsi\" id=\"deskripsiInput\"required>
                            </div>
                            <!-- Input Penulis -->
                            <div class=\"input-group mb-3\">
                                <label for=\"penulis\">Penulis</label>
                                <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" name=\"penulis\" placeholder=\"Masukan penulis\" value=\"<?=\$berita->penulis?>\" required>
                                </div>
                            </div>
                            <!-- Input Sumber -->
                            <div class=\"input-group mb-3\">
                               <label for=\"sumber\">Sumber</label>
                               <div class=\"col-sm-12\">
                               <input type=\"text\" class=\"form-control\" name=\"sumber\" placeholder=\"Masukan Link sumber\" value=\"<?=\$berita->sumber?>\" >
                               </div>
                           </div>
                            <div class=\"mb-3\">
                                <label for=\"gambar\" class=\"col-sm-2 control-label\">Gambar</label>
                                <div class=\"col-sm-12\">
                                        <img src=\"<?=\$berita->gambar?>\" weight=\"50\" height=\"60\">
                                        <input type=\"file\" id=\"foto\" name=\"gambar\" >
                                    </div>
                            </div>
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Update Berita</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <script src=\"https://cdn.quilljs.com/1.3.6/quill.js\"></script>
            <script>
                var templateParagrafBerita = `<?=\$berita->deskripsi?>`;
                var deskripsiEditor = new Quill('#deskripsiEditor', {
                    theme: 'snow'
                });
                deskripsiEditor.root.innerHTML = templateParagrafBerita;
                
                var submitBtn = document.querySelector('form.user button[type=\"submit\"]');

                submitBtn.addEventListener('click', function() {
                    document.getElementById('deskripsiInput').value = deskripsiEditor.root.innerHTML;
                });
            </script>


            ";

            file_put_contents($puskesmas_folder3 .  'UpdateBerita.php', $view_content);


            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Buat SlideShow</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesTambahCorousel')?>\" enctype=\"multipart/form-data\">
                            <!-- Input Judul -->
                            <div class=\"input-group mb-3\">
                                <label for=\"judul\">Judul</label>
                                <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" name=\"judul\" placeholder=\"Masukan Judul\"  required>
                                </div>
                            </div>
                            <!-- Input Judul -->
                            <div class=\"input-group mb-3\">
                                <label for=\"keterangan\">Keterangan</label>
                                <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" name=\"keterangan\" placeholder=\"Masukan Keterangan\"  required>
                                </div>
                            </div>
                        
                            <!-- Input Gambar -->
                            <div class=\"mb-3\">
                                <label for=\"gambar\" class=\"col-sm-2 control-label\">Gambar</label>
                                    <div class=\"col-sm-12\">
                                        <input type=\"file\" class=\"form-control\" id=\"gambar\" name=\"gambar\">
                                        <div class=\"form-text\" id=\"basic-addon4\"> Format : (.png/.jpg/.gif)  Size min : 63,8 KB, Dimension Rekomended : 2048 x 1150 Lanscape</div>
                                    </div>
                            </div>
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Buat SlideShow</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>



            ";

            file_put_contents($puskesmas_folder3 .  'TambahCorousel.php', $view_content);


            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Update SlideShow</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesUpdateCorousel/'.\$${lokasi}_corousel->id_corousel)?>\" enctype=\"multipart/form-data\">
                            <!-- Input Judul -->
                            <div class=\"input-group mb-3\">
                                <label for=\"judul\">Judul</label>
                                <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" name=\"judul\" placeholder=\"Masukan Judul\" value=\"<?=\$${lokasi}_corousel->judul?>\" required>
                                </div>
                            </div>
                            <!-- Input Judul -->
                            <div class=\"input-group mb-3\">
                                <label for=\"keterangan\">Keterangan</label>
                                <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" name=\"keterangan\" placeholder=\"Masukan Keterangan\" value=\"<?=\$${lokasi}_corousel->keterangan?>\" required>
                                </div>
                            </div>
                        
                            <!-- Input Gambar -->
                            <div class=\"mb-3\">
                                <label for=\"gambar\" class=\"col-sm-2 control-label\">Gambar</label>
                                    <div class=\"col-sm-12\">
                                    <img src=\"<?=\$${lokasi}_corousel->gambar?>\" weight=\"50\" height=\"60\">
                                        <input type=\"file\"  id=\"gambar\" name=\"gambar\">
                                        <div class=\"form-text\" id=\"basic-addon4\"> Format : (.png/.jpg/.gif)  Size min : 63,8 KB, Dimension Rekomended : 2048 x 1150 Lanscape</div>
                                    </div>
                            </div>
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Update SlideShow</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            ";

            file_put_contents($puskesmas_folder3 .  'UpdateCorousel.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text\">Data Organisasi</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"box\">
                    <div class=\"box-header d-flex justify-content-between\">
                    </div>
                        <div class=\"box-body\">
                            <div class=\"table-responsive\">
                            <?php echo \$this->session->userdata(\"success\"); ?>
                                <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                    <thead>
                                        <tr>
                                            <th>Keterangan</th>
                                            <th>Gambar</th>
                                            <th>Di Edit</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach (\$${lokasi}_organisasi->result() as \$row) {
                                            \$edit = '<a class=\"btn btn-success  btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdateOrganisasi/\" . \$row->id_organisasi) . '\"><i class=\"fas fa-edit\"></i></a>';
                                            
                                            echo \"<tr>\";
                                            echo \"<td>\" . \$row->keterangan . \"</td>\";
                                            echo \"<td><img src='\" . \$row->gambar . \"' width='100px' height='100px'></img></td>\";
                                            echo \"<td>\" .\$row->date_create . \"</td>\";
                                            echo \"<td>\" . \$edit . \"</td>\";
                                            echo \"</tr>\";

                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>

            </div>


            ";

            file_put_contents($puskesmas_folder3 .  'Organisasi_admin.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Update Organisasi</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesUpdateOrganisasi/'.\$${lokasi}_organisasi->id_organisasi)?>\" enctype=\"multipart/form-data\">
                            <!-- Input Judul -->
                            <div class=\"input-group mb-3\">
                                <label for=\"keterangan\">Keterangan</label>
                                <div class=\"col-sm-12\">
                                <input type=\"text\" class=\"form-control\" name=\"keterangan\" placeholder=\"Masukan Keterangan\" value=\"<?=\$${lokasi}_organisasi->keterangan?>\" required>
                                </div>
                            </div>
                        
                            <!-- Input Gambar -->
                            <div class=\"mb-3\">
                                <label for=\"gambar\" class=\"col-sm-2 control-label\">Gambar</label>
                                    <div class=\"col-sm-12\">
                                    <img src=\"<?=\$${lokasi}_organisasi->gambar?>\" weight=\"50\" height=\"60\">
                                        <input type=\"file\"  id=\"gambar\" name=\"gambar\">
                                    </div>
                            </div>
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Update Organisasi</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            ";

            file_put_contents($puskesmas_folder3 .  'UpdateOrganisasi.php', $view_content);


            $view_content = "
            
            <div class=\"container-fluid\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text\">Data Galeri</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"box\">
                    <div class=\"box-header d-flex justify-content-between\">
                        
                        <a href=\"<?php echo site_url('${lokasi}/${lokasi}_admin/TambahGalery'); ?>\" class=\"btn btn-success mb-3\">Tambah Galeri</a>
                    </div>

                        <div class=\"box-body\">
                            <div class=\"table-responsive\">
                            <?php echo \$this->session->userdata(\"success\"); ?>
                                <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                    <thead>
                                        <tr>
                                            <th>Kegiatan</th>
                                            <th>Gambar</th>
                                            <th>Di Edit</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach (\$${lokasi}_galery->result() as \$row) {
                                            \$edit = '<a class=\"btn btn-success  btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdateGalery/\" . \$row->id_galery) . '\"><i class=\"fas fa-edit\"></i></a>';
                                            \$hapus = '<a class=\"btn btn-danger btn-sm\" href=\"#\" data-toggle=\"modal\" data-target=\"#deleteModal_' . \$row->id_galery . '\"><i class=\"fas fa-trash\"></i></a>';
                                            echo \"<tr>\";
                                            echo \"<td>\" . substr(\$row->kegiatan, 0, 200) . \"</td>\";
                                            echo \"<td><img src='\" . \$row->gambar . \"' width='100px' height='100px'></img></td>\";
                                            echo \"<td>\" .\$row->date_create . \"</td>\";
                                            echo \"<td>\" . \$edit . \"<br><br> \" . \$hapus . \"</td>\";
                                            echo \"</tr>\";

                                            // Modal konfirmasi hapus
                                            echo '<div class=\"modal fade\" id=\"deleteModal_' . \$row->id_galery . '\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel\" aria-hidden=\"true\">';
                                            echo '    <div class=\"modal-dialog\">';
                                            echo '        <div class=\"modal-content\">';
                                            echo '            <div class=\"modal-header\">';
                                            echo '                <h5 class=\"modal-title\" id=\"deleteModalLabel\">Konfirmasi Hapus</h5>';
                                            echo '                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">';
                                            echo '                    <span aria-hidden=\"true\">&times;</span>';
                                            echo '                </button>';
                                            echo '            </div>';
                                            echo '            <div class=\"modal-body\">';
                                            echo '                Apakah Anda yakin ingin menghapus galeri' . \$row->kegiatan .'?';
                                            echo '            </div>';
                                            echo '            <div class=\"modal-footer\">';
                                            echo '                <a href=\"' . site_url(\"${lokasi}/${lokasi}_admin/deleteGalery/\" . \$row->id_galery) . '\" class=\"btn btn-danger\">Ya</a>';
                                            echo '                <button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">Tidak</button>';
                                            echo '            </div>';
                                            echo '        </div>';
                                            echo '    </div>';
                                            echo '</div>';
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>

            </div>



            ";

            file_put_contents($puskesmas_folder3 .  'Galery_admin.php', $view_content);


            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Buat Galeri</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesTambahGalery')?>\" enctype=\"multipart/form-data\">
                            
                            <!-- Editor Kegiatan -->
                            <div class=\"mb-3\">
                                <label for=\"kegiatan\">Kegiatan</label>
                                <div id=\"kegiatanEditor\"></div>
                                <input type=\"hidden\" class=\"form-control\" name=\"kegiatan\" id=\"kegiatanInput\" required>
                            </div>
                            <div class=\"mb-3\">
                                <label for=\"gambar\" class=\"col-sm-2 control-label\">Foto</label>
                                    <div class=\"col-sm-12\">
                                        <input type=\"file\" id=\"gambar\" name=\"gambar\">
                                    </div>
                            </div>
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Buat Galeri</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <script src=\"https://cdn.quilljs.com/1.3.6/quill.js\"></script>
            <script>
            

                var kegiatanEditor = new Quill('#kegiatanEditor', {
                    theme: 'snow'
                });
                
                var submitBtn = document.querySelector('form.user button[type=\"submit\"]');

                submitBtn.addEventListener('click', function() {
                    document.getElementById('kegiatanInput').value = kegiatanEditor.root.innerHTML;
                    
                });
            </script>


            ";

            file_put_contents($puskesmas_folder3 .  'TambahGalery.php', $view_content);


            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Update Galeri</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesUpdateGalery/'.\$${lokasi}_galery->id_galery)?>\" enctype=\"multipart/form-data\">
                            <!-- Editor Galery -->
                            <div class=\"mb-3\">
                                <label for=\"kegiatan\">Kegiatan</label>
                                <div id=\"kegiatanEditor\"></div>
                                <input type=\"hidden\" name=\"kegiatan\" id=\"kegiatanInput\" required>
                            </div>

                            <div class=\"mb-3\">
                                <label for=\"gambar\" class=\"col-sm-2 control-label\">Gambar</label>
                                <div class=\"col-sm-12\">
                                    <img src=\"<?=\$${lokasi}_galery->gambar?>\" width=\"50\" height=\"60\">
                                    <input type=\"file\" id=\"foto\" name=\"gambar\">
                                </div>
                            </div>
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Update Galeri</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
            <script src=\"https://cdn.quilljs.com/1.3.6/quill.js\"></script>
            <script>
                var templateParagrafGalery = `<?=\$${lokasi}_galery->kegiatan?>`;
                var kegiatanEditor = new Quill('#kegiatanEditor', {
                    theme: 'snow'
                });
                kegiatanEditor.root.innerHTML = templateParagrafGalery;
                
                var submitBtn = document.querySelector('form.user button[type=\"submit\"]');

                submitBtn.addEventListener('click', function() {
                    document.getElementById('kegiatanInput').value = kegiatanEditor.root.innerHTML;
                });
            </script>


            ";

            file_put_contents($puskesmas_folder3 .  'UpdateGalery.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold\">Update Layanan </h6>
                </div>
                <div class=\"card-body\">
                <?php echo \$this->session->userdata(\"error\"); ?>
                    <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesUpdateLayanan/' .\$${lokasi}_layanan->id_layanan)?>\" enctype=\"multipart/form-data\">
                    <div style=\"display: flex; gap: 10px;\">
                        <div  class=\"mb-3 col-8\">                 
                            <label for=\"spm\">Standar Pelayanan Minimal</label><br>
                            <img src=\"<?=\$${lokasi}_layanan->spm?>\" width=\"50\" height=\"60\">
                            <input type=\"file\" class=\"form\" name=\"spm\" placeholder=\"Masukan SPM\"   >
                        </div>
                        <div class=\"mb-3\">
                            <label>Konpensasi</label><br>
                            <img src=\"<?=\$${lokasi}_layanan->konpensasi?>\" width=\"50\" height=\"60\">
                            <input type=\"file\" class=\"form\" name=\"konpensasi\" placeholder=\"konpensasi\"  >
                        </div>
                    </div>
                    <!-- Editor Misi -->
                    <div class=\"mb-3\">
                            <label for=\"sarana\">Sarana & Prasarana</label>
                            <div id=\"saranaEditor\"></div>
                            <input type=\"hidden\" class=\"form-control\" name=\"sarana\" id=\"saranaInput\" required>
                        </div>
                        <!-- Editor Misi -->
                        <div class=\"mb-3\">
                            <label for=\"fasilitas\">Fasilitas</label>
                            <div id=\"fasilitasEditor\"></div>
                            <input type=\"hidden\" class=\"form-control\" name=\"fasilitas\" id=\"fasilitasInput\" required>
                        </div>
                        <!-- Editor Misi -->
                        <div class=\"mb-3\">
                            <label for=\"mekanisme\">Mekanisme & Prosedur</label>
                            <div id=\"mekanismeEditor\"></div>
                            <input type=\"hidden\" class=\"form-control\" name=\"mekanisme\" id=\"mekanismeInput\" required>
                        </div>
                        
                        
                        <hr>
                        <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Update Layanan </button>
                    </form>
                </div>
            </div>
            </div>
            </div>
            <script src=\"https://cdn.quilljs.com/1.3.6/quill.js\"></script>
            <script>
            var templateParagrafsarana = `<?=\$${lokasi}_layanan->sarana?>`;
            var templateParagraffasilitas = `<?=\$${lokasi}_layanan->fasilitas?>`;
            var templateParagrafmekanisme = `<?=\$${lokasi}_layanan->mekanisme?>`;


            var saranaEditor = new Quill('#saranaEditor', {
                theme: 'snow'
            });
            saranaEditor.clipboard.dangerouslyPasteHTML(templateParagrafsarana);
            var fasilitasEditor = new Quill('#fasilitasEditor', {
                theme: 'snow'
            });
            fasilitasEditor.clipboard.dangerouslyPasteHTML(templateParagraffasilitas);
            var mekanismeEditor = new Quill('#mekanismeEditor', {
                theme: 'snow'
            });
            mekanismeEditor.clipboard.dangerouslyPasteHTML(templateParagrafmekanisme);

            var submitBtn = document.querySelector('form.user button[type=\"submit\"]');

            submitBtn.addEventListener('click', function() {
                document.getElementById('saranaInput').value = saranaEditor.root.innerHTML;
                document.getElementById('fasilitasInput').value = fasilitasEditor.root.innerHTML;
                document.getElementById('mekanismeInput').value = mekanismeEditor.root.innerHTML;
                
            });
            </script>
            ";

            file_put_contents($puskesmas_folder3 .  'UpdateLayanan.php', $view_content);

            $view_content = "
            
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold text\">Data Layanan Publik</h6>
                    </div>
                    <div class=\"card-body\">
                        <div class=\"box\">
                        <div class=\"box-header d-flex justify-content-between\">
                            
                            <a href=\"<?php echo site_url('${lokasi}/${lokasi}_admin/TambahLayananPublik'); ?>\" class=\"btn btn-success mb-3\">Tambah Layanan Publik</a>
                        </div>

                            <div class=\"box-body\">
                                <div class=\"table-responsive\">
                                <?php echo \$this->session->userdata(\"success\"); ?>
                                    <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                        <thead>
                                            <tr>
                                                <th>Produk Layanan</th>
                                                <th>Biaya</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach (\$${lokasi}_layananpublik->result() as \$row) {
                                                \$edit = '<a class=\"btn btn-success  btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdateLayananPublik/\" . \$row->id_layananpublik) . '\"><i class=\"fas fa-edit\"></i></a>';
                                                \$hapus = '<a class=\"btn btn-danger btn-sm\" href=\"#\" data-toggle=\"modal\" data-target=\"#deleteModal_' . \$row->id_layananpublik . '\"><i class=\"fas fa-trash\"></i></a>';
                                                echo \"<tr>\";
                                                echo \"<td>\" . \$row->produk . \"</td>\";
                                                echo \"<td>\" . 'Rp.' . number_format(\$row->biaya) . \"</td>\";
                                                echo \"<td class='text-center'>\" . \$edit . \" \" . \$hapus . \"</td>\";
                                                echo \"</tr>\";
                                                // Modal konfirmasi hapus
                                                echo '<div class=\"modal fade\" id=\"deleteModal_' . \$row->id_layananpublik . '\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel\" aria-hidden=\"true\">';
                                                echo '    <div class=\"modal-dialog\">';
                                                echo '        <div class=\"modal-content\">';
                                                echo '            <div class=\"modal-header\">';
                                                echo '                <h5 class=\"modal-title\" id=\"deleteModalLabel\">Konfirmasi Hapus</h5>';
                                                echo '                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">';
                                                echo '                    <span aria-hidden=\"true\">&times;</span>';
                                                echo '                </button>';
                                                echo '            </div>';
                                                echo '            <div class=\"modal-body\">';
                                                echo '                Apakah Anda yakin ingin menghapus Layanan ' . \$row->produk .'?';
                                                echo '            </div>';
                                                echo '            <div class=\"modal-footer\">';
                                                echo '                <a href=\"' . site_url(\"${lokasi}/${lokasi}_admin/deleteLayananPublik/\" . \$row->id_layananpublik) . '\" class=\"btn btn-danger\">Ya</a>';
                                                echo '                <button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">Tidak</button>';
                                                echo '            </div>';
                                                echo '        </div>';
                                                echo '    </div>';
                                                echo '</div>';
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            </div>

            
            
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold text\">Mekanisme & Prosedur</h6>
                    </div>
                    <div class=\"card-body\">
                        <div class=\"box\">
                            <div class=\"box-body\">
                                <div class=\"table-responsive\">
                                <?php echo \$this->session->userdata(\"success_edit\"); ?>
                                    <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                        <thead>
                                            <tr>
                                                <th>Standar <br>Pelayanan <br>Masyarakat</th>
                                                <th>Konpensasi</th>
                                                <th>Mekanisme & Prosedur</th>
                                                <th>Sarana</th>
                                                <th>Fasilitas</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach (\$${lokasi}_layanan->result() as \$row) {
                                                \$edit = '<a class=\"btn btn-success  btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdateLayanan/\" . \$row->id_layanan) . '\"><i class=\"fas fa-edit\"></i></a>';
                                                echo \"<tr>\";
                                                echo \"<td><img src='\" . \$row->spm . \"' width='100px' height='100px'></img></td>\";
                                                echo \"<td><img src='\" . \$row->konpensasi . \"' width='100px' height='100px'></img></td>\";
                                                echo \"<td>\" . substr(\$row->mekanisme, 0, 150) . \"</td>\";
                                                echo \"<td>\" . substr(\$row->sarana, 0, 150) . \"</td>\";
                                                echo \"<td>\" . \$row->fasilitas . \"</td>\";
                                                echo \"<td class='text-center'>\" . \$edit . \"</td>\";
                                                echo \"</tr>\";
                                               
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
                  
            ";

            file_put_contents($puskesmas_folder3 .  'LayananPublik_admin.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Tambah Layanan Publik</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesTambahLayananPublik')?>\" enctype=\"multipart/form-data\">
                        
                            <div class=\"mb-2\">
                                <label for=\"produk\">Produk Layanan</label>
                                <input type=\"text\" class=\"form-control\" name=\"produk\" placeholder=\"Masukan Produk Layanan\" required>
                            </div>
                            <div class=\"mb-2\">
                                <label for=\"biaya\">Biaya</label>
                                <input type=\"number\" class=\"form-control\" name=\"biaya\" placeholder=\"Masukan Biaya\" required>
                            </div>
                          
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block mb-3\">Tambah Layanan Publik</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            ";

            file_put_contents($puskesmas_folder3 .  'TambahLayananPublik.php', $view_content);


            $view_content = "
            
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Update Layanan Publik</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesUpdateLayananPublik/' .\$${lokasi}_layananpublik->id_layananpublik)?>\" enctype=\"multipart/form-data\">
                       
                            <div class=\"mb-2\">
                                <label for=\"produk\">Produk Layanan</label>
                                <input type=\"text\" class=\"form-control\" name=\"produk\" placeholder=\"Masukan Produk Layanan\" value=\"<?=\$${lokasi}_layananpublik->produk?>\"  required>
                            </div>
                            <div class=\"mb-2\">
                                <label for=\"biaya\">Biaya</label>
                                <input type=\"number\" class=\"form-control\" name=\"biaya\" placeholder=\"Masukan Biaya\"  value=\"<?=\$${lokasi}_layananpublik->biaya?>\" required>
                            </div>
                           
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block mb-3\">Update Layanan Publik</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>

            ";

            file_put_contents($puskesmas_folder3 .  'UpdateLayananPublik.php', $view_content);


            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold text\">Data Layanan Khusus</h6>
                    </div>
                    <div class=\"card-body\">
                        <div class=\"box\">
                        <div class=\"box-header d-flex justify-content-between\">
                        </div>

                            <div class=\"box-body\">
                                <div class=\"table-responsive\">
                                <?php echo \$this->session->userdata(\"success\"); ?>
                                    <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                        <thead>
                                            <tr>
                                                <th>Visi</th>
                                                <th>Misi</th>
                                                <th>Attribut</th>
                                                <th>Layanan Terpadu</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            foreach (\$${lokasi}_layanankhusus->result() as \$row) {
                                                \$edit = '<a class=\"btn btn-success  btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdateLayananKhusus/\" . \$row->id_layanankhusus) . '\"><i class=\"fas fa-edit\"></i></a>';
                                                echo \"<tr>\";
                                                echo \"<td>\" . \$row->visi . \"</td>\";
                                                echo \"<td>\" . \$row->misi . \"</td>\";
                                                echo \"<td>\" . \$row->atribut . \"</td>\";
                                                echo \"<td>\" . \$row->layananterpadu . \"</td>\";
                                                
                                                echo \"<td>\" . \$edit . \"</td>\";
                                                echo \"</tr>\";

                                                
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            </div>

            

            ";

            file_put_contents($puskesmas_folder3 .  'LayananKhusus_admin.php', $view_content);

            

            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Update Layanan Khusus</h6>
                    </div>
                    <div class=\"card-body\">
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prosesUpdateLayananKhusus/' .\$${lokasi}_layanankhusus->id_layanankhusus)?>\" enctype=\"multipart/form-data\">
                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <!-- Editor Visi -->
                                    <div class=\"mb-3\">
                                        <label for=\"visi\">Visi</label>
                                        <div id=\"visiEditor\"></div>
                                        <input type=\"hidden\" class=\"form-control\" name=\"visi\" id=\"visiInput\" required>
                                    </div>

                                    <!-- Editor Atribut -->
                                    <div class=\"mb-3\">
                                        <label for=\"atribut\">Attribut</label>
                                        <div id=\"atributEditor\"></div>
                                        <input type=\"hidden\" class=\"form-control\" name=\"atribut\" id=\"atributInput\" required>
                                    </div>
                                </div>

                                <div class=\"col-md-6\">
                                    <!-- Editor Misi -->
                                    <div class=\"mb-3\">
                                        <label for=\"misi\">Misi</label>
                                        <div id=\"misiEditor\"></div>
                                        <input type=\"hidden\" class=\"form-control\" name=\"misi\" id=\"misiInput\" required>
                                    </div>

                                    <!-- Editor Layanan Terpadu -->
                                    <div class=\"mb-3\">
                                        <label for=\"layananterpadu\">Layanan Terpadu</label>
                                        <div id=\"layananterpaduEditor\"></div>
                                        <input type=\"hidden\" class=\"form-control\" name=\"layananterpadu\" id=\"layananterpaduInput\" required>
                                    </div>
                                </div>
                            </div>

                            
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Update Layanan Khusus</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <script src=\"https://cdn.quilljs.com/1.3.6/quill.js\"></script>
                <script>
                    var templateParagrafLayanan0 = `<?=\$${lokasi}_layanankhusus->visi?>`;
                    var templateParagrafLayanan01 = `<?=\$${lokasi}_layanankhusus->misi?>`;
                    var templateParagrafLayanan1 = `<?=\$${lokasi}_layanankhusus->atribut?>`;
                    var templateParagrafLayanan2 = `<?=\$${lokasi}_layanankhusus->layananterpadu?>`;

                    var visiEditor = new Quill('#visiEditor', {
                        theme: 'snow'
                    });
                    visiEditor.root.innerHTML = templateParagrafLayanan0;
                    var misiEditor = new Quill('#misiEditor', {
                        theme: 'snow'
                    });
                    misiEditor.root.innerHTML = templateParagrafLayanan01;

                    var atributEditor = new Quill('#atributEditor', {
                        theme: 'snow'
                    });
                    atributEditor.root.innerHTML = templateParagrafLayanan1;

                    var layananterpaduEditor = new Quill('#layananterpaduEditor', {
                        theme: 'snow'
                    });
                    layananterpaduEditor.root.innerHTML = templateParagrafLayanan2;
                    
                    var submitBtn = document.querySelector('form.user button[type=\"submit\"]');

                    submitBtn.addEventListener('click', function() {
                        document.getElementById('visiInput').value = visiEditor.root.innerHTML;
                        document.getElementById('misiInput').value = misiEditor.root.innerHTML;
                        document.getElementById('atributInput').value = atributEditor.root.innerHTML;
                        document.getElementById('layananterpaduInput').value = layananterpaduEditor.root.innerHTML;
                    });
                </script>



            ";

            file_put_contents($puskesmas_folder3 .  'UpdateLayananKhusus.php', $view_content);

            $view_content = "
            <style>
                .news-card {
                    height: 100%;
                }

                .news-image {
                    height: 150px; /* Sesuaikan ukuran gambar yang diinginkan */
                    object-fit: cover;
                }
            </style>

            <div class=\"container mt-5\">
                <h2 class=\"center\">Berita</h2>
                
                <div class=\"row row-cols-1 row-cols-md-3\">
                    <?php 
                    \$counter = 0; // Inisialisasi counter berita yang ditampilkan
                    
                    // Urutkan data berita berdasarkan tanggal secara descending (baru ke lama)
                    \$sorted_berita = array_reverse(\$berita->result());

                    foreach (\$sorted_berita as \$row) {
                        if (\$counter >= 3) {
                            break; // Hentikan perulangan setelah 3 berita ditampilkan
                        }
                    ?>
                    <div class=\"col mb-4\">
                        <div class=\"card news-card\">
                            <img src=\"<?=\$row->gambar?>\" class=\"card-img-top news-image\" alt=\"News Image\">
                            <div class=\"card-body\">
                                <p class=\"card-text\">
                                    <b><?=\$row->judul?></b><br>
                                    <?=substr(\$row->deskripsi, 0, 100)?>...
                                </p>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/ArtikelLengkap/'. \$row->id_berita)?>\" class=\"btn btn-success\">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        \$counter++; // Increment counter setiap kali berita ditampilkan
                    }?>
                    <!-- End of articles items -->
                </div>
            </div>



            ";

            file_put_contents($puskesmas_folder3 .  'Berita.php', $view_content);

            $view_content = "
            
            <div class=\"container-fluid\">
                        

            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-\">Data Sejarah & Maklumat</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"box\">
                    <div class=\"box-header d-flex justify-content-between\">
                    </div>

                        <div class=\"box-body\">
                            <div class=\"table-responsive\">
                            <?php echo \$this->session->userdata(\"success\"); ?>
                                <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                    <thead>
                                        <tr>
                                            <th>Sejarah</th>
                                            <th>Maklumat</th>
                                            <th>Alamat</th>                
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach (\$${lokasi}_sejarah->result() as \$row) {
                                            // tambahan
                                            \$edit = '<a class=\"btn btn-success btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdateSejarah/\" . \$row->id_sejarah) . '\"><i class=\"fas fa-edit\"></i></a>';
                                    
                                            echo \"<tr>\";
                                            echo \"<td>\" . \$row->sejarah . \"</td>\";
                                            echo \"<td><img src='\" . \$row->maklumat . \"' width='100px' height='100px'></img></td>\";
                                            echo \"<td>\" . \$row->alamat . \"</td>\";
                                            
                                            echo \"<td>\" . \$edit. \"</td>\";
                                            echo \"</tr>\";
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>


            ";

            file_put_contents($puskesmas_folder3 .  'Sejarah_admin.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Data Sejarah & Maklumat</h6>
                    </div>
                    <div class=\"card-body\">
                    <?php echo \$this->session->userdata(\"error\"); ?>
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prossesUpdateSejarah/'. \$${lokasi}_sejarah->id_sejarah)?>\" enctype=\"multipart/form-data\">
                            <!-- Input Visi -->
                            <div class=\"mb-3\">
                                <label for=\"sejarah\">Sejarah</label>
                                <div id=\"sejarahEditor\"></div>
                                <input type=\"hidden\" name=\"sejarah\" id=\"sejarahInput\" required>
                            </div>
                            
                            <!-- Input alamat -->
                            <div class=\"input-group mb-3\">
                                <input type=\"text\" class=\"form-control\" name=\"alamat\" placeholder=\"Alamat \" value=\"<?=\$${lokasi}_sejarah->alamat?>\" required>
                            </div>
                            
                            <div class=\"mb-3\">
                                    <label for=\"maklumat\" class=\"col-sm-2 control-label\">Maklumat</label>
                                    <div class=\"col-sm-12\">
                                        <img src=\"<?=\$${lokasi}_sejarah->maklumat?>\" width=\"50\" height=\"60\">
                                        <input type=\"file\" id=\"foto\" name=\"maklumat\">
                                    </div>
                                </div>
                            
                            <hr>
                            <button type=\"button\" class=\"btn btn-success btn-user btn-block\" id=\"submitBtn\">Update Sejarah & Maklumat</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <script src=\"https://cdn.quilljs.com/1.3.6/quill.js\"></script>
                <script>
                    var templateParagrafsejarah = `<?=\$${lokasi}_sejarah->sejarah?>`;
                

                    var sejarahEditor = new Quill('#sejarahEditor', {
                    theme: 'snow'
                });
                sejarahEditor.clipboard.dangerouslyPasteHTML(templateParagrafsejarah);

            

                var submitBtn = document.getElementById('submitBtn');

                submitBtn.addEventListener('click', function() {
                    document.getElementById('sejarahInput').value = sejarahEditor.root.innerHTML;
                    document.querySelector('form.user').submit(); // Submit the form
                });
                </script>


            ";

            file_put_contents($puskesmas_folder3 .  'UpdateSejarah.php', $view_content);

            $view_content = "
            
            <div class=\"container-fluid\">
                        

            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-\">Data Sosial Media</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"box\">
                    <div class=\"box-header d-flex justify-content-between\">
                    </div>

                        <div class=\"box-body\">
                            <div class=\"table-responsive\">
                            <?php echo \$this->session->userdata(\"success\"); ?>
                                <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                    <thead>
                                        <tr>
                                            <th>Instagram</th>
                                            <th>Facebook</th>
                                            <th>Twitter</th>
                                            <th>Email</th>
                                            <th>No HP</th>
                                            <th>Kode POS</th>
                                            
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach (\$${lokasi}_sosialmedia->result() as \$row) {
                                            // tambahan
                                            \$edit = '<a class=\"btn btn-success btn-sm\" href=\"' . site_url(\"${lokasi}/${lokasi}_admin/UpdateSosialMedia/\" . \$row->id_sosialmedia) . '\"><i class=\"fas fa-edit\"></i></a>';
                                    
                                            echo \"<tr>\";
                                            echo \"<td>\" . \$row->instagram . \"</td>\";
                                            echo \"<td>\" . \$row->facebook . \"</td>\";
                                            echo \"<td>\" . \$row->twiter . \"</td>\";
                                            echo \"<td>\" . \$row->email . \"</td>\";
                                            echo \"<td>\" . \$row->no_hp . \"</td>\";
                                            echo \"<td>\" . \$row->kode_pos . \"</td>\";
                                            
                                            echo \"<td>\" . \$edit. \"</td>\";
                                            echo \"</tr>\";
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>


            ";

            file_put_contents($puskesmas_folder3 .  'SosialMedia_admin.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
                <div class=\"card shadow mb-4\">
                    <div class=\"card-header py-3\">
                        <h6 class=\"m-0 font-weight-bold\">Data Sosial Media</h6>
                    </div>
                    <div class=\"card-body\">
                        <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/prossesUpdateSosialMedia/'. \$${lokasi}_sosialmedia->id_sosialmedia)?>\" enctype=\"multipart/form-data\">
                            
                            <!-- Input Email -->
                            <div class=\"input-group mb-3\">
                                <span class=\"input-group-text fas fa-envelope\"></span>
                                <input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"Alamat Email\" value=\"<?=\$${lokasi}_sosialmedia->email?>\" required>
                            </div>
                            
                            <!-- Input No Telpon -->
                            <div class=\"input-group mb-3\">
                                <span class=\"input-group-text fas fa-user\"></span>
                                <input type=\"number\" class=\"form-control\" name=\"no_hp\" placeholder=\"No Telpon\" value=\"<?=\$${lokasi}_sosialmedia->no_hp?>\" required>
                            </div>
                            
                            <!-- Input Kode Pos -->
                            <div class=\"input-group mb-3\">
                                <span class=\"input-group-text fas fa-map\"></span>
                                <input type=\"number\" class=\"form-control\" name=\"kode_pos\" placeholder=\"Kode Post\" value=\"<?=\$${lokasi}_sosialmedia->kode_pos?>\" required>
                            </div>
                            
                            <!-- Input Instagram -->
                            <div class=\"input-group mb-3\">
                                <span class=\"input-group-text fab fa-instagram\"></span>
                                <input type=\"text\" class=\"form-control\" name=\"instagram\" placeholder=\"Instagram Link\" value=\"<?=\$${lokasi}_sosialmedia->instagram?>\" required>
                            </div>
                            
                            <!-- Input Facebook -->
                            <div class=\"input-group mb-3\">
                                <span class=\"input-group-text fab fa-facebook\"></span>
                                <input type=\"text\" class=\"form-control\" name=\"facebook\" placeholder=\"Facebook Link\" value=\"<?=\$${lokasi}_sosialmedia->facebook?>\" required>
                            </div>
                            
                            <!-- Input Twitter -->
                            <div class=\"input-group mb-3\">
                                <span class=\"input-group-text fab fa-twitter\"></span>
                                <input type=\"text\" class=\"form-control\" name=\"twiter\" placeholder=\"Twitter Link\" value=\"<?=\$${lokasi}_sosialmedia->twiter?>\" required>
                            </div>
                            
                            <hr>
                            <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Update Sosial Media</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            ";

            file_put_contents($puskesmas_folder3 .  'UpdateSosialMedia.php', $view_content);

            $view_content = "
            <style>
            .news-card {
                height: 100%;
            }
        
            .news-image {
                max-height: 200px; /* Sesuaikan ukuran gambar yang diinginkan */
                object-fit: cover;
            }
            </style>
            <div class=\"container mt-5\">
                <h2 class=\"text\">Galeri</h2>
                <div class=\"row\">
                <?php 
                    \$counter = 0;
                    \$sorted_galery = array_reverse(\$${lokasi}_galery->result());
            
                    foreach (\$sorted_galery as \$row) {
                        if (\$counter >= 5) {
                            break; 
                        }
                    ?>
                    <div class=\"col-md-4 mb-4\">
                        <div class=\"card news-card\">
                            <img src=\"<?=\$row->gambar?>\" class=\"card-img-top news-image\" alt=\"News Image\">
                            <div class=\"card-body\">
                                <p class=\"card-text\">
                                    <?=substr(\$row->kegiatan,0,100)?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php 
                        \$counter++;
                    }?>
                </div>
            </div>
            
            ";

            file_put_contents($puskesmas_folder3 .  'Galery.php', $view_content);
            $view_content = "
            <!-- Alamat Peta -->
            <div class=\"container mt-5\">
                <h2 class=\"center\">Alamat</h2>
                <div class=\"row map-responsive\">
                <?php
                    foreach (\$${lokasi}_sejarah->result() as \$row) {?>
                    <div class=\"col-md-12 \">
                    <?php echo \$row->alamat_map?> 
                    <?php } ?>
                    </div>
                </div>
            </div>
            ";

            file_put_contents($puskesmas_folder3 .  'Alamat.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Sejarah</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->

                <!-- Isi Konten -->
                <div class=\"container mt-5\">
                <div class=\"card wow zoomIn data-wow-delay=0.6s\">
                    <div class=\"card-body wow zoomIn\" data-wow-delay=\"0.6s\">
                        <h1 style=\"text-align:left;\">Sejarah Singkat</h1>
                        <?php
                        foreach (\$${lokasi}_sejarah->result() as \$row) {
                            echo \$row->sejarah; // Use echo to display the content
                        }
                        ?>
                        
                    </div>
                </div>
                </div>
                <!-- Isi Konten End -->
            
            ";

            file_put_contents($puskesmas_folder3 .  'Sejarah.php', $view_content);

            $view_content = "
            
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                   <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
                   <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
                   <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
               </div>
               <!-- Spinner End -->
           
               <!-- Hero Start -->
               <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                   <div class=\"row py-3\">
                       <div class=\"col-12 text-center\">
                           <h1 class=\"display-3 text-white animated zoomIn\">Visi & Misi</h1>
                       </div>
                   </div>
               </div>
               <!-- Hero End -->
           
               <!-- Visi -->
               <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                   <div class=\"container\">
                       <div class=\"row g-5\">
                           <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                               <div class=\"position-relative h-100\">
                                   <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/visi.png'); ?>\" style=\"object-fit: contain;\">
                               </div>
                           </div>
                           <div class=\"col-lg-7\">
                               <div class=\"section-title mb-4\">
                                   <h5 class=\"position-relative d-inline-block text-primary text-uppercase\">Visi & Misi</h5>
                                   <h1 class=\"display-5 mb-0\">Visi</h1>
                               </div>
                               <ul class =\"mb-4\">
           
                               <?php
                               foreach (\$${lokasi}_visi_misi->result() as \$row) {
                                   echo \$row->visi; // Use echo to display the content
                               }
                               ?>
                           </ul>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- Visi end -->
           
               <!-- Misi -->
               <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                   <div class=\"container\">
                       <div class=\"row g-5\">
                           <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                               <div class=\"position-relative h-100\">
                                   <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/misi.png'); ?>\" style=\"object-fit: contain;\">
                               </div>
                           </div>
                           <div class=\"col-lg-7\">
                               <div class=\"section-title mb-4\">
                                   <h1 class=\"display-5 mb-0\">Misi</h1>
                               </div>
                               <ul class =\"mb-4\">
                               <?php
                               foreach (\$${lokasi}_visi_misi->result() as \$row) {
                                   echo \$row->misi; // Use echo to display the content
                               }
                               ?>
                           </ul>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- Misi end -->
           
               <!-- Motto -->
               <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                   <div class=\"container\">
                       <div class=\"row g-5\">
                           <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                               <div class=\"position-relative h-100\">
                                   <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/motto.png'); ?>\" style=\"object-fit: contain;\">
                               </div>
                           </div>
                           <div class=\"col-lg-7\">
                               <div class=\"section-title mb-4\">
                                   <h1 class=\"display-5 mb-0\">Motto</h1>
                               </div>
                               <ul class =\"mb-4\">
                               <?php
                               foreach (\$${lokasi}_visi_misi->result() as \$row) {
                                   echo \$row->motto; // Use echo to display the content
                               }
                               ?>
                           </ul>
                           </div>
                       </div>
                   </div>
               </div>
               <br>
               <br>
               <br>
               <!-- Motto end -->
            ";

            file_put_contents($puskesmas_folder3 .  'VisiMisi.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->
                
                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Struktur Organisasi</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->

                <!-- Isi Konten -->
                <div class=\"container mt-5\">
                <div class=\"card wow zoomIn data-wow-delay=0.6s\">
                    <div class=\"card-body\">
                    <?php
                        foreach (\$${lokasi}_organisasi->result() as \$row) { ?>
                            <img class=\"img-fluid rounded-top w-100\" src=\"<?=\$row->gambar?>\" alt=\"\">  
                            
                        <?php }
                        ?>
                    </div>
                </div>
                </div>
                <!-- Isi Konten End -->
           
            ";

            file_put_contents($puskesmas_folder3 .  'Organisasi.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Data Pegawai</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->

                <!-- Team Start -->
                <div class=\"container-fluid py-5\">
                    <div class=\"container\">
                        <div class=\"row g-5\">
                            <div class=\"col-lg-4 wow slideInUp\" data-wow-delay=\"0.1s\">
                                <div class=\"section-title bg-light rounded h-100 p-5\">
                                    <h5 class=\"position-relative d-inline-block text-primary text-uppercase\">Pegawai Kami</h5>
                                    <h1 class=\"display-6 mb-4\">Temui Tenaga Kesehatan Bersertifikat & Berpengalaman Kami</h1>
                                </div>
                            </div>
                            <?php foreach (\$${lokasi}_pegawai->result() as \$row) { ?>
                            <div class=\"col-lg-4 wow slideInUp\" data-wow-delay=\"0.3s\">
                                <div class=\"team-item\">
                                    <div class=\"position-relative rounded-top\" style=\"z-index: 1;\">
                                        <img class=\"img-fluid rounded-top w-100\" src=\"<?=\$row->foto ?>\" alt=\"\" style=\"height: 300px; object-fit: cover;\">
                                        <!-- Adjust height as needed and use object-fit to control image display -->
                                    </div>
                                    <div class=\"team-text position-relative bg-light text-center rounded-bottom p-4 pt-5\">
                                        <h4 class=\"mb-2\"><?=\$row->nama ?></h4>
                                        <p class=\"text-primary mb-0\"><?=\$row->jabatan ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Team End -->
            ";

            file_put_contents($puskesmas_folder3 .  'Pegawai.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                   <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
                   <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
                   <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
               </div>
               <!-- Spinner End -->
           
               <!-- Hero Start -->
               <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                   <div class=\"row py-3\">
                       <div class=\"col-12 text-center\">
                           <h1 class=\"display-3 text-white animated zoomIn\">Lokasi & Kontak</h1>
                       </div>
                   </div>
               </div>
               <!-- Hero End -->
               
               <!-- About Start -->
               <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                   <div class=\"container\">
                       <div class=\"row g-5\">
                           <div class=\"col-lg-7\">
                               <div class=\"section-title mb-4\">
                                   <h6 class=\"mb-4\">Nama	    : Puskesmas ${lokasi}</h6>
                                   <?php
                                       foreach (\$${lokasi}_sejarah->result() as \$row) {  ?>
                                   <h6 class=\"mb-4\">Alamat	    : <?=\$row->alamat?></h6> 
                                   <?php }?>
                                   <?php
                                       foreach (\$${lokasi}_sosialmedia->result() as \$row) {  ?>
                                   <h6 class=\"mb-4\">Email	    : <?=\$row->email?></h6> 
                                   <h6 class=\"mb-4\">Telepon	: <?=\$row->no_hp?></h6>
                                   <?php }?>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- About End -->
           
               <!-- Isi Konten -->
               <div class=\"map-responsive \" data-wow-delay=\"0.6s\">
               <?php
                       foreach (\$${lokasi}_sejarah->result() as \$row) {
                           echo \$row->alamat_map; // Use echo to display the content
                       }
                       ?>
               </div>
            ";

            file_put_contents($puskesmas_folder3 .  'Lokasi.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->
            
                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Maklumat</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->
                
                <!-- Isi Konten -->
                <div class=\"container mt-5\">
                <div class=\"card wow zoomIn data-wow-delay=0.6s\">
                    <div class=\"card-body\">
                    <?php
                        foreach (\$${lokasi}_sejarah->result() as \$row) {
                    ?>
                        <img class=\"img-fluid rounded-top w-100\" src=\"<?= \$row->maklumat ?>\" alt=\"\">  
                    <?php }?>
                    </div>
                </div>
                </div>
                <!-- Isi Konten End -->
            ";

            file_put_contents($puskesmas_folder3 .  'Maklumat.php', $view_content);

            $view_content = "
            
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                    <span class=\"sr-only\">Loading...</span>
                </div>
                <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                    <span class=\"sr-only\">Loading...</span>
                </div>
                <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                    <span class=\"sr-only\">Loading...</span>
                </div>
            </div>
            <!-- Spinner End -->

            <!-- Hero Start -->
            <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                <div class=\"row py-3\">
                    <div class=\"col-12 text-center\">
                        <h1 class=\"display-3 text-white animated zoomIn\">Agenda</h1>
                    </div>
                </div>
            </div>
            <!-- Hero End -->

            <!-- Isi Konten -->
            <div class=\"container mt-5\">
                <?php foreach (\$${lokasi}_galery->result() as \$row) { ?>
                    <div class=\"card wow zoomIn\" data-wow-delay=\"0.6s\">
                        <div class=\"card-header\">
                            <h3 class=\"card-title\">Kegiatan</h3>
                        </div>
                        <div class=\"card-body\">
                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <img class=\"img-fluid rounded-top w-100\" src=\"<?=\$row->gambar?>\" >
                                </div>
                                <div class=\"col-md-6\">
                                    <p><?=\$row->kegiatan?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            </div>
            <!-- Isi Konten End -->
            ";

            file_put_contents($puskesmas_folder3 .  'Agenda.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                   <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
                   <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
                   <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
               </div>
               <!-- Spinner End -->
           
               <!-- Hero Start -->
               <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                   <div class=\"row py-3\">
                       <div class=\"col-12 text-center\">
                           <h1 class=\"display-3 text-white animated zoomIn\">ARTIKEL & BERITA</h1>
                       </div>
                   </div>
               </div>
               <!-- Hero End -->
            <style>
                .news-card {
                    height: 100%;
                }
            
                .news-image {
                    height: 150px; /* Sesuaikan ukuran gambar yang diinginkan */
                    object-fit: cover;
                }
            </style>
            
            <div class=\"container mt-5\">
                <h2 class=\"text-center\">Artikel</h2>
                
                <div class=\"row row-cols-1 row-cols-md-3\">
                    <?php 
                    \$counter = 0; // Inisialisasi counter berita yang ditampilkan
                    
                    // Urutkan data berita berdasarkan tanggal secara descending (baru ke lama)
                    \$sorted_berita = array_reverse(\$berita->result());
            
                    foreach (\$sorted_berita as \$row) {
                        if (\$counter >= 10) {
                            break; // Hentikan perulangan setelah 3 berita ditampilkan
                        }
                    ?>
                    <div class=\"col mb-4\">
                        <div class=\"card news-card\">
                            <img src=\"<?=\$row->gambar?>\" class=\"card-img-top news-image\" alt=\"News Image\">
                            <div class=\"card-body\">
                                <p class=\"card-text\">
                                    <b><?=\$row->judul?></b><br>
                                    <?=substr(\$row->deskripsi, 0, 100)?>...
                                </p>
                                <a href=\"<?=site_url('${lokasi}/${lokasi}/ArtikelLengkap/'. \$row->id_berita)?>\" class=\"btn btn-success\">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        \$counter++; // Increment counter setiap kali berita ditampilkan
                    }?>
                    <!-- End of articles items -->
                </div>
            </div>
        

           
            ";

            file_put_contents($puskesmas_folder3 .  'Artikel.php', $view_content);

            $view_content = "
            <style>
                .news-card {
                    height: 100%;
                }

                .news-image {
                    height: 150px; /* Sesuaikan ukuran gambar yang diinginkan */
                    object-fit: cover;
                }
            </style>
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                 <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                     <span class=\"sr-only\">Loading...</span>
                 </div>
                 <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                     <span class=\"sr-only\">Loading...</span>
                 </div>
                 <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                     <span class=\"sr-only\">Loading...</span>
                 </div>
             </div>
             <!-- Spinner End -->
             <div class=\"container mt-5\">
             <div class=\"row\">
                 <div class=\"col-md-8\">
                     <div class=\"card wow zoomIn\" data-wow-delay=\"0.6s\">
                         <div class=\"card-body\">
                             <h1 class=\"card-title\"><?=\$berita->judul?></h1>
                             <p class=\"card-text\" style=\"text-transform: capitalize;\">Berita ini ditulis oleh <?=\$berita->penulis?></p>
                             <hr>
                             <div class=\"d-flex justify-content-center\">
                                 <img src=\"<?=\$berita->gambar?>\" class=\"card-img-top\" style=\"max-width: 100%;\" alt=\"\">
                             </div>
                             <p class=\"card-text\"><?=\$berita->deskripsi?></p>
                             <br>
                             <hr>
                             <p class=\"card-text\">Penulis : <?=\$berita->penulis?></p>
                             <hr>
                             <p class=\"card-text\">Sumber: <a href=\"<?=\$berita->sumber?>\"><?=\$berita->sumber?></a></p>
         
                             <hr>
                             <p class=\"card-text\">Publish : <?=\$berita->date_create?></p>
                         </div>
                     </div>
                 </div>
                 <div class=\"col-md-4\"> <!-- Galeri sisi -->
                     <?php 
                     \$counter = 0;
                     \$sorted_berita_data = array_reverse(\$berita_data->result());
             
                     foreach (\$sorted_berita_data as \$row) {
                         if (\$counter >= 3) {
                             break; 
                         }
                     ?>
                     <div class=\" \">
                         <div class=\"card news-card\">
                             <img src=\"<?=\$row->gambar?>\" class=\"card-img-top news-image\" alt=\"News Image\">
                             <div class=\"card-body\">
                                 <p class=\"card-text\">
                                     <?=substr(\$row->deskripsi,0,100)?>
                                 </p>
                                 <a href=\"<?=site_url('${lokasi}/${lokasi}/ArtikelLengkap/'. \$row->id_berita)?>\" class=\"btn btn-success\">Selengkapnya</a>
                             </div>
                         </div>
                     </div>
                     <?php 
                         \$counter++;
                     }?>
                 
                 <br>
                 <?php 
                 \$counter = 0;
                 \$sorted_galery = array_reverse(\$${lokasi}_galery->result());
         
                 foreach (\$sorted_galery as \$row) {
                     if (\$counter >= 2) {
                         break; 
                     }
                 ?>
                 <div class=\" \">
                     <div class=\"card news-card\">
                         <img src=\"<?=\$row->gambar?>\" class=\"card-img-top news-image\" alt=\"News Image\">
                         <div class=\"card-body\">
                             <p class=\"card-text\">
                                 <?=substr(\$row->kegiatan,0,100)?>
                             </p>
                         </div>
                     </div>
                 </div>
                 <?php 
                     \$counter++;
                 }?>
             </div>
             </div>
             </div>
         
           
            ";

            file_put_contents($puskesmas_folder3 .  'ArtikelLengkap.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Mekanisme & Prosedur</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->

                <!-- Sarana & Prasarana Gedung -->
                <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                    <div class=\"container\">
                        <div class=\"row g-5\">
                            <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                                <div class=\"position-relative h-100\">
                                    <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/hospital.png'); ?>\" style=\"object-fit: contain;\">
                                </div>
                            </div>
                            <div class=\"col-lg-7\">
                                <div class=\"section-title mb-4\">
                                    <h5 class=\"position-relative d-inline-block text-primary text-uppercase\">Mekanisme & Prosedur</h5>
                                
                                </div>
                                <ul class =\"mb-4\">
                                <?php foreach (\$${lokasi}_layananpublik->result() as \$row) { ?>
                                        <?= \$row->mekanisme ?>  
                                <?php }?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sarana & Prasarana Gedung End -->
            ";

            file_put_contents($puskesmas_folder3 .  'Mekanisme.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Sarana & Prasarana</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->

                <!-- Sarana & Prasarana Gedung -->
                <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                    <div class=\"container\">
                        <div class=\"row g-5\">
                            <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                                <div class=\"position-relative h-100\">
                                    <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/hospital.png'); ?>\" style=\"object-fit: contain;\">
                                </div>
                            </div>
                            <div class=\"col-lg-7\">
                                <div class=\"section-title mb-4\">
                                    <h5 class=\"position-relative d-inline-block text-primary text-uppercase\">Sarana & Prasarana Gedung</h5>
                                
                                </div>
                                <ul class =\"mb-4\">
                                <?php foreach (\$${lokasi}_layananpublik->result() as \$row) { ?>
                                        <?= \$row->sarana ?>  
                                <?php }?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sarana & Prasarana Gedung End -->
            ";

            file_put_contents($puskesmas_folder3 .  'Sarana.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                  <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
                  <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
                  <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
              </div>
              <!-- Spinner End -->
          
              <!-- Hero Start -->
              <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                  <div class=\"row py-3\">
                      <div class=\"col-12 text-center\">
                          <h1 class=\"display-3 text-white animated zoomIn\">Fasilitas</h1>
                      </div>
                  </div>
              </div>
              <!-- Hero End -->
          
              <!-- Fasilitas Bangunan -->
              <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                  <div class=\"container\">
                      <div class=\"row g-5\">
                          <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                              <div class=\"position-relative h-100\">
                                  <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/hospital.png'); ?>\" style=\"object-fit: contain;\">
                              </div>
                          </div>
                          <div class=\"col-lg-7\">
                              <div class=\"section-title mb-4\">
                                  <h5 class=\"position-relative d-inline-block text-primary text-uppercase\">Fasilitas Puskesmas</h5>
                                  <h1 class=\"display-5 mb-0\">Fasilitas  </h1>
                              </div>
                              <ul class =\"mb-4\">
                              <?php foreach (\$${lokasi}_layananpublik->result() as \$row) { ?>
                                      <?= \$row->fasilitas ?>  
                              <?php }?>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
              <br>
              <br>
              <br>
              <br>
              <br>
              <br>
              <!-- Fasilitas Bangunan end -->
            ";

            file_put_contents($puskesmas_folder3 .  'Fasilitas.php', $view_content);
            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Produk & Tarif Layanan</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->
                
                <div class=\"container mt-5\">
                <div class=\"card wow zoomIn data-wow-delay=0.6s\">
                    <div class=\"card-body wow zoomIn\" data-wow-delay=\"0.6s\">
                        <div class=\"col-md-12\">
                            
                                
                                <div class=\"card-body\">
                                    <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                        <thead>
                                            <tr>
                                                <th>Produk Layanan</th>
                                                <th>Tarif</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (\$${lokasi}_layananpublik->result() as \$row) { ?>
                                                <tr>
                                                    <td><?=\$row->produk; ?></td>
                                                    <td><?='Rp.'.number_format(\$row->biaya); ?></td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>

            ";

            file_put_contents($puskesmas_folder3 .  'Tarif.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Kompensasi Pelayanan</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->
                
                <div class=\"container mt-5\">
                <div class=\"card wow zoomIn data-wow-delay=0.6s\">
                    <div class=\"card-body wow zoomIn\" data-wow-delay=\"0.6s\">
                        <?php \$firstImageDisplayed = false;  ?>

                        <?php foreach (\$${lokasi}_layananpublik->result() as \$row) { ?>
                            <?php if (!\$firstImageDisplayed) {  ?>
                                <img class=\"img-fluid rounded-top w-100\" src=\"<?=\$row->konpensasi?>\" alt=\"\">
                                <?php \$firstImageDisplayed = true; ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

                <!-- Isi Konten End -->
            ";

            file_put_contents($puskesmas_folder3 .  'Kompensasi.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Standar Pelayanan Minimal</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->
                
                <div class=\"container mt-5\">
                <div class=\"card wow zoomIn data-wow-delay=0.6s\">
                    <div class=\"card-body wow zoomIn\" data-wow-delay=\"0.6s\">
                        <?php \$firstImageDisplayed = false;  ?>

                        <?php foreach (\$${lokasi}_layananpublik->result() as \$row) { ?>
                            <?php if (!\$firstImageDisplayed) {  ?>
                                <img class=\"img-fluid rounded-top w-100\" src=\"<?=\$row->spm?>\" alt=\"\">
                                <?php \$firstImageDisplayed = true; ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <!-- Isi Konten End -->
            ";

            file_put_contents($puskesmas_folder3 .  'Standar.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                 <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                     <span class=\"sr-only\">Loading...</span>
                 </div>
                 <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                     <span class=\"sr-only\">Loading...</span>
                 </div>
                 <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                     <span class=\"sr-only\">Loading...</span>
                 </div>
             </div>
             <!-- Spinner End -->
         
             <!-- Hero Start -->
             <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                 <div class=\"row py-3\">
                     <div class=\"col-12 text-center\">
                         <h1 class=\"display-3 text-white animated zoomIn\">Atribut</h1>
                     </div>
                 </div>
             </div>
             <!-- Hero End -->
         
             <!-- Isi Konten 1 -->
             <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                 <div class=\"container\">
                     <div class=\"row g-5\">
                         <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                             <div class=\"position-relative h-100\">
                                 <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/team.png'); ?>\" style=\"object-fit: contain;\">
                             </div>
                         </div>
                         <div class=\"col-lg-7\">
                             <div class=\"section-title mb-4\">
                                 <h5 class=\"position-relative d-inline-block text-primary text-uppercase\">Atribut Pegawai dan Ruangan</h5>
                                 <h1 class=\"display-5 mb-0\">Atribut yang dipakai</h1>
                             </div>
                             <ul class =\"mb-4\">
                             <?php
                             foreach (\$${lokasi}_layanankhusus->result() as \$row) {
                                 echo \$row->atribut; // Use echo to display the content
                             }
                             ?>
                         </ul>
                         </div>
                     </div>
                 </div>
             </div>
             </div>
             <br>
             <!-- Isi Konten 1 end -->
         
               
            ";

            file_put_contents($puskesmas_folder3 .  'Atribut.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Layanan Terpadu</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->

                <!-- Isi Layanan 1 -->
                <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                    <div class=\"container\">
                        <div class=\"row g-5\">
                            <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                                <div class=\"position-relative h-100\">
                                    <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/medical.png'); ?>\" style=\"object-fit: contain;\">
                                </div>
                            </div>
                            <div class=\"col-lg-7\">
                                <div class=\"section-title mb-4\">
                                    <h5 class=\"position-relative d-inline-block text-primary text-uppercase\">Layanan Terpadu</h5>
                                <?php
                                foreach (\$${lokasi}_layanankhusus->result() as \$row) {?>
                                    <h2 class=\"display-9 mb-0\"><?=\$row->layananterpadu?></h2>
                                </div>
                                
                                <?php } ?>
                        
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <!-- Isi Layanan 1 End -->


            ";

            file_put_contents($puskesmas_folder3 .  'LayananTerpadu.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\">Visi & Pelayanan</h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->

                <!-- Visi -->
                <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                    <div class=\"container\">
                        <div class=\"row g-5\">
                            <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                                <div class=\"position-relative h-100\">
                                    <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/visi.png'); ?>\" style=\"object-fit: contain;\">
                                </div>
                            </div>
                            <div class=\"col-lg-7\">
                                <div class=\"section-title mb-4\">
                                    <h5 class=\"position-relative d-inline-block text-primary text-uppercase\">Visi & Pelayanan Khusus</h5>
                                    <h1 class=\"display-5 mb-0\">Visi</h1>
                                </div>
                                <ul class =\"mb-4\">
                                <?php
                                foreach (\$${lokasi}_layanankhusus->result() as \$row) {
                                    echo \$row->visi; // Use echo to display the content
                                }
                                ?>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Visi end -->

                <!-- Pelayanan -->
                <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                    <div class=\"container\">
                        <div class=\"row g-5\">
                            <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                                <div class=\"position-relative h-100\">
                                    <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/love.png'); ?>\" style=\"object-fit: contain;\">
                                </div>
                            </div>
                            <div class=\"col-lg-7\">
                                <div class=\"section-title mb-4\">
                                    <h1 class=\"display-5 mb-0\">Pelayanan</h1>
                                </div>
                                <ul class =\"mb-4\">
                                <?php
                                foreach (\$${lokasi}_layanankhusus->result() as \$row) {
                                    echo \$row->misi; // Use echo to display the content
                                }
                                ?>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pelayanan end -->
            ";

            file_put_contents($puskesmas_folder3 .  'VisiPelayanan.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                  <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
                  <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
                  <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
              </div>
              <!-- Spinner End -->
          
              <!-- Hero Start -->
              <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                  <div class=\"row py-3\">
                      <div class=\"col-12 text-center\">
                          <h1 class=\"display-3 text-white animated zoomIn\">Tata Nilai</h1>
                      </div>
                  </div>
              </div>
              <!-- Hero End -->
          
              <!-- Tata Nilai -->
              <div class=\"container-fluid py-5 wow fadeInUp\" data-wow-delay=\"0.1s\">
                  <div class=\"container\">
                      <div class=\"row g-5\">
                          <div class=\"col-lg-5\" style=\"min-height: 250px;\">
                              <div class=\"position-relative h-100\">
                                  <img class=\"position-absolute w-100 h-100 rounded wow zoomIn\" data-wow-delay=\"0.9s\" src=\"<?php echo base_url('asset/assets_user/img/puskesmas.png'); ?>\" style=\"object-fit: contain;\">
                              </div>
                          </div>
                          <div class=\"col-lg-7\">
                              <div class=\"section-title mb-4\">
                                  <h1 class=\"display-5 mb-0\">Tata Nilai</h1>
                              </div>
                              <ul class =\"mb-4\">
                              <?php
                              foreach (\$${lokasi}_visi_misi->result() as \$row) {
                                  echo \$row->tatanilai; // Use echo to display the content
                              }
                              ?>
                          </ul>
                          </div>
                      </div>
                  </div>
              </div>
              <br>
              <br>
              <br>
              <br>
              <!-- Tata Nilai end -->
            ";

            file_put_contents($puskesmas_folder3 .  'TataNilai.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                  <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
                  <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
                  <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
              </div>
              <!-- Spinner End -->
          
              <!-- Hero Start -->
              <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                  <div class=\"row py-3\">
                      <div class=\"col-12 text-center\">
                          <h1 class=\"display-3 text-white animated zoomIn\">Pengaduan Pasien</h1>
                      </div>
                  </div>
              </div>
              <!-- Hero End -->
          
              
              <!-- Form Pengaduan -->
              <div class=\"appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn\" data-wow-delay=\"0.6s\">
              <?php echo \$this->session->userdata(\"success\"); ?>
              <form  method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}/IsiPesan')?>\">
                  <div class=\"row g-3\">
                      <div class=\"col-12\">
                          <input type=\"text\" class=\"form-control border-0 bg-light px-4\" name =\"nama\" placeholder=\"Masukan Nama\" style=\"height: 55px;\" required>
                      </div>
                      <div class=\"col-12\">
                          <input type=\"email\" class=\"form-control border-0 bg-light px-4\" name =\"email\" placeholder=\"Masukan Alamat Email\" style=\"height: 55px;\" required>
                      </div>
                      <div class=\"col-12\">
                          <input type=\"text\" class=\"form-control border-0 bg-light px-4\" name =\"subject\" placeholder=\"Subjek\" style=\"height: 55px;\" required>
                      </div>
                      <div class=\"col-12\">
                          <textarea class=\"form-control border-0 bg-light px-4 py-3\" rows=\"5\" name =\"pesan\" placeholder=\"Masukan Pesan\" required></textarea>
                      </div>
                      <?php echo \$captcha['image']; ?>
                      <div class=\"col-12\">
                          <input type=\"text\" class=\"form-control border-0 bg-light px-4\" name=\"captcha\" placeholder=\"Masukan Captcha\" style=\"height: 55px;\" required>
                      </div>
                      <div class=\"col-12\" style=\"display: none;\">
                        <input type=\"text\" class=\"form-control border-0 bg-light px-4\" name=\"puskesmas\" style=\"height: 55px;\" value=\"${lokasi}\" readonly>
                    </div>
                      <div class=\"col-12\">
                          <button class=\"btn btn-dark w-100 py-3\" type=\"submit\">Kirim</button>
                      </div>
                  </div>
              </form>
              </div>
              <br>
              <br>
              <br>
              <br>
              <br>
            
          
              <!-- Form Pengaduan end -->
            ";

            file_put_contents($puskesmas_folder3 .  'UmpanBalik.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                   <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
                   <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
                   <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                       <span class=\"sr-only\">Loading...</span>
                   </div>
               </div>
               <!-- Spinner End -->
           
               <!-- Hero Start -->
               <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                   <div class=\"row py-3\">
                       <div class=\"col-12 text-center\">
                           <h1 class=\"display-3 text-white animated zoomIn\">INDEKS KEPUASAN MASYARAKAT</h1>
                       </div>
                   </div>
               </div>
               <!-- Hero End -->
               
               <!-- Tombol Survey -->
               <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
               <script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js\"></script>
               <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js\"></script>
               <style type=\"text/css\">
                   .box{
                       padding: 30px 40px;
                       border-radius: 5px;
                   }
                   .feedback-btn {
                   cursor: pointer;
               }
           
               .feedback-img {
                   width: 100px;
               }
                 
              
               </style>
              
           <div class=\"container\">
               <div class=\"card wow zoomIn data-wow-delay=0.6s\">
                   <div class=\"card-body\">
                   <?php echo \$this->session->userdata(\"success\"); ?>
                       <div class=\"alert alert-warning\" role=\"alert\">
                           Perhatian!!! Untuk memberikan penilaian silakan klik Emoji
                       </div>
                       <div class=\"row text-center\">
           
                           <!-- Tombol \"Puas\" -->
                           <div class=\"col-md-4\">
                               <div class=\"bg-primary box text-white\">
                                   <div class=\"feedback-btn\" data-toggle=\"modal\" data-target=\"#puasModal\">
                                   <div class=\"row\">
                                       <div class=\"col-md-6\">
                                           <h5>MEMUASKAN</h5>
                                           <h2 id=\"data-mati\"> [ <?=\$survey->puas?> ] </h2>
                                           <h5>suara </h5>
                                       </div>
                                       <div class=\"col-md-4\">
                                               <img src=\"<?=base_url('asset/puas.png')?>\" class=\"feedback-img\" alt=\"Puas\">
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
           
                           <!-- Modal \"Puas\" -->
                           <div class=\"modal fade\" id=\"puasModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"puasModalLabel\" aria-hidden=\"true\">
                               <div class=\"modal-dialog\" role=\"document\">
                                   <div class=\"modal-content\">
                                       <div class=\"modal-header\">
                                           <h5 class=\"modal-title\" id=\"puasModalLabel\">Alasan Puas</h5>
                                           <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                               <span aria-hidden=\"true\">&times;</span>
                                           </button>
                                       </div>
                                       <div class=\"modal-body\">
                                           <form action=\"<?=site_url('${lokasi}/${lokasi}/submit_penilaian/puas');?>\" method=\"post\">
                                               <input type=\"hidden\" name=\"alasan_type\" value=\"puas\">
                                               <textarea name=\"alasan_puas\" class=\"form-control\" placeholder=\"Berikan alasan Anda...\"></textarea>
                                               <button type=\"submit\" class=\"btn btn-primary mt-3\">Kirim</button>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <!-- Modal \"Cukup\" -->
                           <div class=\"modal fade\" id=\"cukupModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"cukupModalLabel\" aria-hidden=\"true\">
                               <div class=\"modal-dialog\" role=\"document\">
                                   <div class=\"modal-content\">
                                       <div class=\"modal-header\">
                                           <h5 class=\"modal-title\" id=\"cukupModalLabel\">Alasan Cukup</h5>
                                           <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                               <span aria-hidden=\"true\">&times;</span>
                                           </button>
                                       </div>
                                       <div class=\"modal-body\">
                                           <form action=\"<?=site_url('${lokasi}/${lokasi}/submit_penilaian/cukup');?>\" method=\"post\">
                                               <input type=\"hidden\" name=\"alasan_type\" value=\"cukup\">
                                               <textarea name=\"alasan_cukup\" class=\"form-control\" placeholder=\"Berikan alasan Anda...\"></textarea>
                                               <button type=\"submit\" class=\"btn btn-primary mt-3\">Kirim</button>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
           
                           <!-- Tombol \"Cukup\" -->
                           <div class=\"col-md-4\">
                               <div class=\"bg-success box text-white\">
                                   <div class=\"feedback-btn\" data-toggle=\"modal\" data-target=\"#cukupModal\">
                                   <div class=\"row\">
                                       <div class=\"col-md-6\">
                                           <h5>CUKUP</h5>
                                           <h2 id=\"data-mati\"> [ <?=\$survey->cukup?> ] </h2>
                                           <h5>suara </h5>
                                       </div>
                                       <div class=\"col-md-4\">
                                               <img src=\"<?=base_url('asset/cukup.png')?>\" class=\"feedback-img\" alt=\"Cukup\">
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
           
                           <!-- Modal \"Kurang\" -->
                           <div class=\"modal fade\" id=\"kurangModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"kurangModalLabel\" aria-hidden=\"true\">
                               <div class=\"modal-dialog\" role=\"document\">
                                   <div class=\"modal-content\">
                                       <div class=\"modal-header\">
                                           <h5 class=\"modal-title\" id=\"kurangModalLabel\">Alasan Kurang</h5>
                                           <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                               <span aria-hidden=\"true\">&times;</span>
                                           </button>
                                       </div>
                                       <div class=\"modal-body\">
                                           <form action=\"<?=site_url('${lokasi}/${lokasi}/submit_penilaian/kurang');?>\" method=\"post\">
                                               <input type=\"hidden\" name=\"alasan_type\" value=\"kurang\">
                                               <textarea name=\"alasan_kurang\" class=\"form-control\" placeholder=\"Berikan alasan Anda...\"></textarea>
                                               <button type=\"submit\" class=\"btn btn-primary mt-3\">Kirim</button>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
           
                           <!-- Tombol \"Kurang\" -->
                           <div class=\"col-md-4\">
                               <div class=\"bg-danger box text-white\">
                                   <div class=\"feedback-btn\" data-toggle=\"modal\" data-target=\"#kurangModal\">
                                   <div class=\"row\">
                                       <div class=\"col-md-6\">
                                           <h5>KURANG</h5>
                                           <h2 id=\"data-mati\"> [ <?=\$survey->kurang?> ] </h2>
                                           <h5>suara </h5>
                                       </div>
                                       <div class=\"col-md-4\">
                                               <img src=\"<?=base_url('asset/kurang.png')?>\" class=\"feedback-img\" alt=\"Kurang\">
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           

            ";

            file_put_contents($puskesmas_folder3 .  'Kepuasan.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                    <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                    <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                        <span class=\"sr-only\">Loading...</span>
                    </div>
                </div>
                <!-- Spinner End -->

                <!-- Hero Start -->
                <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                    <div class=\"row py-3\">
                        <div class=\"col-12 text-center\">
                            <h1 class=\"display-3 text-white animated zoomIn\"> Dokter Yang Hadir Hari ini </h1>
                        </div>
                    </div>
                </div>
                <!-- Hero End -->

            <!-- Team Start -->
            <div class=\"container-fluid py-5\">
                <div class=\"container\">
                    <div class=\"row g-5\">
                    
                        <?php 
                        date_default_timezone_set('Asia/Jakarta'); // Set timezone to Asia/Jakarta
                        
                        foreach (\$${lokasi}_pegawai->result() as \$row) {
                            // Ambil jam masuk dan jam keluar dari database (misal dari field jammasuk dan jamkeluar)
                            \$jamMasuk = strtotime(\$row->jammasuk);
                            \$jamKeluar = strtotime(\$row->jamkeluar);
                            
                            // Ambil jam sekarang
                            \$jamSekarang = strtotime(date('H:i'));
                            
                            // Cek apakah jam masuk lebih kecil dari jam sekarang dan jam keluar lebih besar dari jam sekarang
                            if (\$jamMasuk <= \$jamSekarang && \$jamKeluar >= \$jamSekarang) { 
                                if (stripos(\$row->jabatan, 'dokter') !== false) { // Cek apakah jabatan mengandung kata \"dokter\"
                        ?>
                        <div class=\"col-lg-4 wow slideInUp\" data-wow-delay=\"0.3s\">
                            <div class=\"team-item\">
                                <div class=\"position-relative rounded-top\" style=\"z-index: 1;\">
                                    <img class=\"img-fluid rounded-top w-100\" src=\"<?=\$row->foto ?>\" alt=\"\" style=\"height: 300px; object-fit: cover;\">
                                    <!-- Adjust height as needed and use object-fit to control image display -->
                                </div>
                                <div class=\"team-text position-relative bg-light text-center rounded-bottom p-4 pt-5\">
                                    <h4 class=\"mb-2\"><?=\$row->nama ?></h4>
                                    <p class=\"text-primary mb-0\"><?=\$row->jabatan ?></p>
                                    <p class=\"text-success mb-0\">Jam Kerja</p>
                                    <p class=\"text-secondary mb-0\"><?=\$row->jammasuk ?> - <?=\$row->jamkeluar ?></p>
                                </div>
                            </div>
                        </div>
                        <?php 
                                } // end if
                            } // end if
                        } // end foreach
                        ?>
                    </div>
                </div>
            </div>
            <!-- Team End -->


            ";

            file_put_contents($puskesmas_folder3 .  'PegawaiAktif.php', $view_content);

            $view_content = "
           
            <div class=\"container-fluid\">
            <div class=\"d-flex align-items-center\">
                    <form class=\"col-2 d-flex align-items-center\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/UpdateAntrian/'.\$antrian->id)?>\" enctype=\"multipart/form-data\">
                        <div class=\"mb-4\">
                            <label>Max Antrian</label>
                            <input type=\"number\" class=\"form-control\" name=\"max_nomber\" value=\"<?=\$antrian->max_nomber?>\">
                        </div>
                        <button type=\"submit\" class=\" btn-success btn-sm\"><i class=\"fas fa-check\"></i></button>
                    </form>
                </div>
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold text-\">Data Pendaftaran</h6>
                </div>
                <div class=\"card-body\">
                    <div class=\"box\">
                    <div class=\"box-header d-flex justify-content-between\">
                    </div>
                    <div class=\"box-body\">
                    <div class=\"table-responsive\">
                    <?php echo \$this->session->userdata(\"success\"); ?>
                                <table class=\"table table-bordered table-hover\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>Layanan</th>
                                            <th>No Antrian</th>
                                            <th>QR</th>
                                            <th>Tanggal Daftar</th>
                                            <th>Opsi</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                        foreach (\$${lokasi}_pendaftaran->result() as \$row) {
                                           
                                            \$hapus = '<a class=\"btn btn-danger btn-sm\" href=\"#\" data-toggle=\"modal\" data-target=\"#deleteModal_' . \$row->id_pendaftaran . '\"><i class=\"fas fa-trash\"></i></a>';
                                            echo \"<tr>\";
                                        
                                            echo \"<td>\" . \$row->nama . \"</td>\";
                                            echo \"<td>\" . \$row->tanggal_lahir . \"</td>\";
                                            echo \"<td>\" . \$row->alamat . \"</td>\";
                                            echo \"<td>\" . \$row->layanan . \"</td>\";
                                            echo \"<td>\" . \$row->nomor_pendaftaran . \"</td>\";
                                            echo \"<td><img src='\" . \$row->qr_code . \"' width='100px' height='100px'></img></td>\";
                                            echo \"<td>\" . \$row->tanggal . \"</td>\";
                                            echo \"<td>\" . \$hapus . \"</td>\";
                                            echo \"</tr>\";

                                            // Modal konfirmasi hapus
                                            echo '<div class=\"modal fade\" id=\"deleteModal_' . \$row->id_pendaftaran . '\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel\" aria-hidden=\"true\">';
                                            echo '    <div class=\"modal-dialog\">';
                                            echo '        <div class=\"modal-content\">';
                                            echo '            <div class=\"modal-header\">';
                                            echo '                <h5 class=\"modal-title\" id=\"deleteModalLabel\">Konfirmasi Hapus</h5>';
                                            echo '                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">';
                                            echo '                    <span aria-hidden=\"true\">&times;</span>';
                                            echo '                </button>';
                                            echo '            </div>';
                                            echo '            <div class=\"modal-body\">';
                                            echo '                Apakah Anda yakin ingin menghapus pendaftar' . \$row->nama .'?';
                                            echo '            </div>';
                                            echo '            <div class=\"modal-footer\">';
                                            echo '                <a href=\"' . site_url(\"${lokasi}/${lokasi}_admin/deletePendaftaran/\" . \$row->id_pendaftaran) . '\" class=\"btn btn-danger\">Ya</a>';
                                            echo '                <button type=\"button\" class=\"btn btn-success\" data-dismiss=\"modal\">Tidak</button>';
                                            echo '            </div>';
                                            echo '        </div>';
                                            echo '    </div>';
                                            echo '</div>';
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>

            ";

            file_put_contents($puskesmas_folder3 .  'Pendaftaran_admin.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                  <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
                  <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
                  <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
              </div>
              <!-- Spinner End -->
          
              <!-- Hero Start -->
              <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                  <div class=\"row py-3\">
                      <div class=\"col-12 text-center\">
                          <h1 class=\"display-3 text-white animated zoomIn\">Pendaftaran Pasien</h1>
                      </div>
                      <h5 class=\"display-6 text-white animated zoomIn text-center\">Terdaftar : <?=\$antrian?></h5>
                        <h5 class=\"display-6 text-white animated zoomIn text-center\">Sisa pendaftaran : <?=\$sisa?></h5>
                  </div>
              </div>
              <!-- Hero End -->
          
              
              <!-- Form Pengaduan -->
              <div class=\"appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn\" data-wow-delay=\"0.6s\">
              <?php echo \$this->session->userdata(\"success\"); ?>
              <form  method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}/Daftar')?>\">
                  <div class=\"row g-3\">
                      <div class=\"col-12\">
                          <input type=\"text\" class=\"form-control border-0 bg-light px-4\" name =\"nama\" placeholder=\"Masukan Nama\" style=\"height: 55px;\" required>
                      </div>
                      <div class=\"col-12\">
                      <span class=\"input-group-text fas fa-calendar\" >Tanggal Lahir</span>
                          <input type=\"date\" class=\"form-control border-0 bg-light px-4\" name =\"tanggal_lahir\" placeholder=\"Masukan Tanggal\" style=\"height: 55px;\" required>
                      </div>
                      <div class=\"col-12\">
                          <textarea class=\"form-control border-0 bg-light px-4 py-3\" rows=\"5\" name =\"alamat\" placeholder=\"Masukan Alamat\" required></textarea>
                      </div>
                      <div class=\"form-group\">
                      <select class=\"form-control \" name=\"layanan\" style=\"height: 55px;\" required>
                              <?php
                               foreach (\$${lokasi}_layananpublik->result() as \$row) {
                                  echo '<option value=\"'.\$row->produk.'\"'.\$selected.'>'.\$row->produk.'</option>';
                              }
                              ?>
                          </select>
                  </div>
                      <div class=\"col-12\">
                          <button class=\"btn btn-dark w-100 py-3\" type=\"submit\">Daftar</button>
                      </div>
                  </div>
              </form>
              </div>
              <br>
              <br>
              <br>
              <br>
              <br>
            
          
              <!-- Form Pengaduan end -->

            ";

            file_put_contents($puskesmas_folder3 .  'Pendaftaran.php', $view_content);

            $view_content = "
            <!-- Spinner Start -->
            <div id=\"spinner\" class=\"show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center\">
                  <div class=\"spinner-grow text-primary m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
                  <div class=\"spinner-grow text-dark m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
                  <div class=\"spinner-grow text-secondary m-1\" role=\"status\">
                      <span class=\"sr-only\">Loading...</span>
                  </div>
              </div>
              <!-- Spinner End -->
          
              <!-- Hero Start -->
              <div class=\"container-fluid bg-primary py-5 hero-header mb-5\">
                  <div class=\"row py-3\">
                      <div class=\"col-12 text-center\">
                          <h1 class=\"display-3 text-white animated zoomIn\">Pendaftaran Pasien</h1>
                      </div>
                  </div>
              </div>
              <!-- Hero End -->
          
              
              <!-- Form Pengaduan -->
              <div class=\"appointment-form h-100 d-flex flex-column justify-content-center text-center p-5 wow zoomIn\" data-wow-delay=\"0.6s\">
              <?php echo \$this->session->userdata(\"success\"); ?>
              <div class=\"d-flex justify-content-center align-items-center vh-1\">
                  <div class=\"card\" style=\"width: 18rem;\">
                      <img src=\"<?php echo \$${lokasi}_pendaftaran->qr_code; ?>\" class=\"card-img-top\" alt=\"QR Code\">
                      <div class=\"card-body\">
                          <h5 class=\"card-title\"><?php echo \$${lokasi}_pendaftaran->nama; ?></h5>
                          <p class=\"card-text\">Tanggal Lahir: <?php echo \$${lokasi}_pendaftaran->tanggal_lahir; ?></p>
                          <p class=\"card-text\">No Antrian: <?php echo \$${lokasi}_pendaftaran->nomor_pendaftaran; ?></p>
                          <a href=\"<?php echo \$${lokasi}_pendaftaran->qr_code; ?>\" class=\"btn btn-primary\" download=\"gambar.png\">Cetak Gambar</a>
                      </div>
                  </div>
              </div>
              <br>
              <hr>
              <a href=\"<?=site_url('${lokasi}/${lokasi}')?>\" class=\"btn btn-primary\">Kembali Ke Beranda</a>
          </div>
              <br>
              <br>
              <br>
              <br>
              <br>
            
          
              <!-- Form Pengaduan end -->
            ";

            file_put_contents($puskesmas_folder3 .  'Tiket.php', $view_content);

            $view_content = "
            <div class=\"container-fluid\">
    
            <div class=\"card shadow mb-4\">
                <div class=\"card-header py-3\">
                    <h6 class=\"m-0 font-weight-bold \">Balas Pesan Pengaduan</h6>
                </div>
                <div class=\"card-body\">
                    <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/${lokasi}_admin/BalasPesan')?>\" enctype=\"multipart/form-data\">
                   
                        <div class=\"mb-3\">
                            <input type=\"email\" class=\"form-control\" name=\"email\" value=\"<?=\$umpan_balik->email?>\" readonly  required>
                        </div>
                        <div class=\"mb-3\">
                            <input type=\"text\" class=\"form-control\" name=\"subject\" value=\"<?=\$umpan_balik->subject?>\" readonly  required>
                        </div>
                        <div class=\"mb-3\">
                            <textarea type=\"text\" class=\"form-control\" name=\"pesan\" value=\"<?=\$umpan_balik->pesan?>\" readonly  required><?=\$umpan_balik->pesan?></textarea>
                        </div>
                        <div class=\"mb-3\">
                            <label>Subject</label>
                            <input type=\"text\" class=\"form-control\" name=\"subjectbalas\"  placeholder=\"Masukan Subject Pesan\" required>
                        </div>
                        <div class=\"mb-3\">
                            <label>Balasan</label>
                            <textarea type=\"text\" class=\"form-control\" name=\"balas\" placeholder=\"Masukan Pesan Balasan\" required></textarea>
                        </div>
                        
         
                        <hr>
                        <button type=\"submit\" class=\"btn btn-success btn-user btn-block\">Balas</button>
                    </form>
                </div>
            </div>
        
        </div>
        </div>
        
        
            ";

            file_put_contents($puskesmas_folder3 .  'BalasPengaduan.php', $view_content);

            $view_content = "
            <!DOCTYPE html>
            <html lang=\"en\">

            <head>

                <meta charset=\"utf-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
                <meta name=\"description\" content=\"\">
                <meta name=\"author\" content=\"\">

                <title><?=\$title?></title>
                <!-- Custom fonts for this template -->
                <link href=\"<?=base_url('asset/')?>vendor/fontawesome-free/css/all.min.css\" rel=\"stylesheet\" type=\"text/css\">
                <link href=\"https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i\"
                    rel=\"stylesheet\">
                <!-- Custom styles for this template -->
                <link href=\"<?=base_url('asset/')?>css/sb-admin-2.min.css\" rel=\"stylesheet\">
                <link rel=\"icon\" href=\"<?php echo base_url('asset/img/logodefault.png'); ?>\" type=\"image/x-icon\">
                <style>
                    .label {
                        display: inline-block;
                        width: 150px; 
                        font-weight: bold;
                    }
                    .bg-gradient-green-sea {
                    background: #034419;
                
                    }   
                    .btn-success {
                        background-color: #005700; 
                        border-color: #005700; 
                    }
                    .btn-danger {
                        background-color: #7F0000; 
                        border-color: #7F0000; 
                    }
                </style>
            </head>

            <body class=\"bg-gradient-green-sea\">

                <div class=\"container\">

                    <!-- Outer Row -->
                    <div class=\"row justify-content-center\">

                        <div class=\"col-xl-10 col-lg-12 col-md-9\">

                            <div class=\"card o-hidden border-0 shadow-lg my-5\">
                                <div class=\"card-body p-0\">
                                    <!-- Nested Row within Card Body -->
                                    <div class=\"row\">
                                    <div class=\"col-lg-6 d-none d-lg-block \"><img src=\"<?=base_url('asset/img/logodefault.png')?>\" class=\"img-fluid\" style=\"width: 100%;\"></div>
                                        <div class=\"col-lg-6\">
                                            <div class=\"p-5\">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <div class=\"text-center\">
                                                    <h1 class=\"h4 text-gray-900 mb-2\">Lupa Password?</h1>
                                                    <p class=\"mb-4\">Masukan password baru !</p>
                                                </div>
                                                <?php echo \$this->session->userdata(\"success\"); ?>
                                                <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/Auth/update_password')?>\">
                                                <input type=\"hidden\" name=\"token\" value=\"<?= \$token; ?>\">
                                                    <div class=\"form-group\">
                                                        <input type=\"password\" class=\"form-control form-control-user\"
                                                            name=\"password\" id=\"exampleInputEmail\" aria-describedby=\"emailHelp\"
                                                            placeholder=\"Masukan Password Baru...\" required>
                                                    </div>
                                                    <div class=\"form-group\">
                                                        <input type=\"password\" class=\"form-control form-control-user\"
                                                            name=\"confirm_password\" id=\"exampleInputEmail\" aria-describedby=\"emailHelp\"
                                                            placeholder=\"Ulangi Password...\" required>
                                                    </div>
                                                    <button type=\"submit\" class=\"form-group btn btn-success btn-user btn-block\">
                                                        Reset Password
                                                    </button>
                                                </form>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Bootstrap core JavaScript -->
                <script src=\"<?=base_url('asset/')?>vendor/jquery/jquery.min.js\"></script>
                <script src=\"<?=base_url('asset/')?>vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
                <!-- Core plugin JavaScript -->
                <script src=\"<?=base_url('asset/')?>vendor/jquery-easing/jquery.easing.min.js\"></script>
                <!-- Custom scripts for all pages -->
                <script src=\"js/sb-admin-2.min.js\"></script>

            </body>

            </html>
        
            ";

            file_put_contents($puskesmas_folder3 .  'reset_password_form.php', $view_content);

            $view_content = "
            <!DOCTYPE html>
            <html lang=\"en\">

            <head>

                <meta charset=\"utf-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
                <meta name=\"description\" content=\"\">
                <meta name=\"author\" content=\"\">

                <title><?=\$title?></title>
                <!-- Custom fonts for this template -->
                <link href=\"<?=base_url('asset/')?>vendor/fontawesome-free/css/all.min.css\" rel=\"stylesheet\" type=\"text/css\">
                <link href=\"https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i\"
                    rel=\"stylesheet\">
                <!-- Custom styles for this template -->
                <link href=\"<?=base_url('asset/')?>css/sb-admin-2.min.css\" rel=\"stylesheet\">
                <link rel=\"icon\" href=\"<?php echo base_url('asset/img/logodefault.png'); ?>\" type=\"image/x-icon\">
                <style>
                    .label {
                        display: inline-block;
                        width: 150px; 
                        font-weight: bold;
                    }
                    .bg-gradient-green-sea {
                    background: #034419;
                
                    }   
                    .btn-success {
                        background-color: #005700; 
                        border-color: #005700; 
                    }
                    .btn-danger {
                        background-color: #7F0000; 
                        border-color: #7F0000; 
                    }
                </style>
            </head>

            <body class=\"bg-gradient-green-sea\">

                <div class=\"container\">

                    <!-- Outer Row -->
                    <div class=\"row justify-content-center\">

                        <div class=\"col-xl-10 col-lg-12 col-md-9\">

                            <div class=\"card o-hidden border-0 shadow-lg my-5\">
                                <div class=\"card-body p-0\">
                                    <!-- Nested Row within Card Body -->
                                    <div class=\"row\">
                                    <div class=\"col-lg-6 d-none d-lg-block \"><img src=\"<?=base_url('asset/img/logodefault.png')?>\" class=\"img-fluid\" style=\"width: 100%;\"></div>
                                        <div class=\"col-lg-6\">
                                            <div class=\"p-5\">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <div class=\"text-center\">
                                                    <h1 class=\"h4 text-gray-900 mb-2\">Lupa Password?</h1>
                                                    <p class=\"mb-4\">Masukan alamat Email dan sistem akan mengirim tautan untuk melakukan reset password !</p>
                                                </div>
                                                <?php echo \$this->session->userdata(\"success\"); ?>
                                                <form class=\"user\" method=\"post\" action=\"<?=site_url('${lokasi}/Auth/reset_password')?>\">
                                                    <div class=\"form-group\">
                                                        <input type=\"email\" class=\"form-control form-control-user\"
                                                            name=\"email\" id=\"exampleInputEmail\" aria-describedby=\"emailHelp\"
                                                            placeholder=\"Maukan Email Anda...\">
                                                    </div>
                                                    <button type=\"submit\" class=\"form-group btn btn-success btn-user btn-block\">
                                                        Riset Password
                                                    </button>
                                                </form>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Bootstrap core JavaScript -->
                <script src=\"<?=base_url('asset/')?>vendor/jquery/jquery.min.js\"></script>
                <script src=\"<?=base_url('asset/')?>vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
                <!-- Core plugin JavaScript -->
                <script src=\"<?=base_url('asset/')?>vendor/jquery-easing/jquery.easing.min.js\"></script>
                <!-- Custom scripts for all pages -->
                <script src=\"js/sb-admin-2.min.js\"></script>

            </body>

            </html>
        
            ";

            file_put_contents($puskesmas_folder3 .  'Lupapw.php', $view_content);
            
            // Untuk membuat folder di dalam folder "asset"
            $asset_folder = FCPATH . 'asset/' . $lokasi . '/';
            if (!is_dir($asset_folder)) {
                mkdir($asset_folder, 0777, true);
            }
            
            //Membuat tabel database
            $this->load->dbforge();

            $table_name = $lokasi . '_visi_misi';
            $fields = array(
                'id_visi' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'visi' => array(
                    'type' => 'TEXT', 
                ),
                'misi' => array(
                    'type' => 'TEXT',
                ),
                'motto' => array(
                    'type' => 'TEXT', 
                ),
                'tatanilai' => array(
                    'type' => 'TEXT', 
                ),
                'logo' => array(
                    'type' => 'TEXT', 
                ),
                
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_visi', true);
            $this->dbforge->create_table($table_name, true);
            $data = array(
                'visi' => 'Isi Visi',
                'misi' => 'Isi Misi',
                'motto' =>'Isi Motto',
                'tatanilai' =>'Isi Tatanilai',
                'logo' =>base_url('asset/img/logodefault.png'),
            );
            
            $this->db->insert($table_name, $data);
           

            //Membuat tabel database
            $this->load->dbforge();

            $table_name2 = $lokasi . '_corousel';
            $fields = array(
                'id_corousel' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'judul' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                ),
                'keterangan' => array(
                    'type' => 'TEXT',
                ),
                
                'date_create' => array(
                    'type' => 'DATETIME',
                ),
                'gambar' => array(
                    'type' => 'TEXT', 
                ),
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_corousel', true);
            $this->dbforge->create_table($table_name2, true);
            $data = array(
                'judul' => 'Isi judul',
                'keterangan' => 'Isi keterangan',
                'date_create' =>date('Y-m-d H:i:s', Time()),
                'gambar' =>base_url('asset/assets_user/img/noimage.png'),
            );
            
            $this->db->insert($table_name2, $data);


            //Membuat tabel database
            $this->load->dbforge();

            $table_name3 = $lokasi . '_pegawai';
            $fields = array(
                'id_pegawai' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'nama' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                ),
                'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                ),
                
                'no_hp' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 13,
                ),
                'jabatan' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50, 
                ),
                'jammasuk' => array(
                    'type' => 'TIME', 
                ),
                'jamkeluar' => array(
                    'type' => 'TIME', 
                ),
                'create' => array(
                    'type' => 'DATETIME', 
                ),
                'foto' => array(
                    'type' => 'TEXT', 
                ),
                
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_pegawai', true);
            $this->dbforge->create_table($table_name3, true);


            //Membuat tabel database
            $this->load->dbforge();

            $table_name5 = $lokasi . '_login';
            $fields = array(
                'id_login' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'username' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50, 
                ),
                'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                ),
                
                'password' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 60, 
                ),
                'privasi' => array(
                    'type' => 'INT',
                    'constraint' => 1, 
                ),
                'reset_token' => array(
                    'type' => 'TEXT',
                    
                ),
                'reset_token_expiration' => array(
                    'type' => 'TEXT',
                     
                ),
               
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_login', true);
            $this->dbforge->create_table($table_name5, true);
            $data = array(
                'username' => $username,
                'email' => $email,
                'privasi' => '0',
                'password' => password_hash($password, PASSWORD_DEFAULT) // Simpan password dalam bentuk hash
            );
            
            $this->db->insert($table_name5, $data);

            //Membuat tabel database
            $this->load->dbforge();

            $table_name6 = $lokasi . '_organisasi';
            $fields = array(
                'id_organisasi' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'keterangan' => array(
                    'type' => 'TEXT', 
                ),
                'gambar' => array(
                    'type' => 'TEXT',
                ),
                
                'date_create' => array(
                    'type' => 'DATETIME', 
                ),
               
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_organisasi', true);
            $this->dbforge->create_table($table_name6, true);
            $data = array(
                
                'gambar' => base_url('asset/img/logodefault.png'),
                'date_create' => date('Y-m-d H:i:s', Time()),
            );
            
            $this->db->insert($table_name6, $data);

            //Membuat tabel database
            $this->load->dbforge();

            $table_name7 = $lokasi . '_galery';
            $fields = array(
                'id_galery' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'kegiatan' => array(
                    'type' => 'TEXT', 
                ),
                'gambar' => array(
                    'type' => 'TEXT',
                ),
                
                'date_create' => array(
                    'type' => 'DATETIME',
                ),
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_galery', true);
            $this->dbforge->create_table($table_name7, true);

            //Membuat tabel database
            $this->load->dbforge();

            $table_name8 = $lokasi . '_sejarah';
            $fields = array(
                'id_sejarah' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'sejarah' => array(
                    'type' => 'TEXT', 
                ),
                'maklumat' => array(
                    'type' => 'TEXT',
                ),
                'alamat' => array(
                    'type' => 'TEXT', 
                ),
                'alamat_map' => array(
                    'type' => 'TEXT', 
                ),
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_sejarah', true);
            $this->dbforge->create_table($table_name8, true);
            $data = array(
                
                'maklumat' => base_url('asset/img/logodefault.png'),
                'alamat' => $alamat,
                'alamat_map' => $alamat_map,
            );
            
            $this->db->insert($table_name8, $data);

            //Membuat tabel database
            $this->load->dbforge();

            $table_name9 = $lokasi . '_layananpublik';
            $fields = array(
                'id_layananpublik' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'produk' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                ),
                'biaya' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 6,
                ),
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_layananpublik', true);
            $this->dbforge->create_table($table_name9, true);

            //Membuat tabel database
            $this->load->dbforge();

            $table_name10 = $lokasi . '_layanankhusus';
            $fields = array(
                'id_layanankhusus' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'visi' => array(
                    'type' => 'TEXT', 
                ),
                'misi' => array(
                    'type' => 'TEXT',
                ),
                
                'atribut' => array(
                    'type' => 'TEXT',
                ),
                'layananterpadu' => array(
                    'type' => 'TEXT', 
                ),
                
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_layanankhusus', true);
            $this->dbforge->create_table($table_name10, true);
            $data = array(
                
                'visi' => 'Kosong',
                'misi' => 'Kosong',
                'atribut' => 'Kosong',
                'layananterpadu' => 'kosong',
            );
            
            $this->db->insert($table_name10, $data);

            //Membuat tabel database
            $this->load->dbforge();

            $table_name11 = $lokasi . '_sosialmedia';
            $fields = array(
                'id_sosialmedia' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'instagram' => array(
                    'type' => 'TEXT', 
                ),
                'facebook' => array(
                    'type' => 'TEXT',
                ),
                'twiter' => array(
                    'type' => 'TEXT',
                ),
                
                'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                ),
                'no_hp' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 13, 
                ),
                'kode_pos' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 5, 
                ),
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_sosialmedia', true);
            $this->dbforge->create_table($table_name11, true);
            $data = array(
                
                'no_hp' => $no_hp,
                'email' => $email,
                'kode_pos' => $kode_pos,
            );
            
            $this->db->insert($table_name11, $data);

            //Membuat tabel database
            $this->load->dbforge();

            $table_name12 = $lokasi . '_pendaftaran';
            $fields = array(
                'id_pendaftaran' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'nama' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                ),
                'tanggal_lahir' => array(
                    'type' => 'DATE',
                ),
                'alamat' => array(
                    'type' => 'TEXT',
                ),
                
                'layanan' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 30,
                ),
                'qr_code' => array(
                    'type' => 'TEXT', 
                ),
                'tanggal' => array(
                    'type' => 'DATE', 
                ),
                'nomor_pendaftaran' => array(
                    'type' => 'INT',
                    'constraint' => 2, 
                ),
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_pendaftaran', true);
            $this->dbforge->create_table($table_name12, true);

            //Membuat tabel database
            $this->load->dbforge();

            $table_name13 = $lokasi . '_antrian';
            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'max_nomber' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                ),
                
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', true);
            $this->dbforge->create_table($table_name13, true);
            $data = array(
                'max_nomber' => 10,
            );
            
            $this->db->insert($table_name13, $data);

            //Membuat tabel database
            $this->load->dbforge();

            $table_name14 = $lokasi . '_layanan';
            $fields = array(
                'id_layanan' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'spm' => array(
                    'type' => 'TEXT',
                    
                ),
                'konpensasi' => array(
                    'type' => 'TEXT',
                    
                ),
                'fasilitas' => array(
                    'type' => 'TEXT',
                    
                ),
                'sarana' => array(
                    'type' => 'TEXT',
                    
                ),
                'mekanisme' => array(
                    'type' => 'TEXT',
                    
                ),
                
                
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id_layanan', true);
            $this->dbforge->create_table($table_name14, true);
            $data = array(
                'spm' =>base_url('asset/assets_user/img/noimage.png'),
                'konpensasi' =>base_url('asset/assets_user/img/noimage.png'),
                'fasilitas' => 'Kosong',
                'sarana' => 'Kosong',
                'mekanisme' => 'Kosong',
            );
            
            $this->db->insert($table_name14, $data);

            $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Web puskesmas ${lokasi} berhasil di buat!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            echo "Website untuk ${lokasi} berhasil dibuat!";
            redirect(site_url("SuperAdmin/Content/WebData"));
        } else {
            redirect(site_url("SuperAdmin/SuperAdmin/Generator"));
        }
    
    }
    // public function Update($id) {
    //     $this->load->model('SuperAdmin/WebModel');
        
    //     // Dapatkan data puskesmas berdasarkan ID
    //     $web = $this->WebModel->getWebData($id);
        
    //     if ($web) {
    //         $this->load->dbforge();
    //         $table_name = strtolower($web->lokasi) . '_login';
            
    //         // Hapus tabel login jika ada
    //         if ($this->db->table_exists($table_name)) {
    //             $this->dbforge->drop_table($table_name);
    //         }
            
    //         // Definisikan struktur tabel baru
    //         $fields = array(
    //             'id_login' => array(
    //                 'type' => 'INT',
    //                 'constraint' => 5,
    //                 'unsigned' => true,
    //                 'auto_increment' => true
    //             ),
    //             'username' => array(
    //                 'type' => 'VARCHAR',
    //                 'constraint' => 50 
    //             ),
    //             'email' => array(
    //                 'type' => 'VARCHAR',
    //                 'constraint' => 50 
    //             ),
    //             'password' => array(
    //                 'type' => 'VARCHAR',
    //                 'constraint' => 60 
    //             ),
    //             'privasi' => array(
    //                 'type' => 'INT',
    //                 'constraint' => 1 
    //             ),
    //             'reset_token' => array(
    //                 'type' => 'TEXT',
                    
    //             ),
    //             'reset_token_expiration' => array(
    //                 'type' => 'TEXT',
                     
    //             ),
    //         );
    
    //         // Buat tabel baru dengan struktur yang didefinisikan
    //         $this->dbforge->add_field($fields);
    //         $this->dbforge->add_key('id_login', true);
    //         $this->dbforge->create_table($table_name, true);
            
    //         // Data baru
    //         $username = $this->input->post('username');
    //         $email = $this->input->post('email');
    //         $password = $this->input->post('password');
    //         $data = array(
    //             'username' => $username,
    //             'email' => $email,
    //             'privasi' =>'0',
    //             'password' => password_hash($password, PASSWORD_DEFAULT)
    //         );
            
    //         // Masukkan data baru ke tabel
    //         $this->db->insert($table_name, $data);
            
            
    //         $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Admin berhasil diupdate!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    //     } else {
    //         $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Admin gagal diupdate!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    //     }
        
    //     redirect(site_url("SuperAdmin/Content/WebData"));
    // }
    
    public function Delete($id) {
        // Load model WebModel
        $this->load->model('SuperAdmin/WebModel');
        $web = $this->WebModel->getWebData($id);
    
        if ($web) {
            $this->delete_folder(FCPATH . 'asset/' . $web->lokasi);
            // Hapus folder yang puskesmas
            $puskesmas_folder = APPPATH . 'controllers/' . $web->lokasi . '/';
            if (is_dir($puskesmas_folder)) {
                $this->delete_folder($puskesmas_folder);
            }
            $puskesmas_folder2 = APPPATH . 'models/' . $web->lokasi . '/';
            if (is_dir($puskesmas_folder2)) {
                $this->delete_folder($puskesmas_folder2);
            }
            $puskesmas_folder3 = APPPATH . 'views/' . $web->lokasi . '/';
            if (is_dir($puskesmas_folder3)) {
                $this->delete_folder($puskesmas_folder3);
            }
            // Hapus tabel dari database
            $this->load->dbforge();
            $table_names = [
                'visi_misi',
                'corousel',
                'pegawai',
                'login',
                'organisasi',
                'galery',
                'sejarah',
                'layananpublik',
                'layanankhusus',
                'sosialmedia',
                'pendaftaran',
                'layanan',
                'antrian'
            ];

            foreach ($table_names as $table_name) {
                $full_table_name = strtolower($web->lokasi) . '_' . $table_name;
                if ($this->db->table_exists($full_table_name)) {
                    $this->dbforge->drop_table($full_table_name);
                }
        }

        // Hapus data puskesmas dari database
            $this->WebModel->deleteWeb($id);
    
            // Set flashdata pesan sukses
            $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Web puskesmas ${lokasi} berhasil di hapus!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    
            redirect(site_url("SuperAdmin/Content/WebData"));
        } else {
            // Set flashdata pesan error
            $this->session->set_flashdata('error_message', 'Data puskesmas tidak ditemukan.');
    
            redirect(site_url("SuperAdmin/Content/WebData"));
        }
    }
    
    
    private function delete_folder($folder_path) {
        if (is_dir($folder_path)) {
            $files = scandir($folder_path);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    if (is_dir($folder_path . '/' . $file)) {
                        $this->delete_folder($folder_path . '/' . $file);
                    } else {
                        unlink($folder_path . '/' . $file);
                    }
                }
            }
            rmdir($folder_path);
        }
    }
    

}
?>