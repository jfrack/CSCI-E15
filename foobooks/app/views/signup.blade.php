<!-- /app/views/signup.blade.php -->
<h1>Sign up</h1>

{{ Form::open(array('url' => '/signup')) }}

    <h3>Email: {{ Form::text('email') }}</h2>

    <h3>Password: {{ Form::password('password') }}</h3>

    {{ Form::submit('Submit') }}

{{ Form::close() }}