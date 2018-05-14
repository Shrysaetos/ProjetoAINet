@csrf


<div class="form-group">
    <label for="inputAccountType">Account Type</label>
    <select name="type" id="inputAccountType" class="form-control">
        <option disabled selected> -- select an option -- </option>
        <!--A alterar!!!!!!!-->
        <option {{is_selected(old('type', $user->type), '0')}} value="0">Administrator</option>
    </select>
</div>


<div class="form-group">
    <label for="inputDate">Date</label>
    <input type="datetime-local" name="date" id="inputDate" class="form-control"/>    
</div>


<!--Código de conta inserido pelo utilizador ou gerado????-->


<div class="form-group">
    <label for="inputDescription">Description</label>
    <input
        type="text" class="form-control"
        name="description" id="inputDescription"
        value="{{old('description', $moviment->description)}}"/>
</div>

