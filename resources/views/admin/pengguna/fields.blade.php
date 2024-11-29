<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nama') !!} <span class="badge bg-primary">Wajib</span>
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('role', 'Role') !!} <span class="badge bg-primary">Wajib</span>
    {!! Form::select('role', $role,null, ['class' => 'form-control','placeholder'=>'-- Pilih Role --']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email') !!} <span class="badge bg-primary">Wajib</span>
    {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password') !!} <span class="badge bg-primary">Wajib</span>
    {!! Form::password('password', ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
</div>
