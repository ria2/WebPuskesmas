<?php
class Content extends CI_Controller
{
    public function __construct() {
        parent::__construct();
      
        $this->load->model("LoginModel","",TRUE);
        $this->load->model("FeedModel","",TRUE);
        $this->load->model("BeritaModel","",TRUE);
        $this->load->model("SuperAdmin/WebModel","",TRUE);
        
        
        ;
    }
    public function WebData()
    {
        if($this->session->userdata('login_super')){
            
            $data['title'] = 'Halaman Data Web';
            $data['webpuskesmas'] = $this->WebModel->getWeb();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/Website',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
            redirect(site_url('Auth'));
        }

        
    }
    public function admin()
    {
        if($this->session->userdata('login_super')){
            
            $data['title'] = 'Halaman Setting Super Admin';
            $data['admin'] = $this->LoginModel->getAdmin();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/admin',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
            redirect(site_url('Auth'));
        }

    }
    public function DetailWeb($id)
    {
        if($this->session->userdata('login_super')){
            
            $data['title'] = 'Halaman Detail Web';
            $this->load->model('SuperAdmin/WebModel');
            $data['webpuskesmas'] = $this->WebModel->getWebById($id)->row();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/DetailPuskesmas',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
            redirect(site_url('Auth'));
        }

    }
    public function Adminpuskesmas($kode_puskesmas)
    {
        if ($this->session->userdata('login_super')) {
            $data['title'] = 'Halaman Detail Web';
            $this->load->model('SuperAdmin/WebModel');
            $data['admin'] = $this->WebModel->getWebadmin($kode_puskesmas);
            $data['data_admin'] = $this->WebModel->getAdminpus($kode_puskesmas);
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/Adminpus', $data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        } else {
            redirect(site_url('Auth'));
        }
    }
    public function Feed()
    {
        if($this->session->userdata('login_super')){
            
            $data['title'] = 'Halaman Umpan Balik';
            $data['umpan_balik'] = $this->FeedModel->getFeed();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/Umpan_Balik',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
            redirect(site_url('Auth'));
        }
    }
    public function Berita()
    {
        if($this->session->userdata('login_super')){
           
            $data['title'] = 'Halaman Setting Berita';
            $data['berita'] = $this->BeritaModel->getBerita();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/Berita',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
            redirect(site_url('Auth'));
        }
    }
    public function TambahBerita()
    {
        if($this->session->userdata('login_super')){
            $data['title'] = 'Halaman Tambah Berita';
            // $data['berita'] = $this->BeritaModel->getBerita();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/TambahBerita',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
            redirect(site_url('Auth'));
        }
    }
    public function prosesTambahBerita(){
        if ($this->BeritaModel->prosesTambahBerita()) {
            redirect(site_url("SuperAdmin/Content/Berita"));
        } else {
            redirect(site_url("SuperAdmin/Content/TambahBerita"));
        }
    }
    public function UpdateBerita($id)
    {
        if($this->session->userdata('login_super')){
            $data['title'] = 'Halaman Tambah berita';
            $data['berita'] = $this->BeritaModel->getBeritaById($id)->row();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/UpdateBerita',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
            redirect(site_url('Auth'));
        }
    }
    public function prosesUpdateBerita($id){
        if ($this->BeritaModel->prosesUpdateBerita($id)) {
            redirect(site_url("SuperAdmin/Content/Berita"));
        } else {
            redirect(site_url("SuperAdmin/Content/UpdateBerita/$id"));
        }
    }
    public function deleteBerita($id) {
        $this->BeritaModel->deleteBerita($id);
        redirect(site_url("SuperAdmin/Content/Berita"));
    }
    public function BalasPengaduan($id)
    {
        if($this->session->userdata('login_super')){
            
            $data['title'] = 'Balas Pengaduan';
            $data['umpan_balik'] = $this->FeedModel->getFeedById($id)->row();
            $this->load->view('SuperAdmin/Navbar', $data);
            $this->load->view('SuperAdmin/BalasPengaduan',$data);
            $this->load->view('SuperAdmin/Footer');
            $this->load->view('SuperAdmin/Modal');
        }else{
            redirect(site_url('Auth'));
        }

    }
    public function BalasPesan() {
        $this->FeedModel->balaspesan();
        redirect(site_url("SuperAdmin/Content/Feed"));
    }
    public function DeleteFeed($id) {
        $this->FeedModel->deleteUmpanBalik($id);
        redirect(site_url("SuperAdmin/Content/Feed"));
    }
    
}
?>