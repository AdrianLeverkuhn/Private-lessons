<!--sa130068-->
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
        
        public function _construct()
        {
            parent::_construct();
            $this->load->library('session');
            session_start();
            $this->load->helper('url_helper');
        }
    
    
	public function index()
	{
            $this->load->model('subjectmodel');
            $search = array(
                'minCena' => NULL,
                'maxCena' => NULL,
                'idPredmet' => NULL,
                'idDisciplina' => NULL,
                'naAdresu' => NULL,
                'onlineCasove' => NULL,
                'grupneCasove' => NULL,
                'poOpadajucojCeni' => false,
                'poRastucojCeni' => false,
                'poOceni' => true,
                'poRelevantnosti' => false,
                'pretraga' => "",
                'banovan' => false
            );
            $data['results'] = array();//$this->subjectmodel->getTutorsByCriteria($search);
            $this->load->view('templates/header');
            $this->load->view('home/homeScripts');
            $this->load->view('templates/menubar');
            $this->load->view('home/home', $data);
            $this->load->view('templates/footer');
	}
        
        public function register($registerFailed = 0)
        {
            $data['failed'] = $this->session->flashdata('failedRegister');
            $this->load->view('templates/header');
            $this->load->view('home/loginScripts');
            $this->load->view('templates/menubar');
            $this->load->view('home/register', $data);
            $this->load->view('templates/footer');
        }
        
        public function login($loginFailed = 0)
        {
            $data['loginFailed'] = $loginFailed;
            $this->load->view('templates/header');
            $this->load->view('home/loginScripts');
            $this->load->view('templates/menubar');
            
            $this->load->view('home/login', $data);
            
            $this->load->view('templates/footer');
        }
		
		public function passwordRecovery($status = 0)
		{
			if (!isset($_SESSION['userID'])):
				show_404();
			endif;
			$mail = isset($_POST['email'])? $_POST['email'] : "";
			$data['recoveryFailed'] = $status;
			
			$this->load->view("templates/header");
			$this->load->view("templates/menubar");
			$this->load->view("user/passwordrecovery", $data);
			$this->load->view("templates/footer");
		}
		
		public function attemtRecovery($email)
		{
			$this->load->model('usermodel');
			$id = $this->usermodel->getIdByEmal($email);
			if ($id == NULL || !isset($_SESSION['userID'])):
				show_404();
			endif;
			/*
				INSERT SLANJE MEJLA
			*/
			redirect(site_url()."/home/passwordRecovery/1");
		}
        
        private function emailWrongFormat($email)
        {
            return preg_match('/^[a-zA-Z\d]+@[a-z]+.[a-z]+$/', $email) == 0;
        }
        
        private function passwordWrongFormat($pass)
        {
            return false;//!$pass == $pass;// && regex
        }
        
        private function passwordsNoMatch($pass, $pass2)
        {
            return $pass != $pass2;
        }
        
        private function nameWrongFormat($fname, $lname)
        {
            return preg_match('/^[a-zA-Z\s]*$/', $fname) == 0 &&
                   preg_match('/^[a-zA-Z\s]*$/', $lname) == 0;
        }
        
        /**
         * Checks if nick is in valid format.
         * 
         * FORMAT:
         * -Begin with letter;
         * -Contain only letters and numbers
         * @param string $nick to be checked
         * @return bool FALSE: if good format TRUE: if error
         */
        private function nickWrongFormat($nick)
        {
            return preg_match('/^[a-zA-Z][a-zA-Z\d]*$/', $nick) == 0;
        }
        
        public function attemptLogIn()
        {
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $notFilled = !isset($email) || !isset($pass);
            if ($notFilled):
                $this->login(1);
            elseif ($this->emailWrongFormat($email)):
                $this->login(1);
            else:
                $this->load->model('usermodel');
                $user = $this->usermodel->login($email, $pass);
                if (!isset($user) || $user == NULL || $user == 'banned'):
                    $this->login(1);
                elseif ($this->usermodel->getBanned($user)):
                    $this->login(-1);
                else:
                    $_SESSION['userID'] = $user;
                    $_SESSION['userName'] = $this->usermodel->getDisplayName($user);
                    redirect(site_url().'/home');
                endif;
            endif;
        }
        
        public function attemptReister()
        {
            $this->load->library('validation');
            $this->load->model('UserModel');
            $failed = 0;
            switch($_POST['submit']):
                case 'student':
                    if (!isset($_POST['nick']) || !$this->validation->NickName($_POST['nick'])):
                        $failed |= NICKNAME;
                    endif;
                    $nick = $_POST['nick'];
                    if (!isset($_POST['pass']) || !$this->validation->Password($_POST['pass'])):
                        $failed |= PASSWORDFORMAT;
                    endif;
                    $pass = $_POST['pass'];
                    if (!isset($_POST['pass2']) || $this->passwordsNoMatch($pass, $_POST['pass2'])):
                        $failed |= PASSWORDMATCH;
                    endif;
                    $pass2 = $_POST['pass2'];
                    if (!isset($_POST['email']) || !$this->validation->Email($_POST['email'])):
                        $failed |= EMAILFORMAT;
                    elseif ($this->UserModel->getIdByEmail($_POST['email']) != NULL):
                        $failed |= EMAIL;
                    endif;
                    $email = $_POST['email'];
                    if ($this->nickWrongFormat($nick)):
                        $failed |= NICKNAME;
                    endif;
                    if ($failed == 0):
                        $user = array(
                            'nadimak' => $nick,
                            'email' => $email,
                            'sifra' => $pass
                        );
                        $userID = $this->UserModel->createUser($user);
                        $_SESSION['userID'] = $userID;
                        $_SESSION['userName'] = $this->UserModel->getDisplayName($userID);
                        
                        redirect(site_url().'/home/index');
                        //$this->index();
                    else:
                        $this->session->set_flashdata('failedRegister', $failed);
                        redirect(site_url().'/home/register');
                        //$this->register($failed);
                    endif;
                break;
                case 'tutor':
                    $failed = TUTOR;
                    if (!isset($_POST['ime']) || !$this->validation->Name($_POST['ime'])):
                        $failed != REALNAME;
                    endif;
                    $fname = $_POST['ime'];
                    if (!isset($_POST['prezime']) || !$this->validation->Name($_POST['ime'])):
                        $failed != REALNAME;
                    endif;
                    $lname = $_POST['prezime'];
                    if (!isset($_POST['pass']) || !$this->validation->Password($_POST['pass'])):
                        $failed |= PASSWORDFORMAT;
                    endif;
                    $pass = $_POST['pass'];
                    if (!isset($_POST['pass2']) || $this->passwordsNoMatch($pass, $_POST['pass2'])):
                        $failed |= PASSWORDMATCH;
                    endif;
                    $pass2 = $_POST['pass2'];
                    if (!isset($_POST['email']) || !$this->validation->Email($_POST['email'])):
                        $failed |= EMAILFORMAT;
                    elseif ($this->UserModel->getIdByEmail($_POST['email']) != NULL):
                        $failed |= EMAIL;
                    endif;
                    $email = $_POST['email'];
                    if (!isset($_POST['city'])):
                        $failed |= PASSWORDMATCH;
                    endif;
                    $city = $_POST['city'];
                    if (!isset($_POST['phone']) || !$this->validation->Phone($_POST['phone'])):
                        $failed |= PASSWORDMATCH;
                    endif;
                    $phone = $_POST['phone'];
                    
                    
                    if ($failed == TUTOR):
                        $user = array(
                            'ime' => $fname,
                            'prezime' => $lname,
                            'email' => $email,
                            'sifra' => $pass
                        );
                        $userID = $this->UserModel->createTutor($user);
                        $_SESSION['userID'] = $userID;
                        $_SESSION['userName'] = $this->UserModel->getDisplayName($user);
                        
                        redirect(site_url().'/home/index');
                        //$this->index();
                    else:
                        $this->session->set_flashdata('failedRegister', $failed);
                        redirect(site_url().'/home/register');
                        //$this->register($failed);
                    endif;
                break;
            endswitch;
        }
        
        public function logOut()
        {
            if (isset($_SESSION['userID'])):
                unset($_SESSION['userID']);
            endif;
            if(isset($_SESSION['userName'])):
                unset($_SESSION['userName']);
            endif;
            redirect(site_url().'/home');
        }
}
