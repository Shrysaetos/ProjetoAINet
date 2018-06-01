@csrf
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Name
        <small class="required-asterisc">*</small>
    </label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}" required
               autofocus placeholder="Insert name">

        @if ($errors->has('name'))
            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label for="email" class="col-md-4 control-label">Email
        <small class="required-asterisc">*</small>
    </label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control" placeholder="Insert email" name="email" value="{{ old('email',$user->email) }}"
               placeholder="Insira email" required>

        @if ($errors->has('email'))
            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label for="phone" class="col-md-4 control-label">Phone
        <small class="required-asterisc">*</small>
    </label>

    <div class="col-md-6">
        <input id="phone" type="tel" class="form-control" placeholder="Insert phone" name="phone"
               value="{{ old('phone',$user->phone) }}" required>

        @if ($errors->has('phone'))
            <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('profile_photo') ? ' has-error' : '' }}">
    <label for="profile_photo" class="col-md-4 control-label">Photo</label>
    <div class="input-group col-md-6">
        <input type="file" name="profile_photo" id="profile_photo" class="file" style="border-radius:0;
                            padding:10px;">
        <input type="hidden" name="_token" value=" {{ csrf_token() }} ">

        @if ($errors->has('profile_photo'))
            <span class="help-block">
                    <strong>{{ $errors->first('profile_photo') }}</strong>
                </span>
        @endif
    </div>

</div>


