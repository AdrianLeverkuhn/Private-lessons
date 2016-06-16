<?php

class Search_test extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $_POST = array();
    }
    
    public function test_search_all()
    {
        $output = $this->request('POST', 'search/index', array(
            'city' => 'Beograd',
        ));
        
        $this->assertContains(
            '>500</div>', $output
        );
    }
    
    public function test_search_min_price_1000()
    {
        $output = $this->request('POST', 'search/index', array(
            'cenaMin' => '1000',
            'city' => 'Beograd',
        ));
        
        
        $this->assertNotContains(
            '>500</div>', $output
        );
    }
}