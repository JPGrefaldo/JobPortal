<form action="{{ route('endorsement.edit', ['endorsements' => $endorsement]) }}">
    {{ csrf_field() }}
    <input type="text" value="{{ $endorsement->comment }}" placeholder="Have any comments?" name="comment">
    <input type="submit" value="Submit">
</form>
