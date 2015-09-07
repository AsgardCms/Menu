<div class="form-group{{ $errors->has("icon") ? ' has-error' : '' }}">
    {!! Form::label("icon", trans('menu::menu-items.form.icon')) !!}
    {!! Form::text("icon", Input::old("icon",$menuItem->icon), ['class' => 'form-control', 'placeholder' => trans('menu::menu-items.form.icon')]) !!}
    {!! $errors->first("icon", '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group">
    <label for="page">{{ trans('menu::menu-items.form.page') }}</label>
    <select class="form-control" name="page_id" id="page">
        <option value=""></option>
        <?php foreach ($pages as $page): ?>
            <option value="{{ $page->id }}" {{ $menuItem->page_id == $page->id ? 'selected' : '' }}>
                {{ $page->title }}
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label for="target">{{ trans('menu::menu-items.form.target') }}</label>
    <select class="form-control" name="target" id="target">
        <option value="_self" {{ $menuItem->target == '_self' ? 'selected' : '' }}>{{ trans('menu::menu-items.form.same tab') }}</option>
        <option value="_blank" {{ $menuItem->target == '_blank' ? 'selected' : '' }}>{{ trans('menu::menu-items.form.new tab') }}</option>
    </select>
</div>
