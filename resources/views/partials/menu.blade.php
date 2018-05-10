<div class="pull-right">
    Welcome {{Auth::user()->name}},
    <form action="/logout" method="post" style="display:inline">
        @csrf
        <button type="submit" class="btn btn-default">Logout</button>
    </form>
</div>
