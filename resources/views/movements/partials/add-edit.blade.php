@csrf

<div class="form-group">
    <label for="inputMovimentCategory">Moviment Category</label>
    <select name="moviment_category_id" id="inputMovimentCategory" class="form-control">
        <option disabled selected> -- select an option -- </option>
        <!--A alterar!!!!!!!-->
        <option {{is_selected(old('type', $user->type), '0')}} value="0">Administrator</option>
    </select>
</div>

<div class="form-group">
    <label for="inputDate">Date</label>
    <input type="date" name="date" id="inputDate" class="form-control"/>    
</div>

<div class="form-group">
    <label for="inputValue">Value</label>
    <input
        type="number" class="form-control"
        name="value" id="inputValue" value="{{old('value', $moviment->value)}}" />
</div>

<div class="form-group">
    <label for="inputDescription">Description</label>
    <input
        type="text" class="form-control"
        name="description" id="inputDescription"
        value="{{old('description', $moviment->description)}}"/>
</div>


<div class="form-group">
    <label for="inputDocument">Document</label>
    <input type="file" name="document" id="inputDocument" class="form-control"/> 
</div>

<div class="form-group">
    <label for="inputDocumentDescription">Document Description</label>
    <input
        type="text" class="form-control"
        name="documentDescription" id="inputDocumentDescription"
        value="{{old('description', $moviment->documentDescription)}}"/>
</div>

