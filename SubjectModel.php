<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class SubjectModel extends CI_Model{
    public function __construct(){
        $this->load->database();
    }
    
    //array: reutrns all of subjects(Predmeti)
    /*
     * foreach (getSubjects() as $row)
        {
            echo $row['idPredmet'];
            echo $row['naziv'];
        }
     */
    public function getSubjects(){//NOT TESTED
        $query = $this->db->get('Predmet');
        return $query->result_array();
    }
    
    //string: returns subject name by using its $id
    public function getSubject($idSubject){//NOT TESTED
        $query = $this->db->get_where('Predmet', array('idPredmet' => $idSubject), 1);
        foreach ($query->result() as $row)
        {
            return $row->naziv;
        }
    }
    
    //array: reutrns all of disciplines for a particular subject (Discipline)
    /*
     * foreach (getDisciplines($idSubject) as $row)
        {
            echo $row['idDisciplina'];
            echo $row['idPredmet'];
            echo $row['naziv'];
        }
     */
    public function getDisciplines($idSubject){//NOT TESTED
        $query = $this->db->get_where('Disciplina', array('idPredmet' => $idSubject), 1);
        return $query->result_array();
    }
    
    //string: returns dicipline name by using its $idDiscipline and $idSubject
    public function getDiscipline($idSubject, $idDiscipline){//NOT TESTED
        $query = $this->db->get_where('Predmet', array('idPredmet' => $idSubject, 'idDisciplina' => $idDiscipline), 1);
        foreach ($query->result() as $row)
        {
            return $row->naziv;
        }
    }
    
    //array: returns an array of tutors sorted
    /*
    $data = array(
        'minCena' => $minimalnaCena,//ako nema ogranicenja staviti NULL
        'maxCena' => $maximalnaCena,//ako nema ogranicenja staviti NULL
        'idPredmet' => $idPredmet,//ako nije obelezio, staivti NULL
        'idDisciplina' => $idDisciplina,//ako nije obelezio staviti NULL
        'naAdresu' => $casoviNaAdresi,//ako nije naveo staviti NULL, u suprotnom bool vrednost
        'onlineCasove' => $onlineCasove,//ako nije naveo staviti NULL, u suprotnom bool vrednost
        'grupneCasove' => $grupneCasove,//ako nije naveo staviti NULL, u suprotnom bool vrednost
        'poOpadajucojCeni' => $poOpadajucojCeni,//sortira po opadajucoj ceni, boolean vrednost
        'poRastucojCeni' => $poRastucojCeni,//sortira po rastucoj ceni, boolean vrednost
        'poOceni' => $poOceni,//sortira po oceni, boolean vrednost
        'banovan' => $daLiHocesBanovane//bool vrednost kojom saopstavas dal zelis i banovane, za TRUE se salju svi, za FALSE samo nebanovani
    );
    foreach (getTutorsByCriteria($data) as $row)//one row coresponds to one tutor
        {
            echo $row['idTutor'];
            echo $row['ime'];
            echo $row['prezime'];
            echo $row['biografija'];
            echo $row['slika'];
            echo $row['ukupnaOcena'];
            echo $row['mesto'];
            echo $row['titula'];
            echo $row['biografija'];
            echo $row['cena'];//ona cena koju stavljas u Vec Od ... DIN
        }
     */
    public function getTutorsByCriteria($data){//PARTIALLY TESTED
        $this->db->select('*');
        $this->db->select_min('cena');
        $this->db->from('Tutor');
        $this->db->join('Oglas', 'Tutor.idTutor = Oglas.idTutor');
        $this->db->join('Korisnik', 'Tutor.idTutor = Korisnik.idKorisnik');
        if($data['banovan']!==NULL && $data['banovan']==FALSE)
            $this->db->where('banovan', 'FALSE');
        $this->db->where('cena >=', $data['minCena']);
        $this->db->where('cena <=', $data['maxCena']);
        if($data['idPredmet']!=NULL){
            $this->db->where('idPredmet', $data['idPredmet']);
            if($data['idDisciplina']!=NULL)
                $this->db->where('idDisciplina', $data['idDisciplina']);
        }
        if($data['naAdresu']!=NULL)
            $this->db->where('naAdresu', $data['naAdresu']);
        if($data['onlineCasove']!=NULL)
            $this->db->where('onlineCasove', $data['onlineCasove']);
        if($data['grupneCasove']!=NULL)
            $this->db->where('grupneCasove', $data['grupneCasove']);
        $this->db->group_by('Tutor.idTutor');
        if($data['poOpadajucojCeni']!=NULL)
            $this->db->order_by('cena', 'DESC');
        if($data['poRastucojCeni']!=NULL)
            $this->db->order_by('cena', 'ASC');
        if($data['poOceni']!=NULL)
            $this->db->order_by('ukupnaOcena', 'DESC');
        //$this->db->order_by('title', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //array: returns an array of tutors for such subjects
    /*
    $data = array($idPredmet1, idPredmet2, ...);<---------------------NOTICE THIS >:-(
    
    foreach (getTutorsByCriteria($data) as $row)//one row coresponds to one tutor
        {
            echo $row['idTutor'];
            echo $row['ime'];
            echo $row['prezime'];
            echo $row['biografija'];
            echo $row['slika'];
            echo $row['ukupnaOcena'];
            echo $row['mesto'];
            echo $row['titula'];
            echo $row['biografija'];
            echo $row['cena'];//ona cena koju stavljas u Vec Od ... DIN
        }
     */
    public function getTutorsBySubjects($data){//PARTIALLY TESTED
        $this->db->select('*');
        $this->db->select_min('cena');
        $this->db->from('Tutor');
        $this->db->join('Oglas', 'Tutor.idTutor = Oglas.idTutor'); 
        $this->db->where('banovan', 'FALSE');
        $this->db->where_in('idPredmet', $data);
        $this->db->group_by('Tutor.idTutor');
        $this->db->order_by('ukupnaOcena', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
