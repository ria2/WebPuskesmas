
            <?php

            class SejarahModel extends CI_Model
            {
                public function getSejarah()
                {
                    return $this->db->get('Padalarang_sejarah');
                }
                //Tamabahan
                public function getSejarahById($id)
                {
                    $this->db->where("id_sejarah",$id);
                    return $this->db->get('Padalarang_sejarah');
                }
                function prosesUpdate($id) {
                    $Padalarang_sejarah = array(
                        "sejarah" => $this->input->post("sejarah"),
                        "alamat" => $this->input->post("alamat"),
                    );
                
                    // Retrieve the existing data
                    $existing_sejarah = $this->db->get_where("Padalarang_sejarah", array("id_sejarah" => $id))->row();
                
                    // Check if a new image is uploaded
                    if ($_FILES['maklumat']['error'] !== UPLOAD_ERR_NO_FILE) {
                        $config['upload_path'] = './asset/Padalarang';
                        $config['allowed_types'] = 'gif|jpg|png';
                
                        $this->load->library('upload', $config);
                
                        if (!$this->upload->do_upload('maklumat')) {
                            $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Gunakan format gambar yang sesuai (.gif/.jpg/.png) !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $upload_data = $this->upload->data();
                            $Padalarang_sejarah['maklumat'] = base_url("asset/Padalarang/") . $upload_data['file_name'];
                
                            // Delete the old image if it exists
                            if (!empty($existing_sejarah->maklumat)) {
                                unlink($existing_sejarah->maklumat); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded, retain the existing image
                        $Padalarang_sejarah['maklumat'] = $existing_sejarah->maklumat;
                    }
                
                    // Retain the existing alamat_map
                    $Padalarang_sejarah['alamat_map'] = $existing_sejarah->alamat_map;
                
                    // Update the database with new values
                    $this->db->where("id_sejarah", $id);
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->update("Padalarang_sejarah", $Padalarang_sejarah);
                }
                
                    
            }
            
        ?>

            