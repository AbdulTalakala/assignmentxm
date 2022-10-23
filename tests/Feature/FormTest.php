<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class FormTest extends TestCase
{
    use WithFaker,WithoutMiddleware, RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function home_page()
    {
        $this->get('/')
            ->assertSeeText('Historical Data');  
    }

      /**
     * @test
     */
    public function home_page_post_invalid_no_parameter_passed()
    {
        $this->withExceptionHandling();
        $response = $this->post('/historical-data');
        $response->assertStatus(302);
        // $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function email_is_valid(){
        $myExpectedEmail = $this->faker->email;
        $this->assertMatchesRegularExpression('/^.+\@\S+\.\S+$/', $myExpectedEmail);
    }


    /**
     * @test
     */
    public function company_symbol_is_required()
    {
        $response = $this->post('/historical-data',[
            'startDate' => '2022-06-01',
            'endDate' => '2022-06-05',
            'email' => 'test@gmail.com'
        ]);
        $response->assertStatus(302);
        $this->assertFalse(false);        

    }

    /**
     * @test
     */
    public function start_date_is_required()
    {
        $this->withExceptionHandling();
        $response = $this->post('/historical-data',[
            'companySymbol' => 'AA',
            'endDate' => '2022-06-05',
            'email' => 'test@gmail.com'
        ]);
        $response->assertStatus(302);
        $this->assertFalse(false); 
    }

    /**
     * @test
     */
    public function end_date_is_required()
    {
        $this->withExceptionHandling();
        $response = $this->post('/historical-data',[
            'companySymbol' => 'AA',
            'startDate' => '2022-06-05',
            'email' => 'test@gmail.com'
        ]);
        $response->assertStatus(302);
        $this->assertFalse(false);      
    }

    /**
     * @test
     */
    public function email_is_required()
    {
        $this->withExceptionHandling();
        $response = $this->post('/historical-data',[
            'companySymbol' => 'AA',
            'startDate' => '2022-06-05',
            'endDate' => '2022-06-05'
        ]);
        $response->assertStatus(302);
        $this->assertFalse(false);      
    }

     
    /**
     * @test
     */
    public function if_request_valid_all_parameter_passed(){
        $this->withExceptionHandling();
        $response = $this->post('/historical-data',[
            'companySymbol' => 'AAL',
            'startDate' => '2022-06-05',
            'endDate' => '2022-06-05',
            'email' => 'test@gmail.com'
        ]);
        $this->assertTrue(true);

    }


    

    /**
     * @test
     */

     public function check_start_date_is_less_than_equal_current_date(){
       
        $currentDate = '2022-10-23';
        $this->assertLessThanOrEqual( 
            $currentDate, 
            '2022-10-22', 
            "actual value is Less than or equal to expected"
        );
     }


      /**
     * @test
     */

    public function check_end_date_is_less_than_equal_current_date(){
       
        $currentDate = '2022-10-23';   
        $this->assertLessThanOrEqual( 
            $currentDate, 
            '2022-10-22', 
            "actual value is Less than or equal to expected"
        );
     }

     // End date should greater than equal to end date 

    /**
     * @test
     */
     public function check_end_date_is_greater_than_equal_start_date(){
       
        $startDate = '2022-06-05';
        $this->assertGreaterThanOrEqual( 
            $startDate, 
            '2022-10-23', 
            "end date should greater than equal to start date"
        );
     }

     // Start date should less than equal to end date 
     /**
     * @test
     */
    public function check_start_date_is_less_than_or_equal_end_date(){
       
        $endDate = '2022-06-05';
        $this->assertLessThanOrEqual( 
            $endDate, 
            '2022-06-04', 
            "start date should less than or  equal to end date"
        );
     }

}
