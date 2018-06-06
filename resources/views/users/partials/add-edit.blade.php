                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control" name="phone">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('profile_photo') ? ' has-error' : '' }}">
                            <label for="profile_photo" class="col-md-4 col-form-label text-md-right">Photo</label>
                                <div class="input-group col-md-6">
                                    <input type="file" name="profile_photo" id="profile_photo" class="file" style="border-radius:0; padding:10px;">
                                    <input type="hidden" name="_token" value=" {{ csrf_token() }} ">

                                    @if ($errors->has('profile_photo'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('profile_photo') }}</strong>
                                        </span>
                                    @endif
                                </div>

                        </div>