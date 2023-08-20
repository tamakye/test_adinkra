@extends('dashboard.layouts.app')
@section('title', 'Support Tickets | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('tickets_menu_open','menu-open')
@section('tickets_active','active')


@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Help center</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tickets</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-md-10">
                                <h5 class="mb-1">{{ $ticket->title }}</h5>
                                <div>
                                    <span>Ticket: #{{ $ticket->ticket_id }}</span> |
                                    <span>Status:  <span class="badge {{ $ticket->status == 'open' ? 'bg-info' : 'bg-dark' }}">{{ ucfirst($ticket->status) }}</span> |
                                    <span> Creation date: {{ getCustomLocalTime($ticket->created_at) }}</span>
                                </div>
                            </div>
                            @if($ticket->status == 'open')
                            <div class="col-md-2">
                                <button class="btn btn-danger float-right " data-toggle="modal" data-target="#closeTicket">Close ticket</button>
                            </div>
                            @endif
                        </div>
                        <h5>Messages history</h5>
                        <div class="card border-0" style="border-radius: 5px">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="bg-primary rounded text-white p-2 text-center">
                                            <small>{{ $ticket->users->first_name }}<br>{{ $ticket->created_at->format('d-m-Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <p class="mb-1">{{ $ticket->message }}</p>

                                        @if(!empty($ticket->attachment))
                                        <a href="{{ asset(get_ticket_attachment($ticket->attachment))}}" target="_blank" class="mt-auto">View attached file</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach($comments as $comment)
                        <div class="card border-0" style="border-radius: 5px">
                            <div class="card-body border-top">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class=" {{ !empty( $comment->user_id) ? 'bg-primary' : 'bg-info' }} rounded text-white p-2 text-center">
                                            <small>{{ !empty($comment->user_id) ? $ticket->users->first_name : 'MSS Support'  }}<br>{{ $comment->created_at->format('d-m-Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <p class="mb-1">{{ $comment->comment }}</p>

                                        @if(!empty($comment->attachment))
                                        <a href="{{ asset(get_comment_attachment($comment->attachment))}}" target="_blank" class="mt-auto">View attached file</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if($ticket->status == 'open')
                        <div class="mt-4 mb-4 border-top pt-2">
                            <form action="{{ route('admin.view-ticket.comment') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <label class="text-primary">Reply</label>

                                <div class="form-group mt-2">
                                    <textarea name="comment" id=""rows="5" class="form-control" required="">{{ old('comment') }}</textarea>
                                    @error('comment')
                                    <span class="invalid-feedback" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mt-2">
                                    <label for="message" style="width: auto;">
                                        <button type="button" class="btn add-attachment"><i class="fas fa-paperclip"></i> upload a file</button>
                                        <div class="badge badge-dark show-box p-1">
                                            <span class="close-file"><i class="fas fa-times"></i></span>
                                            <span class="show-filename mt-2"></span>
                                        </div>
                                        <br>
                                        <small>File import is limited to 5MB. Accepted formats are: jpg, png, doc, pdf, rar, zip.</small>
                                    </label>
                                    <input type="file" class="form-control" name="attachment" accept=".jpg, .png, .jpeg, .docx, .doc, .pdf, .zip" style="display: none;" id="attachment">
                                    @error('attachment')
                                    <span class="invalid-feedback" style="display: block;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary mt-2 float-right">Submit reply</button>
                            </form>
                        </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal" id="closeTicket" tabindex="-1" role="dialog" aria-labelledby="closeTicketLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="closeTicketLabel">Close ticket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <form action="{{ route('view-ticket.close') }}" method="POST">
      <div class="modal-body">
        @csrf
        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
        <input type="hidden" name="close" value="close">
        <div class="form-group mt-2">
            <label>Reason for closing ticket</label>
            <textarea name="reason" id=""rows="5" class="form-control" required="">{{ old('reason') }}</textarea>
            @error('reason')
            <span class="invalid-feedback" style="display: block;">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Close this ticket</button>
    </div>
</form>
</div>
</div>
</div>
@endsection