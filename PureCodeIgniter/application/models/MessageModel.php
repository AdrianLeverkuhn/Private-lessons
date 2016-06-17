<!--
me130040
-->
<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MessageModel extends CI_Model{
    public function __construct(){
        $this->load->database();
    }
    
    //void: creates and sends a message
    /*
     * $data = array(
     *      'idPosiljalac' => $idOnogKoSalje, 
     *      'subjekat' => "Danas je bio lep dan",
     *      'text' => "Ovde ide telo. Shh, ubili smo nekoga, ovde ga krijemo ;)"
     *      'primaoci' => array($idPrvoPrimaoca, $idDrugogPrimaoca, ...)
     * );
     */
    public function createMessage($data){
        $data['datum'] = (string)date('Y-m-d H:i:s');
        $primaoci = $data['primaoci'];
        unset($data['primaoci']);
        $this->db->insert('Poruka', $data);
        $this->db->select_max('idPoruka');
        $query = $this->db->get('Poruka');
        $id = -1;
        foreach ($query->result() as $row)
        {
            $id = $row->idPoruka;
        }
        foreach($primaoci as $primalac){
            $data = array(
                'idPoruka' => $id,
                'idKorisnik' => $primalac
            );
            $this->db->insert('Primanje', $data);
        }
    }
    
    //array: reutrns all of messages in uses inbox
    /*
     * foreach (getMessages($id) as $row)
        {
            echo $row['procitana'];
            echo $row['idPosiljalac'];
            echo $row['idKorisnik'];//primalac
            echo $row['subjekat'];
            echo $row['text'];
            echo $row['datum'];
     *      echo $row['idPoruka'];
        }
     */
    public function getMessages($idUser){
        $this->db->select('*');
        $this->db->from('Primanje');
        $this->db->join('Poruka', 'Poruka.idPoruka = Primanje.idPoruka');
        $this->db->where('idKorisnik', $idUser);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //string: returns the subject of message $idMessage
    public function getMessageSubject($idMessage){
        $query = $this->db->get_where('Poruka', array('idPoruka' => $idMessage), 1);
        foreach ($query->result() as $row)
        {
            return $row->subjekat;
        }
    }
    
    //string: returns the body of message $idMessage
    public function getMessageText($idMessage){
        $query = $this->db->get_where('Poruka', array('idPoruka' => $idMessage), 1);
        foreach ($query->result() as $row)
        {
            return $row->text;
        }
    }
    
    //bool: returns if a message has been read by user
    public function isMessageRead($idUser, $idMessage){
        $query = $this->db->get_where('Primanje', array('idKorisnik' => $idUser, 'idPoruka' => $idMessage), 1);
        foreach ($query->result() as $row)
        {
            return $row->procitana;
        }
    }
    
    //void: set that the message has been read
    public function setMessageRead($idUser, $idMessage){
        $this->db->set('procitana', "TRUE", FALSE);
        $this->db->where("idKorisnik", $idUser);
        $this->db->where("idPoruka", $idMessage);
        $this->db->update('Primanje');
    }
}
