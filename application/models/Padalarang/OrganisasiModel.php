
            <?php

            class OrganisasiModel extends CI_Model
            {
                public function getOrganisasi()
                {
                    return $this->db->get('Padalarang_organisasi');
                }
                public function getOrganisasiById($id)
                {
                    $this->db->where("id_organisasi",$id);
                    return $this->db->get('Padalarang_organisasi');
                }
                public function prosesUpdateOrganisasi($id) {
                    $keterangan = $this->input->post("keterangan");
                    
                    
                    $Padalarang_organisasi = array(
                        "keterangan" => $keterangan,
                        "date_create" => date('Y-m-d H:i:s', Time()),
                    );
                
                    $existing_organisasi = $this->db->get_where("Padalarang_organisasi", array("id_organisasi" => $id))->row();
                    
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
                            $Padalarang_organisasi['gambar'] = base_url("asset/Padalarang/") . $upload_data['file_name'];
                
                            // Delete the old image if it exists
                            if (!empty($existing_organisasi->gambar)) {
                                unlink($existing_organisasi->gambar); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded, retain the existing image
                        $Padalarang_organisasi['gambar'] = $existing_organisasi->gambar;
                    }
                
                    $this->db->where("id_organisasi", $id);
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Organisasi berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->update("Padalarang_organisasi", $Padalarang_organisasi);
                }
                 
            }
            ?>
            
            