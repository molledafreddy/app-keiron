<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $search    = '';
        $orderBy   = $request->orderBy == null ? 'id' : $request->orderBy;
        $type      = $request->type == 'true' ? 'DESC' : 'ASC';
        $perPage   = $request->perPage == null ? 10 : $request->perPage;
        
        if (!empty($request->search)) {
            $search = $request->search;
        }

        $tickets = Ticket::with('user')->search($search)->orderBy($orderBy, $type)->paginate($perPage);
        
        return response()->json(['status' => 'ok', 'data' => $tickets], 200);
    }

    public function getTickets()
    {

        $tickets = Ticket::all()->take(14);

        return response()->json(['status' => 'ok', 'data' => $tickets], 201);
    }

    public function store(Request $request)
    {
        $messages = [
            'ticket_pedido'  => 'Only the options in the list are allowed.',
        ];
        $validator = \Validator::make(
            $request->all(),
            [
                'ticket_pedido' => 'required|in:free,requested,assigned'
            ],
            $messages
        );
        if ($validator->fails()) {
            return response()->json(['status' => 'ok', 'data' => $validator->errors()->all()], 422);
        }
        $ticket                = new Ticket();
        $ticket->user_id       = $request->input('user_id');
        $ticket->ticket_pedido = $request->input('ticket_pedido');
        $ticket->save();

        return response()->json(['status' => 'ok', 'data' => $ticket], 201);
    }

    public function show(Ticket $ticket)
    {
        return response()->json(['status' => 'ok', 'data' => $ticket], 200);
    }

    public function solicitTicket(Request $request, Ticket $ticket)
    {
        
        if ($ticket->ticket_pedido != 'free') {
            return response()->json(['status' => 'ok', 'data' => 'Cannot request the ticket'], 422);
        }
        $ticket->user_id       = $request->input('user_id');
        $ticket->ticket_pedido =  'requested';
        $ticket->save();

        return response()->json(['status' => 'ok', 'data' => $ticket], 201);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $messages = [
            'ticket_pedido'      => 'Only the options in the list are allowed.',
        ];
        $validator = \Validator::make(
            $request->all(),
            [
                'ticket_pedido'     => 'required|in:free,requested,assigned'
            ],
            $messages
        );
        if ($validator->fails()) {
            response()->json(['status' => 'ok', 'data' => $validator->errors()->all()], 422);
        }
        
        $ticket->user_id       = $request->input('user_id');
        $ticket->ticket_pedido =  $request->input('ticket_pedido');
        $ticket->save();

        return response()->json(['status' => 'ok', 'data' => $ticket], 201);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->json(['status' => 'ok', 'data' => $ticket], 200);
    }
        
}
