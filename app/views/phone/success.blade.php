<?php 
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>

<Response>
    <Message>You've successfully submitted your response! You chose "{{ $answer->choice->name }}" for the prompt "{{ $answer->poll->prompt }}". Thanks for using Poll Something New!</Message>
</Response>