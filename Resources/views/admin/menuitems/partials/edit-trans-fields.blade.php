<div class='form-group{{ $errors->has("{$lang}[title]") ? ' has-error' : '' }}'>
    {!! Form::label("{$lang}[title]", trans('menu::menu.form.title')) !!}
    <?php $old = $menuItem->hasTranslation($lang) ? $menuItem->translate($lang)->title : '' ?>
    {!! Form::text("{$lang}[title]", Input::old("{$lang}[title]", $old), ['class' => 'form-control', 'placeholder' => trans('menu::menu.form.title')]) !!}
    {!! $errors->first("{$lang}[title]", '<span class="help-block">:message</span>') !!}
</div>
<div class="form-group">
    {!! Form::label("{$lang}[uri]", trans('menu::menu.form.uri')) !!}
    <div class='input-group{{ $errors->has("{$lang}[uri]") ? ' has-error' : '' }}'>
        <span class="input-group-addon">/{{ $lang }}/</span>
        <?php $old = $menuItem->hasTranslation($lang) ? $menuItem->translate($lang)->uri : '' ?>
        {!! Form::text("{$lang}[uri]", Input::old("{$lang}[uri]", $old), ['class' => 'form-control', 'placeholder' => trans('menu::menu.form.uri')]) !!}
        {!! $errors->first("{$lang}[uri]", '<span class="help-block">:message</span>') !!}
    </div>
</div>
<div class="form-group{{ $errors->has("{$lang}[url]") ? ' has-error' : '' }}">
    {!! Form::label("{$lang}[url]", trans('menu::menu.form.url')) !!}
    <?php $old = $menuItem->hasTranslation($lang) ? $menuItem->translate($lang)->url : '' ?>
    {!! Form::text("{$lang}[url]", Input::old("{$lang}[url]", $old), ['class' => 'form-control', 'placeholder' => trans('menu::menu.form.url')]) !!}
    {!! $errors->first("{$lang}[url]", '<span class="help-block">:message</span>') !!}
</div>
<div class="checkbox">
    <?php $old = $menuItem->hasTranslation($lang) ? $menuItem->translate($lang)->status : false ?>
    <label for="{{$lang}}[status]">
        <input id="{{$lang}}[status]"
                name="{{$lang}}[status]"
                type="checkbox"
                class="flat-blue"
                {{ (bool) $old ? 'checked' : '' }}
                value="1" />
        {{ trans('menu::menu.form.status') }}
    </label>
</div>
