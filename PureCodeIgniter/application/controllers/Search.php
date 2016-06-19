<!--sa130068-->
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
    
    public function _construct()
    {
        parent::_construct();
        session_start();
        $this->load->helper('url_helper');
    }
    
    public function index($sorting = RELEVANCE)
    {       
        $this->load->model('subjectmodel');
        
        $searchData = array();
        $city = isset($_GET['city'])? $_GET['city'] : "";
        
        $searchData['pretraga'] =   isset($_GET['searchString'])? $_GET['searchString']." ".$city :
                                    $city;
        $_SESSION['initialSearcgString'] = isset($_GET['searchString'])? $_GET['searchString']:" ";
        $_SESSION['searchString'] = $searchData['pretraga'];
        $searchData['minCena']= isset($_GET['cenaMin']) && $_GET['cenaMin'] != ""? $_GET['cenaMin'] : 0;
        $searchData['maxCena']= isset($_GET['cenaMax']) && $_GET['cenaMax'] != ""? $_GET['cenaMax'] : 10000;
        $searchData['idPredmet']= isset($_GET['subject']) && $_GET['subject'] != "-1" ? $_GET['subject'] : NULL;
        $searchData['idDisciplina']= isset($_GET['discipline']) && $_GET['discipline'] != "-1" ? $_GET['discipline'] : NULL;
        $searchData['naAdresu']= isset($_GET['type'])? $_GET['type'] == ONADDRESS : NULL;
        $searchData['onlineCasove']= isset($_GET['type'])? $_GET['type'] == ONLINE : NULL;
        $searchData['grupneCasove']= isset($_GET['type'])? $_GET['type'] == GROUP : NULL;
        $searchData['poOpadajucojCeni']= $sorting == PRICEHIGH ? TRUE: NULL;
        $searchData['poRastucojCeni']= $sorting == PRICELOW ? TRUE: NULL;
        $searchData['poOceni']= $sorting == RATING ? TRUE: NULL;
        $searchData['poRelevantnosti']= $sorting == RELEVANCE ? TRUE: NULL;
        $searchData['banovan']= false;
        echo $searchData['idPredmet']." ".$searchData['idDisciplina'];
        //return;
        $results = $this->subjectmodel->getTutorsByCriteria($searchData);
        $data['results'] = array();
        $cnt = 0;
        foreach($results as $result):
            $data['results'][$cnt] = $result;
            $cnt++;
        endforeach;
        
        $data['subjects'] = $this->subjectmodel->getSubjects();
        /*foreach($data['subjects'] as $subject):
            $subject['disciplines'] = $this->subjectmodel->getDisciplines($subject['idPredmet']);
        endforeach;*/
        $data['page'] = 1;
        $data['total'] = sizeof($data['results']);
        
        $_SESSION['searchData'] = $searchData;
        $_SESSION['totalResultPages'] = $data['total'];
        
        $this->load->view("templates/header");
        $this->load->view('search/resultsscripts');
        $this->load->view("templates/menubar");
        $this->load->view("search/results", $data);
        $this->load->view("templates/footer");
    }
    
    public function goToPage($page)
    {
        if (!isset($_SESSION['searchData'])):
            show_404();
        endif;
        $this->load->model('subjectmodel');
        $data['results'] = $this->subjectmodel->getTutorsByCriteria($_SESSION['searchData']);
        $data['page'] = $page;
        $data['total'] = ceil(sizeof($data['results']));
        
        $this->load->view("templates/header");
        $this->load->view('search/resultsscripts');
        $this->load->view("templates/menubar");
        $this->load->view("search/results", $data);
        $this->load->view("templates/footer");
    }
    
    public function sortResults($sorting = RELEVANCE)
    {
        
        if (!isset($_SESSION['searchData'])):
            show_404();
        endif;
        $this->load->model('subjectmodel');
        $_SESSION['searchData']['poOpadajucojCeni']= $sorting == PRICEHIGH ? TRUE: NULL;
        $_SESSION['searchData']['poRastucojCeni']= $sorting == PRICELOW ? TRUE: NULL;
        $_SESSION['searchData']['poOceni']= $sorting == RATING ? TRUE: NULL;
        $_SESSION['searchData']['poRelevantnosti']= $sorting == RELEVANCE ? TRUE: NULL;
        
        $data['results'] = array();
        $results =$this->subjectmodel->getTutorsByCriteria($_SESSION['searchData']);
        $cnt = 0;
        foreach($results as $result):
            $data['results'][$cnt] = $result;
            $cnt++;
        endforeach;
        $data['page'] = 1;
        $data['total'] = ceil(sizeof($data['results']));
        
        $this->load->view("templates/header");
        $this->load->view('search/resultsscripts');
        $this->load->view("templates/menubar");
        $this->load->view("search/results", $data);
        $this->load->view("templates/footer");
    }
    
    public function getDisciplines()
    {
        $this->load->model('subjectmodel');
        $subjectID = $_POST['id'];
        if (isset($subjectID) && is_numeric($subjectID)):
            $disciplines = $this->subjectmodel->getDisciplines($subjectID);
            $result = "";
            foreach ($disciplines as $discipline):
                $result .= "<option id=\"".$discipline['idDisciplina']."\" value=\"".$discipline['idDisciplina']."\">".$discipline['naziv']."</option>";
            endforeach;
            echo $result;
        endif;
    }
};