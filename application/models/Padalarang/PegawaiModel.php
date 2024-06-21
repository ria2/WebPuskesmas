<?php

            class PegawaiModel extends CI_Model
            {
                public function getPegawai()
                {
                    return $this->db->get('Padalarang_pegawai');
                }
                public function getPegawaiById($id)
                {
                    $this->db->where("id_pegawai",$id);
                    return $this->db->get('Padalarang_pegawai');
                }
                public function insertPegawai($Padalarang_pegawai)
                {
                    return $this->db->insert('Padalarang_pegawai', $Padalarang_pegawai);
                }
                public function checkEmailExists($email) {
                    $this->db->where('email', $email);
                    $query = $this->db->get('Padalarang_pegawai'); // Ganti 'users' dengan nama tabel yang sesuai
                    return $query->num_rows() > 0;
                }
                public function prosesTambahPegawai(){
                        $nama = $this->input->post("nama");
                        $nik_pegawai = $this->input->post("nik_pegawai");
                        $no_hp = $this->input->post("no_hp");
                        $jenis_kelamin = $this->input->post("jenis_kelamin");
                        $tempatlahir = $this->input->post("tempatlahir");
                        $tgl_lahir = $this->input->post("tgl_lahir");
                        $alamat = $this->input->post("alamat");
                        $agama = $this->input->post("agama");
                        $pendidikan = $this->input->post("pendidikan");
                        $perkawinan = $this->input->post("perkawinan");
                        $status = $this->input->post("status");
                        $jabatan = $this->input->post("jabatan");
                        $jammasuk = $this->input->post("jammasuk");
                        $jamkeluar = $this->input->post("jamkeluar");
                       
                       

                        $Padalarang_pegawai = array(
                            "nama" => $nama,
                            "nik_pegawai" => $nik_pegawai,
                            "no_hp" => $no_hp,
                            "jenis_kelamin" => $jenis_kelamin,
                            "tempatlahir" => $tempatlahir,
                            "tgl_lahir" => $tgl_lahir,
                            "alamat" => $alamat,
                            "agama" => $agama,
                            "pendidikan" => $pendidikan,
                            "perkawinan" => $perkawinan,
                            "status" => $status,
                            "jabatan" => $jabatan,
                            "jammasuk" => $jammasuk,
                            "jamkeluar" => $jamkeluar,
                            
                        );
                        $config['upload_path'] = './asset/Padalarang';
                        $config['allowed_types'] = 'gif|jpg|png';

                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('foto')) {
                            $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $upload_data = $this->upload->data();
                            $Padalarang_pegawai['foto'] = base_url("asset/Padalarang/") . $upload_data['file_name'];
                        }

                        if ($this->PegawaiModel->insertPegawai($Padalarang_pegawai)) {
                            $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Pegawai berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                            redirect(site_url("Padalarang/Padalarang_admin/DataPegawai"));
                        } else {
                            $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Pegawai gagal ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                            redirect(site_url("Padalarang/Padalarang_admin/TambahAdmin"));
                        }
                }
                public function prosesUpdatePegawai($id) {
                    $nama = $this->input->post("nama");
                    $nik_pegawai = $this->input->post("nik_pegawai");
                    $no_hp = $this->input->post("no_hp");
                    $jenis_kelamin = $this->input->post("jenis_kelamin");
                    $tempatlahir = $this->input->post("tempatlahir");
                    $tgl_lahir = $this->input->post("tgl_lahir");
                    $alamat = $this->input->post("alamat");
                    $agama = $this->input->post("agama");
                    $pendidikan = $this->input->post("pendidikan");
                    $perkawinan = $this->input->post("perkawinan");
                    $status = $this->input->post("status");
                    $jabatan = $this->input->post("jabatan");   
                  
                    $Padalarang_pegawai = array(
                        "nama" => $nama,
                        "nik_pegawai" => $nik_pegawai,
                        "no_hp" => $no_hp,
                        "jenis_kelamin" => $jenis_kelamin,
                        "tempatlahir" => $tempatlahir,
                        "tgl_lahir" => $tgl_lahir,
                        "alamat" => $alamat,
                        "agama" => $agama,
                        "pendidikan" => $pendidikan,
                        "perkawinan" => $perkawinan,
                        "status" => $status,
                        "jabatan" => $jabatan,
                    );
                    $existing_pegawai = $this->db->get_where("Padalarang_pegawai", array("id_pegawai" => $id))->row();
                
                // Check if a new image is uploaded
                if ($_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $config['upload_path'] = './asset/Padalarang';
                    $config['allowed_types'] = 'gif|jpg|png';
            
                    $this->load->library('upload', $config);
            
                    if (!$this->upload->do_upload('foto')) {
                        $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $upload_data = $this->upload->data();
                        $Padalarang_pegawai['foto'] = base_url("asset/Padalarang/") . $upload_data['file_name'];
            
                        // Delete the old image if it exists
                        if (!empty($existing_pegawai->foto)) {
                            unlink($existing_pegawai->foto); // Remove the old file
                        }
                    }
                } else {
                    // No new image uploaded, retain the existing image
                    $Padalarang_pegawai['foto'] = $existing_pegawai->foto;
                }

                    $this->db->where("id_pegawai",$id);
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Pegawai berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->update("Padalarang_pegawai",$Padalarang_pegawai);
            }
            public function prosesUpdateJadwal($id) {
                $jammasuk = $this->input->post("jammasuk");
                $jamkeluar = $this->input->post("jamkeluar");    
            
                $Padalarang_jadwal = array(
                    "jammasuk" => $jammasuk,
                    "jamkeluar" => $jamkeluar,
                );
            
                // Update the database
                $this->db->where("id_pegawai", $id);
                $update_result = $this->db->update("Padalarang_pegawai", $Padalarang_jadwal);
            
                if ($update_result) {
                    // Update successful, set flash message
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Jadwal berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                } else {
                    // Update failed, set flash message for failure
                    $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gagal mengupdate Jadwal!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                }
            
                // Return the result of the update operation
                return $update_result;
            }            
            function deletePegawai($id){
                $this->db->where("id_pegawai", $id);
                $Padalarang_pegawai = $this->db->get_where("Padalarang_pegawai", array("id_pegawai" => $id))->row();

                if ($Padalarang_pegawai) {
                    $photoPath = str_replace(base_url(), FCPATH, $Padalarang_pegawai->foto); // Convert URL to server path

                    if (file_exists($photoPath)) {
                        unlink($photoPath);
                    }

                    $this->db->where("id_pegawai", $id);
                    $this->db->delete("Padalarang_pegawai");

                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Pegawai berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                } else {
                    $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Pegawai tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                }
            }
            }
            ?>
            