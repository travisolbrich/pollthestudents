@extends('layouts.app')

@section('content')

<div class="row-fluid">
    <div class="span6">
        <div id="view">            
    <div class="header">
        <h1 id="poll-prompt">Poll Name</h1>
    </div>
    <br>
    <h3>Text your responses to:</h3>
    <h2 class='btn-block disabled'>(210) 526-0691</h2>
    <br>
    <div id="chart-keys">
        <ul class="list">
            <li class="reference key hidden">
                <strong><span class="string chartkey" type="text">String</span></strong>
                <br>
                <button class="btn vote-button">Vote this!</button>
            </li>
        </ul>
    </div>
    <br>
</div>
    </div>
    <div class="span6">
        <div id="chart-section">
    <canvas id="showChart" width="450" height="450"></canvas>
</div>
    </div>
</div>

<!-- 
<div id="submit-answer">            
    <div class="header">
        <h2>Respond</h2>
    </div>          
    <div id="poll-choices">
        <ul class="list">
            <li class="reference choice hidden">
                <button class="answer-button">Choose</button>
                <span class="string" type="text">Poll Choice</span>
            </li>
        </ul>
    </div>
    <span id="select-answer-message" class="hidden">You must select an answer!</span>
</div> -->
    
<div id="success" class="hidden center">            
    <div class="header">
        <h2>Success!</h2>
    </div>            
    <div id="poll-info">
        <p>Your answer has been submitted.</p>
    </div>
</div>

<div id="error" class="hidden center">            
    <div class="header">
        <h1>Woops!</h1>
    </div>            
    <div id="poll-error">
        <p>An error occured. Uhhhh...</p>
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
            refreshPollChart,
            
            pollLoadError,
            
            submitAnswer,
            showSelectAnswerHelp,
            hideSelectAnswerHelp,
            hideAnswerSubmit,
            showAnswerSubmitSuccess,
            showAnswerSubmitFailure;
        
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
            refreshPollChart(poll);
            
            return poll;
        };
        
        refreshPollChoices = function (poll) {
            
            var choices = poll.getChoices(),
                choice,
                choiceId,
                
                pollChoicesDom = $("#poll-choices"),
                pollChoicesList = pollChoicesDom.find(".list"),
                pollChoicesListReference = pollChoicesList.find(".reference"),
                pollChoicesListNonReferences = pollChoicesList.find(".choice").not(".reference"),
                clone = null,

                cloneButton,
                cloneString,
            
                i = 0;
            
            pollChoicesListNonReferences.remove();
            
            for(i = 0; i < choices.length; i += 1)
            {
                choice = choices[i];
                choiceId = choice.getIdentifier();

                clone = pollChoicesListReference.clone(true);
                clone.toggleClass("hidden").toggleClass("reference");
                cloneString = clone.find(".string");
                cloneString.text(choice.getName());
                cloneButton = clone.find(".answer-button");
                cloneButton.click(choiceId, submitAnswer);
                pollChoicesList.append(clone);
            }
            
            //Refresh the choices listing.
        };
        
        refreshPollVisuals = function (poll) {
            
            var promptDom = $( "#poll-prompt" ),
                
                choices = poll.getChoices(),
                choice,
                choicedId,
                choiceDisplayString,
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
                clone.find(".string").text(choiceDisplayString);
                clone.find(".count").text(answersCount);
                pollAnswersList.append(clone);
            }
            
              //Refresh Visuals
        };
        
        refreshPollChart = function (poll) {
            
            var colors = ["#23BC13", "#3B219E", "#E6C017", "#E11721", "#3C3263", 
                          "#3C3263", "#E6C017", "#3A7533", "#8D3E42", "#8F813F", 
                          "#8C74E7", "#6B030", "#80A5902", "#F9EBB0", "#75EE68",	"#AFEEA9"],
                
                pollAnswerData = poll.getAnswersMap(), 
                choices = poll.getChoices(),
                answersMap = poll.getAnswersMap(),
                
                chartKeysDom = $("#chart-keys"),
                chartKeysList = chartKeysDom.find(".list"),
                
                chartKeyReference = chartKeysList.find(".reference"),
                nonReferenceChartKeys = chartKeysList.find(".key").not(".reference"),
                
                chartKey,
                chartVoteButton,
                chartKeyCopy,
                
                color,
                choice,
                choiceId,
                answersCount = answersMap[choiceId],
                
                chartData = [],
                //Get context with jQuery - using jQuery's .get() method.
                ctx = $("#showChart").get(0).getContext("2d");
                //This will get the first returned node in the jQuery collection.
                
            nonReferenceChartKeys.remove();
            
            for(i = 0; i < choices.length; i += 1)
            {
                color = colors[i];
                choice = choices[i];
                choiceId = choice.getIdentifier();
                answersCount = answersMap[choiceId];
                
                choiceDisplayString = ("Text " + {{ $poll->id }} + ":" + choiceId + " for '" + choice.getName() +"' (" + answersCount + " vote(s))");

                chartKeyCopy = chartKeyReference.clone(true);
                chartKeyCopy.toggleClass("hidden").toggleClass("reference");
                chartKeyCopy.find(".string").text(choiceDisplayString).css( "color", color);

                chartVoteButton = chartKeyCopy.find(".vote-button");
                chartVoteButton.click(choiceId, submitAnswer);

                chartKeysList.append(chartKeyCopy);
                
                chartData.push({'value': answersCount, 'color': color});
            }
        
            new Chart(ctx).Pie(chartData, {animateRotate : false});
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

        submitAnswer = function (event) {

        	var choiceId = event.data;
            if(choiceId === "")
            {
                showSelectAnswerHelp();
                
            } else {
                
                hideSelectAnswerHelp();
                answer = new POLL.MODEL.Answer();
                answer.setPollId(pollId);
                answer.setChoiceId(choiceId);
                
                answerRegistry.create(answer, showAnswerSubmitSuccess, showAnswerSubmitFailure);
            }
        };
        
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
            $(".vote-button").toggleClass("hidden").off();
        };
        
        showAnswerSubmitSuccess = function () {
            $("#success").toggleClass("hidden");
            hideAnswerSubmit();
        };

        showAnswerSubmitFailure = function (data, error) {
            $("#error").toggleClass("hidden");
            hideAnswerSubmit();
        };
    
        loadPoll(pollId);
        setInterval(function() { 
            loadPoll(pollId) 
        }, 2000);
</script>
@stop