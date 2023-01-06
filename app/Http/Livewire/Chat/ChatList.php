<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\User;

class ChatList extends Component
{

    public $conversations;
    public $authId;
    public $receiverInstance;
    public $name;
    public $selectedConversation;

    protected $listeners = ['chatUserSelected','refresh'=>'$refresh','resetComponent'];

    function resetComponent(){
        $this->selectedConversation=null;
        $this->receiverInstance=null;
    }
    public function mount()
    {
        $this->authId = auth()->id();
        $this->conversations = Conversation::where('sender_id',$this->authId)->orWhere(['receiver_id'=>$this->authId])->orderBy('last_time_message','desc')->get();
    }

    public function chatUserSelected(Conversation $conversation,$receiverId){
        $this->selectedConversation=$conversation;
        $receiverInstance=User::find($receiverId);

        $this->emitTo('chat.chatbox','loadConversation',$this->selectedConversation,$receiverInstance);
        $this->emitTo('chat.send-message','updateSendMessage',$this->selectedConversation,$receiverInstance);
    }

    public function getChatUserInstance(Conversation $conversation,$request){
        $this->authId=auth()->id();
        if($conversation->sender_id==$this->authId){
            $this->receiverInstance=User::firstWhere('id',$conversation->receiver_id);
        }else{
            $this->receiverInstance=User::firstWhere('id',$conversation->sender_id);
        }
        if(isset($request)){
            return $this->receiverInstance->$request;
        }

    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}