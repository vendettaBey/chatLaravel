<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="chatlist_header bg-gray-50  dark:bg-gray-900 ">
        <div class="title text-gray-900 dark:text-gray-50">
            <h3>Chat List</h3>
        </div>
        <div class="img-container">
            <img src="https://ui-avatars.com/api/?background=3d794b&color=fff&name={{ auth()->user()->name }}"
                alt="">
        </div>
    </div>
    <div class="chatlist_body bg-gray-50 dark:bg-gray-900 text-black">
        @if (count($conversations) > 0)
            @foreach ($conversations as $conversation)
                <div wire:key="{{ $conversation->id }}"
                    class="chatlist_item bg-gray-50 border-b-2 border-green-100 dark:bg-gray-900 dark:border-b-2 dark:border-green-500"
                    wire:click="$emit('chatUserSelected',{{ $conversation }},{{ $this->getChatUserInstance($conversation, $name = 'id') }})">
                    <div class="chatlist_img_container">
                        <img src="https://ui-avatars.com/api/?name={{ $this->getChatUserInstance($conversation, $name = 'name') }}"
                            alt="">
                    </div>
                    <div class="chatlist_info">
                        <div class="top_row">
                            <div class="list_username dark:text-gray-50">
                                {{ $this->getChatUserInstance($conversation, $name = 'name') }}
                            </div>
                            <span
                                class="date font-bold dark:text-gray-50">{{ $conversation->messages->last()->created_at->shortAbsoluteDiffForHumans() }}</span>
                        </div>
                        <div class="bottom_row">
                            <div class="message_body text-truncate font-bold dark:text-gray-100">
                                {{ $conversation->messages->last()->body }}
                            </div>
                            @php
                                if (count($conversation->messages->where('read', 0)->where('receiver_id', Auth()->user()->id)) > 0) {
                                    echo '<div class="unread_count badge rounded-pill text-light bg-danger my-auto">' . count($conversation->messages->where('read', 0)->where('receiver_id', Auth()->user()->id)) . '</div>';
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="no_conversation">
                <h3>No Conversation</h3>
            </div>
        @endif
        <hr>
    </div>

</div>
