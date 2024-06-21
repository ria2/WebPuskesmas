<?php

class WebModel extends CI_Model
{
    //Kelola web
    public function getWeb()
    {
        return $this->db->get('webpuskesmas');
    }
    function totalData() {
        return $this->db->count_all('webpuskesmas');
    }    
    function getWebById($id){
        $this->db->where("kode_puskesmas",$id);
        return $this->db->get('webpuskesmas');
    }
    // function getWebByLokasi($lokasi){
    //     $this->db->where("lokasi",$lokasi);
    //     return $this->db->get('webpuskesmas');
    // }
    public function insertWeb($lokasi) {
        $this->db->insert('webpuskesmas', $lokasi); 
    }
    public function isLokasiExist($lokasi)
    {
        $this->db->where('lokasi', $lokasi);
        $query = $this->db->get('webpuskesmas'); 

        return $query->num_rows() > 0;
    }
    public function isKodePuskesmasExist($kode_puskesmas)
    {
        $this->db->where('kode_puskesmas', $kode_puskesmas);
        $query = $this->db->get('webpuskesmas'); 

        return $query->num_rows() > 0;
    }
    public function updateWeb($id, $data) {
        $this->db->where('kode_puskesmas', $id);
        $this->db->update('webpuskesmas', $data);
    }
  
    public function getWebData($id) {
        return $this->db->get_where('webpuskesmas', array('kode_puskesmas' => $id))->row();
    }
    public function deleteWeb($id) {
        $this->db->where('kode_puskesmas', $id);
        $this->db->delete('webpuskesmas');
    }
      //Kelola admin puskesmas
    public function getWebadmin($kode_puskesmas)
    {
        $this->db->where('kode_puskesmas', $kode_puskesmas);
        return $this->db->get('webpuskesmas')->row();
    }
    public function getAdminpus($kode_puskesmas)
    {
        $web = $this->getWebadmin($kode_puskesmas);
        if ($web) {
            $table_name = strtolower($web->lokasi) . '_login'; 
            return $this->db->get($table_name)->result();
        }
       
        return null; 
    }
    public function getAdminpusByid($id_login,$kode_puskesmas)
    {
        $web = $this->getWebadmin($kode_puskesmas);
        if ($web) {
            $table_name = strtolower($web->lokasi) . '_login';
            $this->db->where('id_login', $id_login);
            return $this->db->get($table_name);
        }
       
        return null; 
    }
    public function checkUsernameExists($table_name, $username, $kode_puskesmas) {
        $this->db->where('username', $username);
        $query = $this->db->get($table_name);
        return $query->num_rows() > 0;
    }
    public function checkEmailExists($table_name, $email, $kode_puskesmas) {
        $this->db->where('email', $email);
        $query = $this->db->get($table_name);
        return $query->num_rows() > 0;
    }
    public function tambahAdmin($table_name, $data)
    {
        return $this->db->insert($table_name, $data);
    }
    public function hapusAdmin($table_name, $id_login) {
        $this->db->where('id_login', $id_login);
        return $this->db->delete($table_name);
    }
    public function updateAdmin($table_name, $id_admin, $data) {
        $this->db->where('id_login', $id_admin);
        return $this->db->update($table_name, $data);
    }
    
}
?>