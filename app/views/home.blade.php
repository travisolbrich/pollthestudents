@extends('layouts.master')

@section('pageContent')
    <div class="container-narrow">

      @include('includes.masthead')

      <div class="jumbotron">
        <h1>Create a Poll!</h1>
        <p class="lead">Create a new public poll.</p>
        <a class="btn btn-large btn-success" href="/poll/create">New Poll</a>
      </div>

      <hr>

      <div class="row-fluid marketing">
        <div class="span6">
          <h4>Be a badass.</h4>
          <p>Make a poll.</p>

          <h4>See that big green button?</h4>
          <p>That button lets you make a poll. It's easy.</p>

          <h4>What is a poll?</h4>
          <p>A poll is something people can answer. Simple as that.</p>
        </div>

        <div class="span6">
          <h4>You've not made a poll yet?</h4>
          <p>Why not? It's a damn easy button to press.</p>

          <h4>I can't think of something else witty to say.</h4>
          <p>So just hit the damn button, already!</p>

          <h4>Made a poll already?</h4>
          <p>Why not make more? <em>Why not Zoidberg?</em></p>
        </div>
      </div>

      <hr>

      <div class="footer">
        <p>TAMU Google Hackathon October 2013</p>
        <p>Travis Olbrich, Derek Burgman, Luis Flores</p>
      </div>

    </div> <!-- /container -->
@stop
