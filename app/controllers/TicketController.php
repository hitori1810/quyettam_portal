<?php

/*
*   Class TicketController
*   Auhor: Hieu Nguyen
*   Date: 2016-03-15
*   Purpose: To handle ticket logic
*/

class TicketController extends BaseController {

    // Render the index page
    public function index() {
        $tickets = SugarUtil::getTicketList();
        $appListStrings = Session::get('app_list_strings');

        $data = array(
            'tickets' => $tickets,
            'statuses' => $appListStrings->case_status_dom,
            'priorities' => $appListStrings->case_priority_dom,
        );
        
        return View::make('ticket.index')->with($data);
    }
    
    // Render the add page
    public function add() {
        $session = Session::get('session');
        $user = Session::get('user');
        $contact = Session::get('contact');
        $appListStrings = Session::get('app_list_strings');
        
        $data = array(
            'user' => $user,
            'contact' => $contact,
            'priorities' => $appListStrings->case_priority_dom,
        );
        
        return View::make('ticket.add')->with($data);    
    }
    
    // Handle saving ticket
    public function save() {
        $session = Session::get('session');
        $user = Session::get('user');
        $contact = Session::get('contact');
        
        // Save ticket data
        $data = array(
            'name' => Input::get('subject'),
            'type' => 'Ticket',
            'status' => 'New',
            'priority' => Input::get('priority'),
            'content' => Input::get('contents'),
            'account_id' => $contact->account_id,
            'assigned_user_id' => $user->id,
        );

        $result = $this->client->save($session->id, 'Cases', '', $data);
        
        // Return result into the view
        if($result != null) {
            Session::flash('success_message', trans('ticket_index.send_ticket_success_msg'));
            return Redirect::to('ticket/index');
        } else {
            Session::flash('error_message', trans('ticket_add.send_ticket_failed_msg'));
            return Redirect::back();
        }    
    }
    
    // Render the view page
    public function view($id) {
        $session = Session::get('session');
        $user = Session::get('user');
        $contact = Session::get('contact');
        $appListStrings = Session::get('app_list_strings');
        $rootSession = $this->client->getRootSession();
        
        // Get ticket
        $ticket = $this->client->retrieve($session->id, 'Cases', $id);       
        
        // Get comments belong to ticket
        $comments = $this->client->getFullList(
            $rootSession, 
            'Notes',
            array(),    // Get all fields
            'notes.parent_type = "Cases" AND notes.parent_id = "'. $id .'"',
            'notes.date_entered ASC'
        );

        // Return data into the view
        $data = array(
            'ticket' => $ticket,
            'user' => $user,
            'contact' => $contact,
            'statuses' => $appListStrings->case_status_dom,
            'priorities' => $appListStrings->case_priority_dom,
            'comments' => $comments,
        );
        
        return View::make('ticket.view')->with($data);    
    }
    
    // Handle sending comment
    public function comment($id) {
        $session = Session::get('session');
        $user = Session::get('user');
        
        // Save user data
        $data = array(
            'name' => 'Comment',
            'description' => Input::get('message'),
            'parent_type' => 'Cases',
            'parent_id' => $id,
            'assigned_user_id' => $user->id,
        );

        $result = $this->client->save($session->id, 'Notes', '', $data);

        // Save attachment if any
        $attachment = Input::file('attachment');

        if($attachment) {
            $attachmentParams = array(
                'session' => $session->id,
                'note' => array(
                    'id' => $result->id,    // Note id
                    'filename' => $attachment->getClientOriginalName(),
                    'file' => base64_encode(File::get($attachment)),
                ),
            );
            
            $this->client->call(SugarMethod::SET_NOTE_ATTACHMENT, $attachmentParams);
        }
        
        // Return result into the view
        if($result != null) {
            Session::flash('success_message', trans('ticket_view.send_comment_success_msg'));
        } else {
            Session::flash('error_message', trans('ticket_view.send_comment_failed_msg'));
        }
        
        return Redirect::back();        
    }
    
    // Handle closing ticket
    public function close($id) {
        $session = Session::get('session');
        
        // Set status as Closed
        $data = array(
            'status' => 'Closed',
        );

        $result = $this->client->save($session->id, 'Cases', $id, $data);

        // Return result into the view
        if($result != null) {
            Session::flash('success_message', trans('ticket_view.close_ticket_success_msg'));
        } else {
            Session::flash('error_message', trans('ticket_view.close_ticket_failed_msg'));
        }
        
        return Redirect::back();        
    }	
}
