<div class="form-group">
    <label for="page">{{ trans('menu::menu-items.form.page') }}</label>
    <select class="form-control" name="page_id" id="page">
        <option value=""></option>
        <?php foreach ($pages as $page): ?>
            <option value="{{ $page->id }}">{{ $page->title }}</option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="target">{{ trans('menu::menu-items.form.target') }}</label>
    <select class="form-control" name="target" id="target">
        <option value="_self">{{ trans('menu::menu-items.form.same tab') }}</option>
        <option value="_blank">{{ trans('menu::menu-items.form.new tab') }}</option>
    </select>
</div>
