@extends('layouts.app')

@section('content')

<div id="view">            
    <div class="header">
        <h1 id="poll-prompt">Poll Name</h1>
    </div>
    <div id="poll-answers">
        <ul class="list">
            <li class="reference answer hidden">
                <span class="string" type="text">Poll Choice</span>
                <span class="count" type="text">Count</span>
            </li>
        </ul>
    </div>
    <button id="refresh-button">Refresh</button>
</div>

<div id="submit-answer">            
    <div class="header">
        <h2>Respond</h2>
    </div>          
    <div>
        <select id="poll-choices">
            <option class="reference choice hidden" value=""></option>
        </select>
    </div>
    <span id="select-answer-message" class="hidden">You must select an answer!</span>
    <button id="submit-answer">Submit Answer</button>
</div>
    
<div id="success" class="hidden">            
    <div class="header">
        <h2>Success!</h2>
    </div>            
    <div id="poll-info">
        <p>Your answer has been submitted.</p>
    </div>
</div>

<div id="error" class="hidden">            
    <div class="header">
        <h1>Woops!</h1>
    </div>            
    <div id="poll-error">
        <p>An error occured. This is not the poll you are looking for...</p>
    </div>
</div>

@stop
@section('javascripts')

<script type="text/javascript">
    
        var pollRegistry = new POLL.REGISTRY.PollRegistry(), 
            answerRegistry = new POLL.REGISTRY.AnswerRegistry(),
            pollMarshaller = new POLL.MARSHALLER.PollMarshaller(),
            
            getPollId,
            pollId,
            loadPoll,
            
            debugGetSamplePoll,
            refreshPollWithData,
            refreshPollChoices,
            refreshPollVisuals,
            
            pollLoadError,
            
            showSelectAnswerHelp,
            hideSelectAnswerHelp,
            hideAnswerSubmit,
            showAnswerSubmitSuccess;
        
        getPollId = function () 
        {
            var pathSplits = location.pathname.split("/"),
                identifier = pathSplits[pathSplits.length - 1];
            
            return identifier;
        };
        
        pollId = getPollId();
        
        loadPoll = function (pollId) {
            
            pollRegistry.read(pollId, refreshPollWithData, pollLoadError);
            //refreshPollWithData();  //Debug
        };
        
        debugGetSamplePoll = function () {
            
            var poll = new POLL.MODEL.Poll(),
                answerMap = {},
                choices = [],
                choice;
            
            poll.setIdentifier(1);
            poll.setPrompt("Sample Poll");
            poll.setChoices(choices);
            
            choice = new POLL.MODEL.Choice();
            choice.setPollId(1);
            choice.setIdentifier(1);
            choice.setName("First Choice");
            choices.push(choice);
            
            choice = new POLL.MODEL.Choice();
            choice.setPollId(1);
            choice.setIdentifier(2);
            choice.setName("Second Choice");
            choices.push(choice);
            
            choice = new POLL.MODEL.Choice();
            choice.setPollId(1);
            choice.setIdentifier(3);
            choice.setName("Third Choice");
            choices.push(choice);
            
            answerMap["1"] = 1;
            answerMap["2"] = 2;
            answerMap["3"] = 3;
            poll.setAnswersMap(answerMap);
            
            return poll;
        };
        
        refreshPollWithData = function (data) {
            
            //var poll = debugGetSamplePoll(); 
            var poll = pollMarshaller.marshallSingle(data);
            
            refreshPollChoices(poll);
            refreshPollVisuals(poll);
            
            return poll;
        };
        
        refreshPollChoices = function (poll) {
            
            var choices = poll.getChoices(),
                choice,
                
                choiceList = $("#poll-choices"),
                choiceReference = choiceList.find(".reference"),
                nonChoiceReferences = choiceList.find(".choice").not(".reference"),
                clone = null,
            
                i = 0;
            
            nonChoiceReferences.remove();
            
            for(i = 0; i < choices.length; i += 1)
            {
                choice = choices[i];

                clone = choiceReference.clone(true);
                clone.toggleClass("hidden").toggleClass("reference");
                clone.text(choice.getName());
                clone.val(choice.getIdentifier());
                choiceList.append(clone);
            }
            
            //Refresh the choices listing.
        };
        
        refreshPollVisuals = function (poll) {
            
            var promptDom = $( "#poll-prompt" ),
                
                choices = poll.getChoices(),
                choice,
                choiceId,
                answersMap = poll.getAnswersMap(),
                
                pollAnswersDom = $( "#poll-answers" ),
                pollAnswersList = pollAnswersDom.find(".list"),
                pollAnswersListReference = pollAnswersList.find(".reference"),
                pollAnswersListNonReferences = pollAnswersList.find(".answer").not(".reference"),
                clone = null,
            
                i = 0;
            
            promptDom.text(poll.getPrompt());
            
            //Clear the listing.
            pollAnswersListNonReferences.remove();
            
            for(i = 0; i < choices.length; i += 1)
            {
                choice = choices[i];
                choiceId = choice.getIdentifier();
                answersCount = answersMap[choiceId];
                
                clone = pollAnswersListReference.clone(true);
                clone.toggleClass("hidden").toggleClass("reference");
                clone.find(".string").text(choice.getName());
                clone.find(".count").text(answersCount);
                pollAnswersList.append(clone);
            }
            
              //Refresh Visuals
        };
        
        pollLoadError = function () {
            
            //Ahhhh
            
        };
        
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
        
        $( "#refresh-button" ).click(function() {
            loadPoll(pollId);
        });
        
        $( "#submit-answer" ).click(function() {
            
            //Create options for each option.
            var answer,
                selectedChoice = $( "#poll-choices option:selected" ),
                choiceId = selectedChoice.val();
    
            if(choiceId === "")
            {
                showSelectAnswerHelp();
                
            } else {
                
                hideSelectAnswerHelp();
                answer = new POLL.MODEL.Answer();
                answer.setPollId(pollId);
                answer.setChoiceId(choiceId);
                
                answerRegistry.create(answer);
            }
        });
        
        showSelectAnswerHelp = function () {
            var help = $("#select-answer-message");
            help.removeClass("hidden");
        };
    
        hideSelectAnswerHelp = function () {
            var help = $("#select-answer-message");
            help.addClass("hidden");
        };
    
        createChoice = function () {
          
            var choiceList = $(".poll-choices .list"),
                choiceReference = choiceList.find(".reference"),
                clone = choiceReference.clone(true);
            
            clone.toggleClass("hidden");
            clone.toggleClass("reference");
            clone.appendTo(choiceList);
        };
                
        hideAnswerSubmit = function () {
            $("#submit-answer").toggleClass("hidden");
        };
        
        showAnswerSubmitSuccess = function (pollId) {
            $("#success").toggleClass("hidden");
            hideAnswerSubmit();
        };
        
        loadPoll(pollId);
</script>
@stop