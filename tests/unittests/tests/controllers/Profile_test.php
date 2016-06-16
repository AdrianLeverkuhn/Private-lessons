<?php

class Profile_test extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $_POST = array();
    }
    
    public function test_has_rating()
    {
        $output = $this->request('POST', 'user/profile/1');
        
        $this->assertContains(
            '<p>glupan</p>', $output
        );
    }
    
    public function test_has_biography()
    {
        $output = $this->request('POST', 'user/profile/1');
        
        $this->assertContains(
            '<p>ekrgnfxsdfhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh</p>', $output
        );
    }
}