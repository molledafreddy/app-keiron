<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\User;

class AuthControllerUnitTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');

    }//end setUp()

    public function testLoginUserSuccessful()
    {
        $controller     = new AuthController;
        $user = factory(\App\User::class, 1)->create()->first();
        $user->password = bcrypt('12345678');
        $user->email = $this->faker->email;
        $user->save();

        $request  = new Request(
            [
                'email' => $user->email,
                'password' => 'secret',
            ]
        );
        $response = $controller->login($request);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($user->email, json_decode($response->getContent())->user->emai);

    }//end testLoginUserSuccessful()


    // public function testLoginUserFaild()
    // {
    //     $controller = new AuthController;

    //     $request  = new Request(
    //         [
    //             'email'    => '',
    //             'password' => '',
    //         ]
    //     );
    //     $response = $controller->login($request);
    //     $this->assertEquals(401, $response->getStatusCode());
    //     $this->assertEquals('Unauthorised', json_decode($response->getContent())->error);

    // }//end testLoginUserFaild()


}//end class
