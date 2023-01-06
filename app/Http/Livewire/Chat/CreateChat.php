<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;
use App\Models\User;
use App\Models\Message;

class CreateChat extends Component
{
    public $users;
    public $hi="Hi";

    public function checkConversation($receiverId){
        $checkedConversation= Conversation::where('receiver_id',auth()->user()->id)->where('sender_id',$receiverId)->orWhere('receiver_id',$receiverId)->where('sender_id',auth()->user()->id)->get();
        if(count($checkedConversation)==0){

            $createdConversation=Conversation::create(['receiver_id'=>$receiverId,'sender_id'=>auth()->user()->id]);
            $createdMessage=Message::create(['conversation_id'=>$createdConversation->id,'sender_id'=>auth()->user()->id,'receiver_id'=>$receiverId,'body'=>$this->hi]);

            $createdConversation->last_time_message=$createdMessage->created_at;
            $createdConversation->save();

            dd('saved');


        }elseif(count($checkedConversation)>=1){
            dd('conversation');
        }
    }

    public function render()
    {
        $this->users = User::inRandomOrder()->where('id', '!=', auth()->id())->get();
        return view('livewire.chat.create-chat');
    }
}