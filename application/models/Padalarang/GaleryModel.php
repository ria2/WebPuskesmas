
            
            <?php

            class GaleryModel extends CI_Model
            {
                public function getGalery()
                {
                    return $this->db->get('Padalarang_galery');
                }
                public function getGaleryById($id)
                {
                    $this->db->where("id_galery",$id);
                    return $this->db->get('Padalarang_galery');
                }
                public function prosesTambahGalery(){
                    $kegiatan = $this->input->post('kegiatan');
                    
                    $Padalarang_galery = array(
                        "kegiatan" => $kegiatan,
                        "date_create" => date('Y-m-d H:i:s', Time()),
                    );
                    $config['upload_path'] = './asset/Padalarang';
                    $config['allowed_types'] = 'gif|jpg|png';

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('gambar')) {
                        $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $upload_data = $this->upload->data();
                        $Padalarang_galery['gambar'] = base_url("asset/Padalarang/") . $upload_data['file_name'];
                    }

                    $this->db->where("id_galery");
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Galery berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->insert("Padalarang_galery",$Padalarang_galery);
                }
                public function prosesUpdateGalery($id) {
                    $kegiatan = $this->input->post('kegiatan');
                    
                    $Padalarang_galery = array(
                        "kegiatan" => $kegiatan,
                        "date_create" => date('Y-m-d H:i:s', Time()),
                    );
                
                    $existing_galery = $this->db->get_where("Padalarang_galery", array("id_galery" => $id))->row();
                    
                    // Check if a new image is uploaded
                    if ($_FILES['gambar']['error'] !== UPLOAD_ERR_NO_FILE) {
                        $config['upload_path'] = './asset/Padalarang';
                        $config['allowed_types'] = 'gif|jpg|png';
                
                        $this->load->library('upload', $config);
                
                        if (!$this->upload->do_upload('gambar')) {
                            $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $upload_data = $this->upload->data();
                            $Padalarang_galery['gambar'] = base_url("asset/Padalarang/") . $upload_data['file_name'];
                
                            // Delete the old image if it exists
                            if (!empty($existing_galery->gambar)) {
                                unlink($existing_galery->gambar); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded, retain the existing image
                        $Padalarang_galery['gambar'] = $existing_galery->gambar;
                    }
                
                    $this->db->where("id_galery", $id);
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Galery berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->update("Padalarang_galery", $Padalarang_galery);
                }
                function deleteGalery($id){
                    $this->db->where("id_galery", $id);
                    $Padalarang_galery = $this->db->get_where("Padalarang_galery", array("id_galery" => $id))->row();

                    if ($Padalarang_galery) {
                        $photoPath = str_replace(base_url(), FCPATH, $Padalarang_galery->gambar); // Convert URL to server path

                        if (file_exists($photoPath)) {
                            unlink($photoPath);
                        }

                        $this->db->where("id_galery", $id);
                        $this->db->delete("Padalarang_galery");

                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berita berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    } else {
                        $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Berita tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    }
                }
                
            }
            ?>
            
            