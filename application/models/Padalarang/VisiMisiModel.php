<?php

            class VisiMisiModel extends CI_Model
            {
                public function getVisiMisi()
                {
                    return $this->db->get('Padalarang_visi_misi');
                }
                public function getVisiMisiById($id)
                {
                    $this->db->where("id_visi",$id);
                    return $this->db->get('Padalarang_visi_misi');
                }
                function prosesUpdate($id){
                    $Padalarang_visi_misi = array(
                        "visi" => $this->input->post("visi"),
                        "misi" => $this->input->post("misi"),
                        "motto" => $this->input->post("motto"),
                        "tatanilai" => $this->input->post("tatanilai"),
                        
                        
                        
                        );
                        $existing_logo = $this->db->get_where("Padalarang_visi_misi", array("id_visi" => $id))->row();
                    
                        // Check if a new image is uploaded
                        if ($_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
                            $config['upload_path'] = './asset/img';
                            $config['allowed_types'] = 'gif|jpg|png';
                    
                            $this->load->library('upload', $config);
                    
                            if (!$this->upload->do_upload('logo')) {
                                $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                                redirect($_SERVER['HTTP_REFERER']);
                            } else {
                                $upload_data = $this->upload->data();
                                $Padalarang_visi_misi['logo'] = base_url("asset/img/") . $upload_data['file_name'];
                    
                                // Delete the old image if it exists
                                if (!empty($existing_logo->logo)) {
                                    unlink($existing_logo->logo); // Remove the old file
                                }
                            }
                        } else {
                            // No new image uploaded, retain the existing image
                            $Padalarang_visi_misi['logo'] = $existing_logo->logo;
                        }
                    
                        $this->db->where("id_visi",$id);
                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Visi & Misi berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        return $this->db->update("Padalarang_visi_misi",$Padalarang_visi_misi);
                    }
            }
            ?>
            