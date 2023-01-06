<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    @if ($selectedConversation)
        <div class="chatbox_footer bg-gray-100 dark:bg-gray-900 w-full">
            <form action="" wire:submit.prevent='sendMessage' class="w-full">
                <div class="custom_form_group w-full">
                    <input wire:model="body" type="text" name="control" id="control" class="control"
                        placeholder="Mesajınızı Yazın">
                    <button type="submit" class="submit"><i class="bi bi-send"></i>Send</button>
                </div>
            </form>
        </div>
    @endif
</div>
