<!--sa130068-->
<?php

class Test extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
    }
    
    public function index(){
        $this->view();
    }
    
    public function view($page = 'proba'){
        $className = lcfirst(get_class($this));
        if (!file_exists(APPPATH.'views/'.$className.'/'.$page.'.php')){
            show_404();
        }
        
        $this->load->model("userModel");
        $this->load->model("reportModel");
        $this->load->model("messageModel");
        $this->load->model("subjectModel");
        //$this->userModel->setEmail(1, "mile@mile.com");
        
        $data = array();
        $data = $this->getDataFromModels();
        
        $this->load->view('templates/header', $data);
        $this->load->view("$className/".$page, $data);
        $this->load->view('templates/footer', $data);
    }
    
    protected function getDataFromModels(){
        $data['title'] = 'Naslov';
        $data['upit'] = "";
        $podaci = array(
           'idPosiljalac' => 1,
           'idPrimalac' => 1,
          'text' => "Ovo je lazan profil"
      );
        $tutor = array(
      'ime' => "Emil",
      'prezime' => "Maid",
      'email' => "mile@mile.com",
      'sifra' => "asdf"
    );
        //$this->userModel->createTutor($tutor);
        $poruka = array(
            'idPosiljalac' => 1, 
            'subjekat' => "Danas je bio lep dan",
            'text' => "Ovde ide telo. Shh, ubili smo nekoga, ovde ga krijemo ;)",
            'primaoci' => array(1)
        );
        //$this->userModel->createTutor($tutor);
        //$data['upit'] = $this->reportModel->createReport($podaci);
        //$data['upit'] = $this->reportModel->getReportText(5);
        //$data['upit'] = $this->reportModel->createReport($podaci);
        //$data['upit'] = $this->reportModel->setMarkReport(13,1);
        //$data['upit'] = $this->messageModel->createMessage($poruka);
        //$data['upit'] .= $this->reportModel->isMarkedReport(5);
        //$data['upit'] = $this->messageModel->setMessageRead(1,1);
        //$data['upit'] = $this->messageModel->isMessageRead(1,1);
        
        $podaci = array(
            'minCena' => 0,//ako nema ogranicenja staviti NULL
            'maxCena' => 1000,//ako nema ogranicenja staviti NULL
            'idPredmet' => 1,//ako nije obelezio, staivti NULL
            'idDisciplina' => NULL,//ako nije obelezio staviti NULL
            'naAdresu' => FALSE,//ako nije naveo staviti NULL, u suprotnom bool vrednost
            'onlineCasove' => FALSE,//ako nije naveo staviti NULL, u suprotnom bool vrednost
            'grupneCasove' => FALSE,//ako nije naveo staviti NULL, u suprotnom bool vrednost
            'poOpadajucojCeni' => FALSE,//sortira po opadajucoj ceni, boolean vrednost
            'poRastucojCeni' => FALSE,//sortira po rastucoj ceni, boolean vrednost
            'poOceni' => FALSE,
            'banovan' => FALSE,
            'poRelevantnosti' => false
        );
        
        $rows = $this->subjectModel->getTutorsByCriteria($podaci);
        
        
        foreach ($rows as $row)
        {
            $data['upit'] .= $row['ime'].
            //$row['idPosiljalac'].
            //$row['idKorisnik'].//primalac
            //$row['subjekat'].
            $row['cena'].
            $row['prezime'];
        }
        
        /*
        $rows = $this->messageModel->getMessages(1);
        
        foreach ($rows as $row)
        {
            $data['upit'] .= $row['procitana'].
            $row['idPosiljalac'].
            $row['idKorisnik'].//primalac
            $row['subjekat'].
            $row['text'].
            $row['datum'];
        }
        */
        return $data;
    }
}
