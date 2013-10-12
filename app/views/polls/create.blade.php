@extends('layouts.master')

@section('pageContent')
<h1>Create a Poll</h1>


<div id="create">            
    <div class="header">
        <h1>New Poll</h1>
    </div>            
    <div class="poll-info">
        <label>Poll Prompt</label>
        <input id="prompt" type="text" placeholder="Where is a fun place to go at night?" checked/>
        
        <label>Make Public</label>
        <input id="isPublic" type="checkbox" checked/>
    </div>
    <button id="submit">Submit Poll</button>
</div>

<div id="success" class="hidden">            
    <div class="header">
        <h1>Success!</h1>
    </div>            
    <div class="poll-info">
        <p>Your new pool has been created!</p>
        <a class="share" href="/poll/view?id=">Share your Poll</a>
    </div>
</div>

<script type="text/javascript">
    
    var poll = new POLL.MODEL.Poll(),
        pollRegistry = new POLL.REGISTRY.PollRegistry(),
        hideCreate,
        showSuccess,
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
    
    $( "#submit" ).change(function() {
        pollRegistry.create(poll, pollSuccess, pollFailure);
    });
    
    hideCreate = function () {
        
        //$("#success").
        
    };
    
    showSuccess = function () {
        
    };
    
    pollSuccess = function (html) {
      alert('successful : ' + html);
        //Share your poll here or whatever.
      $("#result").html("Successful");
    };
    
    pollError = function(data, errorThrown){
      alert('request failed :'+errorThrown);
    };
    
</script>


@stop