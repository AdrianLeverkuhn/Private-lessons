<!--
me130040
-->
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
        $query = $this->db->get_where('Disciplina', array('idPredmet' => $idSubject));
        return $query->result_array();
    }
    
    //string: returns dicipline name by using its $idDiscipline and $idSubject
    public function getDiscipline($idSubject, $idDiscipline){//NOT TESTED
        $query = $this->db->get_where('Disciplina', array('idPredmet' => $idSubject, 'idDisciplina' => $idDiscipline), 1);
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
        'poRelevantnosti' => $poRelevantnosti,//seortira prema relevantnosti sa stringom koji je poslat kao pretraga
        'pretraga' => $stringPretrage,//vrednost koju je korisnik uneo u searchbar
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
            $this->db->where('idPredmet', (int)$data['idPredmet']);
            if($data['idDisciplina']!=NULL)
                $this->db->where('idDisciplina', (int)$data['idDisciplina']);
            file_put_contents("logovi", "ulazi");
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
        //file_put_contents("logovi", $this->db->get_compiled_select());
        $query = $this->db->get();
        $result = $query->result_array();;
        if($data['poRelevantnosti']!=NULL){
            $searches = explode(" ", strtolower($data['pretraga']));
            $myResult = array();
            $cnt = 0;
            foreach($result as $row){
                $myResult[$cnt] = array();
                $myResult[$cnt]['row'] = $row;
                $myResult[$cnt]['relevance'] = $this->relevancePoints($row, $searches);
                $cnt++;
            }
            $resutl = array();
            if(!usort($myResult, array($this,'cmp'))):
                return $resutl;
            endif;
            //echo '<pre>';print_r($myResult); echo '</pre>';
            
        //file_put_contents("logovi", $string);
            $cnt = 0;
            for(; $cnt < sizeof($myResult); $cnt++):
                $resutl[$cnt] = $myResult[$cnt]['row'];
            endfor;
            
            return $resutl;
        }
        return $result;
    }

    private function cmp($a, $b)
    {
        $raz = (int)$a['relevance'] - (int)$b['relevance'];
        file_put_contents("logovi", $raz);
        return $raz * - 1;
    }
    
    private function relevancePoints($tutor, $words){
        $weights = array(
            'firstName' => 20,
            'lastName' => 20,
            'region' => 15,
            'advert' => 10,
            'education' => 2,
            'certificate' => 5,
            'biography' => 1
        );
        $total = 0;
        foreach($words as $word){
            if($word != ""):
            if ($tutor['ime'] !== ""):$total += $weights['firstName']*substr_count(strtolower($tutor['ime']), $word);endif;
            if ($tutor['prezime'] !== ""):$total += $weights['lastName']*substr_count(strtolower($tutor['prezime']), $word);endif;
            if ($tutor['mesto'] !== ""):$total += $weights['region']*substr_count(strtolower($tutor['mesto']), $word);endif;
            if ($tutor['biografija'] !== ""):$total += $weights['biography']*substr_count(strtolower($tutor['biografija']), $word);endif;
            
            $this->db->select('*');
            $this->db->from('Tutor');
            $this->db->join('Oglas', 'Tutor.idTutor = Oglas.idTutor');
            $this->db->join('Predmet', 'Predmet.idPredmet = Oglas.idPredmet');
            $query = $this->db->get();
            $result = $query->result_array();
            foreach($result as $row){
                $total += $weights['advert']*substr_count(strtolower($row['naziv']), $word);
            }
            
            $this->db->select('*');
            $this->db->from('Tutor');
            $this->db->join('Sertifikat', 'Tutor.idTutor = Sertifikat.idTutor');
            
            $query = $this->db->get();
            
            $result = $query->result_array();
            foreach($result as $row){
                $total += $weights['certificate']*substr_count(strtolower($row['naziv']), $word);
            }
            
            $this->db->select('*');
            $this->db->from('Tutor');
            $this->db->join('Obrazovanje', 'Tutor.idTutor = Obrazovanje.idTutor');
            $query = $this->db->get();
            $result = $query->result_array();
            foreach($result as $row){
                $total += $weights['education']*substr_count(strtolower($row['institucija']), $word);
                $total += $weights['education']*substr_count(strtolower($row['opis']), $word);
            }
            endif;
        }
        return $total;
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
