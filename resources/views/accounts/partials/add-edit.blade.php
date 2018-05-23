@csrf

<div class="form-group">
    <label for="inputCode">Account Code</label>
    <input
        type="text" class="form-control"
        name="code" id="inputCode"
        value="{{old('code', $account->code)}}"/>
</div>


<div class="form-group">
    <label for="inputAccountType">Account Type</label>
    <select name="type" id="inputAccountType" class="form-control">
        <option disabled selected> -- select an option -- </option>


        @foreach ($account_types as $type)
        <option> {{$type->name}}</option>
        @endforeach
        
    </select>
</div>


<div class="form-group">
    <label for="inputDate">Date</label>
    <input type="datetime-local" name="date" id="inputDate" class="form-control"/>    
</div>

<div class="form-group">
    <label for="inputStartBalance">Start balance</label>
    <input
        type="number" class="form-control"
        name="startBalance" id="inputStartBalance"
        value="{{old('startBalance', $account->startBalance)}}"/>
</div>


<div class="form-group">
    <label for="inputDescription">Description</label>
    <input
        type="text" class="form-control"
        name="description" id="inputDescription"
        value="{{old('description', $account->description)}}"/>
</div>

