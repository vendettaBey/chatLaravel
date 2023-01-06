<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="chat_container bg-gray-50 dark:bg-gray-900 text-black dark:text-white">
        <div class="chat_list_container">
            @livewire('chat.chat-list')
        </div>
        <div class="chatbox_container bg-gray-50 dark:bg-gray-900 text-black dark:text-white">
            @livewire('chat.chatbox')
            @livewire('chat.send-message')
        </div>
    </div>

    <script>
        window.addEventListener('chatSelected', event => {
            if (window.innerWidth < 768) {
                $('.chat_list_container').hide();
                $('.chatbox_container').show();
            }

            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
            let height = $('.chatbox_body')[0].scrollHeight;

            window.livewire.emit('updateHeight', {
                height: height
            })


            $(window).resize(function() {
                if (window.innerWidth > 768) {
                    $('.chat_list_container').show();
                    $('.chatbox_container').show();
                }
            })

            $(document).on('click', '.return', function() {
                $('.chat_list_container').show();
                $('.chatbox_container').hide();
            })
        });
    </script>

</div>
