@extends('layouts.app')

@section('content')

<h1>Create a Poll</h1>
<div class="row-fluid">
    <div class="span12">
    </p>{{ HTML::link('/', 'Poll Something New') }} is a web application created for the <a href="https://www.smore.com/ggr3">aggieHack(web)</a> hackathon. It was created in the span of 24 hours by <a href="https://github.com/travisolbrich">Travis Olbrich</a> and <a href="https://github.com/dereekb">Derek Burgman</a>, two Texas A&amp;M Computer Science students.</p>
    
    <p>{{ HTML::link('/', 'Poll Something New') }} was created to allow professors or other presenters to quickly ask their class or audience a question. The presenter can quickly and easily create their poll, and everyone in the audience can answer by either visiting a website on their phone or laptop or by texting their response to a phone number listed on the page.</p>

    <p>The text message handling is handled through <a href="http://www.twilio.com/">Twilio</a>. Twilio is an excellent (and cheap) service that allows you to easily connect an application to text messaging or voice calls. When a text message is recieved by Twilio, the text message content is POSTed to the Poll Something New API. The application could be easily extended to support recieving poll responses via call as well.</p>

    <p>Poll Something New was built using PHP and Javascript. It is based on the wonderful <a href="http://laravel.com">Laravel framework</a> for PHP and the <a href="http://jquery.com">jQuery</a> javascript framework. The application consists of a number of views that all query the Poll Something New API. The application was built such that it could easily be accessed by any other application.</p>

    <p>It is very important to note that Poll Something New is <strong>NOT</strong> a finished project and should not be used in any serious setting. While the core functionality works, the application was quickly built in less than 24 hours. It contains many bugs, vulnerabilities, and other issues that would not allow it to be an accurate polling system. For example, users are currently able to submit as many responses as they want. Some work would need to be done to limit the number of submissions per person. Also, the ID of private polls can be very easily guessed. To make private polls more private, more unguessable, unsequential poll IDs should be created. Nevertheless, Poll Something New is a awesome, working proof of concept.</p>
    </div>
</div>
@stop