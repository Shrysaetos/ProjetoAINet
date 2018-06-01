@extends('layouts.app')

@section('content')
    @if (count($errors) > 0)
        @include ('shared.errors')
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit User</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="PUT" action="{{ route('user.update') }}" enctype="multipart/form-data">
                            @include('users.partials.add-edit')
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary" href="{{route('user.update')}}" name="ok"
                                            onClick="this.form.submit(); this.disabled=true; this.value='Saving...';">
                                        Save
                                    </button>
                                    <a class="btn btn-default" href="{{route('user.profile')}}">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection