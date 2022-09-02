<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Userdetail;

class loginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $this->assertTrue(true);
    // }

    public function test_checkIfUserCanViewTheLoginPage()
    {
        $check = $this->get('/login');
        $check->assertStatus(200); //ok
    }

    public function test_checkIfUserCanViewTheLoginPageWithDifferentMethod()
    {
        $check = $this->post('/login');
        $check->assertStatus(405); //method not allowed
    }

    public function test_user_login_with_admin_credential()
    {
        $response = $this->post('/getdata', [
            'email'=> 'meera94191@gmail.com',
            'password' => 'meera'
        ]);
        $response->assertStatus(302); //redirect
        $response->assertRedirect('/admin');
    }

    public function test_user_login_with_agent_credential()
    {
        $data = [
            'email' => 'lakshya.anand@ladybirdweb.com',
            'password' => 'lakshya'
        ]; 
        $response = $this->post('/getdata', $data);
        $response->assertStatus(302);
        $response->assertRedirect('/agent');
    }

    public function test_check_if_user_login_without_credentials()
    {
        $response = $this->post('/getdata', [
            'email'=> '',
            'password' => ''
        ]);
        $response->assertInvalid(['email', 'password']);    // assertInvalid is used for validation using validator
        $response->assertStatus(302);
        // $response->assertRedirect('/login');
    }

    public function test_check_if_user_login_with_wrong_email()
    {
        $response = $this->post('/getdata', [
            'email'=> 'abc@gmail.com',
            'password' => '123'
        ]);
        $response->assertSee('Invalid email', $escaped = true);
        $response->assertStatus(200);
    }

    public function test_check_if_user_login_with_wrong_password()
    {
        $response = $this->post('/getdata', [
            'email'=> 'lakshya.anand@ladybirdweb.com',
            'password' => '123'
        ]);
        $response->assertSee('Invalid password', $escaped = true);
        $response->assertStatus(200);
    }

    public function test_check_admin_can_view_the_addagents_page()
    {
        $response = $this->withSession(['role'=>'Admin'])->get('/addagents');
        $response->assertStatus(200);
    }

    public function test_add_agent_without_email()
    {
        $response = $this->withSession(['role'=>'Admin'])->post('/addagent',[
            'email'=>'',
            'name'=>''
        ]);
        $response->assertInvalid(['email', 'name']);
        $response->assertStatus(302);
    }

    public function test_add_agent_without_name()
    {
        $response = $this->withSession(['role'=>'Admin'])->post('/addagent',[
            'email'=>'abc@gmail.com',
            'name'=>''
        ]);
        $response->assertInvalid(['name']);
        $response->assertStatus(302);
    }

    public function test_add_agent_with_existing_email()
    {
        $response = $this->withSession(['role'=>'Admin'])->post('/addagent',[
            'email'=>'lakshya.anand@ladybirdweb.com',
            'name'=>'lak'
        ]);
        $response->assertInvalid(['email']);
        $response->assertStatus(302);
        // $response->assertRedirect('/addagents');
    }

    public function test_add_agent_and_delete_agent()
    {
        $data = [
            'email'=>'amzad.choudhary@ladybirdweb.com',
            'name'=>'amzad'
        ];
        $response = $this->withSession(['role'=>'Admin'])->post('/addagent', $data);
        $response->assertStatus(200); // 200 for the first time when the agent was not added in the db. After the agent was added then  it will be 302
        $response->assertSee('Agent added successfully', $escaped = true);   // assertSee will not use in redirect, it only use in view
            $this->assertDatabaseHas('userdetails', $data);

        $userdetail = Userdetail::where('email','amzad.choudhary@ladybirdweb.com')->get()->first();
        $id = $userdetail->id;
        $response = $this->withSession(['role'=>'Admin'])->get('/deleteagent/'.$id);    //
        $response->assertStatus(302);
        $response->assertRedirect('/admin');
            $this->assertDatabaseMissing('userdetails', $data);
    }


    // public function test_checkAgent()
    // {
    //     $response = $this->get('/agent');
    //     $response->assertStatus(302); //redirect to login without adding the information
    // }

    // public function test_checkSession()
    // {
    //     $response = $this->withSession(['role'=>'Admin'])->get("/admin");
    //     $response->assertStatus(200);
    // }

    // public function test_cannotReturnToLoginPageWithSession()
    // {
    //     $response = $this->withSession(['role'=>'Admin'])->get("/login");
    //     $response->assertStatus(302);
    //     $response->assertRedirect('admin');
    // }
    
}
