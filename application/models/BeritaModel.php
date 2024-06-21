<?php

            class BeritaModel extends CI_Model
            {
                public function getBerita()
                {
                    return $this->db->get('berita');
                }
                public function getBeritaById($id)
                {
                    $this->db->where("id_berita",$id);
                    return $this->db->get('berita');
                }
                function totalData() {
                    return $this->db->count_all('berita');
                }
                public function prosesTambahBerita(){
                    $judul = $this->input->post("judul");
                    $deskripsi = $this->input->post("deskripsi");
                    $penulis = $this->input->post('penulis');
                    $sumber = $this->input->post('sumber');
                    
                    $berita = array(
                        "judul" => $judul,
                        "deskripsi" => $deskripsi,
                        "penulis" => $penulis,
                        "sumber" => $sumber,
                        "date_create" => date('Y-m-d H:i:s', Time()),
                    );
                    $config['upload_path'] = './asset/img';
                    $config['allowed_types'] = 'gif|jpg|png';

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('gambar')) {
                        $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $upload_data = $this->upload->data();
                        $berita['gambar'] = base_url("asset/img/") . $upload_data['file_name'];
                    }

                    $this->db->where("id_berita");
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berita $judul berhasil di buat !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->insert("berita",$berita);
                }
                public function prosesUpdateBerita($id) {
                    $judul = $this->input->post("judul");
                    $deskripsi = $this->input->post("deskripsi");
                    $penulis = $this->input->post('penulis');
                    $sumber = $this->input->post('sumber');
                    
                    $berita = array(
                        "judul" => $judul,
                        "deskripsi" => $deskripsi,
                        "penulis" => $penulis,
                        "sumber" => $sumber,
                        "date_create" => date('Y-m-d H:i:s', Time()),
                    );
                
                    $existing_berita = $this->db->get_where("berita", array("id_berita" => $id))->row();
                    
                    // Check if a new image is uploaded
                    if ($_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
                        $config['upload_path'] = './asset/img';
                        $config['allowed_types'] = 'gif|jpg|png';
                
                        $this->load->library('upload', $config);
                
                        if (!$this->upload->do_upload('gambar')) {
                            $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $upload_data = $this->upload->data();
                            $berita['gambar'] = base_url("asset/img/") . $upload_data['file_name'];
                
                            // Delete the old image if it exists
                            if (!empty($existing_berita->gambar)) {
                                unlink($existing_berita->gambar); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded, retain the existing image
                        $berita['gambar'] = $existing_berita->gambar;
                    }
                
                    $this->db->where("id_berita", $id);
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berita $judul berhasil di update !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->update("berita", $berita);
                }

                function deleteBerita($id) {
                    $this->db->where("id_berita", $id);
                    $berita = $this->db->get_where("berita", array("id_berita" => $id))->row();

                    if ($berita) {
                        $photoPath = str_replace(base_url(), FCPATH, $berita->gambar); // Convert URL to server path

                        if (file_exists($photoPath)) {
                            unlink($photoPath);
                        }

                        $this->db->where("id_berita", $id);
                        $this->db->delete("berita");

                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berita berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    } else {
                        $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Berita tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    }

                    
                }

                
            }
            ?>
            