<form action="{{ route('endorsements.store', ['endorsement-request' => $endorsementRequest]) }}" method="POST">
    {{ csrf_field() }}
    <input type="text" placeholder="Please feel free to leave a comment for this endorsement request." name="comment">
    <input type="submit" value="Submit">
</form>
