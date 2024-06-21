
            <?php
            class Padalarang_admin extends CI_Controller {
                public function __construct() {
                    parent::__construct();
                    $this->load->model("Padalarang/CorouselModel","",TRUE);
                    $this->load->model("Padalarang/VisiMisiModel","",TRUE);
                    $this->load->model("Padalarang/PegawaiModel","",TRUE);
                    $this->load->model("Padalarang/LoginModel","",TRUE);
                    $this->load->model("FeedModel","",TRUE);
                    $this->load->model("BeritaModel","",TRUE);
                    $this->load->model("KepuasanModel","",TRUE);
                    $this->load->model("Padalarang/OrganisasiModel","",TRUE);
                    $this->load->model("Padalarang/GaleryModel","",TRUE);
                    $this->load->model("Padalarang/LayananPublikModel","",TRUE);
                    $this->load->model("Padalarang/LayananKhususModel","",TRUE);
                    $this->load->model("Padalarang/SejarahModel","",TRUE);
                    $this->load->model("Padalarang/SosialMediaModel","",TRUE);
                    $this->load->model("Padalarang/PendaftaranModel","",TRUE);
                    
                    ;
                }
                public function index()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Admin';
                        $data['Padalarang_login'] = $this->LoginModel->totalData();
                        $data['umpan_balik'] = $this->FeedModel->totalData();
                        $data['survey'] = $this->KepuasanModel->get_survey_results(); 
                        $data['survey_reason'] = $this->KepuasanModel->getSurveyReason(); 
                        $data['berita'] = $this->BeritaModel->totalData();
                        $data['pendaftaran'] = $this->PendaftaranModel->totalData();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Dashboard_admin', $data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                        
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function Corousel()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Setting Corousel';
                        $data['Padalarang_corousel'] = $this->CorouselModel->getCorousel();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Corousel_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function VisiMisi()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Setting Visi & Misi';
                        $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Visi_Misi_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function Berita()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Setting Berita';
                        $data['berita'] = $this->BeritaModel->getBerita();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Berita_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                
                public function Feed()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Umpan Balik';
                        $data['umpan_balik'] = $this->FeedModel->getFeed();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Umpan_Balik_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function DataPegawai()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Data Pegawai';
                        $data['Padalarang_pegawai'] = $this->PegawaiModel->getPegawai();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/DataPegawai_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }

                }
                public function Organisasi()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Data Organisasi';
                        $data['Padalarang_organisasi'] = $this->OrganisasiModel->getOrganisasi();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Organisasi_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }

                }
                public function admin()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Setting Admin';
                        $data['Padalarang_login'] = $this->LoginModel->getAdmin();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function TambahAdmin()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Tambah Admin';
                        $data['Padalarang_login'] = $this->LoginModel->getAdmin();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Tambah_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function UpdateAdmin($id)
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Tambah Admin';
                        $data['Padalarang_login'] = $this->LoginModel->getAdminById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Update_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesUpdate($id){
                    if ($this->LoginModel->prosesUpdate($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/admin"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateAdmin/$id"));
                    }
                }
                public function deleteAdmin($id) {
                    $this->LoginModel->deleteAdmin($id);
                    redirect(site_url("Padalarang/Padalarang_admin/admin"));
                }
                public function UpdateVisi($id) {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Tamabah Visi & Misi';
                        $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisiById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Update_Visi_Misi',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prossesUpdateVisi($id){
                    if ($this->VisiMisiModel->prosesUpdate($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/VisiMisi"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateVisi/$id"));
                    }
                }
                public function TambahPegawai()
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Tambah Pegawai';
                        $data['Padalarang_pegawai'] = $this->PegawaiModel->getPegawai();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/TambahPegawai',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prossesTambahPegawai(){
                    if ($this->PegawaiModel->prosesTambahPegawai()) {
                        redirect(site_url("Padalarang/Padalarang_admin/DataPegawai"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/DataPegawai"));
                    }
                }
                public function UpdatePegawai($id)
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Edit Pegawai';
                        $data['Padalarang_pegawai'] = $this->PegawaiModel->getPegawaiById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdatePegawai',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prossesUpdatePegawai($id){
                    if ($this->PegawaiModel->prosesUpdatePegawai($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/DataPegawai"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/DataPegawai"));
                    }
                }
                public function deletePegawai($id) {
                    $this->PegawaiModel->deletePegawai($id);
                    redirect(site_url("Padalarang/Padalarang_admin/DataPegawai"));
                }
                public function JadwalPegawai()
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Jadwal Pegawai';
                        $data['Padalarang_pegawai'] = $this->PegawaiModel->getPegawai();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/JadwalPegawai',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function UpdateJadwal($id)
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Edit Jadwal Pegawai';
                        $data['Padalarang_pegawai'] = $this->PegawaiModel->getPegawaiById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdateJadwal',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prossesUpdateJadwal($id){
                    if ($this->PegawaiModel->prosesUpdateJadwal($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/JadwalPegawai"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/JadwalPegawai"));
                    }
                }
                public function TambahBerita()
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Tambah Berita';
                        $data['berita'] = $this->BeritaModel->getBerita();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/TambahBerita',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesTambahBerita(){
                    if ($this->BeritaModel->prosesTambahBerita()) {
                        redirect(site_url("Padalarang/Padalarang_admin/Berita"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/TambahBerita"));
                    }
                }
                public function UpdateBerita($id)
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Tambah berita';
                        $data['berita'] = $this->BeritaModel->getBeritaById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdateBerita',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesUpdateBerita($id){
                    if ($this->BeritaModel->prosesUpdateBerita($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/Berita"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateBerita"));
                    }
                }
                public function deleteBerita($id) {
                    $this->BeritaModel->deleteBerita($id);
                    redirect(site_url("Padalarang/Padalarang_admin/berita"));
                }
                public function TambahCorousel()
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Tambah Slide Show';
                        $data['Padalarang_Corousel'] = $this->CorouselModel->getCorousel();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/TambahCorousel',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesTambahCorousel(){
                    if ($this->CorouselModel->prosesTambahCorousel()) {
                        redirect(site_url("Padalarang/Padalarang_admin/Corousel"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/TambahCorousel"));
                    }
                }
                public function UpdateCorousel($id)
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Tambah Corousel';
                        $data['Padalarang_corousel'] = $this->CorouselModel->getCorouselById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdateCorousel',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesUpdateCorousel($id){
                    if ($this->CorouselModel->prosesUpdateCorousel($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/Corousel"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateCorousel"));
                    }
                }
                public function deleteCorousel($id) {
                    $this->CorouselModel->deleteCorousel($id);
                    redirect(site_url("Padalarang/Padalarang_admin/Corousel"));
                }
                public function UpdateOrganisasi($id)
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Update Organisasi';
                        $data['Padalarang_organisasi'] = $this->OrganisasiModel->getOrganisasiById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdateOrganisasi',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesUpdateOrganisasi($id){
                    if ($this->OrganisasiModel->prosesUpdateOrganisasi($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/Organisasi"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateOrganisasi"));
                    }
                }
                public function Galery()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Setting Galery';
                        $data['Padalarang_galery'] = $this->GaleryModel->getGalery();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Galery_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function TambahGalery()
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Tambah Galery';
                        $data['Padalarang_galery'] = $this->GaleryModel->getGalery();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/TambahGalery',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesTambahGalery(){
                    if ($this->GaleryModel->prosesTambahGalery()) {
                        redirect(site_url("Padalarang/Padalarang_admin/Galery"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/TambahGalery"));
                    }
                }
                public function UpdateGalery($id)
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Tambah Galery';
                        $data['Padalarang_galery'] = $this->GaleryModel->getGaleryById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdateGalery',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesUpdateGalery($id){
                    if ($this->GaleryModel->prosesUpdateGalery($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/Galery"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateGalery"));
                    }
                }
                public function deleteGalery($id) {
                    $this->GaleryModel->deleteGalery($id);
                    redirect(site_url("Padalarang/Padalarang_admin/Galery"));
                }

                public function LayananPublik()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Setting Layanan Publik';
                        $data['Padalarang_layananpublik'] = $this->LayananPublikModel->getLayananPublik();
                        $data['Padalarang_layanan'] = $this->LayananPublikModel->getLayanan();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/LayananPublik_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function TambahLayananPublik()
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Tambah LayananPublik';
                        $data['Padalarang_layananpublik'] = $this->LayananPublikModel->getLayananPublik();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/TambahLayananPublik',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesTambahLayananPublik(){
                    if ($this->LayananPublikModel->prosesTambahLayananPublik()) {
                        redirect(site_url("Padalarang/Padalarang_admin/LayananPublik"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/TambahLayananPublik"));
                    }
                }
                public function UpdateLayananPublik($id)
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Update Layanan Publik';
                        $data['Padalarang_layananpublik'] = $this->LayananPublikModel->getLayananPublikById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdateLayananPublik',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function UpdateLayanan($id)
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Update Mekanisme Layanan Publik';
                        $data['Padalarang_layanan'] = $this->LayananPublikModel->getLayananById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdateLayanan',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesUpdateLayananPublik($id){
                    if ($this->LayananPublikModel->prosesUpdateLayananPublik($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/LayananPublik"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateLayananPublik"));
                    }
                }
                public function prosesUpdateLayanan($id){
                    if ($this->LayananPublikModel->prosesUpdateLayanan($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/LayananPublik"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateLayanan/".$id));
                    }
                }
                public function deleteLayananPublik($id) {
                    $this->LayananPublikModel->deleteLayananPublik($id);
                    redirect(site_url("Padalarang/Padalarang_admin/LayananPublik"));
                }
                public function LayananKhusus()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Setting Layanan Khusus';
                        $data['Padalarang_layanankhusus'] = $this->LayananKhususModel->getLayananKhusus();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/LayananKhusus_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                
                public function UpdateLayananKhusus($id)
                {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Update Layanan Khusus';
                        $data['Padalarang_layanankhusus'] = $this->LayananKhususModel->getLayananKhususById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdateLayananKhusus',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prosesUpdateLayananKhusus($id){
                    if ($this->LayananKhususModel->prosesUpdateLayananKhusus($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/LayananKhusus"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateLayananKhusus"));
                    }
                }
               
                public function Sejarah()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Setting Sejarah';
                        $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Sejarah_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                //Tambahan
                public function UpdateSejarah($id) {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman Sejarah & Maklumat';
                        $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarahById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdateSejarah',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prossesUpdateSejarah($id){
                    if ($this->SejarahModel->prosesUpdate($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/Sejarah"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateVisi/$id"));
                    }
                }
                public function SosialMedia()
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Setting Sosial Media';
                        $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/SosialMedia_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                //Tambahan
                public function UpdateSosialMedia($id) {
                    if($this->session->userdata('login')){
                        $data['title'] = 'Halaman update Sosial Media ';
                        $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMediaById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/UpdateSosialMedia',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function prossesUpdateSosialMedia($id){
                    if ($this->SosialMediaModel->prosesUpdate($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/SosialMedia"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/UpdateSosialMedia/$id"));
                    }
                }
                public function Pendaftaran()
                {
                    if($this->session->userdata('login')){
                        $tanggalawal = $this->input->get('tanggalawal');
                        $tanggalakhir = $this->input->get('tanggalakhir');
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Halaman Data Pendaftaran';
                        $data['Padalarang_pendaftaran'] = $this->PendaftaranModel->getPendaftaran($tanggalawal, $tanggalakhir);
                        $data['antrian'] = $this->PendaftaranModel->getAntrian()->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/Pendaftaran_admin',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Padalarang/Auth'));
                    }
                }
                public function deletePendaftaran($id) {
                    $this->PendaftaranModel->deletePendaftaran($id);
                    redirect(site_url("Padalarang/Padalarang_admin/Pendaftaran"));
                }
                public function BalasPengaduan($id)
                {
                    if($this->session->userdata('login')){
                        $foto = $this->session->userdata('foto');
                        $data['title'] = 'Balas Pengaduan';
                        $data['umpan_balik'] = $this->FeedModel->getFeedById($id)->row();
                        $this->load->view('Padalarang/Navbar_admin', $data);
                        $this->load->view('Padalarang/BalasPengaduan',$data);
                        $this->load->view('Padalarang/Footer_admin');
                        $this->load->view('Padalarang/Modal_admin');
                    }else{
                        redirect(site_url('Auth'));
                    }
            
                }
                public function BalasPesan() {
                    $this->FeedModel->balaspesan();
                    redirect(site_url("Padalarang/Padalarang_admin/Feed"));
                }
                public function DeleteFeed($id) {
                    $this->FeedModel->deleteUmpanBalik($id);
                    redirect(site_url("Padalarang/Padalarang_admin/Feed"));
                }
                public function UpdateAntrian($id){
                    if ($this->PendaftaranModel->UpdateAntrian($id)) {
                        redirect(site_url("Padalarang/Padalarang_admin/Pendaftaran"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang_admin/Pendaftaran"));
                    }
                }
                public function mpdfPendaftaran(){
                    $tanggalawal = $this->input->get('tanggalawal');
                    $tanggalakhir = $this->input->get('tanggalakhir');
                    $mpdf = new \Mpdf\Mpdf();
                    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    $data['Padalarang_pendaftaran'] = $this->PendaftaranModel->getPendaftaran($tanggalawal, $tanggalakhir);
                    
                    // Assuming 'Padalarang/CetakLaporan' view expects a variable named 'allantrian'
                    $datacetak = $this->load->view('Padalarang/CetakAntrian', ['allantrian' => $data['Padalarang_pendaftaran']->result()], TRUE);
                    
                    $mpdf->WriteHTML($datacetak);
                    $mpdf->Output();
                } 
                public function mpdfPegawai(){
                    $mpdf = new \Mpdf\Mpdf();
                    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
                    $data['Padalarang_pegawai'] = $this->PegawaiModel->getPegawai();
                    
                    $datapegawai = $this->load->view('Padalarang/CetakPegawai', ['allpegawai' => $data['Padalarang_pegawai']->result()], TRUE);
                    
                    $mpdf->WriteHTML($datapegawai);
                    $mpdf->Output();
                }                    
            }
            