<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\EditTicketRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\AssigneeChange;
use App\Notifications\StatusChange;

class TicketController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Builder $builder)
    {
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => "No", 'render' => null, 'orderable' => false, 'searchable' => false],
            ['data' => 'title', 'name' => 'title', 'title' => "Title"],
            ['data' => 'status', 'name' => 'status', 'title' => "Status"],
            ['data' => 'created_date', 'name' => 'created_date', 'title' => "Created Date"],
            ['data' => 'action', 'name' => 'action', 'title' => "Action", 'orderable' => false, 'searchable' => false],
        ])->ajax([
            'url' => route('ticket.datatable.list'),
            'type' => 'POST',
            'headers' => ['X-CSRF-TOKEN' => csrf_token()],
            'data' => 'function(d) {
                d.search =  $("#all_search").val();
            }'
        ])->parameters([
            'paging' => true,
            'bLengthChange' => false,
            'searching' => false,
            'info' => false,
        ]);
        return view('tickets.list', compact('html'));
    }

    /**
     * Display table of ticket
     */
    public function dataTableList(Request $request)
    {
        if (Auth::user()->role == 0){
            $ticket_data = Ticket::where('user_id',Auth::id())->orderBy('id', 'DESC');
        }else{
            $ticket_data = Ticket::orderBy('id', 'DESC');
        }

        $ticket_data->when(request('search'), function ($q) {
            return $q->where('title', 'LIKE', '%' . request('search') . '%')->orWhere('description', 'LIKE', '%' . request('search') . '%');
        });

        return DataTables::of($ticket_data)
            ->addColumn('action', function ($ticket_data) {
                if (Auth::user()->role == 0){
                    $str = '<a class="btn btn-primary" href=' . route('ticket.show', $ticket_data->id) . '>Show</a>
                ';
                }else{
                    $str = '<a class="btn btn-primary" href=' . route('ticket.edit', $ticket_data->id) . '>Edit</a>&nbsp;&nbsp
                <a class="btn btn-primary" href=' . route('ticket.show', $ticket_data->id) . '>Show</a>
                ';
                }


                return $str;
            })
            ->editColumn('status', function ($ticket_data) {
                $str = $ticket_data->status == '1' ? 'Pending' : 'Closed';
                return $str;
            })
            ->addIndexColumn()
            ->escapeColumns()
            ->toJSON();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('name','id')->get();
        return view('tickets.add',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTicketRequest $request)
    {

        $ticket_data = new Ticket();
        $ticket_data->title = $request->title;
        $ticket_data->description = $request->description;
        $ticket_data->user_id = Auth::id();
        $ticket_data->save();
        return redirect()->route('ticket.list')->with('success', 'Tickets created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $ticket_data = Ticket::where('id', $id)->first();
        $users = User::where('role',1)->get();
        return view('tickets.edit', compact('ticket_data','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditTicketRequest $request, $id)
    {
        //
        $ticket_data = Ticket::find($id);
        $old_assigned_user_id = $ticket_data->assigned_user_id;
        $old_status = $ticket_data->status;
        $ticket_data->title = $request->title;
        $ticket_data->description = $request->description;
        $ticket_data->status = $request->status;
        $ticket_data->assigned_user_id = $request->assignee;
        $ticket_data->save();

        $user = User::find($request->assignee);
        try {
            if($request->assignee != $old_assigned_user_id){
                $user->notify((new AssigneeChange($ticket_data)));
            }
            if($old_status != $request->status){
                $user->notify((new StatusChange($ticket_data)));
            }
        }catch (\Exception $exception){
            return redirect()->route('ticket.list')->with('error', "Ticket update but Notification not send,Please set mail credential!");
        }
        return redirect()->route('ticket.list')->with('success', 'Booking Updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $ticket_data = Ticket::where('id', $id)->with('getUserInfo')->first();
        return view('tickets.show', compact('ticket_data'));
    }
}
