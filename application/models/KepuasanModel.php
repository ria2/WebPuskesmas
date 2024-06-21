<?php

class KepuasanModel extends CI_Model
{
    public function submit_survey($type, $reason) {
        //mengambil IP
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $user_ip = $_SERVER['REMOTE_ADDR'];
        }  
        $existing_entry = $this->db->get_where('survey_reasons', array('user_ip' => $user_ip))->row();
    
        if (!$existing_entry) {
            // IP address belum ada dalam tabel 'survey', maka dapat mengisi survei
            $this->db->set($type, "{$type} + 1", FALSE);
            $this->db->update('survey');
    
            $data = array(
                'type' => $type,
                'reason' => $reason,
                'user_ip' => $user_ip // Simpan IP address pengguna dalam tabel
            );
            $this->db->insert('survey_reasons', $data);
            $this->session->set_flashdata("success", "<div class='alert alert-success' role='alert'>Berhasil mengisi kepuasan sebelumnya !</div>");
            return true; 
        } else {
            $this->session->set_flashdata("success", "<div class='alert alert-danger' role='alert'>Anda sudah mengisi kepuasan sebelumnya !</div>");
            return false; // IP address sudah mengisi survei sebelumnya
        }
    }
    

    public function get_survey_results() {
        $query = $this->db->get('survey'); // Mengambil seluruh baris dari tabel 'survey'
        if ($query->num_rows() > 0) {
            return $query->row(); // Mengambil baris pertama hasil query
        } else {
            return false; // Tidak ada data yang ditemukan
        }
    }

    public function getSurveyReason(){
        return $this->db->get('survey_reasons');
    }
}
