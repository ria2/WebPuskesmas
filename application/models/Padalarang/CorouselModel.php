<?php

            class CorouselModel extends CI_Model
            {
                public function getCorousel()
                {
                    return $this->db->get('Padalarang_corousel');
                }
                public function getCorouselById($id)
                {
                    $this->db->where("id_corousel",$id);
                    return $this->db->get('Padalarang_corousel');
                }
                public function prosesTambahCorousel(){
                    $judul = $this->input->post("judul");
                    $keterangan = $this->input->post("keterangan");
                   
                    
                    $Padalarang_corousel = array(
                        "judul" => $judul,
                        "keterangan" => $keterangan,
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
                        $Padalarang_corousel['gambar'] = base_url("asset/Padalarang/") . $upload_data['file_name'];
                    }

                    $this->db->where("id_corousel");
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Slide show berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->insert("Padalarang_corousel",$Padalarang_corousel);
                }
                public function prosesUpdateCorousel($id) {
                    $judul = $this->input->post("judul");
                    $keterangan = $this->input->post("keterangan");
                    
                    
                    $Padalarang_corousel = array(
                        "judul" => $judul,
                        "keterangan" => $keterangan,
                        
                        "date_create" => date('Y-m-d H:i:s', Time()),
                    );
                
                    $existing_corousel = $this->db->get_where("Padalarang_corousel", array("id_corousel" => $id))->row();
                    
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
                            $Padalarang_corousel['gambar'] = base_url("asset/Padalarang/") . $upload_data['file_name'];
                
                            // Delete the old image if it exists
                            if (!empty($existing_corousel->gambar)) {
                                unlink($existing_corousel->gambar); // Remove the old file
                            }
                        }
                    } else {
                        // No new image uploaded, retain the existing image
                        $Padalarang_corousel['gambar'] = $existing_corousel->gambar;
                    }
                
                    $this->db->where("id_corousel", $id);
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Slide show berhasil diupdate !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->update("Padalarang_corousel", $Padalarang_corousel);
                }
                function deleteCorousel($id){
                    $this->db->where("id_corousel", $id);
                    $Padalarang_corousel = $this->db->get_where("Padalarang_corousel", array("id_corousel" => $id))->row();

                    if ($Padalarang_corousel) {
                        $photoPath = str_replace(base_url(), FCPATH, $Padalarang_corousel->gambar); // Convert URL to server path

                        if (file_exists($photoPath)) {
                            unlink($photoPath);
                        }

                        $this->db->where("id_corousel", $id);
                        $this->db->delete("Padalarang_corousel");

                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Slide show berhasil dihapus !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    } else {
                        $this->session->set_flashdata("error", "<div class='alert alert-danger' role='alert'>Slide show tidak ditemukan!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    }
                }
                
            }
            ?>
            