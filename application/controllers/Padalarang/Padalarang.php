
            
            <?php
            class Padalarang extends CI_Controller {
                public function __construct()
                {
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

                    $data['title'] = 'Halaman Awal';
                    $data['Padalarang_corousel'] = $this->CorouselModel->getCorousel();
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['berita'] = $this->BeritaModel->getBerita();
                    $data['Padalarang_galery'] = $this->GaleryModel->getGalery();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $data['Padalarang_pegawai'] = $this->PegawaiModel->getPegawai();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Dashboard',$data);
                    $this->load->view('Padalarang/Berita',$data);
                    $this->load->view('Padalarang/PegawaiAktif',$data);
                    $this->load->view('Padalarang/Galery',$data);
                    $this->load->view('Padalarang/Alamat',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Sejarah()
                {

                    $data['title'] = 'Halaman Sejarah';
                    
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Sejarah',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Visi()
                {

                    $data['title'] = 'Halaman Visi & Misi';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/VisiMisi',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Struktur()
                {

                    $data['title'] = 'Halaman Struktur Organisasi';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_organisasi'] = $this->OrganisasiModel->getOrganisasi();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Organisasi',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function DataPegawai()
                {

                    $data['title'] = 'Halaman Data Pegawai';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_pegawai'] = $this->PegawaiModel->getPegawai();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Pegawai',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Lokasi()
                {

                    $data['title'] = 'Halaman Lokasi & Kontak';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Lokasi',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Maklumat()
                {

                    $data['title'] = 'Halaman Maklumat';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Maklumat',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Agenda()
                {

                    $data['title'] = 'Halaman Agenda';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_galery'] = $this->GaleryModel->getGalery();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Agenda',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Artikel()
                {

                    $data['title'] = 'Halaman Artikel & Berita';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['berita'] = $this->BeritaModel->getBerita();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Artikel',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function ArtikelLengkap($id)
                {

                    $data['title'] = 'Halaman Artikel & Berita';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['berita'] = $this->BeritaModel->getBeritaById($id)->row();
                    $data['Padalarang_galery'] = $this->GaleryModel->getGalery();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $data['berita_data'] = $this->BeritaModel->getBerita();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/ArtikelLengkap',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Mekanisme()
                {

                    $data['title'] = 'Mekanisme Layanan Publik';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_layananpublik'] = $this->LayananPublikModel->getLayanan();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Mekanisme',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Sarana()
                {

                    $data['title'] = 'Mekanisme Layanan Publik';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_layananpublik'] = $this->LayananPublikModel->getLayanan();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Sarana',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Fasilitas()
                {

                    $data['title'] = 'Mekanisme Layanan Publik';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_layananpublik'] = $this->LayananPublikModel->getLayanan();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Fasilitas',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Tarif()
                {

                    $data['title'] = 'Mekanisme Layanan Publik';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_layananpublik'] = $this->LayananPublikModel->getLayananPublik();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Tarif',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Kompensasi()
                {

                    $data['title'] = 'Mekanisme Layanan Publik';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_layananpublik'] = $this->LayananPublikModel->getLayanan();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Kompensasi',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Standar()
                {

                    $data['title'] = 'Mekanisme Layanan Publik';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_layananpublik'] = $this->LayananPublikModel->getLayanan();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Standar',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function VisiPelayanan()
                {

                    $data['title'] = 'Visi & Misi Layanan Khusus';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_layanankhusus'] = $this->LayananKhususModel->getLayananKhusus();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/VisiPelayanan',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Atribut()
                {

                    $data['title'] = 'Visi & Misi Layanan Khusus';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_layanankhusus'] = $this->LayananKhususModel->getLayananKhusus();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Atribut',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Layanan()
                {

                    $data['title'] = 'Visi & Misi Layanan Khusus';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_layanankhusus'] = $this->LayananKhususModel->getLayananKhusus();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/LayananTerpadu',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function TataNilai()
                {

                    $data['title'] = 'Tata Nilai';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/TataNilai',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Pengaduan()
                {

                    $data['title'] = 'Pengaduan ';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $data['umpan_balik'] = $this->FeedModel->getFeed();
                    $data['captcha'] = $this->FeedModel->captcha();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/UmpanBalik',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function IsiPesan(){
                    if ($this->FeedModel->IsiPesan()) {
                        redirect(site_url("Padalarang/Padalarang/Pengaduan"));
                    } else {
                        redirect(site_url("Padalarang/Padalarang/Pengaduan"));
                    }
                }
                public function Kepuasan()
                {

                    $data['title'] = 'Kepuasan ';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['survey'] = $this->KepuasanModel->get_survey_results();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Kepuasan',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function submit_penilaian($type) {
                    $alasan_type = $this->input->post('alasan_type');
                    $alasan = $this->input->post('alasan_' . $alasan_type);
                    $this->KepuasanModel->submit_survey($type, $alasan);
                    redirect('Padalarang/Padalarang/Kepuasan');
                }
                public function Pendaftaran()
                {

                    $data['title'] = 'Pendaftaran ';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $data['Padalarang_layananpublik'] = $this->LayananPublikModel->getLayananPublik();
                    $data['antrian'] = $this->PendaftaranModel->get_last_queue_number();
                    $data['sisa'] = $this->PendaftaranModel->sisa();
                    $this->load->view('Padalarang/Navbar',$data);
                    $this->load->view('Padalarang/Pendaftaran',$data);
                    $this->load->view('Padalarang/Footer',$data);
                }
                public function Daftar(){
                    $id = $this->PendaftaranModel->Daftar(); // Menyimpan ID pendaftaran yang baru saja dibuat
                
                    if ($id) {
                        redirect(site_url("Padalarang/Padalarang/Tiket/" . $id));
                    } else {
                        redirect(site_url("Padalarang/Padalarang/Pendaftaran"));
                    }
                }                
                public function Tiket($id)
                {
                    $data['title'] = 'Tiket';
                    $data['Padalarang_sosialmedia'] = $this->SosialMediaModel->getSosialMedia();
                    $data['Padalarang_sejarah'] = $this->SejarahModel->getSejarah();
                    $data['Padalarang_pendaftaran'] = $this->PendaftaranModel->getPendaftaranById($id)->row(); // Perubahan di sini
                    $data['Padalarang_visi_misi'] = $this->VisiMisiModel->getVisiMisi();
                    $this->load->view('Padalarang/Navbar', $data);
                    $this->load->view('Padalarang/Tiket', $data);
                    $this->load->view('Padalarang/Footer', $data);
                }
                
            }
            
            