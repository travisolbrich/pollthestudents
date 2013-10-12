<div id="view">            
    <div class="header">
        <h1>Poll Name</h1>
    </div>            
    <div class="poll-info">
        <span id="poll-prompt">What is your favorite place to eat?</span>
    </div>
    <div class="poll-answers">
        <ul class="list">
            <li class="reference answer hidden">
                <span class="string" type="text"></span>
            </li>
        </ul>
    </div>
</div>

<div id="submit-answer">            
    <div class="header">
        <h2>Respond</h2>
    </div>          
    <div class="poll-choices">
        <select>
            <option class="reference choice hidden" value="ID"></option>
        </select>
    </div>
    
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

<script type="text/javascript">
    
    $(document).ready(function() {
        
        var pollRegistry = new POLL.REGISTRY.PollRegistry(), 
            answerRegistry = new POLL.REGISTRY.AnswerRegistry(),
            pollMarshaller = new POLL.MARSHALLER.PollMarshaller(),
            
            getPollId,
            pollId,
            poll,
            loadPoll,
            
            refreshPoll,
            refreshChoices,
            refreshPollVisuals,
            pollLoadError,
            
            hideAnswerSubmit,
            showAnswerSubmitSuccess;
        
        getPollId = function () 
        {
            var pathSplits = location.pathname.split("/"),
                identifier = pathSplits[pathSplits.length - 1];
            
            return identifier;
        };
        
        pollId = getPollId();
        
        loadPoll = function () {
            pollRegistry.read(pollId, refreshPoll, pollLoadError);
        };
        
        refreshPoll = function (data) {
            
            poll = pollMarshaller.marshallSingle(data);
            
            refreshChoices();
            refreshPollVisuals();
        };
        
        refreshChoices = function () {
            
            var choices = poll.getChoices(),
                choice,
                
                choiceListing = $(".poll-choices .list"),
                choiceReference = choiceList.find(".reference"),
                clone = null;
            
                i = 0;
            
            for(i = 0; i < choices.length; i += 1)
            {
                choice = choices[i];

                clone = choiceReference.clone(true);
                clone.text(choice.getName());
                clone.value(choice.getIdentifier());
            }
            
            
            //Refresh the choices listing.
        };
        
        refreshPollVisuals = function () {
            
            
            
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
        
        $( "#submit-answer" ).click(function() {
            
            //Create options for each option.
            var answer,
                selectedChoice = $( "#poll-choices option:selected" ),
                choiceId = selectedChoice.val(),
                pollId = poll.getId();
    
            answer = new POLL.REGISTRY.Answer();
            answer.setPollId(pollId);
            answer.setChoiceId(choiceId);
            
            answerRegistry.create(answer);
        });
        
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
        
    });
</script>