@extends('layouts.app')

@section('content')

<h1>Create a Poll</h1>
<div id="create">            
    <div class="header">
        <h1>New Poll</h1>
    </div>            
    <div class="poll-info">
        <label>Poll Prompt</label>
        <input id="prompt" type="text" placeholder="What is your favorite place to eat?" checked/>
        
        <label>Make Public</label>
        <input id="isPublic" value="true" type="checkbox" checked/>
    </div>
    <div class="poll-choices">
        <ul class="list">
            <li class="reference choice hidden">
                <input class="string" type="text" placeholder="Antonio's Pizza" checked/>
            </li>
        </ul>
        <button id="newChoice">New Choice</button>
    </div>
    
    <button id="submit">Submit Poll</button>
</div>

<div id="error" class="hidden">            
    <div class="header">
        <h1>Woops!</h1>
    </div>            
    <div id="poll-error">
        <p>An error occured. Try something different...</p>
    </div>
</div>

<div id="success" class="hidden">            
    <div class="header">
        <h1>Success!</h1>
    </div>            
    <div id="poll-info">
        <p>Your new pool has been created!</p>
        <a id="newPollLink" href="/poll/view?id=">Share your Poll</a>
    </div>
</div>
@stop
@section('javascripts')
<script type="text/javascript">
    
    $(document).ready(function() {
        
        var poll = new POLL.MODEL.Poll(),
            pollRegistry = new POLL.REGISTRY.PollRegistry(),
            createChoice,
            hideCreate,
            showSuccess,
            showError,
            pollSuccess,
            pollFailure;
        
        $( "#isPublic" ).change(function() {
            
            var value = $( "#isPublic" ).val();
            poll.setPrompt(value);
        });
        
        $( "#prompt" ).change(function() {
            var value = $( "#prompt" ).val();
            poll.setPrompt(value);
        });
        
        $( "#newChoice" ).click(function() {
            createChoice();
        });
        
        $( "#submit" ).click(function() {
            
            //Create options for each option.
            var choices = [], 
                choiceListing = $(".poll-choices .list"),
                isPublic = $("#isPublic").val(),
                choiceStringInput;
    
            choiceListing.find('li').each(function(){
                // cache jquery var
                var current = $(this);
                
                if(current.hasClass("hidden") == false)
                {
                    var choice = new POLL.MODEL.Choice(),
                        choiceStringInput = current.find(".string"),
                        value = choiceStringInput.val();
                    
                    if(value !== ""){
                        choice.setName(value);
                        choices.push(choice);
                    }
                }
            });
            
            poll.setIsPublic(isPublic);
            poll.setChoices(choices);
            pollRegistry.create(poll, pollSuccess, pollFailure);
        });
        
        createChoice = function () {
          
            var choiceList = $(".poll-choices .list"),
                choiceReference = choiceList.find(".reference"),
                clone = choiceReference.clone(true);
            
            clone.toggleClass("hidden");
            clone.toggleClass("reference");
            clone.appendTo(choiceList);
        };
                
        hideCreate = function () {
            $("#create").toggleClass("hidden");
        };
        
        showSuccess = function (pollId) {
            $("#success").toggleClass("hidden");
            hideCreate();
            
            var address = "/poll/" + pollId;
            $('newPollLink').attr('href',('/poll/view?id='+pollId));
        };
        
        showError = function () {
            $("#error").toggleClass("hidden");
        };
        
        pollSuccess = function (html) {
            showSuccess();
        };
        
        pollError = function(data, errorThrown){
            showError();
        };
        
    });
</script>

@stop