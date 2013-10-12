@extends('layouts.app')

@section('content')

<div class="row-fluid">
<div class="span9">
<h1>Create a Poll</h1>
    <div id="create">      
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
</div>

<div class="span3">
    <h5>Don't worry, you're in good hands!</h5>
    <canvas id="peoplewholike" width="200px" ></canvas>
</div>
</div>
@stop

@section('javascripts')
    <script type="text/javascript">
        var pieData = [
                {
                    value: 99,
                    color:"#51a351"
                },
                {
                    value : 2,
                    color : "#bd362f"
                }            
            ];

        //Get the context of the canvas element we want to select
        var myPie = new Chart(document.getElementById("peoplewholike").getContext("2d")).Pie(pieData);
        
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