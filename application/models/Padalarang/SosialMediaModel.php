

            <?php

            class SosialMediaModel extends CI_Model
            {
                public function getSosialMedia()
                {
                    return $this->db->get('Padalarang_sosialmedia');
                }
                //Tamabahan
                public function getSosialMediaById($id)
                {
                    $this->db->where("id_sosialmedia",$id);
                    return $this->db->get('Padalarang_sosialmedia');
                }
                function prosesUpdate($id){
                    $Padalarang_sosialmedia = array(
                        "instagram" => $this->input->post("instagram"),
                        "facebook" => $this->input->post("facebook"),
                        "twiter" => $this->input->post("twiter"),
                        "email" => $this->input->post("email"),
                        "no_hp" => $this->input->post("no_hp"),
                        "kode_pos" => $this->input->post("kode_pos"),
                        
                        
                        );
                        $this->db->where("id_sosialmedia",$id);
                        $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Sosial Media berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        return $this->db->update("Padalarang_sosialmedia",$Padalarang_sosialmedia);
                }
                    
            }
            
         ?>
            
            