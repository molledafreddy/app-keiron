<?php declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Ticket;
use App\User;

class UserControllerUnitTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->controller = new UserController;

        $this->user = factory(\App\User::class)->create();
        
        $this->request = new Request(
            [
                'user_id'        => $this->user->id,
                'ticket_pedido'  => 'free'
            ]
        );

        $this->requestSearch = new Request(
            [
                'type'          => 'DESC',
                'perPage'       => 10,
                'orderBy'       => 'id',
                'search'        => ''
            ]
        );

        

    }//end setUp()


    public function testIndexAllParametersSearchTicketPedidoTrueSuccess()
    {
        $this->be($this->user);
        factory(\App\User::class, 10)->create();
        
        $response = $this->controller->index($this->requestSearch);

        $this->assertEquals(200, $response->getStatusCode());
    
    }

    
}//end class
