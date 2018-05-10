<div class="form-group">
    <label for="inputFullname">Fullname</label>
    <input
        type="text" class="form-control"
        name="fullname" id="inputFullname"
        placeholder="Fullname" value="<?= escape(old('fullname', $user->fullname)) ?>" />
</div>
<div class="form-group">
    <label for="inputType">Type</label>
    <select name="user_type" id="inputType" class="form-control">
        <option disabled selected> -- select an option -- </option>
        <option <?= is_selected(old('user_type', strval($user->type)), '0') ?> value="0">Administrator</option>
        <option <?= is_selected(old('user_type', strval($user->type)), '1') ?> value="1">Publisher</option>
        <option <?= is_selected(old('user_type', strval($user->type)), '2') ?> value="2">Client</option>
    </select>
</div>
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input
        type="email" class="form-control"
        name="email" id="inputEmail"
        placeholder="Email address" value="<?= escape(old('email', $user->email)) ?>"/>
</div>
