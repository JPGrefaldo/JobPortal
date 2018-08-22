@if ($errors->has($input_element))
    <span class="input__error-message">
        <strong>{{ $errors->first($input_element) }}</strong>
    </span>
@endif