<form action="{{ route('endorsement.store', ['endorsement-request' => $endorsementRequest]) }}" method="POST">
    {{ csrf_field() }}
    <input type="text" placeholder="Have any comments?" name="comment">
    <input type="submit" value="Submit">
</form>
