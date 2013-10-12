<h1>Create a Poll</h1>

{{ Form::open(array('url' => 'poll')) }}

{{ Form::label('name', 'Poll Name') }}
{{ Form::text('name') }}

{{ Form::close() }}