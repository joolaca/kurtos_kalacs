<div class="container">
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
        {!! Form::open(['url' => 'login', 'method' => 'POST', 'class' => 'form-signin']) !!}
            <h2 class="form-signin-heading">Jelentkezz be</h2>
            <div class="form-group">
                <label class="col-md-5">Felhasználónév</label>
                <div class="col-md-7">{!! Form::text('user_name') !!} </div>
            </div>

            <div class="form-group">
                <label class="col-md-5" >Jelszó</label>
                <div class="col-md-7">{!! Form::password('password') !!} </div>
            </div>
            <div class="form-group">

                {!! Form::submit('ok', ['class' => 'btn btn-lg btn-primary btn-block']) !!}
            </div>

        {!! Form::close() !!}
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </div>
    </div>
</div>


