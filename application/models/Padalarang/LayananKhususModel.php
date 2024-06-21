
            <?php

            class LayananKhususModel extends CI_Model
            {
                public function getLayananKhusus()
                {
                    return $this->db->get('Padalarang_layanankhusus');
                }
                public function getLayananKhususById($id)
                {
                    $this->db->where("id_layanankhusus",$id);
                    return $this->db->get('Padalarang_layanankhusus');
                }
                public function prosesTambahLayananKhusus(){
                    $visi = $this->input->post("visi");
                    $misi = $this->input->post("misi");
                    $atribut = $this->input->post('atribut');
                    $layananterpadu = $this->input->post('layananterpadu');
                    
                    
                    $Padalarang_layanankhusus = array(
                        "visi" => $visi,
                        "misi" => $misi,
                        "atribut" => $atribut,
                        "layananterpadu" => $layananterpadu,

                    );
                    

                    $this->db->where("id_layanankhusus");
                    return $this->db->insert("Padalarang_layanankhusus",$Padalarang_layanankhusus);
                }
                public function prosesUpdateLayananKhusus($id) {
                    $visi = $this->input->post("visi");
                    $misi = $this->input->post("misi");
                    $atribut = $this->input->post('atribut');
                    $layananterpadu = $this->input->post('layananterpadu');
                    
                    
                    $Padalarang_layanankhusus = array(
                        "visi" => $visi,
                        "misi" => $misi,
                        "atribut" => $atribut,
                        "layananterpadu" => $layananterpadu,
                        
                    );
                
                    $this->db->where("id_layanankhusus", $id);
                    $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Layanan Khusus berhasil ditambahkan !<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    return $this->db->update("Padalarang_layanankhusus", $Padalarang_layanankhusus);
                }
                
                
            }
            ?>
            
            
            