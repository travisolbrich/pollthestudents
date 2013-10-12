@extends('layouts.master')

@section('title')
Poll Something New
@stop

@section('pageContent')
<div class="container-narrow">

  @include('includes.masthead')

  <div class="jumbotron">
    <h1>Create a Poll!</h1>
    <p class="lead">Create a new public poll.</p>
    <a class="btn btn-large btn-success" href="/poll/create">New Poll</a>
  </div>

  <hr>
    
    <div id="recent-polls">
        <ul class="list">
            <li class="reference poll hidden">
                <a class="string small" href="">This is the reference...</a>
            </li>
        </ul>
    </div>
@stop
@section('javascripts')
<script type="text/javascript">
    
    $(document).ready(function() {
        
        var pollRegistry = new POLL.REGISTRY.PollRegistry(),
            pollMarshaller = new POLL.MARSHALLER.PollMarshaller(),
            
            refreshData,
            
            refreshPolls,
            refreshPollVisuals,
            
            pollLoadSuccess,
            pollLoadError;
        
        refreshData = function () 
        {
            pollRegistry.searchRecent(4, pollLoadSuccess, pollLoadError);   
        }
    
        refreshPolls = function (data) {
            var polls = pollMarshaller.marshall(data);
            refreshPollChoices(polls);
        };
        
        refreshPollChoices = function (polls) {
            
            var poll,
                pollPrompt,
                address,
                
                pollList = $("#recent-polls"),
                pollReference = pollList.find(".reference"),
                nonReferencePolls = pollList.find(".poll").not(".reference"),
                clone = null,
            
                i = 0;
            
            nonReferencePolls.remove();
            
            for(i = 0; i < polls.length; i += 1)
            {
                poll = polls[i];
                pollPrompt = poll.getPrompt();
                pollIdentifier = poll.getIdentifier();

                address = ('/poll/'+pollId);
                
                clone = pollReference.clone(true);
                clone.toggleClass("hidden").toggleClass("reference");
                clone.find(".string").text(pollPrompt).attr('href',address);
                
                pollList.append(clone);
            }
        };
    
        pollLoadSuccess = function (data) {
            refreshPolls(data);  
        };

        pollLoadError = function () {
            $("#recent-polls").toggleClass("hidden");
        };
    
    });
    
</script>
        
      <hr>

      <div class="row-fluid marketing">
        <div class="span6">
          <h4>Be awesome.</h4>
          <p>Make a poll.</p>

          <h4>See that big green button?</h4>
          <p>That button lets you make a poll. It's easy.</p>

          <h4>What is a poll?</h4>
          <p>A poll is something people can answer. Simple as that.</p>
        </div>

        <div class="span6">
          <h4>You've not made a poll yet?</h4>
          <p>Why not? It's a really easy button to press.</p>

          <h4>I can't think of something else witty to say.</h4>
          <p>So just hit the button, already!</p>

          <h4>Made a poll already?</h4>
          <p>Why not make more? <em>Why not Zoidberg?</em></p>
        </div>
      </div>

      <hr>

      @include('includes.footer')

    </div> <!-- /container -->
@stop
