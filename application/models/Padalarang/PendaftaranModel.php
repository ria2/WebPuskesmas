

            <?php
            class PendaftaranModel extends CI_Model
            {
                public function getPendaftaran($tanggalawal = null, $tanggalakhir = null)
                {
                    if ($tanggalawal && $tanggalakhir) {
                        $tanggalawalbaru = strtotime($tanggalawal);
                        $tanggalakhirbaru = strtotime($tanggalakhir);

                        $this->db->where('tanggal >=', date('Y-m-d', $tanggalawalbaru));
                        $this->db->where('tanggal <=', date('Y-m-d', $tanggalakhirbaru));
                    }

                    return $this->db->get('Padalarang_pendaftaran');
                }

                public function totalData()
                {
                    return $this->db->count_all('Padalarang_pendaftaran');
                }

                public function deletePendaftaran($id)
                {
                    $this->db->where("id_pendaftaran", $id);
                    $Padalarang_pendaftaran = $this->db->get_where("Padalarang_pendaftaran", array("id_pendaftaran" => $id))->row();

                    if ($Padalarang_pendaftaran) {
                        $photoPath = str_replace(base_url(), FCPATH, $Padalarang_pendaftaran->qr_code); // Convert URL to server path

                        if (file_exists($photoPath)) {
                            unlink($photoPath);
                        }

                        $this->db->where("id_pendaftaran", $id);
                        $this->db->delete("Padalarang_pendaftaran");

                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Pendaftaran berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    } else {
                        $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Pendaftaran tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    }
                }

                public function getPendaftaranById($id)
                {
                    $this->db->where("id_pendaftaran", $id);
                    return $this->db->get('Padalarang_pendaftaran');
                }
                public function getAntrian()
                {
                    return $this->db->get('Padalarang_antrian');
                }
                public function getAntrianById($id)
                {
                    $this->db->where("id", $id);
                    return $this->db->get('Padalarang_antrian');
                }
                public function UpdateAntrian($id) {
                    $max_nomber = $this->input->post("max_nomber");
                    $antrian = array(
                        "max_nomber" => $max_nomber,   
                    );
                    $this->db->where("id", $id);
                    $this->session->set_flashdata('success', "<div class='alert alert-success' role='alert'>Max Antrian di perbaharui!</div>");
                    return $this->db->update("Padalarang_antrian", $antrian);
                }

                public function Daftar()
                {
                    $this->load->library('ciqrcode');
                    $this->load->library('session');

                    if ($this->input->post()) {
                        $last_queue_number = $this->PendaftaranModel->get_last_queue_number(); // mengambil nomor antrian terakhir dari database
                        $antrian =  $this->PendaftaranModel->getAntrian()->row();
                        $max = $antrian->max_nomber;

                        
                            // cek jika hari sekarang berdbeda dari hari terakhir yang di rekam 
                            $last_recorded_date = $this->PendaftaranModel->get_last_recorded_date();
                            $current_date = date('Y-m-d');

                            if ($last_recorded_date != $current_date) {
                                $next_queue_number = 1; // mereset no antrian kembali ke 1 untuk hari baru 
                            } else {
                                $next_queue_number = $last_queue_number + 1;
                            
                        }

                        if ($next_queue_number <= $max) { // cek jika no antrian selanjutnya di set oleh admin sesuai dengan kebutuhan 
                            $data = array(
                                'nomor_pendaftaran' => $next_queue_number,
                                'nama' => $this->input->post('nama'),
                                'nik' => $this->input->post('nik'),
                                'tempat_lahir' => $this->input->post('tempat_lahir'),
                                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                                'jk' => $this->input->post('jk'),
                                'alamat' => $this->input->post('alamat'),
                                'pekerjaan' => $this->input->post('pekerjaan'),
                                'layanan' => $this->input->post('layanan'),
                                'tanggal' => date('Y-m-d H:i:s', time()),
                            );

                            $qr_code_path = $this->generate_qr_code($data);

                            if ($qr_code_path) {
                                $data['qr_code'] = $qr_code_path;
                                $id = $this->PendaftaranModel->save_data($data);
                                $this->session->set_flashdata('success', "<div class='alert alert-success' role='alert'>Daftar berhasil!</div>");
                                redirect(site_url("Padalarang/Padalarang/Tiket/" . $id));
                            } else {
                                $this->session->set_flashdata('error', 'Gagal melakukan pendaftaran.');
                            }
                        } else {
                            $this->session->set_flashdata('success', "<div class='alert alert-danger' role='alert'>Pendaftaran Penuh!</div>");
                        }

                        redirect('Padalarang/Padalarang/Pendaftaran');
                    }
                }

                public function get_last_recorded_date()
                {
                    $this->db->select_max('tanggal');
                    $query = $this->db->get('Padalarang_pendaftaran');
                    $result = $query->row_array();

                    return isset($result['tanggal']) ? date('Y-m-d', strtotime($result['tanggal'])) : null;
                }
                
                public function get_last_queue_number()
                {
                    date_default_timezone_set('Asia/Jakarta');
                    $current_date = date('Y-m-d');
                    
                    $this->db->select('nomor_pendaftaran');
                    $this->db->where('DATE(tanggal)', $current_date);
                    $this->db->order_by('nomor_pendaftaran', 'DESC');
                    $this->db->limit(1);
                    $query = $this->db->get('Padalarang_pendaftaran');

                    $result = $query->row_array();

                    if (empty($result)) {
                        return 0; // Reset ke 0 ketika tidak ada record yang ditemukan untuk tanggal sekarang
                    }

                    return isset($result['nomor_pendaftaran']) ? $result['nomor_pendaftaran'] : 0;
                }
                

                public function generate_qr_code($data)
                {
                    $this->load->library('ciqrcode');

                    $qr_code_data = "Nama: " . $data['nama'] . "
";
                    $qr_code_data .= "No Pendaftaran: " . $data['nomor_pendaftaran'] . "
";
                    $qr_code_data .= "Tanggal: " . $data['tanggal'] . "
";
                    $qr_code_data .= "Layanan: " . $data['layanan'] . "
";                  // Menambahkan informasi layanan
                    // Tambahkan informasi lain sesuai kebutuhan, dengan format yang sesuai

                    $qr_code_name = $data['nama'] . '_layanan_' . $data['layanan'] . '.png'; // Ubah format nama file

                    $config['cacheable'] = true;
                    $config['cachedir'] = './asset/image/qrcodes/';
                    $config['errorlog'] = './asset/image/qrcodes/';
                    $config['quality'] = true;
                    $config['size'] = 1024;
                    $config['black'] = array(224, 255, 255);
                    $config['white'] = array(70, 130, 180);

                    $this->ciqrcode->initialize($config);

                    try {
                        $params['data'] = $qr_code_data;
                        $params['level'] = 'H';
                        $params['size'] = $config['size'];
                        $params['savename'] = $config['cachedir'] . $qr_code_name;
                        $this->ciqrcode->generate($params);
                    } catch (Exception $e) {
                        return false;
                    }

                    $qr_code_path = base_url() . 'asset/image/qrcodes/' . $qr_code_name;
                    return $qr_code_path;
                }

                public function save_data($data)
                {
                    $this->db->insert('Padalarang_pendaftaran', $data);
                    return $this->db->insert_id(); // Mengembalikan ID yang baru saja dibuat
                }
                public function sisa(){
                    $last_queue_number = $this->PendaftaranModel->get_last_queue_number();
                    $antrian =  $this->PendaftaranModel->getAntrian()->row();
                    $max = $antrian->max_nomber;
                
                    $sisa_pendaftaran = $max - $last_queue_number;
                
                    return $sisa_pendaftaran;
                }
            }

            ?>
            
            