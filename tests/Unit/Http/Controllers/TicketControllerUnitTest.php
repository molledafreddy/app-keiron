<?php declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\TicketController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Ticket;
use App\User;

class TicketControllerUnitTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->controller = new TicketController;

        $this->user = factory(\App\User::class)->create();
        $this->ticket = factory(\App\Ticket::class)->create();
        
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


    public function testTicketSuccessAndNullTickets()
    {
        $this->be($this->user);
        $response = $this->controller->show($this->ticket);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($this->ticket->id, json_decode($response->getContent())->data->id);
    
    }

    public function testIndexAllParametersSearchTicketPedidoTrueSuccess()
    {
        $this->be($this->user);
        factory(\App\Ticket::class, 10)->create();
        
        $this->requestSearch['search'] = $this->ticket->ticket_pedido;
        
        $response = $this->controller->index($this->requestSearch);
        
        $this->assertEquals(200, $response->getStatusCode());
    
    }

    public function testIndexNullParametersSuccess()
    {
        $this->be($this->user);
        factory(\App\Ticket::class, 10)->create();
        $response = $this->controller->index($this->requestSearch);
        $this->assertEquals(200, $response->getStatusCode());

    }

    public function testupdateFailNoDifferentValue()
    {
        $this->be($this->user);
        $user = User::first();
        $this->request['user_id']  = $user->id;
        
        $response = $this->controller->update($this->request, $this->ticket);
        
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('ok', json_decode($response->getContent())->status);
    }

    
    public function testStoreTicketSuccessfull()
    {
        $this->be($this->user);
        $response = $this->controller->store($this->request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($this->request->user_id, json_decode($response->getContent())->data->user_id);
        $this->assertEquals('free', json_decode($response->getContent())->data->ticket_pedido);
    }

    public function testStoreTicketNullFailed()
    {
        $this->request['user_id']       = null;
        $this->request['ticket_pedido'] = null;
        $this->be($this->user);
        $response = $this->controller->store($this->request);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals('The ticket pedido field is required.', json_decode($response->getContent())->data[0]);
    }

    public function testDeleteSuccessfull()
    {
        $this->be($this->user);
        $response = $this->controller->destroy($this->ticket);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertSoftDeleted('tickets', ['id' => json_decode($response->getContent())->data->id]);
    }

}//end class
