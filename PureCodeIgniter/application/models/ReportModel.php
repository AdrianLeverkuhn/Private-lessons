<!--
me130040
-->
<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class ReportModel extends CI_Model{
    public function __construct(){
        $this->load->database();
    }
    //TODO: ucitavanje datuma ne radi, ispisuje 0000:00:00
    //void: creates a report with passed data
    /*
     * $data = array(
     *      'idPosiljalac' => $idOnogKoSalje, 
     *      'idPrimalac' => $idOnogKoBivaPrijavljen, 
     *      'text' => "Ovo je lazan profil"
     * );
     */
    public function createReport($data){
        $data['datum'] = (string)date('Y-m-d H:i:s');
        $this->db->insert('Prijava', $data);
    }
    
    //string: returns text of particular report
    public function getReportText($idReport){
        $query = $this->db->get_where('Prijava', array('idPrijava' => $idReport), 1);
        foreach ($query->result() as $row)
        {
            return $row->text;
        }
    }
    
    //array: reutrns all of reports
    /*
     * foreach (getReports() as $row)
        {
            echo $row['idPrijava'];
            echo $row['idPosiljalac'];
            echo $row['idPrimalac'];
            echo $row['idAdmin'];
            echo $row['text'];
            echo $row['datum'];
        }
     */
    public function getReports(){
        $query = $this->db->get('Prijava');
        return $query->result_array();
    }
    
    //bool: returns if the report has been read
    public function isMarkedReport($idReport){
        $query = $this->db->get_where('Prijava', array('idPrijava' => $idReport), 1);
        foreach ($query->result() as $row)
        {
            return $row->idAdmin != NULL;
        }
    }
    
    //void: marks the report that it has been read by admin
    public function setMarkReport($idReport, $idAdmin){
        $this->db->set('idAdmin', "$idAdmin", FALSE);
        $this->db->where("idPrijava", $idReport);
        $this->db->update('Prijava');
    }
}