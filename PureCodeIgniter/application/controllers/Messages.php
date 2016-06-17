<!--sa130068-->
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller
{
    public function _construct()
    {
        parent::_construct();
        session_start();
        $this->load->helper('url_helper');
    }
    
    public function index($page = 1)
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (!isset($_SESSION['userID'])):
            show_404();
        endif;
        $profileID = $_SESSION['userID'];
        $this->load->model('messagemodel');
        $this->load->model('usermodel');
        $messages = $this->messagemodel->getMessages($profileID);
        $cnt = sizeof($messages) - 1;
        $data['messages'] = array();
        foreach($messages as $message):
            $data['messages'][$cnt] = array(
                'senderId' => $message['idPosiljalac'],
                'senderName' => $this->usermodel->getDisplayName($message['idPosiljalac']),
                'subject' => $message['subjekat'],
                'dateSent' => $message['datum'],
                'idPoruka' => $message['idPoruka'],
                'read' => $message['procitana'],
            );
            $cnt--;
        endforeach;
        if (isset($_SESSION['userID'])):
            $data['numOfMessages'] = $this->unreadMessages(($_SESSION['userID']));
            $data['numOfReports'] = $this->unreadReports(($_SESSION['userID']));
        endif;
        $data['isAdmin'] = $this->usermodel->isAdmin($_SESSION['userID']);
        $data['fail'] = isset($_SESSION['failedSend'])? $_SESSION['failedSend']: 0;
        unset($_SESSION['failedSend']);
        $data['page'] = $page;
        $data['total'] = ceil(sizeof($messages) / 10);
        
        $this->load->view("templates/header");
        $this->load->view("messages/inboxscripts");
        $this->load->view("templates/menubar");
        $this->load->view("messages/inbox", $data);
        $this->load->view("templates/footer");
    }
    
    public function inbox($page = 1)
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->index($page);
    }
    
    public function send($profileID)
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (isset($_SESSION['userID']) && isset($_POST['subject'])):
            $message = array(
            'primaoci' => array($profileID),
            'text' => isset($_POST['text']) ? $_POST['text'] : "",
            'subjekat' => $_POST['subject'],
            'idPosiljalac' => $_SESSION['userID'],
            );
            $this->load->model('messagemodel');
            $this->messagemodel->createMessage($message);
            redirect(site_url()."/user/profile/".$profileID);
        endif;
        redirect(site_url()."/user/profile/".$profileID);
    }
    
    public function sendByName($page)
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (!isset($_SESSION['userID']) || !isset($_POST['subject']) || !isset($_POST['sendTo']) || !isset($_POST['content'])):
            show_404();
        endif;
        $name = $_POST['sendTo'];
        $subject = $_POST['subject'];
        $content = $_POST['content'];
        
        if ($subject == "" || $name == "" || $content == ""):
            show_404();
        endif;
        
        $this->load->model('usermodel');
        $id = $this->usermodel->getIdByDisplayName($name);
        $fail = 0;
        if ($id == NULL):
            $fail = 1;
        else:
            $this->load->model('messagemodel');
            $message = array(
                'idPosiljalac' => $_SESSION['userID'],
                'subjekat' => $subject,
                'text' => $content,
                'primaoci' => array($id)
            );
            $this->messagemodel->createMessage($message);
        endif;
        $_SESSION['failedSend'] = $fail;
        redirect(site_url()."/messages/inbox/".$page);
    }
    
    public function getMessageBody()
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if(!isset($_SESSION['userID'])):
            return;
        endif;
        $this->load->model('messagemodel');
        $id = $_POST['id'];
        
        if (isset($id) && is_numeric($id)):
            $body = $this->messagemodel->getMessageText($id);
            $this->messagemodel->setMessageRead($_SESSION['userID'], $id);
            echo $body;
        endif;
    }
    
    public function getReportText()
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('reportmodel');
        $id = $_POST['id'];
        
        if (isset($id) && is_numeric($id)):
            $body = $this->reportmodel->getReportText($id);
            echo $body;
        endif;
    }
    
    public function getReportBanned()
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('reportmodel');
        $this->load->model('usermodel');
        $id = $_POST['id'];
        
        if (isset($id) && is_numeric($id)):
            foreach($this->reportmodel->getReports() as $report):
                if ($report['idPrijava'] == $id):
                    echo ($this->usermodel->getBanned($report['idPrimalac']) === TRUE? "Unban" : "Ban");
                return;
                endif;
            endforeach;
        endif;
        echo"err";
    }
    
    public function reports($page = 1)
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('usermodel');
        if (!isset($_SESSION['userID']) || !$this->usermodel->isAdmin($_SESSION['userID'])):
            show_404();
            return;
        endif;
        if (isset($_SESSION['userID'])):
            $data['numOfMessages'] = $this->unreadMessages(($_SESSION['userID']));
            $data['numOfReports'] = $this->unreadReports(($_SESSION['userID']));
        endif;
        $this->load->model('reportmodel');
        $reports = $this->reportmodel->getReports();
        $data['reports'] = array();
        $data['page'] = $page;
        $data['total'] = ceil(sizeof($reports) / 10);
        $cnt = sizeof($reports) - 1;
        foreach($reports as $report):
            $data['reports'][$cnt] = array(
                'idReport' => $report['idPrijava'],
                'idReported' => $report['idPrimalac'],
                'read' => $report['idAdmin'] != NULL,
                'nameReported' => $this->usermodel->getDisplayName($report['idPrimalac']),
                'date' => $report['datum'],
                'nameReporting' => $this->usermodel->getDisplayName($report['idPosiljalac']),
            );
            $cnt--;
        endforeach;
        $this->load->view("templates/header");
        $this->load->view("messages/inboxscripts");
        $this->load->view("templates/menubar");
        $this->load->view("messages/reports", $data);
        $this->load->view("templates/footer");
    }
    
    public function reply($profileID)
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        if (!isset($_SESSION['userID'])):
            show_404();
        endif;
        $this->load->model('messagemodel');
        $message = array(
            'idPosiljalac' => $_SESSION['userID'],
            'subjekat' => (strpos($_POST['subject'], "RE: ") === 0) ? "Re: ".$_POST['subject']: $_POST['subject'],
            'text' => $_POST['text'],
            'primaoci' => array($profileID)
        );
        $this->messagemodel->createMessage($message);
        redirect(site_url()."/messages/inbox");
    }
    
    private function unreadMessages($profileID)
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('messagemodel');
        $messages = $this->messagemodel->getMessages($profileID);
        $cnt = 0;
        foreach($messages as $message):
            $cnt += $message['procitana'];
        endforeach;
        return $cnt;
    }
    
    private function unreadReports($profileID)
    {
        if(isset($_SESSION['initialSearcgString'])):
            unset($_SESSION['initialSearcgString']);
        endif;
        $this->load->model('reportmodel');
        $messages = $this->reportmodel->getReports($profileID);
        $cnt = 0;
        foreach($messages as $message):
            $cnt += $message['idAdmin'] == NULL;
        endforeach;
        return $cnt;
    }
};