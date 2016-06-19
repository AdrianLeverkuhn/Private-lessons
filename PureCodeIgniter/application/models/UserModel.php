<!--
me130040
-->
<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model{
    
    public function __construct(){
        $this->load->database();
    }

    
    
    //--------------------------------------------------------------------------
    //user-profile-edit
    //void: sets the email of user
    public function setEmail($id, $newEmail){//NOT TESTED
        $this->db->set('email', "'$newEmail'", FALSE);
        $this->db->where("idKorisnik", $id);
        $this->db->update('Korisnik');
    }
    
    //string: returns email of user with $id, NULL if doesn't exist
    public function getEmail($id){//NOT TESTED
        $this->db->select('email');
        $this->db->from('Korisnik');
        $this->db->where("idKorisnik", $id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
            return $row->email;
        }
        return NULL;
    }
    
    //void: sets the region i.e. Beograd for a user with id $id
    public function setRegion($id, $newRegion){//NOT TESTED
        $this->db->set('mesto', "'$newRegion'", FALSE);
        $this->db->where("idTutor", $id);
        $this->db->update('Tutor');
    }
    
    //string: returns region of user with $id, NULL if doesn't exist
    public function getRegion($id){//NOT TESTED
        $this->db->select('mesto');
        $this->db->from('Tutor');
        $this->db->where("idTutor", $id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
            return $row->mesto;
        }
        return NULL;
    }
    
    //void: sets the contacts i.e. 011/123-123 for a user with id $id
    public function setContact($id, $newContact){//NOT TESTED
        $this->db->set('telefoni', "'$newContact'", FALSE);
        $this->db->where("idTutor", $id);
        $this->db->update('Tutor');
    }
    
    //string: returns contacts i.e. telephone numbers of user with $id, NULL if doesn't exist
    public function getContact($id){//NOT TESTED
        $this->db->select('telefoni');
        $this->db->from('Tutor');
        $this->db->where("idTutor", $id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
            return $row->telefoni;
        }
        return NULL;
    }
    
    //void: sets the image location and name on server hdd i.e. /server/slikeKorisnika/zivan.png for a user with id $id
    public function setImage($id, $newImage){//NOT TESTED
        $this->db->set('slika', "'$newImage'", FALSE);
        $this->db->where("idTutor", $id);
        $this->db->update('Tutor');
    }
    
    //string: returns image location of user with $id, NULL if doesn't exist
    public function getImage($id){//NOT TESTED
        $this->db->select('slika');
        $this->db->from('Tutor');
        $this->db->where("idTutor", $id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
            return $row->slika;
        }
        return NULL;
    }
    
    //void: sets the first name for a user with id $id
    public function setFirstName($id, $newFirstName){//NOT TESTED
        $this->db->set('ime', "'$newFirstName'", FALSE);
        $this->db->where("idTutor", $id);
        $this->db->update('Tutor');
        $last = $this->getLastName($id);
        //$this->setDisplayName($id, $newFirstName." ".$last);
    }
    
    //string: returns first name of user with $id, NULL if doesn't exist
    public function getFirstName($id){//NOT TESTED
        $this->db->select('ime');
        $this->db->from('Tutor');
        $this->db->where("idTutor", $id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
            return $row->ime;
        }
        return NULL;
    }
    
    //void: sets the last name for a user with id $id
    public function setLastName($id, $newLastName){//NOT TESTED
        $this->db->set('prezime', "'$newLastName'", FALSE);
        $this->db->where("idTutor", $id);
        $this->db->update('Tutor');
        $first = $this->getFirstName($id);
        //$this->setDisplayName($id, $first." ".$newLastName);
    }
    
    //string: returns last name of user with $id, NULL if doesn't exist
    public function getLastName($id){//NOT TESTED
        $this->db->select('prezime');
        $this->db->from('Tutor');
        $this->db->where("idTutor", $id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
            return $row->prezime;
        }
        return NULL;
    }
    
    //void: sets the display name for a user with id $id
    public function setDisplayName($id, $newDisplayName){//NOT TESTED
        $this->db->set('nadimak', "'$newDisplayName'", FALSE);
        $this->db->where("idKorisnik", $id);
        $this->db->update('Korisnik');
    }
    
    //string: returns display name of user with $id, NULL if doesn't exist
    //display name for tutors, display name is $firstName." ".$lastName
    /*public function getDisplayName($id){//NOT TESTED
        $this->db->select('nadimak');
        $this->db->from('Korisnik');
        $this->db->where("idKorisnik", $id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
        {
            return $row->nadimak;
        }
        return NULL;
    }*/
    
    public function getDisplayName($id){//NOT TESTED
        if($this->isTutor($id)){
            $this->db->select('ime');
            $this->db->select('prezime');
            $this->db->from('Tutor');
            $this->db->where("idTutor", $id);
            $query = $this->db->get();
            foreach ($query->result() as $row)
            {
                return $row->ime." ".$row->prezime;
            }
            return NULL;
        }else{
            $this->db->select('nadimak');
            $this->db->from('Korisnik');
            $this->db->where("idKorisnik", $id);
            $query = $this->db->get();
            foreach ($query->result() as $row)
            {
                return $row->nadimak;
            }
            return NULL;
        }
    }
    
    //void: sets the group class modifier for a user with id $id
    //note! $groupClass argument should be TRUE or FALSE
    public function setGroupClass($id, $groupClass){//NOT TESTED
        $this->db->set('grupneCasove', "'$groupClass'", FALSE);
        $this->db->where("idTutor", $id);
        $this->db->update('Tutor');
    }
    
    public function getGroupClass($idTutor){//NOT TESTED
        $query = $this->db->get_where('Tutor', array('idTutor' => $idTutor), 1);
        foreach ($query->result() as $row)
        {
            return $row->grupneCasove;
        }
        return NULL;
    }
    
    //void: sets the online class modifier for a user with id $id
    //note! $onlineClass argument should be TRUE or FALSE
    public function setOnlineClass($id, $onlineClass){//NOT TESTED
        $this->db->set('onlineCasove', "'$onlineClass'", FALSE);
        $this->db->where("idTutor", $id);
        $this->db->update('Tutor');
    }
    
    public function getOnlineClass($idTutor){//NOT TESTED
        $query = $this->db->get_where('Tutor', array('idTutor' => $idTutor), 1);
        foreach ($query->result() as $row)
        {
            return $row->onlineCasove;
        }
        return NULL;
    }
    
    //void: sets the group class modifier for a user with id $id
    //note! $onAddressClass argument should be TRUE or FALSE
    public function setOnAddressClass($id, $onAddressClass){//NOT TESTED
        $this->db->set('naAdresu', "'$onAddressClass'", FALSE);
        $this->db->where("idTutor", $id);
        $this->db->update('Tutor');
    }
    
    public function getOnAddressClass($idTutor){//NOT TESTED
        $query = $this->db->get_where('Tutor', array('idTutor' => $idTutor), 1);
        foreach ($query->result() as $row)
        {
            return $row->naAdresu;
        }
        return NULL;
    }
    
    //void: adds an advert to tutor
    /*
    $data = array(
        'idTutor' => $idTutoraKojiDajeOglas,
        'idPredmet' => $idPredmetaZaKojiDajeOglas,//dohvatiti metodom
        'idDisciplina' => $idPoddisciplineZaKojiDajeOglas,//opcioni parametar
        'cena' => $cena//integer vrednost
    );
     */
    public function addAdvert($data){//NOT TESTED
        $this->db->insert('Oglas', $data);
    }
    
    //void: removes the advert
    public function removeAdvert($idAdvert){//NOT TESTED
        $this->db->where('idOglas', $idAdvert);
        $this->db->delete('Oglas');
    }
    
    //array: reutrns all of adverts for tutor $idTutor
    /*
     * foreach (getAdverts($idUser) as $row)
        {
            echo $row['idOglas'];
            echo $row['idTutor'];
            echo $row['idPredmet'];
            echo $row['idDisciplina'];
            echo $row['cena'];
        }
     */
    public function getAdverts($idTutor){//NOT TESTED
        $query = $this->db->get_where('Oglas', array('idTutor' => $idTutor));
        return $query->result_array();
    }
    
    //string: returns the biography of tutor $idTutor
    public function getBiography($idTutor){//NOT TESTED
        $query = $this->db->get_where('Tutor', array('idTutor' => $idTutor), 1);
        foreach ($query->result() as $row)
        {
            return $row->biografija;
        }
        return NULL;
    }
    
    //void: changes the biography of tutor
    public function setBiography($idTutor, $newBiography){//NOT TESTED
        $this->db->set('biografija', "'$newBiography'", FALSE);
        $this->db->where("idTutor", $idTutor);
        $this->db->update('Tutor');
    }
    
    //void: adds a work experience to tutor (Posao)
    /*
    $data = array(
        'idTutor' => $idTutora,
        'naziv' => $imePosla,
        'poslodavac' => $imePoslodavca,
        'period' => $period,//pamti se u obliku stringa
        'opis' => $opis,//pamti se u obliku stringa
    );
     */
    public function addWorkExperience($data){//NOT TESTED
        $this->db->insert('Posao', $data);
    }
    
    //void: removes work experience
    public function removeWorkExperience($idWork){//NOT TESTED
        $this->db->where('idPosao', $idWork);
        $this->db->delete('Posao');
    }
    
    //array: reutrns all of work experiences for tutor $idTutor
    /*
     * foreach (getWorkExperience($idUser) as $row)
        {
            echo $row['idPosao'];
            echo $row['idTutor'];
            echo $row['naziv'];
            echo $row['poslodavac'];
            echo $row['period'];
            echo $row['opis'];
        }
     */
    public function getWorkExperience($idTutor){//NOT TESTED
        $query = $this->db->get_where('Posao', array('idTutor' => $idTutor));
        return $query->result_array();
    }
    
    //void: adds an education to tutor (Obrazovanje)
    /*
    $data = array(
        'idTutor' => $idTutora,
        'institucija' => $skola,//ETF na primer
        'nivo' => $imePoslodavca,//master
        'period' => $period,//pamti se u obliku stringa
        'opis' => $opis,//pamti se u obliku stringa
    );
     */
    public function addEducation($data){//NOT TESTED
        $this->db->insert('Obrazovanje', $data);
    }
    
    //void: removes the education
    public function removeEducation($idEdu){//NOT TESTED
        $this->db->where('idObrazovanje', $idEdu);
        $this->db->delete('Obrazovanje');
    }
    
    //array: reutrns all of work experiences for tutor $idTutor
    /*
     * foreach (getEducation($idUser) as $row)
        {
            echo $row['idObrazovanje'];
            echo $row['idTutor'];
            echo $row['institucija'];
            echo $row['nivo'];
            echo $row['period'];
            echo $row['opis'];
        }
     */
    public function getEducation($idTutor){//NOT TESTED
        $query = $this->db->get_where('Obrazovanje', array('idTutor' => $idTutor));
        return $query->result_array();
    }
    
    //void: adds a certificate to tutor (Sertifikat)
    /*
    $data = array(
        'idTutor' => $idTutora,
        'ustanova' => $ustanova,//British Council
        'naziv' => $imePoslodavca,//CAE
        'datum' => $period//pamti se u obliku stringa
    );
     */
    public function addCertificate($data){//NOT TESTED
        $this->db->insert('Sertifikat', $data);
    }
    
    //void: removes the certificate
    public function removeCertificate($idCertificate){//NOT TESTED
        $this->db->where('idSertifikat', $idCertificate);
        $this->db->delete('Sertifikat');
    }
    
    //array: reutrns all of work experiences for tutor $idTutor
    /*
     * foreach (getCertificates($idUser) as $row)
        {
            echo $row['idSertifikat'];
            echo $row['idTutor'];
            echo $row['ustanova'];
            echo $row['naziv'];
            echo $row['datum'];
        }
     */
    public function getCertificates($idTutor){//NOT TESTED
        $query = $this->db->get_where('Sertifikat', array('idTutor' => $idTutor));
        return $query->result_array();
    }
    
        
    //int: number of overall half-stars for tutor by id
    public function getOverallRating($idTutor){//NOT TESTED
        $query = $this->db->get_where('Tutor', array('idTutor' => $idTutor), 1);
        foreach ($query->result() as $row)
        {
            return $row->ukupnaOcena;
        }
        return NULL;
    }
    
    //array: reutrns all ratings for tutor $idTutor
    /*
     * foreach (getRatings($idUser) as $row)
        {
            echo $row['idKorisnik'];//onaj ko mu je dao ocenu
            echo $row['idTutor'];
            echo $row['text'];
            echo $row['ocena'];//broj polu zvezdica, npr. ako ima 5 zvezdica, ova vrednost je 10
            echo $row['datum'];
        }
     */
    public function getRatings($idTutor){//NOT TESTED
        $query = $this->db->get_where('Ocena', array('idTutor' => $idTutor));
        return $query->result_array();
    }
    
    //void: adds a rating to tutor (Ocena)
    /*
    $data = array(
        'idTutor' => $idTutora,
        'idKorisnik' => $idOcenjivaca,
        'text' => $text,//Ne valja ovaj, mnogo smara :P
        'ocena' => $ocena,//broj poluzvezdica, ako je ocena 3.5 zvezdica, proslediti 7
    );
     */
    public function addRating($data){//NOT TESTED
        $data['datum'] = (string)date('Y-m-d H:i:s');
        $this->db->insert('Ocena', $data);
    }
    
    //void: upgrades the current user with id $id to tutor status
    //requres $data array to be defined the following way
    //$data = array(
    //    'idTutor' => $id,
    //    'ime' => "Emil",
    //    'prezime' => "Maid"
    //    ...
    //    biografija, titula, slika, telefoni, mesto
    //);
    public function upgradeToTutor($id, $data){
        $data['idTutor'] = $id;
        $this->db->insert('Tutor', $data);
    }
    
    //int: returns the id of a user with email $email, else NULL
    public function getIdByEmail($email){
        $query = $this->db->get_where('Korisnik', array('email' => "$email"), 1);
        foreach ($query->result() as $row)
        {
            return $row->idKorisnik;
        }
        return NULL;
    }
    
    //int: returns the id of a user with display name $nick, else NULL
    public function getIdByDisplayName($nick){
        $query = $this->db->get_where('Korisnik', array('nadimak' => "$nick"), 1);
        foreach ($query->result() as $row)
        {
            return $row->idKorisnik;
        }
        $query = $this->db->get_where('Tutor');
        foreach($query as $row):
            $name = $row->ime." ".$row->prezime;
            if ($nick == $name):
                return $row->idTutor;
            endif;
        endforeach;
        return NULL;
    }
    
    //int: returns the id of a newly created user
    //$data = array(
    //  'nadimak' => "mile",
    //  'email' => "mile@mile.com",
    //  'sifra' => "asdf"
    //);
    public function createUser($data){
        $sif = $data['sifra'];
        $data['sifra'] = password_hash("$sif", PASSWORD_BCRYPT);
        $this->db->insert('Korisnik', $data);
        return $this->getIdByEmail($data['email']);
    }
    
    //int: returns the id of a newly created tutor
    //$data = array(
    //  'ime' => "Emil",
    //  'prezime' => "Maid",
    //  'email' => "mile@mile.com",
    //  'sifra' => "asdf"
    //);
    public function createTutor($data){
        $data['nadimak'] = $data['ime']." ".$data['prezime'];
        $podaci = array(
            'nadimak' => $data['ime']." ".$data['prezime'],
            'email' => $data['email'],
            'sifra' => $data['sifra']
        );
        $id = $this->createUser($podaci);
        $podaci2 = array(
            'idTutor' => $id,
            'ime' => $data['ime'],
            'prezime' => $data['prezime']
        );
        $this->upgradeToTutor($id, $podaci2);
        return $id;
    }
    
    //int: returns NULL if cannot login, else returns id of user
    public function login($email, $password){
        $query = $this->db->get_where('Korisnik', array('email' => "$email"), 1);
        $hash = 1;
        $id = -1;
        foreach ($query->result() as $row)
        {
            $hash = $row->sifra;
            $id = $row->idKorisnik;
        }
        if($hash==1)
            return NULL;
        //$hash = '$2y$10$Y3eywVV/adBRgL2YyXfpQOF.W7x74oakVS1Lw5jw24wfEYBfmwdya';
        if(password_verify($password , $hash)){
            if (password_needs_rehash($hash, PASSWORD_BCRYPT)) {
                // If so, create a new hash, and replace the old one
                $newHash = password_hash($password, PASSWORD_BCRYPT);
                //stavi $newHash u bazu
            }
            //uradi login
            return $id;
        }else{
            return NULL;
        }
    }
    
    
    //bool: returns true if user with id $id has password $password
    public function isPassword($id, $password){
        //dohvati $hash iz baze
        $query = $this->db->get_where('Korisnik', array('idKorisnik' => $id), 1);
        $hash = "1";
        foreach ($query->result() as $row)
        {
            $hash = $row->sifra;
        }
        return (password_verify($password , $hash)); 
    }
    
    //void: updates the password to $newPassword to user with id $id
    public function changePassword($id, $newPassword){
        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
        $this->db->set('sifra', "'$hash'", FALSE);
        $this->db->where("idKorisnik", $id);
        $this->db->update('Korisnik');
    }
    
    //void: bans the user with id $id
    public function banUser($id){//NOT TESTED
        $this->db->set('banovan', "1", FALSE);
        $this->db->where("idKorisnik", $id);
        $this->db->update('Korisnik');
    }
    
    //void: unbans the user with id $id
    public function unbanUser($id){//NOT TESTED
        $this->db->set('banovan', "0", FALSE);
        $this->db->where("idKorisnik", $id);
        $this->db->update('Korisnik');
    }
    
    public function getBanned($id)
    {
        $query = $this->db->get_where('Korisnik', array('idKorisnik' => $id));
        foreach ($query->result() as $row)
        {
            return $row->banovan;
        }
        return NULL;
    }
    
    //bool: checks if user $id is an admin
    public function isAdmin($id){//NOT TESTED
        $query = $this->db->get_where('Admin', array('idAdmin' => $id), 1);
        return sizeof($query->result()) == 1;
    }
    
    //bool: checks if user $id is a tutor
    public function isTutor($id){//NOT TESTED
        $query = $this->db->get_where('Tutor', array('idTutor' => $id), 1);
        return sizeof($query->result()) != 0;
    }
    
    //void: deletes the user $id from database
    public function deleteUser($id){//NOT TESTED
        $this->db->where('idKorisnik', $id);
        $this->db->delete('Korisnik');
    }
}
