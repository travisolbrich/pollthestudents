<div class="masthead">
<ul class="nav nav-pills pull-right">
  <li class="{{ $active == "home" ? "active" : "" }}">{{ HTML::link('', 'Home') }}</li>
  <li class="{{ $active == "about" ? "active" : "" }}">{{ HTML::link('about', 'About')}}</li>
</ul>
<h3 class="muted">{{ HTML::link('', 'Poll Something New') }}</h3>
</div>

<hr>