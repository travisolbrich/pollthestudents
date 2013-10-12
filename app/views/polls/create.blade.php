@extends('layouts.app')

@section('title')
Create a Poll
@stop

@section('content')

<div class="row-fluid">
<div class="span12">
<div id="create">   

    <div class="row-fluid">
    <div class="span10 offset1">
    <h1>Create a Poll</h1>
    <hr>
    <div class="form-horizontal">         
        <div class="poll-info">
            <div class="control-group">
            {{ Form::label('prompt', 'Prompt', array('class'=>'control-label')) }}
                <div class="controls">
                {{ Form::text('prompt', null, array('placeholder'=>'What is your favorite place to eat?', 'class' => 'span12'))}}
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" name="is_public"> Make Public
                    </label>
                </div>
            </div>
        </div>

        <div class="poll-choices">
    
            <div class="control-group">
                <label for="prompt" class="control-label">Choices</label>
                <div class="controls">
                    <div class="list">
                        
                        <div class="reference choice hidden">
                            <input class="string span12" type="text" placeholder="Somewhere else..." checked/>
                        </div>

                        <div class="choice">
                            <input class="string span12" type="text" placeholder="Potato Shack" checked/>
                        </div>

                        <div class="choice">
                            <input id="first" class="string span12" type="text" placeholder="Antonio's Pizza" checked/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-success" id="submit">Submit Poll</button>
                    <button class="btn btn-primary" id="newChoice">Add a New Choice</button>
                </div>
            </div>
        </div>
        
        
    </div>
    </div>
    </div>
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
        <a id="newPollLink" class="btn btn-large btn-success" href="/poll/view?id=1">View Poll</a>
    </div>
</div>
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
                nonReferenceChoiceListings = choiceListing.find(".choice").not(".reference"),
                isPublic = $("#isPublic").val(),
                choiceStringInput;
    
            nonReferenceChoiceListings.each(function(){
                // cache jquery var
                var current = $(this);
                
                var choice = new POLL.MODEL.Choice(),
                    choiceStringInput = current.find(".string"),
                    value = choiceStringInput.val();
                
                if(value !== ""){
                    choice.setName(value);
                    choices.push(choice);
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
            
            var address = ('/poll/'+pollId);
            $('#newPollLink').attr('href',address);
        };
        
        showError = function () {
            $("#error").toggleClass("hidden");
        };
        
        pollSuccess = function (data, x, y) {
            showSuccess(data);
        };
        
        pollError = function(data, errorThrown){
            showError();
        };
        
    });
</script>

@stop