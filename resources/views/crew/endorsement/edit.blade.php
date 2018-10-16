<form action="{{ route('endorsements.update', ['endorsements' => $endorsement]) }}">
    {{ csrf_field() }}
    @method('PUT')
    <input type="text" value="{{ $endorsement->comment }}" placeholder="Please feel free to leave a comment for this endorsement request." name="comment">
    <input type="submit" value="Submit">
</form>
