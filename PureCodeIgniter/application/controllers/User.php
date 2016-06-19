<!--sa130068-->
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function _construct() {
        parent::_construct();
        session_start();
        $this->load->helper('url_helper');
        $this->load->library('validation');
    }

    public function profile($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');
        $this->load->model('subjectmodel');
        /* if (false):
          show_404();//Promeniti kasnije da prikaze nesto normalno
          return;
          endif; */
        $data = array();
        $data['loggedIn'] = isset($_SESSION['userID']);
        $data['isAdmin'] = $data['loggedIn'] && $this->usermodel->isAdmin($_SESSION['userID']);
        $data['isTutor'] = $this->usermodel->isTutor($profileID);

        $data['profileID'] = $profileID;
        $data['biography'] = $this->usermodel->getBiography($profileID);
        $data['firstName'] = $this->usermodel->getFirstName($profileID);
        $data['lastName'] = $this->usermodel->getLastName($profileID);
        $data['region'] = $this->usermodel->getRegion($profileID);
        $data['email'] = $this->usermodel->getEmail($profileID);
        $data['contact'] = $this->usermodel->getContact($profileID);
        $data['image'] = $this->usermodel->getImage($profileID);
        if ($data['image'] == ""):
            $data['image'] = /* site_url(). */"/img/sloth.png";
        endif;
        $data['rating'] = $this->usermodel->getOverallRating($profileID);
        $adverts = $this->usermodel->getAdverts($profileID);
        $data['adverts'] = array();


        $cnt = 0;
        if ($data['loggedIn'] && $profileID == $_SESSION['userID']):
            $data['onAddress'] = $this->usermodel->getOnAddressClass($_SESSION['userID']);
            $data['online'] = $this->usermodel->getOnlineClass($_SESSION['userID']);
            $data['group'] = $this->usermodel->getGroupClass($_SESSION['userID']);
            $data['numOfMessages'] = $this->unreadMessages(($_SESSION['userID']));
            $data['numOfReports'] = $this->unreadReports(($_SESSION['userID']));
        endif;
        foreach ($adverts as $advert):
            $data['adverts'][$cnt] = array(
                'oblast' => $this->subjectmodel->getSubject($advert['idPredmet']),
                'podoblast' => $this->subjectmodel->getDiscipline($advert['idPredmet'], $advert['idDisciplina']),
                'cena' => $advert['cena'],
                'id' => $advert['idOglas']
            );
            $cnt++;
        endforeach;
        $data['banned'] = $this->usermodel->getBanned($profileID);
        $data['workExperience'] = $this->usermodel->getWorkExperience($profileID);
        $data['certificates'] = $this->usermodel->getCertificates($profileID);
        $data['education'] = $this->usermodel->getEducation($profileID);
        $ratings = $this->usermodel->getRatings($profileID);
        $data['displayName'] = $this->usermodel->getDisplayName($profileID);
        $data['ratings'] = array();
        $this->load->model('subjectmodel');
        $data['ocenio'] = false;
        $data['subjects'] = $this->subjectmodel->getSubjects();
        if (sizeof($ratings) != 0):
            $i = 0;
            foreach ($ratings as $rating):
                $data['ratings'][$i] = array();
                $data['ratings'][$i]['text'] = $rating['text'];
                $data['ratings'][$i]['ocena'] = $rating['ocena'];
                $data['ratings'][$i]['datum'] = $rating['datum'];
                $data['ratings'][$i]['ocenjivac'] = $this->usermodel->getDisplayName($rating['idKorisnik']);
                if(isset($_SESSION['userID']) && $rating['idKorisnik'] == $_SESSION['userID']):
                    $data['ocenio'] = true;
                endif;
                $i++;
            endforeach;
        else:
            $ratings = 0;
        endif;
        $data['groupClass'] = $this->usermodel->getGroupClass($profileID) == 1;
        $data['onAddressClass'] = $this->usermodel->getOnAddressClass($profileID) == 1;
        $data['onlineClass'] = $this->usermodel->getOnlineClass($profileID) == 1;
        //$data['groupClass'] = $this->usermodel->getEducation($profileID);


        $this->load->view('templates/header');
        $this->load->view('user/profilescripts', $data);
        $this->load->view('templates/menubar');
        $this->load->view('user/profile', $data);
        $this->load->view('templates/footer');
    }

    public function rate($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (!isset($_SESSION['userID']) || !isset($_POST['rating']) || !isset($_POST['comment'])):
            redirect(site_url() . "/user/profile/" . $profileID);
        endif;
        $data = array(
            'idTutor' => $profileID,
            'idKorisnik' => $_SESSION['userID'],
            'text' => $_POST['comment'], //Ne valja ovaj, mnogo smara :P
            'ocena' => $_POST['rating'] * 2, //broj poluzvezdica, ako je ocena 3.5 zvezdica, proslediti 7
        );
        $this->load->model('usermodel');
        $ratings = $this->usermodel->getRatings($profileID);
        foreach ($ratings as $rating):
            if ($rating['idKorisnik'] == $_SESSION['userID'])
                redirect(site_url() . "/user/profile/" . $profileID);
        endforeach;
        $this->usermodel->addRating($data);
        redirect(site_url() . "/user/profile/" . $profileID);
    }

    public function editbio($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');
        $biography = isset($_POST['biography']) ? $_POST['biography'] : "";
        if ($biography == ""):
            $_SESSION['noBio'] = true;
        else:
            $this->usermodel->setBiography($profileID, $biography);
        endif;
        redirect("/user/profile/" . $profileID);
    }

    public function editinfo($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');
        $group = isset($_POST['group']) ? $_POST['group'] === "Yes" : 0;
        $online = isset($_POST['online']) ? $_POST['online'] === "Yes" : 0;
        $address = isset($_POST['onAddress']) ? $_POST['onAddress'] === "Yes" : 0;
        $this->usermodel->setGroupClass($profileID, $group);
        $this->usermodel->setOnlineClass($profileID, $online);
        $this->usermodel->setOnAddressClass($profileID, $address);



        $config['upload_path'] = './img/';
        $config['allowed_types'] = 'jpeg|jpg|png|bmp';
        $config['max_size'] = 20000;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['file_name'] = "" . $profileID; //.".".$this->upload->data()['image_type'];//end(explode(".", $_FILES[$input_file_field_name]['name']));;
        $config['overwrite'] = TRUE;


        $this->load->library('upload', $config);
        if ($this->upload->do_upload('userfile')) {
            $data = array('upload_data' => $this->upload->data());
            $slika = "/img/" . $profileID . $this->upload->data()['file_ext'];
            $this->usermodel->setImage($profileID, $slika);
        }

        $_SESSION['emptyFields'] = 0;
        if (isset($_POST['fname']) && $_POST['fname'] != ""):
            $this->usermodel->setFirstName($profileID, $_POST['fname']);
        else:
            $_SESSION['emptyFields'] |= EMPTYFIRSTNAME;
        endif;
        if (isset($_POST['lname']) && $_POST['lname'] != ""):
            $this->usermodel->setLastName($profileID, $_POST['lname']);
        else:
            $_SESSION['emptyFields'] |= EMPTYLASTNAME;
        endif;

        if (isset($_POST['email']) && $_POST['email'] != ""):
            $this->usermodel->setEmail($profileID, $_POST['email']);
        else:
            $_SESSION['emptyFields'] |= EMPTYEMAIL;
        endif;
        if (isset($_POST['phone']) && $_POST['phone'] != ""):
            $this->usermodel->setContact($profileID, $_POST['phone']);
        else:
            $_SESSION['emptyFields'] |= EMPTYCONTACT;
        endif;


        redirect("/user/profile/" . $profileID);
    }

    private function unreadMessages($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('messagemodel');
        $messages = $this->messagemodel->getMessages($profileID);
        $cnt = 0;
        foreach ($messages as $message):
            $cnt += !$message['procitana'];
        endforeach;
        return $cnt;
    }

    private function unreadReports($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('reportmodel');
        $messages = $this->reportmodel->getReports($profileID);
        $cnt = 0;
        foreach ($messages as $message):
            $cnt += $message['idAdmin'] == NULL;
        endforeach;
        return $cnt;
    }

    public function passwordChange($failed = 0) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (!isset($_SESSION['userID'])):
            show_404();
        endif;
        $this->load->model('usermodel');
        $data['isAdmin'] = $this->usermodel->isAdmin($_SESSION['userID']);
        $data['failed'] = $failed;
        if ($profileID = $_SESSION['userID']):
            $data['numOfMessages'] = $this->unreadMessages(($_SESSION['userID']));
            $data['numOfReports'] = $this->unreadReports(($_SESSION['userID']));
        endif;
        $this->load->view('templates/header');
        $this->load->view('user/passchangescripts');
        $this->load->view('templates/menubar');
        $this->load->view('user/changepassword', $data);
        $this->load->view('templates/footer');
    }

    public function attemptPasswordChange() {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (!isset($_SESSION['userID'])):
            show_404();
        endif;
        $profileID = $_SESSION['userID'];
        $failed = 0;
        $this->load->library('validation');
        $this->load->model('usermodel');
        if (!isset($_POST['oldPass']) || !$this->usermodel->isPassword($profileID, $_POST['oldPass'])):
            $failed |= WRONGPASSWORD;
        endif;
        if (!isset($_POST['newPass']) || !$this->validation->Password($_POST['newPass'])):
            $failed |= WRONGPASSWORDFORMAT;
        endif;
        if (!isset($_POST['newPass1']) || $_POST['newPass1'] != $_POST['newPass']):
            $failed |= PASSWORDNOMATCH;
        endif;
        if ($failed == 0):
            $this->usermodel->changePassword($profileID, $_POST['newPass']);
            redirect(site_url() . "/user/profile/" . $profileID);
        else:
            redirect(site_url() . "/user/passwordchange/" . $failed);
        endif;
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
    public function becomeTutor($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if ($_SESSION['userID'] == $profileID):
            $this->load->model('usermodel');
            $idTutor = $profileID;
            $ime = isset($_POST['fname']) ? $_POST['fname'] : NULL;
            $prezime = isset($_POST['lname']) ? $_POST['lname'] : NULL;
            $grad = isset($_POST['city']) ? $_POST['city'] : NULL;
            $telefon = isset($_POST['phone']) ? $_POST['phone'] : NULL;
            $stariMejl = $this->usermodel->getEmail($profileID);
            $mejl = isset($_POST['email']) ? $_POST['email'] : NULL;
            $format = 0;
            if (!$this->validation->Email($mejl)):
                $format |= EMAILFORMAT;
            endif;
            if (isset($stariMejl) && $format == 0):
                $this->usermodel->setEmail($profileID, $mejl);
            endif;
            
            $slika = "";
            
            
            if (isset($input_file_field_name)):
                $config['upload_path'] = './profileimgs/';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['max_size'] = 1048576;
                $config['max_width'] = 1024;
                $config['max_height'] = 1024;
                $config['file_name'] = "" . $profileID . "." . end(explode(".", $_FILES[$input_file_field_name]['name']));
                $config['overwrite'] = TRUE;


                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('userfile')) {
                    $data = array('upload_data' => $this->upload->data());
                    $slika = "/img/" . $profileID . $this->upload->data()['file_ext'];
                }
            endif;

            if ($ime == NULL && $prezime == NULL && $telefon == NULL)
            {
                redirect(site_url() . "/user/profile/" . $profileID);
            }
            
            if ($ime == NULL || $prezime == NULL || $grad == NULL || $telefon == NULL):
                //redirect(site_url()/* . "/user/profile/" . $profileID*/);
                redirect("/user/profile/" . $profileID);
            endif;
            $format = 0;
            if (!$this->validation->Email($mejl)):
                $format |= EMAILFORMAT;
            endif;
            if (!$this->validation->Name($ime) || !$this->validation->Name($prezime)):
                $format |= REALNAME;
            endif;
            if (!$this->validation->Phone($telefon)):
                $format |= PHONE;
            endif;




            if ($format == 0):



                $tutorData = array(
                    'idTutor' => $idTutor,
                    'ime' => $ime,
                    'prezime' => $prezime,
                    'mesto' => $grad,
                    'telefoni' => $telefon,
                    'titula' => NULL,
                    'biografija' => NULL,
                    'slika' => $slika,
                );
                $this->usermodel->upgradeToTutor($profileID, $tutorData);
                if (strcmp($slika, "") != 0):
                    $this->usermodel->setImage($idTutor, $slika);
                endif;
            else:
                $_SESSION['editInforError'] = $format;
                redirect(site_url() . "/user/profile/" . $profileID );
            endif;
            redirect(site_url() . "/user/profile/" . $profileID);
        else:
            show_404();
        endif;
    }

    public function addAdvert() {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (!isset($_SESSION['userID'])):
            show_404();
        endif;
        if (!isset($_POST['price']) || !isset($_POST['subject']) || !isset($_POST['discipline'])):
            redirect("/user/profile/" . $profileID);
        endif;
        $subject = $_POST['subject'];
        $discipline = $_POST['discipline'];

        $this->load->model('subjectmodel');
        $this->load->model('usermodel');

        if ($this->subjectmodel->getSubject($subject) == NULL || $this->subjectmodel->getDiscipline($subject, $discipline) == NULL):
            redirect("/user/profile/" . $profileID);
        endif;

        $data = array(
            'idTutor' => $_SESSION['userID'],
            'idPredmet' => $subject,
            'idDisciplina' => $discipline,
            'cena' => $_POST['price']
        );
        $this->usermodel->addAdvert($data);
        redirect(site_url() . "/user/profile/" . $_SESSION['userID']);
    }

    public function addJob($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');

        $jobName = isset($_POST['jobName']) ? $_POST['jobName'] : "";
        if (strlen($jobName) > 45):
            $temp = substr($jobName, 0, 42);
            $jobName = $temp. "...";
        endif;
        $employer = isset($_POST['employer']) ? $_POST['employer'] : "";
        if (strlen($employer) > 45):
            $temp = substr($employer, 0, 42);
            $employer = $temp. "...";
        endif;
        $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : "";
        $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : "";
        $stillWorking = isset($_POST['stillWorking']) ? $_POST['stillWorking'] : false;

        $opis = isset($_POST['description'])? $_POST['description'] : "";
        
        if ($employer == "" || $jobName == "" || $startDate == "" || ($endDate == "" && $stillWorking == false)):
            redirect("/user/profile/" . $profileID);
        else:
            $work = array(
                'idTutor' => $profileID,
                'naziv' => $jobName,
                'poslodavac' => $employer,
                'period' => $startDate . " - " . ($stillWorking ? "Još Traje" : $endDate),
                'opis' => $opis
            );
            $this->usermodel->addWorkExperience($work);
            redirect("/user/profile/" . $profileID);
        endif;
    }

    public function addEducation($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');

        $school = isset($_POST['school']) ? $_POST['school'] : "";
        if (strlen($school) > 90):
            $temp = substr($school, 0, 87);
            $school = $temp. "...";
        endif;
        $name = isset($_POST['name']) ? $_POST['name'] : "";
        if (strlen($name) > 45):
            $temp = substr($name, 0, 42);
            $name = $temp. "...";
        endif;
        $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : "";
        $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : "";
        $ongoing = isset($_POST['ongoing']) ? $_POST['ongoing'] : false;

        $opis = isset($_POST['description'])? $_POST['description'] : "";
        
        if ($school == "" || $name == "" || $startDate == "" || ($endDate == "" && $ongoing == false)):
            redirect("/user/profile/" . $profileID);
        else:
            $education = array(
                'idTutor' => $profileID,
                'institucija' => $school,
                'nivo' => $name,
                'period' => $startDate . " - " . ($endDate == "" ? "Još Traje" : $endDate),
                'opis' => $opis
            );
            $this->usermodel->addEducation($education);
            redirect("/user/profile/" . $profileID);
        endif;
    }

    public function addCertificate($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');

        $institution = isset($_POST['institution']) ? $_POST['institution'] : "";
        if (strlen($institution) > 45):
            $temp = substr($institution, 0, 42);
            $institution = $temp. "...";
        endif;
        $name = isset($_POST['name']) ? $_POST['name'] : "";
        if (strlen($name) >=45):
            $temp = substr($name, 0, 42);
            $name = $temp. "...";
        endif;
        $expires = isset($_POST['expires']) ? $_POST['expires'] : "";

        if ($institution == "" || $name == "" || $expires == ""):
            redirect("/user/profile/" . $profileID);
        else:
            $certificate = array(
                'idTutor' => $profileID,
                'naziv' => $name,
                'ustanova' => $institution,
                'datum' => $expires,
            );
            $this->usermodel->addCertificate($certificate);
            redirect("/user/profile/" . $profileID);
        endif;
    }

    public function report($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('reportmodel');
        if (!isset($_SESSION['userID'])):
            show_404();
        endif;

        $reason = isset($_POST['reason']) ? $_POST['reason'] : "";
        if ($reason == ""):
            redirect("/user/profile/" . $profileID);
        else:
            $report = array(
                'idPosiljalac' => $_SESSION['userID'],
                'idPrimalac' => $profileID,
                'text' => $reason
            );
            $this->reportmodel->createReport($report);
            redirect("/user/profile/" . $profileID);
        endif;
    }

    public function removeAdvert($advertID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');
        //$this->load->model('subjectmodel');

        if (!isset($_SESSION['userID'])):
            show_404();
        endif;
        $this->usermodel->removeAdvert($advertID);
        redirect(site_url() . "/user/profile/" . $_SESSION['userID']);
    }

    public function removeJob($jobID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');
        //$this->load->model('subjectmodel');

        if (!isset($_SESSION['userID'])):
            show_404();
        endif;
        $this->usermodel->removeWorkExperience($jobID);
        redirect(site_url() . "/user/profile/" . $_SESSION['userID']);
    }

    public function removeEducation($jobID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');
        //$this->load->model('subjectmodel');

        if (!isset($_SESSION['userID'])):
            show_404();
        endif;
        $this->usermodel->removeEducation($jobID);
        redirect(site_url() . "/user/profile/" . $_SESSION['userID']);
    }

    public function removeCertificate($jobID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');
        //$this->load->model('subjectmodel');

        if (!isset($_SESSION['userID'])):
            show_404();
        endif;
        $this->usermodel->removeCertificate($jobID);
        redirect(site_url() . "/user/profile/" . $_SESSION['userID']);
    }

    public function sentence() {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])):
            return;
        endif;
        $reportID = $_POST['id'];
        $this->load->model('usermodel');
        if (!isset($_SESSION['userID']) || !$this->usermodel->isAdmin($_SESSION['userID'])):
            return;
        endif;
        $this->load->model('reportmodel');
        foreach ($this->reportmodel->getReports() as $report):
            if ($report['idPrijava'] == $reportID):
                $this->reportmodel->setMarkReport($reportID, $_SESSION['userID']);
                if ($this->usermodel->getBanned($report['idPrimalac'])):
                    $this->usermodel->unbanUser($report['idPrimalac']);
                else:
                    $this->usermodel->banUser($report['idPrimalac']);
                endif;
                break;
            endif;
        endforeach;
    }

    public function ban($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');
        if (!isset($_SESSION['userID']) || !$this->usermodel->isAdmin($_SESSION['userID'])):
            return;
        endif;
        $this->usermodel->banUser($profileID);
        redirect(site_url() . "/user/profile/" . $profileID);
    }

    public function unban($profileID) {
        if (isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');
        if (!isset($_SESSION['userID']) || !$this->usermodel->isAdmin($_SESSION['userID'])):
            return;
        endif;
        $this->usermodel->unbanUser($profileID);
        redirect(site_url() . "/user/profile/" . $profileID);
    }

}
