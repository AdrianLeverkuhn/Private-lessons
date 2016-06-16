<?php

class Home_test extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $_POST = array();
    }
    
    public function test_login_correct()
    {
        $output = $this->request('POST', 'home/attemptLogIn', array(
            'email' => 'nesto@nesto.com',
            'pass' => 'nestonesto',
        ));
        
        $this->assertContains(
            '>tutor tutoric</a>', $output
        );
    }
    
    public function test_login_incorrect()
    {
        $output = $this->request('POST', 'home/attemptLogIn', array(
            'email' => 'nesto@nesto.com',
            'pass' => 'nestonesto1',
        ));
        
        
        $this->assertContains(
            '<div class="error-message">Kombinacija e-mail - lozinka je pogrešna</div>', $output
        );
    }
}