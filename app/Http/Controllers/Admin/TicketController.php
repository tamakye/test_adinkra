<?php

namespace App\Http\Controllers\Admin;

use App\Events\TicketCommentEvent;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Ticketcategory;
use App\Models\Ticketcomment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TicketController extends Controller
{
	public function showTickets(){

		$tickets =  Ticket::latest()->paginate(10);

		return view('dashboard.tickets.show-tickets', compact('tickets'));
	}

	/**
	 * view a ticket
	 *
	 * @param      <type>  $ticket_id  The ticket identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function viewTicket($ticket_id){

		$ticket =  Ticket::where('ticket_id', $ticket_id)->firstOrfail();
		$comments = $ticket->ticketcomments;

		return view('dashboard.tickets.view-ticket', compact('ticket', 'comments'));
	}

	/**
	 * Saves a comment.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 */
	public function saveComment(Request $request){

		if ($request->has('close')) {
			$request->validate([
				'reason'   => ['required', 'string']
			]);
		}else{
			$request->validate([
				'comment'   => ['required', 'string'],
				'attachment'   => ['nullable', 'file', 'mimes:jpeg,png,jpg,zip,pdf,doc,docx|max:5000'],
			]);
		}

		$comment = Ticketcomment::create([
			'admin_id'   => Auth::guard('admin')->user()->id,
			'ticket_id' => $request->ticket_id,
			'comment' => $request->comment,
			'comment_id' => strtoupper(Str::random(10)),
		]);

		$this->uploadCommentAttachment($comment);

		// get ticket
		$ticket = $comment->tickets;

		if ($request->has('close')) {
			$ticket->update(['status' => 'closed']);
		}

		// send to user
		$receiver = 'user';
		$user = $ticket->users;

		// dispatach event
		event(new TicketCommentEvent($ticket, $user, $receiver, $comment));

		return redirect()->back()->with('success', 'Comment submitted successfully');;
	}


	/**
	 * Uploads a comment attachment.
	 *
	 * @param      <type>  $comment  The comment
	 */
	public function uploadCommentAttachment($comment){

		if (request()->has('attachment')) {

			if (is_file(get_comment_attachment($comment->attachment))) {
				unlink(get_comment_attachment($comment->attachment));
			}

			$file 	= request()->file('attachment');
			$ext 	= $file->getClientOriginalExtension();
			$name 	= $comment->comment_id.'.'.$ext;
			$save  	= $file->storeAs('public/tickets/comments/', $name);

			$comment->update([
				'attachment' => $name,
			]);
		}

	}


	/**
	 * Shows the ticiket category.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function showTiciketCategory(){

		$categories = Ticketcategory::latest()->get();

		$category = Ticketcategory::find(request()->q);

		return view('dashboard.tickets.categories', compact('categories', 'category'));
	}


	/**
	 * Adds a ticiket category.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function addTiciketCategory(Request $request){

		$request->validate([
			'category' => ['required', 'string', 'max:255']
		]);

		$category = Ticketcategory::updateOrCreate(
			[
				'id' => $request->id
			],
			[
				'name' => $request->category
			]
		);

		return redirect()->route('admin.tickets.categories')->with('success', 'Category added successfully');
	}

	/**
	 * delete a ticiket category
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function deleteTiciketCategory($id){

		$category = Ticketcategory::find($id);

		$category->delete();

		return redirect()->route('admin.tickets.categories')->with('info', 'Category deleted successfully');
	}
}
