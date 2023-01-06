<div>
    {{-- Because she competes with no one, no one can compete with her. --}}

    @if ($selectedConversation)
        <div class="chatbox_header">
            <div class="return dark:text-gray-50">
                <i class="bi bi-arrow-left"></i>
            </div>
            <div class="img_container">
                <img src="https://ui-avatars.com/api/?name={{ $receiverInstance->name }}" alt="">
            </div>
            <div class="name text-gray-900 dark:text-gray-50">
                {{ $receiverInstance->name }}
            </div>
            <div class="info">
                <div class="info_item">
                    <i class="bi bi-telephone-fill"></i>
                </div>
                <div class="info_item">
                    <i class="bi bi-image"></i>
                </div>
                <div class="info_item">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
            </div>
        </div>
        <div class="chatbox_body">
            @foreach ($messages as $message)
                <div style="width:80%;max-width: 80%;max-width: max-content;"
                    class="msg_body {{ auth()->id() == $message->sender_id ? 'msg_body_me' : 'msg_body_receiver' }}">
                    {{ $message->body }}
                    <div class="message_body_footer">
                        <div class="date">
                            {{ $message->created_at->format('m: i a') }}
                        </div>
                        <div class="read dark:text-gray-900 text-gray-50 font-bold">

                            @php
                                if ($message->user->id === auth()->id()) {
                                    if ($message->read == 0) {
                                        echo '<i class="bi bi-check2 status_tick"></i>';
                                    } else {
                                        echo '<i class="bi bi-check2-all text-primary"></i>';
                                    }
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <script>
            $('.chatbox_body').scroll(function() {
                var top = $('.chatbox_body').scrollTop();
                if (top == 0) {
                    window.livewire.emit('loadmore');
                }
            });
        </script>

        <script>
            window.addEventListener('updateHeight', event => {
                let old = event.detail.height;
                let newHeight = $('.chatbox_body')[0].scrollHeight;
                let height = $('.chatbox_body').scrollTop(newHeight - old);
                window.livewire.emit('updateHeight', {
                    height: newHeight
                })
            })
        </script>
    @else
        <div class="fs-4 text-center text-primary">
            <h3>No Conversation Selected</h3>
        </div>
    @endif
</div>

<script>
    window.addEventListener('rowChatToBottom', event => {
        $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
    })
</script>

<script>
    $(document).on('click', '.return', function() {
        window.livewire.emit('resetComponent');
    })
</script>

<script>
    window.addEventListener('markAsRead', event => {
        var value = document.querySelectorAll('.status_tick');
        value.forEach(element, index => {
            element.classList.remove('bi bi-check2');
            element.classList.add('bi bi-check2-all', 'text-primary');
        });
    })
</script>
