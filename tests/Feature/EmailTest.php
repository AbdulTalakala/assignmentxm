<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mail;
use App\Mail\CompanyMail;

class EmailTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     /** @test */
    public function it_send_email()
    {
        Mail::fake();
        
        $data = ["CompanySymbol"=>$this->faker->name,'startDate'=>$this->faker->date,'endDate'=>$this->faker->date];
        Mail::to($this->faker->email)->send(new CompanyMail($data));
        Mail::assertSent(CompanyMail::class);
    }
}
