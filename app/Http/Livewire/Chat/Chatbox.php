<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;
use App\Models\User;
use App\Events\MessageSent;
use App\Events\MessageRead;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;


class Chatbox extends Component
{
    public $selectedConversation;
    public $receiverInstance;
    public $paginateVar=10;
    protected $listeners = ['loadConversation','pushMessage','loadmore','updateHeight'];
    public $messages_count;
    public $messages;
    public $height;

    function resetComponent(){
        $this->selectedConversation=null;
        $this->receiverInstance=null;
    }

    public function getListeners(){
        $auth_id=auth()->user()->id;
        return [
            "echo-private:chat.{$auth_id},MessageSent" => 'broadcastedMessageReceived',
            "echo-private:chat.{$auth_id},MessageRead" => 'broadcastedMessageRead',
            'loadConversation','pushMessage','loadmore','updateHeight','broadcastMessageRead' , 'resetComponent'
        ];
    }

    public function broadcastedMessageRead($event){
        // dd($event);
        if($this->selectedConversation){
            if((int)$this->selectedConversation->id===(int)$event['conversation_id']){
                $this->dispatchBrowserEvent('markAsRead');

            }
        }
    }


    public function broadcastedMessageReceived($event){

        $this->emitTo('chat.chat-list','refresh');

        $broadcastedMessage=Message::find($event['message']);
        if($this->selectedConversation){
            if( (int)$this->selectedConversation->id==$event['conversation_id']){

                $broadcastedMessage->read=1;
                $broadcastedMessage->save();

                $this->pushMessage($broadcastedMessage->id);

                $this->emitSelf('broadcastMessageRead');

            }
        }
    }

    public function broadcastMessageRead(){
        broadcast(new MessageRead($this->selectedConversation->id,$this->receiverInstance->id));
    }


    public function pushMessage($messageId){
        $newMessage=Message::find($messageId);
        $this->messages->push($newMessage);
        $this->dispatchBrowserEvent('rowChatToBottom');
    }

    function loadmore(){
        //dd('top reached');
        $this->paginateVar+=10;
        $this->messages_count=Message::where('conversation_id',$this->selectedConversation->id)->count();

        $this->messages=Message::where('conversation_id',$this->selectedConversation->id)->skip($this->messages_count - $this->paginateVar)->take($this->paginateVar)->get();
        $height=$this->height;
        $this->dispatchBrowserEvent('updateHeight',($height));

    }
    function updateHeight($height){
        $this->height=$height;

        //$this->dispatchBrowserEvent('updateHeight',$height);
    }

    public function loadConversation(Conversation $conversation,User $receiver){

        $this->selectedConversation=$conversation;
        $this->receiverInstance=$receiver;

        $this->messages_count=Message::where('conversation_id',$this->selectedConversation->id)->count();

        $this->messages=Message::where('conversation_id',$this->selectedConversation->id)->skip($this->messages_count - $this->paginateVar)->take($this->paginateVar)->get();
        $this->dispatchBrowserEvent('chatSelected');

        Message::where('conversation_id',$this->selectedConversation->id)->where('receiver_id',Auth::user()->id)->update(['read'=>1]);

        $this->emitSelf('broadcastMessageRead');



    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}