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
    public function _construct() {
        parent::_construct();
        $this->load->library('session');
        session_start();
        $this->load->helper('url_helper');
    }

    public function index() {
        
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('subjectmodel');
        $this->load->model('usermodel');
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
        $data['results'] = array(); 
        $data['results'][0] = array(
            'idTutor' => 71,
            'slika' => $this->usermodel->getImage(71),
            'ime' => $this->usermodel->getDisplayName(71),
            'ukupnaOcena' => $this->usermodel->getOverallRating(71)
        );
        $data['results'][1] = array(
            'idTutor' => 81,
            'slika' => $this->usermodel->getImage(81),
            'ime' => $this->usermodel->getDisplayName(81),
            'ukupnaOcena' => $this->usermodel->getOverallRating(81)
        );
        $data['results'][2] = array(
            'idTutor' => 91,
            'slika' => $this->usermodel->getImage(91),
            'ime' => $this->usermodel->getDisplayName(91),
            'ukupnaOcena' => $this->usermodel->getOverallRating(91)
        );
        
        $this->load->view('templates/header');
        $this->load->view('home/homeScripts');
        $this->load->view('templates/menubar');
        $this->load->view('home/home', $data);
        $this->load->view('templates/footer');
    }

    public function register($registerFailed = 0) {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (isset($_SESSION['userID'])):
            show_404();
        endif;
        $data['failed'] = $this->session->flashdata('failedRegister');
        $this->load->view('templates/header');
        $this->load->view('home/loginScripts');
        $this->load->view('templates/menubar');
        $this->load->view('home/register', $data);
        $this->load->view('templates/footer');
    }

    public function login($loginFailed = 0) {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (isset($_SESSION['userID'])):
            show_404();
        endif;
        $data['loginFailed'] = $loginFailed;
        $this->load->view('templates/header');
        $this->load->view('home/loginScripts');
        $this->load->view('templates/menubar');

        $this->load->view('home/login', $data);

        $this->load->view('templates/footer');
    }

    public function passwordRecovery($status = 0) {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (isset($_SESSION['userID'])):
            show_404();
        endif;
        $mail = isset($_POST['email']) ? $_POST['email'] : "";
        $data['status'] = $status;

        $this->load->view("templates/header");
        $this->load->view('home/loginScripts');
        $this->load->view("templates/menubar");
        $this->load->view("home/passwordrecovery", $data);
        $this->load->view("templates/footer");
    }

    public function attemtRecovery() {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (isset($_SESSION['userID'])):
            show_404();
        endif;
        $this->load->model('usermodel');
        if (!isset($_POST['email'])):
            show_404();
        endif;
        $email = $_POST['email'];
        $id = $this->usermodel->getIdByEmail($email);
        if ($id == NULL):
            redirect(site_url() . "/home/passwordRecovery/-1");
        endif;
        $_SESSION['recoverPasswordUserID'] = $id;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $argumentName = '';
        
        for ($i = 0; $i < 10; $i++):
            $argumentName .= $characters[rand(0, $charactersLength - 1)];
        endfor;
        
        $_SESSION['recoverPasswordArgumentName'] = $argumentName;
        
        $argumentValue = '';
        
        for ($i = 0; $i < 25; $i++):
            $argumentValue .= $characters[rand(0, 9)];
        endfor;
        
        $_SESSION['recoverPasswordArgumentValue'] = $argumentValue;
        
        $recoveryUrl = site_url()."/home/setNewPassword/".$argumentName."/".$argumentValue;
        
        file_put_contents("recovery", $recoveryUrl);
        
        redirect(site_url() . "/home/passwordRecovery/1");
    }

    public function setNewPassword($argumentName, $argumentValue, $failed = 0)
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (isset($_SESSION['userID'])):
            show_404();
        endif;
        if (isset($_SESSION['recoverPasswordUserID'])):
            if (isset($_SESSION['recoverPasswordArgumentName']) && $_SESSION['recoverPasswordArgumentName'] == $argumentName&& isset($_SESSION['recoverPasswordArgumentValue']) && $_SESSION['recoverPasswordArgumentValue'] ==$argumentValue):
                $data['failed'] = $failed;
                
                $this->load->view("templates/header");
                $this->load->view('home/loginScripts');
                $this->load->view("templates/menubar");
                $this->load->view("home/setNewPassword", $data);
                $this->load->view("templates/footer");
            else:
                show_404();
            endif;
        else:
            show_404();
        endif;
        
    }
    
    public function attemptSetNewPassowrd()
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (!isset($_SESSION['recoverPasswordUserID'])):
            show_404();
        endif;
        
        $failed = 0;
        if (!isset($_POST['pass'])):
            $failed |= EMPTYPASSWORD;
        endif;
        if (!isset($_POST['pass1'])):
            $failed |= EMPTYPASSWORDCONFIRM;
        endif;
        
        $pass = $_POST['pass'];
        $pass1 = $_POST['pass1'];
        
        $this->load->library('validation');
        
        if(!$this->validation->Password($pass)):
            $failed |= PASSWORDFORMAT;
        endif;
        
        if(!$this->validation->PasswordMatch($pass, $pass1)):
            $failed |= PASSWORDMATCH;
        endif;
        
        if ($failed == 0):
            $this->load->model('usermodel');
            $this->usermodel->changePassword($_SESSION['recoverPasswordUserID'], $pass);
            
            $_SESSION['userID'] = $_SESSION['recoverPasswordUserID'];
            $_SESSION['userName'] = $this->usermodel->getDisplayName($_SESSION['userID']);
            
            unset($_SESSION['recoverPasswordUserID']);
            
            $this->index();
        else:
            $this->setNewPassword($_SESSION['recoverPasswordArgumentName'], $_SESSION['recoverPasswordArgumentValue'], $failed);
        endif;  
    }

    public function attemptLogIn() {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (isset($_SESSION['userID'])):
            show_404();
        endif;
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $notFilled = !isset($email) || !isset($pass);
        if ($notFilled):
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
                //redirect(site_url() . '/home');
                $this->index();
            endif;
        endif;
    }

    public function attemptReister() {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (isset($_SESSION['userID'])):
            show_404();
        endif;
        $this->load->library('validation');
        $this->load->model('UserModel');
        $failed = 0;
        switch ($_POST['submit']):
            case 'student':
                if (!isset($_POST['nick']) || !$this->validation->NickName($_POST['nick'])):
                    $failed |= NICKNAME;
                endif;
                $nick = $_POST['nick'];
                if (!isset($_POST['pass']) || !$this->validation->Password($_POST['pass'])):
                    $failed |= PASSWORDFORMAT;
                endif;
                $pass = $_POST['pass'];
                if (!isset($_POST['pass2']) || !$this->validation->PasswordMatch($pass, $_POST['pass2'])):
                    $failed |= PASSWORDMATCH;
                endif;
                $pass2 = $_POST['pass2'];
                if (!isset($_POST['email']) || !$this->validation->Email($_POST['email'])):
                    $failed |= EMAILFORMAT;
                elseif ($this->UserModel->getIdByEmail($_POST['email']) != NULL):
                    $failed |= EMAIL;
                endif;
                $email = $_POST['email'];
                if (!$this->validation->NickName($nick)):
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

                    redirect(site_url() . '/home/index');
                //$this->index();
                else:
                    $this->session->set_flashdata('failedRegister', $failed);
                    redirect(site_url() . '/home/register');
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
                if (!isset($_POST['pass2']) || !$this->validation->PasswordMatch($pass, $_POST['pass2'])):
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
                    //user didn't come here through our register form, or there was an error
                    show_404();
                endif;
                $city = $_POST['city'];

                $phone = $_POST['phone'];
                
                if ($failed == TUTOR):
                    $user = array(
                        'ime' => $fname,
                        'prezime' => $lname,
                        'email' => $email,
                        'sifra' => $pass
                    );
                    $userID = $this->UserModel->createTutor($user);
                    
                    $this->UserModel->setContact($userID, $phone);
                    $this->UserModel->setRegion($userID, $city);
                    
                    $_SESSION['userID'] = $userID;
                    $_SESSION['userName'] = $this->UserModel->getDisplayName($userID);

                    redirect(site_url() . '/home/index');
                //$this->index();
                else:
                    $this->session->set_flashdata('failedRegister', $failed);
                    redirect(site_url() . '/home/register');
                //$this->register($failed);
                endif;
                break;
        endswitch;
    }

    public function logOut() {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (isset($_SESSION['userID'])):
            unset($_SESSION['userID']);
        endif;
        if (isset($_SESSION['userName'])):
            unset($_SESSION['userName']);
        endif;
        redirect(site_url() . '/home');
    }
}
