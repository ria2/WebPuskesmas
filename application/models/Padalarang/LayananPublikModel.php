
            <?php

            class LayananPublikModel extends CI_Model
            {
                public function getLayananPublik()
                {
                    return $this->db->get('Padalarang_layananpublik');
                }
                public function getLayanan()
                {
                    return $this->db->get('Padalarang_layanan');
                }
                public function getLayananPublikById($id)
                {
                    $this->db->where("id_layananpublik",$id);
                    return $this->db->get('Padalarang_layananpublik');
                }
                public function getLayananById($id)
                {
                    $this->db->where("id_layanan",$id);
                    return $this->db->get('Padalarang_layanan');
                }
                public function insertLayananPublik($Padalarang_layananpublik)
                {
                    return $this->db->insert('Padalarang_layananpublik', $Padalarang_layananpublik);
                }
                public function prosesTambahLayananPublik(){
                    $produk = $this->input->post("produk");
                    $biaya = $this->input->post('biaya');
                    
                    $Padalarang_layananpublik = array(
                        "produk" => $produk,
                        "biaya" => $biaya,
                       
                    );

                    if ($this->LayananPublikModel->insertLayananPublik($Padalarang_layananpublik)) {
                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Layanan berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        redirect(site_url("Padalarang/Padalarang_admin/LayananPublik"));
                    } else {
                        $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Layanan gagal ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        redirect(site_url("Padalarang/Padalarang_admin/TambahLayananPublik"));
                    }
                }
                
                public function prosesUpdateLayananPublik($id) {
                    $produk = $this->input->post("produk");
                    $biaya = $this->input->post('biaya');
                   
                  
                    
                    $Padalarang_layananpublik = array(
                        "produk" => $produk,
                        
                        "biaya" => $biaya,
   
                    );
                    
                    $this->db->where("id_layananpublik", $id);
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Layanan berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->update("Padalarang_layananpublik", $Padalarang_layananpublik);
                }  
                function prosesUpdateLayanan($id){
                    $fasilitas = $this->input->post("fasilitas");
                    $sarana = $this->input->post("sarana");
                    $mekanisme = $this->input->post('mekanisme');
                  
                    
                    $Padalarang_layanan = array(
                        "fasilitas" => $fasilitas,
                        "sarana" => $sarana,
                        "mekanisme" => $mekanisme,
                        
                    );
                    
                    $existing_layanan = $this->db->get_where("Padalarang_layanan", array("id_layanan" => $id))->row();
                    
                    // Check if a new image is uploaded for konpensasi
                    if ($_FILES['konpensasi']['error'] !== UPLOAD_ERR_NO_FILE) {
                        $config['upload_path'] = './asset/Padalarang';
                        $config['allowed_types'] = 'gif|jpg|png';
                        
                        $this->load->library('upload', $config);
                        
                        if (!$this->upload->do_upload('konpensasi')) {
                            $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $upload_data = $this->upload->data();
                            $Padalarang_layanan['konpensasi'] = base_url("asset/Padalarang/") . $upload_data['file_name'];
                            
                            // Delete the old image if it exists
                            if (!empty($existing_layanan->konpensasi)) {
                                unlink($existing_layanan->konpensasi); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded for konpensasi, retain the existing image
                        $Padalarang_layanan['konpensasi'] = $existing_layanan->konpensasi;
                    }
                    
                    // Check if a new image is uploaded for spm
                    if ($_FILES['spm']['error'] !== UPLOAD_ERR_NO_FILE) {
                        $config['upload_path'] = './asset/Padalarang';
                        $config['allowed_types'] = 'gif|jpg|png';
                        
                        $this->load->library('upload', $config);
                        
                        if (!$this->upload->do_upload('spm')) {
                            $error = $this->upload->display_errors();
                            $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $upload_data = $this->upload->data();
                            $Padalarang_layanan['spm'] = base_url("asset/Padalarang/") . $upload_data['file_name'];
                            
                            // Delete the old image if it exists
                            if (!empty($existing_layanan->spm)) {
                                unlink($existing_layanan->spm); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded for spm, retain the existing image
                        $Padalarang_layanan['spm'] = $existing_layanan->spm;
                    }
                    $this->db->where("id_layanan", $id);
                    $this->session->set_flashdata("success_edit", "<div class='alert alert-success' role='alert'>Layanan berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->update("Padalarang_layanan", $Padalarang_layanan);
                }                        
                
                function deleteLayananPublik($id) {
                    $this->db->where("id_layananpublik", $id);
                    $Padalarang_layananpublik = $this->db->get_where("Padalarang_layananpublik", array("id_layananpublik" => $id))->row();
                
                    if ($Padalarang_layananpublik) {
                       
                
                        
                
                            $this->db->where("id_layananpublik", $id);
                            $this->db->delete("Padalarang_layananpublik");
                
                            $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Layanan berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        
                    } else {
                        $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Layanan tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    }
                
                   
                }
                
            }
            ?>
            
            
            